<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $model = $modelClass::findOrFail($request->id);

        // Check if already liked
        $existingLike = $model->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $model->decrement('likes_count');
            $liked = false;
        } else {
            $model->likes()->create(['user_id' => $user->id]);
            $model->increment('likes_count');
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $model->likes_count
        ]);
    }
}
