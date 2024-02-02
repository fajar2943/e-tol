<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopupCollection;
use App\Models\Topup;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Symfony\Component\HttpFoundation\Response;

class TopupController extends Controller
{
    public function index(){
        $topups = Topup::whereUserId(auth()->user()->id)->latest()->paginate(5);
        $balance = rupiah(User::find(auth()->user()->id)->balance);
        $vehicle = Vehicle::whereUserId(auth()->user()->id)->count();
        return response()->json([
            'topups' => new TopupCollection($topups),
            'balance' => $balance,
            'vehicle' => "$vehicle Unit",
            'next_data' => ($topups->currentPage() < $topups->lastPage()) ? $topups->currentPage() + 1 : 0,
        ], Response::HTTP_OK);
    }
    public function store(Request $request){        
        $request['user_id'] = auth()->user()->id;
        $request['inv_no'] = 'INV-'.date('ymd');
        $request['status'] = 'Unpaid';
        $topup = Topup::create($request->all());
        $request['inv_no'] = $request->inv_no.'-'.$topup->id;
        
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
        Config::$overrideNotifUrl = config('app.url').'/api/midtrans-callback';

        $params = array(
            'transaction_details' => array(
                'order_id' => $request->inv_no,
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

        $topup->update(['inv_no' => $request->inv_no, 'payment_token' => Snap::getSnapToken($params)]);
        return response()->json($topup->payment_token, Response::HTTP_CREATED);
    }
}
