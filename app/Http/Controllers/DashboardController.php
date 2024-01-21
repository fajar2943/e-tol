<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('admin.dashboard.index');
    }    

    public function transaction_chart(){
        return response()->json([
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','1')->count(),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','2')->count(),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','3')->count(),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','4')->count(),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','5')->count(),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','6')->count(),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','7')->count(),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','8')->count(),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','9')->count(),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','10')->count(),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','11')->count(),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','12')->count(),
        ]);
    }
    public function revenue_chart(){
        return response()->json([
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','1')->sum('price'),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','2')->sum('price'),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','3')->sum('price'),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','4')->sum('price'),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','5')->sum('price'),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','6')->sum('price'),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','7')->sum('price'),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','8')->sum('price'),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','9')->sum('price'),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','10')->sum('price'),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','11')->sum('price'),
            Transaction::whereYear('created_at', now()->year)->whereMonth('created_at','12')->sum('price'),
        ]);
    }
}
