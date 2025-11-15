<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Kursus;
use App\Models\Kategori;
use App\Models\Modul;
use App\Models\Kuis;
use App\Models\User;
use App\Models\ProgresPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InstructorController extends Controller
{
    /**
     * Display the instructor dashboard.
     */
    public function dashboard()
    {
        $instructor = Auth::user();
        
        // Get all courses for this instructor
        $courses = Kursus::where('instruktur_id', $instructor->id)
            ->withCount(['moduls as total_modules'])
            ->withCount(['progresPesertas as total_students'])
            ->get();
        
        // Calculate total students across all courses
        $totalStudents = $courses->sum('total_students');
        
        // Calculate total courses
        $totalCourses = $courses->count();
        
        // Calculate average rating (simulated for now)
        $averageRating = 4.8;
        
        // Get recent courses (limit to 2 for dashboard display)
        $recentCourses = $courses->take(2);
        
        return view('layouts.instruktur.dashboard', compact(
            'totalCourses', 
            'totalStudents', 
            'averageRating', 
            'recentCourses'
        ));
    }

    /**
     * Display a listing of the courses.
     */
    public function index()
    {
        $courses = Kursus::where('instruktur_id', Auth::id())->with('kategori')->get();
        return view('layouts.instruktur.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $categories = Kategori::all();
        return view('layouts.instruktur.courses.create', compact('categories'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_publish' => 'required|in:Draft,Published,Rejected'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course = Kursus::create([
            'instruktur_id' => Auth::id(),
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'thumbnail' => $thumbnailPath,
            'status_publish' => $request->status_publish
        ]);

        return redirect()->route('instruktur.courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified course.
     */
    public function show(Kursus $kursus)
    {
        // Ensure the instructor owns this course
        if ($kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        $kursus->load('moduls.kuis');
        return view('layouts.instruktur.courses.show', compact('kursus'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Kursus $kursus)
    {
        // Ensure the instructor owns this course
        if ($kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        $categories = Kategori::all();
        return view('layouts.instruktur.courses.edit', compact('kursus', 'categories'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Kursus $kursus)
    {
        // Ensure the instructor owns this course
        if ($kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_publish' => 'required|in:Draft,Published,Rejected'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $thumbnailPath = $kursus->thumbnail;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $kursus->update([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'thumbnail' => $thumbnailPath,
            'status_publish' => $request->status_publish
        ]);

        return redirect()->route('instruktur.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Kursus $kursus)
    {
        // Ensure the instructor owns this course
        if ($kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        // Delete all related records in the correct order due to foreign key constraints
        // First get all modules for this course
        $modules = $kursus->moduls;

        foreach ($modules as $module) {
            // Delete quiz results for this module
            $module->hasilKuis()->delete();
            
            // Delete quizzes for this module
            $module->kuis()->delete();
            
            // Delete progress records for this module
            $module->progresPesertas()->delete();
        }

        // Delete all modules for this course
        $kursus->moduls()->delete();

        // Finally delete the course
        $kursus->delete();

        return redirect()->route('instruktur.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    /**
     * Show modules for a specific course
     */
    public function showModules(Kursus $kursus)
    {
        // Ensure the instructor owns this course
        if ($kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        $kursus->load('moduls');
        return view('layouts.instruktur.modules.index', compact('kursus'));
    }

    /**
     * Show the form for creating a new module
     */
    public function createModule(Kursus $kursus)
    {
        // Ensure the instructor owns this course
        if ($kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        // Get available quizzes for this course
        $quizzes = Kuis::whereHas('modul', function ($query) use ($kursus) {
            $query->where('kursus_id', $kursus->id);
        })->get();

        return view('layouts.instruktur.modules.create', compact('kursus', 'quizzes'));
    }

    /**
     * Store a newly created module in storage
     */
    public function storeModule(Request $request, Kursus $kursus)
    {
        // Ensure the instructor owns this course
        if ($kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'tipe_materi' => 'required|in:Video,Artikel,Kuis',
            'urutan' => 'required|integer|min:1',
            'konten_teks' => 'nullable|string',
            'penjelasan' => 'nullable|string',
            'url_video' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:1024000', // 1GB limit
            'video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_deskripsi' => 'nullable|string',
            'durasi_video' => 'nullable|integer|min:0',
            'quiz_id' => 'nullable|exists:kuis,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle video upload
        $videoUrl = $request->url_video;
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $videoUrl = Storage::url($videoPath);
        }

        $videoThumbnailPath = null;
        if ($request->hasFile('video_thumbnail')) {
            $videoThumbnailPath = $request->file('video_thumbnail')->store('video_thumbnails', 'public');
        }

        $modul = Modul::create([
            'kursus_id' => $kursus->id,
            'quiz_id' => $request->quiz_id,
            'judul' => $request->judul,
            'tipe_materi' => $request->tipe_materi,
            'urutan' => $request->urutan,
            'konten_teks' => $request->konten_teks,
            'penjelasan' => $request->penjelasan,
            'url_video' => $videoUrl,
            'video_thumbnail' => $videoThumbnailPath,
            'video_deskripsi' => $request->video_deskripsi,
            'durasi_video' => $request->durasi_video
        ]);

        return redirect()->route('instruktur.courses.show', $kursus)
            ->with('success', 'Module created successfully.');
    }

    /**
     * Show the form for editing the specified module
     */
    public function editModule(Modul $modul)
    {
        // Ensure the instructor owns this course
        if ($modul->kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        // Get available quizzes for this course
        $quizzes = Kuis::whereHas('modul', function ($query) use ($modul) {
            $query->where('kursus_id', $modul->kursus->id);
        })->get();

        return view('layouts.instruktur.modules.edit', compact('modul', 'quizzes'));
    }

    /**
     * Update the specified module in storage
     */
    public function updateModule(Request $request, Modul $modul)
    {
        // Ensure the instructor owns this course
        if ($modul->kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'tipe_materi' => 'required|in:Video,Artikel,Kuis',
            'urutan' => 'required|integer|min:1',
            'konten_teks' => 'nullable|string',
            'penjelasan' => 'nullable|string',
            'url_video' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:1024000', // 1GB limit
            'video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_deskripsi' => 'nullable|string',
            'durasi_video' => 'nullable|integer|min:0',
            'quiz_id' => 'nullable|exists:kuis,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle video upload
        $videoUrl = $request->url_video;
        if ($request->hasFile('video_file')) {
            // Delete old video if it exists and is stored locally
            if ($modul->url_video && strpos($modul->url_video, 'storage') !== false) {
                $oldVideoPath = str_replace(Storage::url(''), '', $modul->url_video);
                if (Storage::disk('public')->exists($oldVideoPath)) {
                    Storage::disk('public')->delete($oldVideoPath);
                }
            }
            
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $videoUrl = Storage::url($videoPath);
        }

        $videoThumbnailPath = $modul->video_thumbnail;
        if ($request->hasFile('video_thumbnail')) {
            // Delete old thumbnail if it exists
            if ($modul->video_thumbnail && Storage::disk('public')->exists($modul->video_thumbnail)) {
                Storage::disk('public')->delete($modul->video_thumbnail);
            }
            
            $videoThumbnailPath = $request->file('video_thumbnail')->store('video_thumbnails', 'public');
        }

        $modul->update([
            'quiz_id' => $request->quiz_id,
            'judul' => $request->judul,
            'tipe_materi' => $request->tipe_materi,
            'urutan' => $request->urutan,
            'konten_teks' => $request->konten_teks,
            'penjelasan' => $request->penjelasan,
            'url_video' => $videoUrl,
            'video_thumbnail' => $videoThumbnailPath,
            'video_deskripsi' => $request->video_deskripsi,
            'durasi_video' => $request->durasi_video
        ]);

        return redirect()->route('instruktur.courses.show', $modul->kursus)
            ->with('success', 'Module updated successfully.');
    }

    /**
     * Remove the specified module from storage
     */
    public function destroyModule(Modul $modul)
    {
        // Ensure the instructor owns this course
        if ($modul->kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        $kursus = $modul->kursus;
        $modul->delete();

        return redirect()->route('instruktur.courses.show', $kursus)
            ->with('success', 'Module deleted successfully.');
    }

    /**
     * Show quizzes for a specific module
     */
    public function showQuizzes(Modul $modul)
    {
        // Ensure the instructor owns this course
        if ($modul->kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        $modul->load('kuis');
        return view('layouts.instruktur.quizzes.index', compact('modul'));
    }

    /**
     * Show the form for creating a new quiz
     */
    public function createQuiz(Modul $modul)
    {
        // Ensure the instructor owns this course
        if ($modul->kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        return view('layouts.instruktur.quizzes.create', compact('modul'));
    }

    /**
     * Store a newly created quiz in storage
     */
    public function storeQuiz(Request $request, Modul $modul)
    {
        // Ensure the instructor owns this course
        if ($modul->kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:A,B,C,D',
            'score_weight' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $quiz = Kuis::create([
            'modul_id' => $modul->id,
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
            'score_weight' => $request->score_weight
        ]);

        return redirect()->route('instruktur.modules.quizzes.index', $modul)
            ->with('success', 'Quiz created successfully.');
    }

    /**
     * Show the form for editing the specified quiz
     */
    public function editQuiz(Kuis $kuis)
    {
        // Ensure the instructor owns this course
        if ($kuis->modul->kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        return view('layouts.instruktur.quizzes.edit', compact('kuis'));
    }

    /**
     * Update the specified quiz in storage
     */
    public function updateQuiz(Request $request, Kuis $kuis)
    {
        // Ensure the instructor owns this course
        if ($kuis->modul->kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:A,B,C,D',
            'score_weight' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kuis->update([
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
            'score_weight' => $request->score_weight
        ]);

        return redirect()->route('instruktur.modules.quizzes.index', $kuis->modul)
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified quiz from storage
     */
    public function destroyQuiz(Kuis $kuis)
    {
        // Ensure the instructor owns this course
        if ($kuis->modul->kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        $modul = $kuis->modul;
        $kuis->delete();

        return redirect()->route('instruktur.modules.quizzes.index', $modul)
            ->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Show student progress for a specific course
     */
    public function showStudentProgress(Kursus $kursus)
    {
        // Ensure the instructor owns this course
        if ($kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        // Get all students enrolled in this course
        // We need to get all students who have any progress records for this course,
        // even if they've been reset (completed = false)
        $students = User::where('peran', 'Peserta')
            ->whereHas('progresPesertas', function ($query) use ($kursus) {
                $query->whereHas('modul', function ($query) use ($kursus) {
                    $query->where('kursus_id', $kursus->id);
                });
            })
            ->with(['progresPesertas' => function ($query) use ($kursus) {
                $query->whereHas('modul', function ($query) use ($kursus) {
                    $query->where('kursus_id', $kursus->id);
                })->with('modul');
            }])
            ->get();

        // Get all modules for this course
        $modules = $kursus->moduls()->orderBy('urutan')->get();

        return view('layouts.instruktur.students.progress', compact('kursus', 'students', 'modules'));
    }

    /**
     * Show analytics dashboard for the instructor
     */
    public function analytics()
    {
        $instructor = Auth::user();
        
        // Get all courses for this instructor with module and progress counts
        $courses = Kursus::where('instruktur_id', $instructor->id)
            ->withCount('moduls as total_modules')
            ->withCount('progresPesertas as total_students')
            ->get();
        
        // Calculate completion data for each course
        $completionData = [];
        $courseNames = [];
        $studentCounts = [];
        $completionRates = [];
        
        foreach ($courses as $course) {
            $totalModules = $course->total_modules;
            if ($totalModules > 0) {
                // Get all progress records for this course
                $progressRecords = $course->progresPesertas;
                
                // Count completed modules
                $completedModules = $progressRecords->where('completed', true)->count();
                $totalModuleInstances = $progressRecords->count();
                
                // Calculate completion rate for this course
                $completionRate = $totalModuleInstances > 0 ? ($completedModules / $totalModuleInstances) * 100 : 0;
                $completionData[$course->id] = round($completionRate, 2);
            } else {
                $completionData[$course->id] = 0;
            }
            
            // Prepare data for charts
            $courseNames[] = $course->judul;
            $studentCounts[] = $course->total_students;
            $completionRates[] = $completionData[$course->id];
        }
        
        // Calculate total students across all courses
        $totalStudents = $courses->sum('total_students');
        
        // Calculate total courses
        $totalCourses = $courses->count();
        
        // Get top performing courses
        arsort($completionData);
        $topCourses = array_slice($completionData, 0, 5, true);
        
        return view('layouts.instruktur.analytics.index', compact(
            'courses', 
            'totalStudents', 
            'totalCourses', 
            'completionData', 
            'topCourses', 
            'courseNames', 
            'studentCounts', 
            'completionRates'
        ));
    }

    /**
     * Reset student progress for a specific course
     */
    public function resetStudentProgress(Kursus $kursus, User $user)
    {
        // Ensure the instructor owns this course
        if ($kursus->instruktur_id !== Auth::id()) {
            return redirect()->route('instruktur.courses.index')
                ->with('error', 'Unauthorized access.');
        }

        // Ensure the user is a student
        if ($user->peran !== 'Peserta') {
            return redirect()->back()
                ->with('error', 'Invalid user role.');
        }

        // Reset all progress records for this student in this course
        // Instead of deleting, we reset the progress to initial state
        ProgresPeserta::where('user_id', $user->id)
            ->whereHas('modul', function ($query) use ($kursus) {
                $query->where('kursus_id', $kursus->id);
            })
            ->update([
                'completed' => false,
                'completed_at' => null
            ]);

        return redirect()->back()
            ->with('success', 'Student progress has been reset successfully.');
    }
}