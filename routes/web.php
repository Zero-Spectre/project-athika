<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\DiskusiController;
use App\Http\Controllers\AccountController;
// use App\Http\Controllers\GeminiController; // Removed GeminiController

// Public routes
Route::get('/', function () {
    return view('landing');
})->name('home');

// Test route for AI functionality
Route::get('/test-ai', function () {
    // Test if we can access the environment variables
    $apiKey = env('OPENROUTER_API_KEY');
    
    // Try fallback method
    if (!$apiKey) {
        $envFile = base_path('.env');
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    $value = trim($value, '"\'');
                    
                    if ($key === 'OPENROUTER_API_KEY') {
                        $apiKey = $value;
                        break;
                    }
                }
            }
        }
    }
    
    return response()->json([
        'api_key_present' => !empty($apiKey),
        'api_key_length' => $apiKey ? strlen($apiKey) : 0,
        'api_key_preview' => $apiKey ? substr($apiKey, 0, 10) . '...' : null,
    ]);
});

// Redirect based on role
Route::get('/dashboard', [AuthController::class, 'redirectBasedOnRole'])->name('redirectBasedOnRole');

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/password/reset', [AuthController::class, 'showPasswordResetForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendPasswordResetLink'])->name('password.email');

// Community Discussion routes (available to all authenticated users)
Route::middleware('auth')->prefix('diskusi')->group(function () {
    Route::get('/', [DiskusiController::class, 'index'])->name('diskusi.index');
    Route::get('/create', [DiskusiController::class, 'create'])->name('diskusi.create');
    Route::post('/', [DiskusiController::class, 'store'])->name('diskusi.store');
    Route::get('/{diskusiTopik}', [DiskusiController::class, 'show'])->name('diskusi.show');
    Route::get('/{diskusiTopik}/edit', [DiskusiController::class, 'edit'])->name('diskusi.edit');
    Route::put('/{diskusiTopik}', [DiskusiController::class, 'update'])->name('diskusi.update');
    Route::delete('/{diskusiTopik}', [DiskusiController::class, 'destroy'])->name('diskusi.destroy');
    
    // Comment routes
    Route::post('/{diskusiTopik}/comments', [DiskusiController::class, 'addComment'])->name('diskusi.comments.store');
    Route::get('/comments/{diskusiKomentar}/edit', [DiskusiController::class, 'editComment'])->name('diskusi.comments.edit');
    Route::put('/comments/{diskusiKomentar}', [DiskusiController::class, 'updateComment'])->name('diskusi.comments.update');
    Route::delete('/comments/{diskusiKomentar}', [DiskusiController::class, 'destroyComment'])->name('diskusi.comments.destroy');
    
    // Like routes
    Route::post('/{diskusiTopik}/like', [DiskusiController::class, 'likeTopic'])->name('diskusi.like');
    Route::post('/comments/{diskusiKomentar}/like', [DiskusiController::class, 'likeComment'])->name('diskusi.comments.like');
    
    // Mark as resolved
    Route::post('/{diskusiTopik}/resolve', [DiskusiController::class, 'markAsResolved'])->name('diskusi.resolve');
    
    // Mistral AI routes
    Route::post('/ask-ai', [\App\Http\Controllers\MistralAIController::class, 'askQuestion'])->name('diskusi.ask.ai');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Account settings routes
    Route::get('/account/settings', [AccountController::class, 'showSettings'])->name('account.settings');
    Route::post('/account/settings', [AccountController::class, 'updateSettings'])->name('account.update');
    
    // Admin routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // User management routes
        Route::get('/users', [AdminController::class, 'indexUsers'])->name('admin.users.index');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        
        // Course management routes
        Route::get('/courses', [AdminController::class, 'indexCourses'])->name('admin.courses.index');
        Route::delete('/courses/{kursus}', [AdminController::class, 'destroyCourse'])->name('admin.courses.destroy');
        Route::get('/courses/{kursus}/students', [AdminController::class, 'selectStudent'])->name('admin.courses.students.select');
        // Student progress routes
        Route::get('/courses/{kursus}/students/{user}/progress', [AdminController::class, 'showStudentProgress'])->name('admin.courses.progress.show');
        Route::delete('/courses/{kursus}/students/{user}/progress/reset', [AdminController::class, 'resetStudentProgress'])->name('admin.courses.progress.reset');
        
        // Category management routes
        Route::get('/categories', [AdminController::class, 'indexCategories'])->name('admin.categories.index');
        Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::get('/categories/{kategori}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
        Route::put('/categories/{kategori}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
        Route::delete('/categories/{kategori}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
        
        // Reports and settings
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports.index');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings.index');
    });
    
    // Instructor routes
    Route::middleware('instruktur')->prefix('instruktur')->group(function () {
        Route::get('/dashboard', [InstructorController::class, 'dashboard'])->name('instruktur.dashboard');
        
        // Analytics route
        Route::get('/analytics', [InstructorController::class, 'analytics'])->name('instruktur.analytics.index');
        
        // Course routes
        Route::get('/courses', [InstructorController::class, 'index'])->name('instruktur.courses.index');
        Route::get('/courses/create', [InstructorController::class, 'create'])->name('instruktur.courses.create');
        Route::post('/courses', [InstructorController::class, 'store'])->name('instruktur.courses.store');
        Route::get('/courses/{kursus}', [InstructorController::class, 'show'])->name('instruktur.courses.show');
        Route::get('/courses/{kursus}/edit', [InstructorController::class, 'edit'])->name('instruktur.courses.edit');
        Route::put('/courses/{kursus}', [InstructorController::class, 'update'])->name('instruktur.courses.update');
        Route::delete('/courses/{kursus}', [InstructorController::class, 'destroy'])->name('instruktur.courses.destroy');
        
        // Module routes
        Route::get('/courses/{kursus}/modules', [InstructorController::class, 'showModules'])->name('instruktur.modules.index');
        Route::get('/courses/{kursus}/modules/create', [InstructorController::class, 'createModule'])->name('instruktur.modules.create');
        Route::post('/courses/{kursus}/modules', [InstructorController::class, 'storeModule'])->name('instruktur.modules.store');
        Route::get('/modules/{modul}/edit', [InstructorController::class, 'editModule'])->name('instruktur.modules.edit');
        Route::put('/modules/{modul}', [InstructorController::class, 'updateModule'])->name('instruktur.modules.update');
        Route::delete('/modules/{modul}', [InstructorController::class, 'destroyModule'])->name('instruktur.modules.destroy');
        
        // Quiz routes
        Route::get('/modules/{modul}/quizzes', [InstructorController::class, 'showQuizzes'])->name('instruktur.modules.quizzes.index');
        Route::get('/modules/{modul}/quizzes/create', [InstructorController::class, 'createQuiz'])->name('instruktur.modules.quizzes.create');
        Route::post('/modules/{modul}/quizzes', [InstructorController::class, 'storeQuiz'])->name('instruktur.modules.quizzes.store');
        Route::get('/quizzes/{kuis}/edit', [InstructorController::class, 'editQuiz'])->name('instruktur.modules.quizzes.edit');
        Route::put('/quizzes/{kuis}', [InstructorController::class, 'updateQuiz'])->name('instruktur.modules.quizzes.update');
        Route::delete('/quizzes/{kuis}', [InstructorController::class, 'destroyQuiz'])->name('instruktur.modules.quizzes.destroy');
        
        // Student progress routes
        Route::get('/courses/{kursus}/progress', [InstructorController::class, 'showStudentProgress'])->name('instruktur.courses.progress');
        // Reset student progress route
        Route::delete('/courses/{kursus}/students/{user}/progress/reset', [InstructorController::class, 'resetStudentProgress'])->name('instruktur.courses.progress.reset');
    });
    
    // Participant routes
    Route::middleware('peserta')->prefix('peserta')->group(function () {
        Route::get('/dashboard', [ParticipantController::class, 'dashboard'])->name('peserta.dashboard');
        
        // Course routes
        Route::get('/courses', [ParticipantController::class, 'indexCourses'])->name('peserta.courses.index');
        Route::get('/courses/{kursus}', [ParticipantController::class, 'showCourse'])->name('peserta.courses.show');
        Route::post('/courses/{kursus}/enroll', [ParticipantController::class, 'enrollCourse'])->name('peserta.courses.enroll');
        
        // Module routes
        Route::get('/courses/{kursus}/modules', [ParticipantController::class, 'indexModules'])->name('peserta.modules.index');
        Route::get('/modules/{modul}', [ParticipantController::class, 'showModule'])->name('peserta.modules.show');
        Route::get('/modules/{modul}/export-pdf', [ParticipantController::class, 'exportModuleToPdf'])->name('peserta.modules.export-pdf');
        Route::post('/modules/{modul}/complete', [ParticipantController::class, 'completeModule'])->name('peserta.modules.complete');
        
        // Quiz routes
        Route::get('/quizzes', [ParticipantController::class, 'indexQuizzes'])->name('peserta.quizzes.index');
        Route::get('/quizzes/{kuis}', [ParticipantController::class, 'showQuiz'])->name('peserta.quizzes.show');
        Route::post('/quizzes/{kuis}/submit', [ParticipantController::class, 'submitQuiz'])->name('peserta.quizzes.submit');
        
        // Progress and certificates
        Route::get('/progress', [ParticipantController::class, 'progress'])->name('peserta.progress.index');
        Route::get('/certificates', [ParticipantController::class, 'certificates'])->name('peserta.certificates.index');
        Route::get('/certificate/{kursus}', [ParticipantController::class, 'viewCertificate'])->name('peserta.certificate.view');
    });
});