<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function favourite($eventId)
    {
        try {
            $user = auth()->user();
            if (!$user->favourites()->where('events_id', $eventId)->exists()) {
                $user->favourites()->attach($eventId);
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'Already favorited']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function unfavourite($eventId)
    {
        try {
            $user = auth()->user();
            $user->favourites()->wherePivot('events_id', $eventId)->detach();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function favouriteEvents()
    {
        $favourites = Favourite::with('event')
                             ->where('user_id', Auth::id())
                             ->paginate(10);

        $user = Auth::user();

        return view('favourites.index', compact('favourites', 'user'));
    }
}