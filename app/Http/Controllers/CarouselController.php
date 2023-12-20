<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CarouselController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Carousel::orderBy('id', 'asc')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                $url = asset('storage/' . $data->image);
                return '<img src="' . $url . '" width="100px" />';
            })
            ->addColumn('action', function ($data) {
                $editBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm mt-1 editCarousel"><i class="fas fa-pencil-alt"></i> Edit</a>';

                $deleteBtn = '<button onclick="deleteCarousel(`' . route('carousel.destroy', $data->id) . '`)" class="btn btn-sm mt-1 btn-danger"><i class="fas fa-trash"></i> Delete</button>';


                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
        }

        return view('admin.carousel.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|mimes:png,jpg,svg,jpeg|max:4000',
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images/carousel', $imageName, 'public');

        Carousel::create([
            'title' => $request->title,
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => 'Carousel Created Successfully'
        ]);
    }

    public function edit($id)
    {
        $carousel = Carousel::find($id);

        return response()->json($carousel);
    }

    public function update(Request $request, $id)
    {
        $carousel = Carousel::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|mimes:jpg,png,gif,svg|max:4000',
        ]);

        $carousel->title = $request->input('title');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/images/carousel', $imageName);

            if ($carousel->image) {
                Storage::delete('public/' . $carousel->image);
            }

            $carousel->image = str_replace('public/', '', $imagePath);
        }

        $carousel->save();

        return response()->json([
            'success' => 'Carousel Updated Successfully'
        ]);
    }

    public function destroy($id)
    {
        $carousel = Carousel::findOrFail($id);

        if ($carousel->image) {
            Storage::delete('public/'. $carousel->image);
        }

        $carousel->delete();

        return response()->json([
            'success' => 'Carousel Deleted Successfully'
        ]);
    }
}
