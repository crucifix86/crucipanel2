<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    public function show($slug): JsonResponse
    {
        try {
            $article = News::where('slug', $slug)->first();
            
            if (!$article) {
                return response()->json([
                    'success' => false,
                    'message' => 'Article not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'article' => [
                    'title' => $article->title,
                    'content' => $article->content,
                    'category' => $article->category,
                    'author' => $article->author,
                    'date' => $article->date($article->created_at),
                    'description' => $article->description,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading article'
            ], 500);
        }
    }
}