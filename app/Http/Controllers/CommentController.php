<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
            'commentable_id' => 'required|integer',
            'commentable_type' => 'required|string',
        ]);
        $allowed = ['App\Models\Snippet', 'App\Models\Post', 'App\Models\Comment'];

        if (!in_array($request->commentable_type, $allowed)) {
            abort(403, 'Invalid comment target');
        }

        // Create the comment
        Comment::create([
            'user_id' => Auth::id(),
            'body' => $request->body, // Contains HTML from Quill
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $request->commentable_type,
            'votes' => 0,
            'is_solution' => false,
        ]);

        return back()->with('success', 'Comment posted successfully!');
    }

    // app/Http/Controllers/CommentController.php

    public function update(Request $request, $id)
    {
        $comment = \App\Models\Comment::findOrFail($id);

        // 1. Authorization Check
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // 2. 7-Day Time Limit Check
        if ($comment->created_at->lt(now()->subDays(7))) {
            return back()->with('error', 'You can only edit comments within 7 days.');
        }

        $request->validate(['body' => 'required|string']);
        $comment->update(['body' => $request->body]);

        return back()->with('success', 'Comment updated successfully.');
    }

    public function destroy($id)
    {
        $comment = \App\Models\Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($comment->created_at->lt(now()->subDays(7))) {
            return back()->with('error', 'You can only delete comments within 7 days.');
        }

        $comment->delete(); // This will cascade delete replies if set up in DB, otherwise handled by code
        return back()->with('success', 'Comment deleted.');
    }
}
