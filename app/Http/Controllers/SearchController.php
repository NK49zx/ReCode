<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    // Search for questions by title and return JSON response
    public function search(Request $request): JsonResponse
    {
        try {
            // Validate search query length
            if (!$request->has('q') || strlen($request->q) < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search query too short'
                ]);
            }

            $query = $request->get('q');
            $questions = Question::where('title', 'like', "%{$query}%")
                ->with(['tags', 'user'])
                ->withCount('answers')
                ->select(['id', 'title', 'views', 'user_id'])
                ->take(5)
                ->get()
                ->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'title' => $question->title,
                        'views' => $question->views,
                        'answers' => $question->answers->count(),
                        'tags' => $question->tags->pluck('name')
                    ];
                });

            // Return successful search results
            return response()->json([
                'success' => true,
                'data' => $questions
            ]);

        } catch (\Exception $e) {
            // Handle errors and return error message
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during search.'
            ], 500);
        }
    }
}
