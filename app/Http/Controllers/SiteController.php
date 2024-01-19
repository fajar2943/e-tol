<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class SiteController extends Controller
{
    public function index(){
        if(!auth()->user()){
            return view('site.index');
        }
        $vehicles = Vehicle::where('user_id', auth()->user()->id)->get();
        return view('site.index', compact('vehicles'));
    }

    public function vehicle(Request $request){
        $this->validate($request, [
            'name' => 'required|max:100',
            'number' => 'required|max:100',
        ]);
        
        $request['user_id'] = auth()->user()->id;
        $vehicle = Vehicle::create($request->all());

        if($request->hasFile('image')){
            $vehicle->addMediaFromRequest('image')->toMediaCollection('vehicles');
        }

        return redirect()->back()->with('success', 'Vehicle Berhasil di simpan')->with('page', '#vehiclePage');
    }    

    public function updateVehicle(Request $request){
        $this->validate($request, [
            'name' => 'required|max:100',
            'number' => 'required|max:100',
        ]);

        $vehicle = Vehicle::find($request->id);
        $vehicle->update($request->all());

        if($request->hasFile('image')){
            $vehicle->clearMediaCollection('vehicles');
            $vehicle->addMediaFromRequest('image')->toMediaCollection('vehicles');
        }

        return redirect()->back()->with('success', 'Vehicle Berhasil di update')->with('page', '#vehiclePage');
    }    

    public function deleteVehicle($id){
        $vehicle = Vehicle::find($id);
        $vehicle->clearMediaCollection('vehicles');
        $vehicle->delete();
        return redirect()->back()->with('success', 'Vehicle Berhasil di hapus')->with('page', '#vehiclePage');
    }    

    public function topup(Request $request){
        $request['user_id'] = auth()->user()->id;
        $request['inv_no'] = 'INV-'.date('ymd');
        $request['status'] = 'Unpaid';

        $topup = Topup::create($request->all());
        $topup->update(['inv_no' => $request->inv_no.'-'.$topup->id]);

        return redirect('/invoice/'.$topup->inv_no);
    }

    public function invoice($inv_no){
        $topup = Topup::where('inv_no', $inv_no)->first();
        if($topup->payment_token == null){
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;
            Config::$overrideNotifUrl = config('app.url').'/api/midtrans-callback';

            $params = array(
                'transaction_details' => array(
                    'order_id' => $topup->inv_no,
                    'gross_amount' => $topup->total,
                ),
                'customer_details' => array(
                    'first_name' => auth()->user()->name,
                    'last_name' => '',
                    'email' => auth()->user()->email,
                    'phone' => '',
                ),
                "callbacks"=> array(
                    "finish" => config('app.url').'/invoice/'.$topup->inv_no,
                )
            );
            $topup->update(['payment_token' => Snap::getSnapToken($params)]);
            return view('site.payment', compact('topup'));
        }elseif($topup->status == 'Unpaid'){
            return view('site.payment', compact('topup'));
        }else{
            return view('site.invoice', compact('topup'));
        }
    }

    public function callback(Request $request){
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            if(($request->transaction_status == 'capture' && $request->payment_type == 'credit_card' && $request->fraud_status == 'accept') or $request->transaction_status == 'settlement'){
                $topup = Topup::whereInvNo($request->order_id)->first();
                $topup->update(['status' => 'Paid']);
                $user = User::find($topup->user_id);
                $user->update(['balance' => $user->balance + $topup->total]);
            }

            // elseif($request->transaction_status == 'expire'){

            // }elseif($request->transaction_status == 'refund'){
                        
            // }

            return $topup->status;
        }
        return 'Kode Hash Salah';
    }

    public function transaction(Request $request){
        $vehicle = Vehicle::whereNumber($request->number)->first();
        if(!$vehicle){
            return 'Plat Nomor tidak valid';
        }
        $user = User::find($vehicle->user_id);
        if($user->balance < $request->price){
            return 'Saldo tidak cukup';
        }
        Transaction::create([
            'vehicle_id' => $vehicle->id, 'price' => $request->price, 
            'saldo_awal' => $user->balance, 'saldo_akhir' => $user->balance - $request->price,
        ]);
        $user->update(['balance' => $user->balance - $request->price]);

        return 'Transaksi Berhasil';
    }
}
