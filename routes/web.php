<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionVoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ProfileAnswerController;
use App\Http\Controllers\ProfileUpvoteController;
use App\Http\Controllers\ProfileBookmarkController;
use App\Http\Controllers\ProfileQuestionController;
use App\Http\Controllers\ProfileStatsController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminAnalyticsController;
use App\Http\Controllers\AdminQuestionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminReportController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [DashboardController::class, 'index'])->name('welcome');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/question/{id}', [QuestionController::class, 'show'])->name('question.show');

// Tag routes (public)
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');

// Apply the logout.banned middleware to all web routes that require authentication
Route::middleware(['auth', 'logout.banned'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Question routes
    Route::get('/question', [QuestionController::class, 'create'])->name('question.create');
    Route::post('/question', [QuestionController::class, 'store'])->name('question.store');
    Route::get('/question/{question}/edit', [QuestionController::class, 'edit'])->name('question.edit');
    Route::put('/question/{question}', [QuestionController::class, 'update'])->name('question.update');
    Route::delete('/question/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');

    // Answer routes that require authentication
    Route::post('/question/{question}/answer', [AnswerController::class, 'store'])->name('answer.store');
    Route::put('/answer/{answer}', [AnswerController::class, 'update'])->name('answer.update');
    Route::delete('/answer/{answer}', [AnswerController::class, 'destroy'])->name('answer.destroy');
    Route::post('/answer/{answer}/accept', [AnswerController::class, 'accept'])->name('answer.accept');
    Route::get('/answer/{answer}/edit-external', [AnswerController::class, 'editExternal'])->name('answer.edit_external');

    // Vote routes
    Route::post('/answer/{answer}/upvote', [VoteController::class, 'upvote'])->name('answer.upvote');
    Route::post('/answer/{answer}/downvote', [VoteController::class, 'downvote'])->name('answer.downvote');
    Route::post('/questions/{question}/upvote', [QuestionVoteController::class, 'upvote'])->name('question_vote.upvote');
    Route::post('/questions/{question}/downvote', [QuestionVoteController::class, 'downvote'])->name('question_vote.downvote');

    // Bookmark routes
    Route::post('/question/{question}/bookmark', [BookmarkController::class, 'store'])->name('question.bookmark');
    Route::delete('/question/{question}/bookmark', [BookmarkController::class, 'destroy'])->name('question.unbookmark');

    // Profile bookmarks
    Route::get('/profile/bookmarks', [ProfileBookmarkController::class, 'index'])->name('profile.bookmarks');

    // Profile answers
    Route::get('/profile/answers', [ProfileAnswerController::class, 'index'])->name('profile.answers');

    // Profile upvoted questions
    Route::get('/profile/upvoted', [ProfileUpvoteController::class, 'index'])->name('profile.upvoted');

    // Profile questions
    Route::get('/profile/questions', [ProfileQuestionController::class, 'index'])->name('profile.questions');

    // Profile stats
    Route::get('/profile/stats', [ProfileStatsController::class, 'index'])->name('profile.stats');

    // Report system
    Route::get('/report/create', [ReportController::class, 'create'])->name('report.create');
    Route::post('/report', [ReportController::class, 'store'])->name('report.store');
});

// Admin Dashboard Route
Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Admin user management CRUD
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });

    // Admin Questions (under /admin so they do not override the public /questions page)
    Route::get('/admin/questions', [AdminQuestionController::class, 'index'])->name('admin.questions.index');
    Route::get('/admin/questions/{id}/edit', [AdminQuestionController::class, 'edit'])->name('admin.questions.edit');
    Route::put('/admin/questions/{id}', [AdminQuestionController::class, 'update'])->name('admin.questions.update');
    Route::delete('/admin/questions/{id}', [AdminQuestionController::class, 'destroy'])->name('admin.questions.destroy');

    // Admin Analytics
    Route::get('/admin/analytics', [AdminAnalyticsController::class, 'index'])->name('admin.analytics.index');

    // Admin report management
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/reports/{id}', [AdminReportController::class, 'show'])->name('admin.reports.display');
        Route::post('/reports/{id}/process', [AdminReportController::class, 'process'])->name('admin.reports.process');
        Route::post('/reports/ban-user/{id}', [AdminReportController::class, 'banUser'])->name('admin.reports.banUser');
        Route::post('/reports/unban-user/{id}', [AdminReportController::class, 'unbanUser'])->name('admin.reports.unbanUser');
    });
});

require __DIR__.'/auth.php';
