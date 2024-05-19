<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if($user){
             $deposits = transaction::where('user_id',Auth::user()->id)->where('transaction_type','deposit')->orderBy('id','desc')->get();
             return view('deposit.index', compact('deposits'));
         }
         else{
            echo 'You are not logged in';
         }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if($user){
             return view('deposit.create');
         }
         else{
            echo 'You are not logged in';
         }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //  dd($request);
        $data = new transaction();
        $data->user_id = Auth::user()->id;
        $data->transaction_type = 'deposit';
        $data->amount  = $request->amount ;
        $data->fee  = 0.0;
        $data->date  = Carbon::now();
        $user = User::find(Auth::user()->id);
        $user->balance =  $user->balance + $request->amount;
        $user->save();
           
        $data->save();
        return redirect('deposit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $deposit = transaction::find($id);
        return view('deposit.edit',compact('deposit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $deposit = transaction::find($id);
        $deposit->user_id = Auth::user()->id;
        $deposit->transaction_type = 'deposit';
        $deposit->amount  = $request->amount ;
        $user = User::find(Auth::user()->id);
        $user->balance =  $user->balance + $request->amount;
        $user->save();
        $deposit->fee  = 0.0;
        $deposit->date  = Carbon::now();
        $deposit->save();
        return redirect('deposit');
    }
}
