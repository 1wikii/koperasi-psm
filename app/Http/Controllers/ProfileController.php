<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\UserAdresses;
use App\Services\FileUploadService;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('pages.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|numeric',
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png|max:1024', // 1MB
        ]);

        try {
            DB::beginTransaction();

            // Update foto jika ada
            $fileUploadService = new FileUploadService();
            $validated['profile_photo_path'] = $fileUploadService->upload($request, 'profile_photo', 'profile', $user->profile_photo_path);

            // Simpan data
            $user->update($validated);

            DB::commit();

            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * index alamat
     */

    public function address()
    {
        $data = UserAdresses::where('user_id', Auth::id())->get();
        return view('pages.profile.address', compact('data'));
    }

    /**
     * Tambah alamat
     */
    public function addAddress(Request $request)
    {
        // Validasi data sesuai dengan form Anda
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:20',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:1000',
        ], [
            'label.required' => 'Label alamat wajib diisi',
            'label.max' => 'Label alamat maksimal 20 karakter',
            'recipient_name.required' => 'Nama penerima wajib diisi',
            'phone.required' => 'Nomor telepon wajib diisi',
            'phone.max' => 'Nomor telepon maksimal 15 karakter',
            'postal_code.required' => 'Kode pos wajib diisi',
            'postal_code.max' => 'Kode pos maksimal 10 karakter',
            'address.required' => 'Detail alamat wajib diisi',
            'address.max' => 'Detail alamat maksimal 1000 karakter',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan dalam pengisian form.');
        }

        try {

            DB::beginTransaction();
            // Data provinsi dan kabupaten dari form (hardcoded)
            $province = 'Lampung';
            $regency = 'Way Kanan';

            // Gabungkan alamat lengkap
            $fullAddress = $request->address . ', ' . $regency . ', ' . $province . ', ' . $request->postal_code;

            // Simpan alamat ke database
            $address = new UserAdresses();
            $address->user_id = Auth::id();
            $address->label = $request->label; // Sesuai dengan name="label" di form
            $address->recipient_name = $request->recipient_name;
            $address->phone = $request->phone;
            $address->address = $fullAddress;
            $address->postal_code = $request->postal_code;
            $address->save();

            DB::commit();

            return redirect()->back()->with('success', 'Alamat berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateAddress(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $address = UserAdresses::findOrFail($id);

            $validated = $request->validate([
                'label' => 'required|string|max:20',
                'phone' => 'required|string|max:15',
                'recipient_name' => 'required|string|max:255',
                'postal_code' => 'required|string|max:10',
                'address' => 'required|string|max:500',
            ], [
                'label.required' => 'Label alamat harus diisi',
                'label.max' => 'Label alamat maksimal 20 karakter',
                'phone.required' => 'Nomor telepon harus diisi',
                'phone.max' => 'Nomor telepon maksimal 15 karakter',
                'recipient_name.required' => 'Nama penerima harus diisi',
                'recipient_name.max' => 'Nama penerima maksimal 255 karakter',
                'postal_code.required' => 'Kode pos harus diisi',
                'postal_code.max' => 'Kode pos maksimal 10 karakter',
                'address.required' => 'Detail alamat harus diisi',
                'address.max' => 'Detail alamat maksimal 500 karakter',
            ]);

            // Add default province and district
            $validated['province'] = 'Lampung';
            $validated['district'] = 'Way Kanan';

            $address->update($validated);

            DB::commit();

            return redirect()->back()->with('success', 'Alamat berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menghapus alamat
     */
    public function delAddress($id)
    {
        try {
            DB::beginTransaction();

            $address = UserAdresses::where('user_id', Auth::id())->findOrFail($id);
            $address->delete();

            DB::commit();
            return redirect()->back()
                ->with('success', 'Alamat berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function orders()
    {
        $orders = Orders::with('orderItems.products')->where('user_id', Auth::id())->get()->map(function ($order) {
            $order->date = Carbon::parse($order->created_at)->format('d-m-Y');
            return $order;
        });

        return view('pages.profile.myOrders', compact('orders'));
    }

    public function completeOrder($id)
    {
        try {
            DB::beginTransaction();

            $order = Orders::where('user_id', Auth::id())->findOrFail($id);
            $order->status = 'completed'; // Atur status menjadi 'completed'
            $order->save();

            DB::commit();
            return redirect()->back()
                ->with('success', 'Pesanan berhasil diselesaikan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
