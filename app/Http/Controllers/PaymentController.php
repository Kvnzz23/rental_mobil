<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rentals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        // Ambil data pending hanya jika status 'all' atau 'unpaid'
        $pendingPayment = ($status === 'all' || $status === 'unpaid')
            ? Rentals::with(['customer', 'car', 'payment'])
            ->whereDoesntHave('payment', function ($q) {
                $q->where('status', 'paid');
            })
            ->latest()
            ->get()
            : collect();
    
        // Ambil data paid hanya jika status 'all' atau 'paid'
        $paidPayment = ($status === 'all' || $status === 'paid')
            ? Payment::with(['rental.customer', 'rental.car'])
            ->where('status', 'paid')
            ->latest('tgl_pembayaran')
            ->get()
            : collect();
        return view('pages.data_payment.show', compact('pendingPayment', 'paidPayment', 'status'));
    }

    public function nota($id)
    {
        $rental = Rentals::with(['customer', 'car', 'payment'])->findOrFail($id);
        return view('pages.data_payment.nota', compact('rental'));
    }

    public function paid($id)
    {
        $rental = Rentals::findOrFail($id);

        if ($rental->status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah dikonfirmasi sebelumnya.');
        }

        DB::transaction(function () use ($rental) {
            Payment::updateOrCreate(
                ['rental_id' => $rental->id_rental],
                [
                    'total'       => $rental->total_harga, // Sesuaikan dengan nama kolom total harga di tabel rentals
                    'tgl_pembayaran' => now(),
                    'status'       => 'paid',
                ]
            );
            $rental->update(['status' => 'berjalan']);
        });

        return redirect()->route('payment.index');
    }
}
