<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Donation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaction::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('username', function ($data) {
                    return $data->user->name;
                })
                ->addColumn('title', function ($data) {
                    return $data->donation->title;
                })
                ->addColumn('donation_amount', function ($data) {
                    return 'IDR ' . format_uang($data->donation_amount);
                })
                ->addColumn('status', function ($data) {
                    return '<span class="badge bg-success text-sm">' . $data->status . '</span>';
                })
                ->addColumn('checkout_at', function ($data) {
                    return tanggal_indonesia($data->created_at);
                })
                ->addColumn('paid_at', function ($data) {
                    return tanggal_indonesia($data->paid_at);
                })
                ->rawColumns(['title', 'donation_amount', 'status', 'checkout_at', 'paid_at'])
                ->make(true);

        }

        return view('admin.transactions.index');
    }

    public function donate($id)
    {
        $donationCard = Donation::findOrFail($id);

        return view('donator.checkout', compact('donationCard'));
    }

    public function checkout(Request $request, $donation_id)
    {
        $request->validate([
            'donation_amount' => 'required',
            'message' => 'required',
        ]);

        $user_id = auth()->user()->id;

        $transaction = Transaction::create([
            'donation_id' => $donation_id,
            'user_id' => $user_id,
            'status' => 'Not Paid',
            'donation_amount' => $request->donation_amount,
            'message' => $request->message,
        ]);

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $transaction->donation_amount,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $transaction->snap_token = $snapToken;
        $transaction->save();

        return response()->json([
            'success' => 'Checkout Successfully',
            'transaction' => $transaction,
        ]);
    }

    public function getPayment($transaction_id)
    {
        $transaction = Transaction::with('donation')->findOrFail($transaction_id);

        return view('donator.payment', compact('transaction'));
    }

    public function payment(Request $request, $transaction_id)
    {
        try {
            // Your logic to update status and paid_at columns
            $transaction = Transaction::findOrFail($transaction_id);
            $transaction->status = 'Paid';
            $transaction->paid_at = now();
            $transaction->save();

            // Return a JSON response if necessary
            return response()->json(['success' => true, 'message' => 'Payment updated successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Transaction not found.'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred during payment.'], 500);
        }
    }

    public function mydonation(Request $request)
    {
        if ($request->ajax()) {

            $user_id = auth()->user()->id;

            $data = Transaction::where('user_id', $user_id)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($data) {
                    return $data->donation->title;
                })
                ->addColumn('donation_amount', function ($data) {
                    return 'IDR ' . format_uang($data->donation_amount);
                })
                ->addColumn('status', function ($data) {
                    return '<span class="badge bg-success text-sm">' . $data->status . '</span>';
                })
                ->addColumn('checkout_at', function ($data) {
                    return tanggal_indonesia($data->created_at);
                })
                ->addColumn('paid_at', function ($data) {
                    return tanggal_indonesia($data->paid_at);
                })
                ->addColumn('action', function ($data) {

                    if ($data->status == "Paid") {
                        $payBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm mt-1 editDonation disabled"><i class="fas fa-money-check-alt"></i> Pay</a>';
                    } else {
                        $payBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm mt-1 editDonation"><i class="fas fa-money-check-alt"></i> Pay</a>';
                    }

                    return $payBtn;
                })
                ->rawColumns(['title', 'donation_amount', 'status', 'checkout_at', 'paid_at', 'action'])
                ->make(true);

        }

        return view('donator.mydonation');
    }
}
