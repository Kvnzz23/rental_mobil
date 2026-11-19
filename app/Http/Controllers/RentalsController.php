<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use App\Models\Customers;
use App\Models\Rentals;
use Illuminate\Http\Request;

class RentalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_rental = Rentals::with('customer', 'car')->latest()->get();
        return view('pages.data_rental.show', compact('data_rental'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customers::all();
        $cars      = Cars::where('status', 'tersedia')->get();
        return view('pages.data_rental.form', compact('customers', 'cars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'     => 'required',
            'car_id'          => 'required',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status'          => 'required',
            'total_harga'     => 'required|numeric',
        ]);

        Rentals::create([
            'customer_id'     => $request->customer_id,
            'car_id'          => $request->car_id,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'total_harga'     => $request->total_harga,
            'status'          => $request->status,
        ]);

        Cars::where('id_cars', $request->car_id)->update(['status' => 'disewa']);
        return redirect('/data-rental');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function selesai($id) {
        $rental = Rentals::findOrFail($id);

        $rental->update(['status'=>'selesai']);
        $rental->car->update(['status'=>'tersedia']);

        return redirect('/data-rental');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rental = Rentals::findOrFail($id);
        $customers = Customers::all();
        $cars      = Cars::where('status', 'tersedia');
        return view('pages.data_rental.form', compact('rental', 'customers', 'cars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rental = Rentals::findOrFail($id);

        $request->validate([
            'customer_id'     => 'required',
            'car_id'          => 'required',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status'          => 'required',
            'total_harga'     => 'required|numeric',
        ]);

        $rental->update([
            'customer_id'     => $request->customer_id,
            'car_id'          => $request->car_id,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'total_harga'     => $request->total_harga,
            'status'          => $request->status,
        ]);

        if (in_array($request->status, ['selesai', 'batal'])) {
            Cars::where('id_cars', $request->car_id)->update(['status' => 'tersedia']);
        } else {
            Cars::where('id_cars', $request->car_id)->update(['status' => 'disewa']);
        }

        return redirect('/data-rental');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rental = Rentals::findOrFail($id);

        if ($rental->status != 'selesai' && $rental->car) {
            $rental->car->update(['status' => 'tersedia']);
        }

        $rental->delete();

        return redirect('/data-rental')->with('success', 'Data rental berhasil dihapus!');
    }
}
