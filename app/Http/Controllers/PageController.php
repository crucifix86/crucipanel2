<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\News;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        // Get download articles for navigation
        $download = News::where('category', 'download')
            ->orderBy('created_at', 'desc');

        return view('website.page', compact('page', 'download'));
    }
}