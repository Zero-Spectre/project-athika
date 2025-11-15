<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Kursus;
use App\Models\Kategori;
use App\Models\ProgresPeserta;
use App\Models\DiskusiTopik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalCourses = Kursus::count();
        $totalCategories = Kategori::count();
        $totalEnrollments = ProgresPeserta::count();
        $totalDiscussions = DiskusiTopik::count();
        
        // Get recent users
        $recentUsers = User::latest()->take(5)->get();
        
        // Get user statistics by role
        $userStats = [
            'admin' => User::where('peran', 'Admin')->count(),
            'instruktur' => User::where('peran', 'Instruktur')->count(),
            'peserta' => User::where('peran', 'Peserta')->count(),
        ];
        
        // Get course statistics
        $courseStats = [
            'published' => Kursus::where('status_publish', 'Published')->count(),
            'draft' => Kursus::where('status_publish', 'Draft')->count(),
            'archived' => Kursus::where('status_publish', 'Archived')->count(),
        ];
        
        // Get recent activity
        $recentActivity = $this->getRecentActivity();
        
        // Get enrollment statistics
        $enrollmentStats = $this->getEnrollmentStats();
        
        return view('layouts.admin.dashboard', compact(
            'totalUsers', 
            'totalCourses', 
            'totalCategories', 
            'totalEnrollments',
            'totalDiscussions',
            'recentUsers', 
            'userStats',
            'courseStats',
            'recentActivity',
            'enrollmentStats'
        ));
    }

    /**
     * Get recent activity for dashboard
     */
    private function getRecentActivity()
    {
        // For now, we'll return mock data
        // In a real implementation, this would fetch actual activity data
        return [
            ['user' => 'John Doe', 'action' => 'Enrolled', 'item' => 'Web Development Fundamentals', 'time' => '2 hours ago', 'type' => 'enrollment'],
            ['user' => 'Sarah Johnson', 'action' => 'Completed', 'item' => 'Data Science Essentials', 'time' => '5 hours ago', 'type' => 'completion'],
            ['user' => 'Michael Chen', 'action' => 'Created', 'item' => 'Mobile App Development', 'time' => '1 day ago', 'type' => 'creation'],
            ['user' => 'Emma Rodriguez', 'action' => 'Posted', 'item' => 'UX Design Discussion', 'time' => '1 day ago', 'type' => 'discussion'],
            ['user' => 'David Wilson', 'action' => 'Enrolled', 'item' => 'Cloud Computing Basics', 'time' => '2 days ago', 'type' => 'enrollment'],
        ];
    }
    
    /**
     * Get enrollment statistics
     */
    private function getEnrollmentStats()
    {
        // For now, we'll return mock data
        // In a real implementation, this would fetch actual enrollment data
        return [
            'this_week' => 42,
            'last_week' => 38,
            'this_month' => 156,
            'last_month' => 142,
        ];
    }

    /**
     * Display a listing of users.
     */
    public function indexUsers()
    {
        $users = User::latest()->paginate(10);
        return view('layouts.admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function createUser()
    {
        return view('layouts.admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'peran' => 'required|in:Admin,Instruktur,Peserta',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'peran' => $request->peran,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function editUser(User $user)
    {
        return view('layouts.admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function updateUser(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'peran' => 'required|in:Admin,Instruktur,Peserta',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'peran' => $request->peran,
        ]);

        // If password is provided, update it
        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroyUser(User $user)
    {
        // Prevent deletion of the current admin user
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Display a listing of courses.
     */
    public function indexCourses()
    {
        $courses = Kursus::with('instruktur', 'kategori')->latest()->paginate(10);
        return view('layouts.admin.courses.index', compact('courses'));
    }

    /**
     * Display a listing of categories.
     */
    public function indexCategories()
    {
        $categories = Kategori::latest()->paginate(10);
        return view('layouts.admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function createCategory()
    {
        return view('layouts.admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:kategori',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Kategori::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function editCategory(Kategori $kategori)
    {
        return view('layouts.admin.categories.edit', compact('kategori'));
    }

    /**
     * Update the specified category in storage.
     */
    public function updateCategory(Request $request, Kategori $kategori)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:kategori,nama,' . $kategori->id,
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kategori->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroyCategory(Kategori $kategori)
    {
        // Check if category is being used by any courses
        if ($kategori->kursus()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category because it is being used by courses.');
        }

        $kategori->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Display reports.
     */
    public function reports()
    {
        // Get statistics for reports
        $totalUsers = User::count();
        $totalCourses = Kursus::count();
        $totalCategories = Kategori::count();
        
        // User distribution by role
        $userDistribution = [
            'Admin' => User::where('peran', 'Admin')->count(),
            'Instruktur' => User::where('peran', 'Instruktur')->count(),
            'Peserta' => User::where('peran', 'Peserta')->count(),
        ];
        
        // Course distribution by category
        $courseDistribution = Kategori::withCount('kursus')->get();
        
        // Recent activity (mock data for now)
        $recentActivity = [
            ['user' => 'John Doe', 'action' => 'Created', 'item' => 'Web Development Course', 'time' => '2 hours ago'],
            ['user' => 'Sarah Johnson', 'action' => 'Enrolled', 'item' => 'Data Science Course', 'time' => '5 hours ago'],
            ['user' => 'Michael Chen', 'action' => 'Completed', 'item' => 'UX Design Quiz', 'time' => '1 day ago'],
        ];
        
        return view('layouts.admin.reports.index', compact(
            'totalUsers', 
            'totalCourses', 
            'totalCategories', 
            'userDistribution', 
            'courseDistribution', 
            'recentActivity'
        ));
    }

    /**
     * Display settings.
     */
    public function settings()
    {
        return view('layouts.admin.settings.index');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroyCourse(Kursus $kursus)
    {
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

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    /**
     * Show student selection page for a specific course
     */
    public function selectStudent(Kursus $kursus)
    {
        return view('layouts.admin.courses.student_select', compact('kursus'));
    }

    /**
     * Show student progress for a specific course (for admin)
     */
    public function showStudentProgress(Kursus $kursus, User $user)
    {
        // Ensure the user is a student
        if ($user->peran !== 'Peserta') {
            return redirect()->back()
                ->with('error', 'Invalid user role.');
        }

        // Get student progress for this course
        $progressRecords = ProgresPeserta::where('user_id', $user->id)
            ->whereHas('modul', function ($query) use ($kursus) {
                $query->where('kursus_id', $kursus->id);
            })
            ->with('modul')
            ->get();

        return view('layouts.admin.courses.progress', compact('kursus', 'user', 'progressRecords'));
    }

    /**
     * Reset student progress for a specific course (for admin)
     */
    public function resetStudentProgress(Kursus $kursus, User $user)
    {
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