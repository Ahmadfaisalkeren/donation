<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Donation::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('donation_target', function ($data) {
                    return 'IDR' . ' ' . format_uang($data->donation_target);
                })
                ->addColumn('current_donation', function ($data) {
                    return 'IDR' . ' ' . format_uang($data->getTotalDonationAmount());
                })
                ->addColumn('start_date', function ($data) {
                    return tanggal_indonesia($data->start_date);
                })
                ->addColumn('end_date', function ($data) {
                    return tanggal_indonesia($data->end_date);
                })
                ->addColumn('image', function ($data) {
                    $url = asset('storage/' . $data->image);
                    return '<img src="' . $url . '" width="100px" />';
                })
                ->addColumn('action', function ($data) {
                    $deleteBtn = '<button onclick="deleteDonation(`' . route('donations.destroy', $data->id) . '`)" class="btn btn-sm mt-1 btn-danger"><i class="fas fa-trash"></i> Delete</button>';

                    $editBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm mt-1 editDonation"><i class="fas fa-pencil-alt"></i> Edit</a>';

                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action', 'donation_target', 'current_donation', 'start_date', 'end_date', 'image'])
                ->make(true);
        }

        return view('admin.donations.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|mimes:jpg,png,gif,svg|max:4000',
            'donation_target' => 'required|integer|min:0', // Add validation rules for donation_target
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        // Log the incoming donation_target value for debugging
        Log::info('Incoming Donation Target: ' . $request->donation_target);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images/donation', $imageName, 'public');

        // Log the image path for debugging
        Log::info('Image Path: ' . $imagePath);

        // Create the donation
        $donation = Donation::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'donation_target' => $request->donation_target,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Log the donation_target value after saving for debugging
        Log::info('Donation Target After Saving: ' . $donation->donation_target);

        return response()->json([
            'success' => 'Donation Created Successfully',
        ]);
    }

    public function edit($id)
    {
        $donation = Donation::find($id);

        return response()->json($donation);
    }

    public function update(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpg,png,gif,svg|max:4000',
            'donation_target' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
        ]);

        $donation->title = $request->input('title');
        $donation->description = $request->input('description');
        $donation->donation_target = $request->input('donation_target');
        $donation->start_date = $request->input('start_date');
        $donation->end_date = $request->input('end_date');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/images/donation', $imageName);

            if ($donation->image) {
                Storage::delete('public/' . $donation->image);
            }

            $donation->image = str_replace('public/', '', $imagePath);
        }

        $donation->save();

        return response()->json([
            'success' => 'Donation Updated Successfully',
        ]);
    }

    public function destroy($id)
    {
        $donation = Donation::findOrFail($id);

        if ($donation->image) {
            Storage::delete('public/' . $donation->image);
        }

        $donation->delete();

        return response()->json([
            'success' => 'Donation Deleted Successfully',
        ]);
    }
}
