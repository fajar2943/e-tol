<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(){
        $vehicles = Vehicle::where('user_id', auth()->user()->id)->get();
        return view('site.index', compact('vehicles'));
    }

    public function vehicle(Request $request){
        $this->validate($request, [
            'name' => 'required|max:100',
            'number' => 'required|max:100',
        ]);
        
        $request['user_id'] = auth()->user()->id;
        Vehicle::create($request->all());

        return redirect()->back()->with('success', 'Vehicle Berhasil di simpan');
    }
}
