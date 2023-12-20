<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DonatorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', '=', 'donator')->get();


        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return
                $bannedBtn = '<button class="btn btn-danger btn-sm" data-id="' . $data->id . '"><i class="fas fa-ban"></i> Ban User </button>';

                return $bannedBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.donator.index');
    }

    public function myprofile()
    {
        $user_id = auth()->user()->id;
        $myprofile = User::where('id', $user_id)->get();

        return view('donator.myprofile', compact('myprofile'));
    }

}
