<?php

/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\User;
use hrace009\PerfectWorldAPI\API; // Import the API class

class Home extends Controller
{
    public function index()
    {
        $news = News::orderBy('id', 'desc')->whereNotIn('category', ['download', 'guide'])->paginate(3);

        // Fetch news items for 'download' category for the navbar
        $download = News::where('category', 'download')->orderBy('created_at', 'desc');

        // Fetch news items for 'guide' category for the navbar
        $guide = News::where('category', 'guide')->orderBy('created_at', 'desc');

        // Data for Widgets
        $api = new API();

        // **FIXED**: Query for Admins and GMs using the 'role' column.
        $gms = User::where('role', 'Administrator')
            ->orWhere('role', 'Gamemaster')
            ->take(5)
            ->get();

        $totalUser = User::count();

        return view('website.home', [
            'news' => $news,
            'download' => $download,
            'guide' => $guide,
            'api' => $api,           // Pass API object to the view
            'gms' => $gms,           // Pass GMs collection to the view
            'totalUser' => $totalUser, // Pass total user count
        ]);
    }

    public function indexCategory(string $category)
    {
        // Fetch news items for 'download' category for the navbar
        $download = News::where('category', 'download')->orderBy('created_at', 'desc');

        // Fetch news items for 'guide' category for the navbar
        $guide = News::where('category', 'guide')->orderBy('created_at', 'desc');

        // Data for Widgets
        $api = new API();
        
        // **FIXED**: Query for Admins and GMs using the 'role' column.
        $gms = User::where('role', 'Administrator')
            ->orWhere('role', 'Gamemaster')
            ->take(5)
            ->get();
        
        $totalUser = User::count();

        return view('website.index', [
            'news' => News::whereCategory($category)->paginate(3),
            'download' => $download,
            'guide' => $guide,
            'api' => $api,
            'gms' => $gms,
            'totalUser' => $totalUser,
            'category_name' => $category // Pass category name for the title
        ]);
    }

    public function showPost(string $slug)
    {
        // Fetch news items for 'download' category for the navbar
        $download = News::where('category', 'download')->orderBy('created_at', 'desc');

        // Fetch news items for 'guide' category for the navbar
        $guide = News::where('category', 'guide')->orderBy('created_at', 'desc');

        // Data for Widgets
        $api = new API();
        
        // **FIXED**: Query for Admins and GMs using the 'role' column.
        $gms = User::where('role', 'Administrator')
            ->orWhere('role', 'Gamemaster')
            ->take(5)
            ->get();

        $totalUser = User::count();

        return view('website.article', [
            'article' => News::whereSlug($slug)->firstOrFail(),
            'download' => $download,
            'guide' => $guide,
            'api' => $api,
            'gms' => $gms,
            'totalUser' => $totalUser,
        ]);
    }

    public function indexTags(string $tag)
    {
        // Fetch news items for 'download' category for the navbar
        $download = News::where('category', 'download')->orderBy('created_at', 'desc');

        // Fetch news items for 'guide' category for the navbar
        $guide = News::where('category', 'guide')->orderBy('created_at', 'desc');

        // Data for Widgets
        $api = new API();
        
        // **FIXED**: Query for Admins and GMs using the 'role' column.
        $gms = User::where('role', 'Administrator')
            ->orWhere('role', 'Gamemaster')
            ->take(5)
            ->get();

        $totalUser = User::count();

        return view('website.index', [
            'news' => News::where('keywords', 'LIKE', '%' . $tag . '%')->orderByDesc('created_at')->paginate(3),
            'download' => $download,
            'guide' => $guide,
            'api' => $api,
            'gms' => $gms,
            'totalUser' => $totalUser,
            'tag_name' => $tag // Pass tag name for the title
        ]);
    }
}
