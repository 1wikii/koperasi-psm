<?php

namespace App\Http\Controllers\superAdmin;

use App\Http\Controllers\Controller;
use App\Models\PaymentAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentAccountController extends Controller
{
    public function index()
    {
        $paymentAccounts = PaymentAccounts::where('is_active', true)->get();
        return view('pages.superAdmin.paymentAccount', compact('paymentAccounts'));
    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            $request->validate([
                'bank_nama' => 'required|string|max:255',
                'account_number' => 'required|string|max:50',
                'account_holder_name' => 'required|string|max:255'
            ]);

            PaymentAccounts::create($request->all());

            DB::commit();

            return redirect()->back()->with('success', 'Payment account berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }


    }

    public function update(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            $request->validate([
                'bank_name' => 'required|string|max:255',
                'account_number' => 'required|string|max:50',
                'account_holder_name' => 'required|string|max:255'
            ]);

            PaymentAccounts::findOrFail($id)->update($request->all());

            DB::commit();

            return redirect()->back()->with('success', 'Payment account berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            PaymentAccounts::findOrFail($id)->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Payment account berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }




    }
}
