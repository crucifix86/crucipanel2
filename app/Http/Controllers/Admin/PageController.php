<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('order')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'nav_title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'active' => 'boolean',
            'show_in_nav' => 'boolean',
            'order' => 'nullable|integer',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $validated['active'] = $request->has('active');
        $validated['show_in_nav'] = $request->has('show_in_nav');
        $validated['order'] = $validated['order'] ?? 0;

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', __('admin.page_created'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'nav_title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'active' => 'boolean',
            'show_in_nav' => 'boolean',
            'order' => 'nullable|integer',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $validated['active'] = $request->has('active');
        $validated['show_in_nav'] = $request->has('show_in_nav');
        $validated['order'] = $validated['order'] ?? 0;

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', __('admin.page_updated'));
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', __('admin.page_deleted'));
    }

    public function toggle(Page $page)
    {
        $page->update(['active' => !$page->active]);
        return redirect()->route('admin.pages.index')->with('success', __('admin.page_status_updated'));
    }
}