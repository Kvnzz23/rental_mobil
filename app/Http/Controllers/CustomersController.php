<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $data_customer = Customers::where(
            'nama_customer',
            'LIKE',
            "%$search%"
        )->get();

        return view('pages.data_customer.show', compact('data_customer'));
    }

    public function create()
    {
        return view('pages.data_customer.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required',
            'no_ktp' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        Customers::create([
            'nama_customer' => $request->nama_customer,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ]);

        return redirect('/data-customer');
    }

    public function edit($id)
    {
        $customer = Customers::findOrFail($id);

        return view('pages.data_customer.form', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customers::findOrFail($id);

        $request->validate([
            'nama_customer' => 'required',
            'no_ktp' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        $customer->update([
            'nama_customer' => $request->nama_customer,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ]);

        return redirect('/data-customer');
    }

    public function destroy($id) {
        Customers::findOrFail($id)->delete();
        return redirect('/data-customer');
    }
}
