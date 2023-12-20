<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Testimonial::orderBy('id', 'asc')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                $url = asset('storage/' . $data->image);
                return '<img src="' . $url . '" width="100px" />';
            })
            ->addColumn('action', function ($data) {
                $editBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm mt-1 editTestimonial"><i class="fas fa-pencil-alt"></i> Edit</a>';

                $deleteBtn = '<button onclick="deleteTestimonial(`' . route('testimonial.destroy', $data->id) . '`)" class="btn btn-sm mt-1 btn-danger"><i class="fas fa-trash"></i> Delete</button>';


                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
        }

        return view('admin.testimonials.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'testimonial' => 'required|string|max:255',
            'job' => 'required|string|max:255',
            'image' => 'required|mimes:png,jpg,svg,jpeg|max:4000'
        ]);

        $image = $request->file('image');
        $imageName = time() .' . '. $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('image/testimonials', $imageName , 'public');

        Testimonial::create([
            'name' => $request->name,
            'testimonial' => $request->testimonial,
            'job' => $request->job,
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => 'Testimonial Created Successfully'
        ]);
    }

    public function edit($id)
    {
        $testimonial = Testimonial::find($id);

        return response()->json($testimonial);
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'name' => 'nullable|string|max:255',
            'testimonial' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'image' => 'nullable|mimes:png,jpg,svg,jpeg|max:4000'
        ]);

        $testimonial->name = $request->input('name');
        $testimonial->testimonial = $request->input('testimonial');
        $testimonial->job = $request->input('job');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . ' . ' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/image/testimonials', $imageName);

            if ($testimonial->image) {
                Storage::delete('public/'. $testimonial->image);
            }

            $testimonial->image = str_replace('public', '' , $imagePath);

        }

        $testimonial->save();

        return response()->json([
            'success' => 'Testimonial Updated Successfully'
        ]);
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->image) {
            Storage::delete('public/'. $testimonial->image);
        }

        $testimonial->delete();

        return response()->json([
            'success' => 'Testimonial Deleted Successfully'
        ]);
    }
}
