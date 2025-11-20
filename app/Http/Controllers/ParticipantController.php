<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Kursus;
use App\Models\Modul;
use App\Models\Kuis;
use App\Models\ProgresPeserta;
use App\Models\HasilKuis;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ParticipantController extends Controller
{
    /**
     * Display the participant dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get enrolled courses with progress
        // Using a more explicit query to ensure we get all enrolled courses
        $enrolledCourses = Kursus::whereHas('moduls.progresPesertas', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with([
            'moduls.progresPesertas' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }, 
            'instruktur'
        ])->orderBy('judul')->get();
        
        // Get available courses (published courses that user is not enrolled in)
        $availableCourses = Kursus::where('status_publish', 'Published')
            ->whereDoesntHave('moduls.progresPesertas', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['instruktur', 'kategori'])
            ->orderBy('judul')
            ->get(); // Removed limit to show all available courses
        
        // Show all courses on dashboard (both enrolled and available)
        $allCourses = $enrolledCourses->merge($availableCourses)->sortBy('judul');
        
        // Count enrolled courses
        $enrolledCount = $enrolledCourses->count();
        
        // Count completed courses
        $completedCount = 0;
        foreach ($enrolledCourses as $course) {
            $totalModules = $course->moduls->count();
            $completedModules = $course->moduls->filter(function ($module) {
                $progress = $module->progresPesertas->firstWhere('user_id', Auth::id());
                return $progress && $progress->completed;
            })->count();
            
            if ($totalModules > 0 && $completedModules == $totalModules) {
                $completedCount++;
            }
        }
        
        // Get certificates (completed courses)
        $certificates = $enrolledCourses->filter(function ($course) {
            $totalModules = $course->moduls->count();
            $completedModules = $course->moduls->filter(function ($module) {
                $progress = $module->progresPesertas->firstWhere('user_id', Auth::id());
                return $progress && $progress->completed;
            })->count();
            
            return $totalModules > 0 && $completedModules == $totalModules;
        });
        
        // Get recent progress data for chart
        $progressData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('M', strtotime("-{$i} months"));
            $progressData[$month] = rand(0, 5); // Simulated data
        }
        
        return view('layouts.peserta.dashboard', compact(
            'enrolledCourses', 
            'availableCourses',
            'allCourses', // Added all courses
            'enrolledCount', 
            'completedCount', 
            'certificates', 
            'progressData'
        ));
    }

    /**
     * Display a listing of enrolled courses with search and filter.
     */
    public function indexCourses(Request $request)
    {
        $user = Auth::user();
        
        $query = Kursus::whereHas('moduls.progresPesertas', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['moduls.progresPesertas' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }, 'kategori', 'instruktur']);
        
        // Apply search filter
        if ($request->has('search') && $request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        
        // Apply category filter
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }
        
        // Apply status filter
        if ($request->has('status') && $request->status) {
            if ($request->status == 'completed') {
                $query->whereDoesntHave('moduls', function ($subQuery) {
                    $subQuery->whereDoesntHave('progresPesertas', function ($progressQuery) {
                        $progressQuery->where('completed', true);
                    });
                });
            } elseif ($request->status == 'in_progress') {
                $query->whereHas('moduls.progresPesertas', function ($subQuery) {
                    $subQuery->where('completed', false);
                })->orWhereDoesntHave('moduls.progresPesertas', function ($subQuery) {
                    $subQuery->where('completed', true);
                });
            }
        }
        
        $courses = $query->get();
        
        // Get all categories for filter dropdown
        $categories = Kategori::all();
        
        // Get recommended courses (not yet enrolled)
        $recommendedCourses = Kursus::where('status_publish', 'Published')
            ->whereDoesntHave('moduls.progresPesertas', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['instruktur', 'kategori'])
            ->orderBy('judul')
            ->limit(6) // Limit to 6 for display
            ->get();
        
        return view('layouts.peserta.courses.index', compact('courses', 'categories', 'recommendedCourses'));
    }

    /**
     * Display course details.
     */
    public function showCourse(Kursus $kursus)
    {
        $user = Auth::user();
        
        // Check if user is enrolled in this course
        $isEnrolled = $kursus->moduls->flatMap->progresPesertas->pluck('user_id')->contains($user->id);
        
        if (!$isEnrolled) {
            return redirect()->route('peserta.courses.index')
                ->with('error', 'You are not enrolled in this course.');
        }
        
        $kursus->load(['moduls.progresPesertas' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }, 'kategori', 'instruktur']);
        
        return view('layouts.peserta.courses.show', compact('kursus'));
    }

    /**
     * Enroll in a course.
     */
    public function enrollCourse(Kursus $kursus)
    {
        $user = Auth::user();
        
        // Check if already enrolled
        $alreadyEnrolled = $kursus->moduls->flatMap->progresPesertas->pluck('user_id')->contains($user->id);
        
        if ($alreadyEnrolled) {
            return redirect()->back()->with('info', 'You are already enrolled in this course.');
        }
        
        // Create progress records for all modules
        foreach ($kursus->moduls as $module) {
            ProgresPeserta::create([
                'user_id' => $user->id,
                'modul_id' => $module->id,
                'completed' => false
            ]);
        }
        
        return redirect()->back()->with('success', 'Successfully enrolled in the course.');
    }

    /**
     * Display modules for a course.
     */
    public function indexModules(Kursus $kursus)
    {
        $user = Auth::user();
        
        // Check if user is enrolled in this course
        $isEnrolled = $kursus->moduls->flatMap->progresPesertas->pluck('user_id')->contains($user->id);
        
        if (!$isEnrolled) {
            return redirect()->route('peserta.courses.index')
                ->with('error', 'You are not enrolled in this course.');
        }
        
        $kursus->load(['moduls.progresPesertas' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }]);
        
        return view('layouts.peserta.modules.index', compact('kursus'));
    }

    /**
     * Display a specific module.
     */
    public function showModule(Modul $modul)
    {
        $user = Auth::user();
        
        // Check if user is enrolled in the course this module belongs to
        $isEnrolled = $modul->kursus->moduls->flatMap->progresPesertas->pluck('user_id')->contains($user->id);
        
        if (!$isEnrolled) {
            return redirect()->route('peserta.courses.index')
                ->with('error', 'You are not enrolled in this course.');
        }
        
        $progress = ProgresPeserta::where('user_id', $user->id)
            ->where('modul_id', $modul->id)
            ->first();
        
        // Load related quiz if exists
        $modul->load('kuis');
        
        return view('layouts.peserta.modules.show', compact('modul', 'progress'));
    }

    /**
     * Mark module as completed.
     */
    public function completeModule(Modul $modul)
    {
        $user = Auth::user();
        
        // Check if user is enrolled in the course this module belongs to
        $isEnrolled = $modul->kursus->moduls->flatMap->progresPesertas->pluck('user_id')->contains($user->id);
        
        if (!$isEnrolled) {
            return redirect()->route('peserta.courses.index')
                ->with('error', 'You are not enrolled in this course.');
        }
        
        $progress = ProgresPeserta::firstOrCreate([
            'user_id' => $user->id,
            'modul_id' => $modul->id
        ]);
        
        $progress->update([
            'completed' => true,
            'completed_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Module marked as completed.');
    }

    /**
     * Display quizzes.
     */
    public function indexQuizzes(Request $request)
    {
        $user = Auth::user();
        
        // Base query for quizzes
        $query = Kuis::whereHas('modul.kursus.moduls.progresPesertas', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['modul.kursus', 'modul.progresPesertas' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }]);
        
        // Apply category filter
        if ($request->has('kategori') && $request->kategori) {
            $query->whereHas('modul.kursus', function ($subQuery) use ($request) {
                $subQuery->where('kategori_id', $request->kategori);
            });
        }
        
        $quizzes = $query->get();
        
        // Get all categories for filter dropdown
        $categories = Kategori::all();
        
        return view('layouts.peserta.quizzes.index', compact('quizzes', 'categories'));
    }

    /**
     * Display a specific quiz.
     */
    public function showQuiz(Kuis $kuis)
    {
        $user = Auth::user();
        
        // Check if user is enrolled in the course this quiz belongs to
        $isEnrolled = $kuis->modul->kursus->moduls->flatMap->progresPesertas->pluck('user_id')->contains($user->id);
        
        if (!$isEnrolled) {
            return redirect()->route('peserta.courses.index')
                ->with('error', 'You are not enrolled in this course.');
        }
        
        // Check if user has already submitted this quiz
        $hasTakenQuiz = HasilKuis::where('user_id', $user->id)
            ->where('modul_id', $kuis->modul->id)
            ->exists();
            
        if ($hasTakenQuiz) {
            return redirect()->route('peserta.quizzes.index')
                ->with('info', 'You have already submitted this quiz.');
        }
        
        return view('layouts.peserta.quizzes.show', compact('kuis', 'hasTakenQuiz'));
    }

    /**
     * Submit quiz answers.
     */
    public function submitQuiz(Request $request, Kuis $kuis)
    {
        $user = Auth::user();
        
        // Check if user is enrolled in the course this quiz belongs to
        $isEnrolled = $kuis->modul->kursus->moduls->flatMap->progresPesertas->pluck('user_id')->contains($user->id);
        
        if (!$isEnrolled) {
            return redirect()->route('peserta.courses.index')
                ->with('error', 'You are not enrolled in this course.');
        }
        
        // Validate answer
        $validator = Validator::make($request->all(), [
            'answer' => 'required|string|in:A,B,C,D',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Calculate score
        $correctAnswers = 0;
        $totalQuestions = 1; // Only one question per quiz
        
        if ($request->answer == $kuis->correct_answer) {
            $correctAnswers = 1;
        }
        
        $score = ($correctAnswers / $totalQuestions) * 100;
        
        // Save quiz result
        HasilKuis::create([
            'user_id' => $user->id,
            'modul_id' => $kuis->modul->id,
            'score' => $score,
        ]);
        
        // If score is 70 or above, mark module as completed
        if ($score >= 70) {
            $progress = ProgresPeserta::firstOrCreate([
                'user_id' => $user->id,
                'modul_id' => $kuis->modul->id
            ]);
            
            $progress->update([
                'completed' => true,
                'completed_at' => now()
            ]);
            
            return redirect()->route('peserta.quizzes.index')
                ->with('success', "Quiz submitted successfully! Your score: {$score}%. Module completed.");
        }
        
        return redirect()->route('peserta.quizzes.index')
                ->with('success', "Quiz submitted successfully! Your score: {$score}%.");
    }

    /**
     * Display progress tracking.
     */
    public function progress()
    {

        $user = Auth::user();
        
        // Get enrolled courses with progress
        $courses = Kursus::whereHas('moduls.progresPesertas', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['moduls.progresPesertas' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }, 'instruktur'])->get();
        
        return view('layouts.peserta.progress.index', compact('courses'));
    }

    /**
     * Display certificates.
     */
    public function certificates()
    {
        $user = Auth::user();
        
        // Get completed courses (certificates)
        $courses = Kursus::whereHas('moduls.progresPesertas', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('completed', true);
        })->with(['moduls.progresPesertas' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }, 'instruktur'])->get()->filter(function ($course) {
            $totalModules = $course->moduls->count();
            $completedModules = $course->moduls->filter(function ($module) {
                $progress = $module->progresPesertas->firstWhere('user_id', Auth::id());
                return $progress && $progress->completed;
            })->count();
            
            return $totalModules > 0 && $completedModules == $totalModules;
        });
        
        return view('layouts.peserta.certificates.index', compact('courses'));
    }

    /**
     * Display individual certificate.
     */
    public function viewCertificate(Kursus $kursus)
    {
        $user = Auth::user();
        
        // Check if user has completed this course
        $isCompleted = $kursus->moduls->every(function ($module) use ($user) {
            $progress = $module->progresPesertas->firstWhere('user_id', $user->id);
            return $progress && $progress->completed;
        });
        
        if (!$isCompleted) {
            return redirect()->route('peserta.certificates.index')
                ->with('error', 'You have not completed this course yet.');
        }
        
        // Get completion date (latest completion date among modules)
        $completionDate = null;
        foreach ($kursus->moduls as $module) {
            $progress = $module->progresPesertas->firstWhere('user_id', $user->id);
            if ($progress && $progress->completed_at) {
                if (!$completionDate || $progress->completed_at > $completionDate) {
                    $completionDate = $progress->completed_at;
                }
            }
        }
        
        return view('view.certificate', compact('kursus', 'completionDate'));
    }

    /**
     * Export module article content to PDF.
     */
    public function exportModuleToPdf(Modul $modul)
    {
        $user = Auth::user();
        
        // Check if user is enrolled in the course this module belongs to
        $isEnrolled = $modul->kursus->moduls->flatMap->progresPesertas->pluck('user_id')->contains($user->id);
        
        if (!$isEnrolled) {
            return redirect()->route('peserta.courses.index')
                ->with('error', 'You are not enrolled in this course.');
        }
        
        // Check if module is an article
        if ($modul->tipe_materi !== 'Artikel') {
            return redirect()->back()
                ->with('error', 'Only article modules can be exported to PDF.');
        }
        
        // Load the PDF view with module data
        $pdf = Pdf::loadView('layouts.peserta.modules.pdf', compact('modul'));
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Return the PDF as a download
        return $pdf->download("{$modul->judul}.pdf");
    }
}