<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use App\Models\Customers;
use App\Models\Rentals;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMobil     = Cars::count();
        $mobilTersedia  = Cars::where('status', 'tersedia')->count();
        $mobilDisewa    = Cars::where('status', 'disewa')->count();
        $totalPelanggan = Customers::count();

        $totalRental        = Rentals::count();
        $rentalAktif        = Rentals::where('status', 'aktif')->count();
        $totalPendapatan    = Rentals::where('status', 'selesai')->sum('total_harga');

        $mobilTerbaru    = Cars::latest()->take(5)->get();
        $rentalTerbaru   = Rentals::with('customer', 'car')->latest()->take(5)->get();

        return view('pages.dashboard.show', compact(
            'totalMobil',
            'mobilTersedia',
            'mobilDisewa',
            'totalPelanggan',
            'totalRental',
            'rentalAktif',
            'totalPendapatan',
            'mobilTerbaru',
            'rentalTerbaru'
        ));
    }
}