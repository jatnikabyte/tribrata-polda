<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Update template content by keyword.
     */
    public function update(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $template = Template::updateOrCreate(
            ['keyword' => $request->keyword],
            [
                'content' => $request->content,
                'is_active' => true,
                'updated_by' => auth()->id(),
            ]
        );

        // If newly created, set created_by
        if ($template->wasRecentlyCreated) {
            $template->update(['created_by' => auth()->id()]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Template berhasil diperbarui.',
            'keyword' => $template->keyword,
            'content' => $template->content,
        ]);
    }
}
