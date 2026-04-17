<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Tabloid;
use App\Models\Subscriber;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class TabloidController extends Controller
{
    public function index(): View
    {
        $totalFollow = Subscriber::count();
        $totalViews = Tabloid::sum('view_count');
        $tabloids = Tabloid::where('is_active', true)
            ->withCount('subscribers')
            ->latest()
            ->paginate(12);

        return view('public.tabloids.index', compact(['tabloids','totalViews','totalFollow']));
    }

    public function incrementViewCount($tabloid): JsonResponse
    {
        $tabloidId = decryptID($tabloid);
        $tabloid = Tabloid::find($tabloidId);
        $tabloid->increment('view_count');

        // If subscriber cookie exists, create/update tabloid_subscribers record
        $subscriberEmail = request()->cookie('subscriber_email');
        if ($subscriberEmail) {
            $subscriber = Subscriber::where('email', $subscriberEmail)->first();
            if ($subscriber) {
                // Sync without detaching - creates pivot if not exists, updates subscribed_at if exists
                $subscriber->tabloids()->syncWithoutDetaching([
                    $tabloidId => ['subscribed_at' => now()]
                ]);
            }
        }

        return response()->json(['success' => true, 'view_count' => $tabloid->fresh()->view_count]);
    }
}
