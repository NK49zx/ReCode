<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Tag;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalQuestions = Question::count();
        $answeredQuestions = Question::has('answers')->count();
        $totalAnswers = Answer::count();
        $popularTags = Tag::withCount('questions')->orderByDesc('questions_count')->take(5)->get();

        // User registrations per day for the last 14 days
        $userRegistrations = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Chart data
        $labels = collect(range(0, 13))->map(fn($i) => now()->subDays(13 - $i)->format('Y-m-d'))->toArray();
        $data = array_map(fn($date) => $userRegistrations[$date] ?? 0, $labels);

        return view('admin.analytics.index', compact(
            'totalUsers',
            'totalQuestions',
            'answeredQuestions',
            'totalAnswers',
            'popularTags',
            'labels',
            'data'
        ));
    }
}
