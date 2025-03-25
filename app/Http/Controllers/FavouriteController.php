<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function favourite(Event $event)
    {
        try {
            // Debug log untuk membantu pemecahan masalah
            \Log::info('Favourite action started', [
                'event_id' => $event->id,
                'user_id' => Auth::id(),
                'request_type' => request()->ajax() ? 'ajax' : 'normal'
            ]);
            
            $user = Auth::user();
            
            // Debug log untuk cek user
            if (!$user) {
                \Log::error('User tidak ditemukan');
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login terlebih dahulu'
                ], 401);
            }
            
            // Cek apakah sudah favorit
            $isFavourited = $user->favourites()->where('events_id', $event->id)->exists();
            \Log::info('Status favorit saat ini', ['isFavourited' => $isFavourited]);
            
            if ($isFavourited) {
                // Hapus dari favorit
                $result = $user->favourites()->detach($event->id);
                \Log::info('Hasil detach', ['result' => $result]);
                
                $message = 'Event dihapus dari favorit';
                $favourited = false;
            } else {
                // Tambahkan ke favorit
                $result = $user->favourites()->attach($event->id);
                \Log::info('Hasil attach', ['result' => $result]);
                
                $message = 'Event ditambahkan ke favorit';
                $favourited = true;
            }
            
            // Response based on request type
            if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'favourited' => $favourited,
                    'message' => $message
                ]);
            }
            
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            // Log error dengan detail
            \Log::error('Error in favourite action', [
                'event_id' => $event->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function unfavourite(Event $event)
    {
        try {
            $user = Auth::user();
            $user->favourites()->detach($event->id);
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

    public function toggleFavourite(Event $event)
    {
        $user = auth()->user();
        
        if ($user->favouriteEvents()->where('events_id', $event->id)->exists()) {
            $user->favouriteEvents()->detach($event->id);
            return response()->json(['favourited' => false]);
        } else {
            $user->favouriteEvents()->attach($event->id);
            return response()->json(['favourited' => true]);
        }
    }
}