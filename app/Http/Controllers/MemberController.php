<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index()
    {
        // Fetch all users except the currently logged-in user
        // Eager load counts to avoid N+1 performance issues
        $users = User::where('id', '!=', Auth::id())
                     ->withCount(['followers', 'following', 'snippets'])
                     ->paginate(24); // Show 24 per page

        return view('pages.members', compact('users'));
    }
}
