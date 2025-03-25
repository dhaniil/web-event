<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'nomer' => ['nullable', 'string', 'max:13'],
            'kelas' => ['nullable', 'string'],
            'jurusan' => ['nullable', 'string']
        ]);
    
        DB::table('users')
            ->where('id', $user->id)
            ->update($request->only(['name', 'email', 'nomer', 'kelas', 'jurusan']));
    
        activity()
            ->useLog('user')
            ->causedBy($user)
            ->event('profile_update')
            ->withProperties($request->only(['name', 'email', 'nomer', 'kelas', 'jurusan']))
            ->log('User memperbarui profil');
    
        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($request->password)
            ]);

        activity()
            ->useLog('user')
            ->causedBy($user)
            ->event('password_update')
            ->log('User memperbarui password');

        return redirect()->back()->with('success', 'Password berhasil diperbarui');
    }

    public function updateProfilePicture(Request $request)
    {
        // Validasi file
        $validator = Validator::make($request->all(), [
            'profile_picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()->first()], 422);
        }

        try {
            $user = Auth::user();
            $file = $request->file('profile_picture');

            // Hapus file lama jika ada
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Generate nama file unik
            $randomStr = Str::random(8);
            $fileName = 'user' . $user->id . '_' . time() . '_' . $randomStr . '.' . $file->getClientOriginalExtension();

            // Simpan file ke folder profile-pictures
            $path = $file->storeAs('profile-pictures', $fileName, 'public');

            if (!$path) {
                throw new \Exception('Gagal menyimpan file, periksa permission folder storage');
            }

            // Update database
            $updated = DB::table('users')
                ->where('id', $user->id)
                ->update(['profile_picture' => $path]);

            if (!$updated) {
                throw new \Exception('Gagal mengupdate database');
            }

            // Log aktivitas
            activity()
                ->useLog('user')
                ->causedBy($user)
                ->event('profile_picture_update')
                ->log('User memperbarui foto profil');

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diperbarui',
                'image_url' => asset('storage/' . $path)
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Gagal mengupload foto: ' . $e->getMessage()], 500);
        }
    }

    public function deleteProfilePicture()
    {
        try {
        $user = Auth::user();

            if (!$user->profile_picture) {
                return redirect()->back()->with('error', 'Tidak ada foto profil untuk dihapus');
            }

            // Hapus file dari storage
            if (Storage::disk('public')->exists($user->profile_picture)) {
                $deleted = Storage::disk('public')->delete($user->profile_picture);
                
                if (!$deleted) {
                    throw new \Exception('Gagal menghapus file dari storage');
                }
            }
            
            // Update database
            $updated = DB::table('users')
                ->where('id', $user->id)
                ->update(['profile_picture' => null]);

            if (!$updated) {
                throw new \Exception('Gagal mengupdate database');
            }

            // Log aktivitas
            activity()
                ->useLog('user')
                ->causedBy($user)
                ->event('profile_picture_delete')
                ->log('User menghapus foto profil');

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus');
            
        } catch (\Exception $e) {
            Log::error('Delete foto profil gagal', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'Gagal menghapus foto: ' . $e->getMessage());
        }
    }

    public function updateKelasJurusan(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'kelas' => ['nullable', 'string'],
            'jurusan' => ['nullable', 'string']
        ]);
        
        DB::table('users')
            ->where('id', $user->id)
            ->update($request->only(['kelas', 'jurusan']));
            
        activity()
            ->useLog('user')
            ->causedBy($user)
            ->event('kelas_jurusan_update')
            ->withProperties($request->only(['kelas', 'jurusan']))
            ->log('User memperbarui kelas dan jurusan');
            
        return redirect()->back()->with('success', 'Kelas dan jurusan berhasil diperbarui');
    }

    public function destroy()
    {
        $user = Auth::user();

        // Hapus foto profil jika ada
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Log aktivitas
        activity()
            ->useLog('user')
            ->causedBy($user)
            ->event('account_delete')
            ->log('User menghapus akun');

        // Logout dan hapus akun
        Auth::logout();
        DB::table('users')->where('id', $user->id)->delete();

        return redirect('/');
    }

    public function editProfile(Request $request)
    {
        return $this->edit($request);
    }
}
