<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('public.pages.index', compact('pages'));
    }

    public function show(string $slug): View
    {
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.pages.show', compact('page'));
    }
}
