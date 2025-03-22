<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UlasanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:500',
        ]);

        try {
            // Cek apakah pengguna sudah memberikan ulasan untuk event ini
            $existingUlasan = Ulasan::where('user_id', auth()->id())
                                    ->where('event_id', $request->event_id)
                                    ->first();
            
            if ($existingUlasan) {
                // Update ulasan yang sudah ada
                $existingUlasan->rating = $request->rating;
                $existingUlasan->komentar = $request->komentar;
                $existingUlasan->updated_at = now();
                $existingUlasan->save();
                
                $message = 'Ulasan berhasil diperbarui';
            } else {
                // Buat ulasan baru
                $ulasan = new Ulasan();
                $ulasan->event_id = $request->event_id;
                $ulasan->user_id = auth()->id();
                $ulasan->rating = $request->rating;
                $ulasan->komentar = $request->komentar;
                $ulasan->save();
                
                $message = 'Ulasan berhasil ditambahkan';
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            // Log minimal untuk production
            \Log::error('Error adding review', [
                'event_id' => $request->event_id,
                'error' => $e->getMessage()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan. Silakan coba lagi.'
                ], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}