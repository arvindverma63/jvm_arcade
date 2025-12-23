<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// 1. Import the Notification Class
use App\Notifications\UserActionNotification;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string',
        ]);

        $user = Auth::user();
        $modelClass = $request->type;

        // Find the Snippet or Comment
        $model = $modelClass::findOrFail($request->id);

        // Check if already liked
        $existingLike = $model->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            // UN-LIKE Logic
            $existingLike->delete();
            $model->decrement('likes_count');
            $liked = false;
        } else {
            // LIKE Logic
            $model->likes()->create(['user_id' => $user->id]);
            $model->increment('likes_count');
            $liked = true;

            // --- [NOTIFICATION LOGIC] ---
            // Only send if the user is liking SOMEONE ELSE'S content
            if ($model->user_id !== $user->id) {

                // Get a readable name (e.g., "Snippet" or "Comment")
                $contentType = class_basename($model);

                // Send notification to the OWNER of the content ($model->user)
                $model->user->notify(new UserActionNotification(
                    "{$user->name} liked your {$contentType}."
                ));
            }
            // ----------------------------
        }

        return response()->json([
            'liked' => $liked,
            'count' => $model->likes_count
        ]);
    }
}
