<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Article;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        // Get download articles for navigation
        $download = Article::where('category', 'download')
            ->where('enabled', 1);

        return view('website.page', compact('page', 'download'));
    }
}