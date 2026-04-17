<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function index(): View
    {
        $videos = Video::where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('public.videos.index', compact('videos'));
    }

    public function show(string $slug): View
    {
        $video = Video::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $video->increment('view_count');

        return view('public.videos.show', compact('video'));
    }
}
