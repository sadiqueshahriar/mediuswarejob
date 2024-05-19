<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class withdrawController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user){
             $withdraws = transaction::where('user_id',Auth::user()->id)->where('transaction_type','withdraw')->orderBy('id','desc')->get();
             return view('withdraw.index', compact('withdraws'));
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
             return view('withdraw.create');
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
        $data->transaction_type = 'withdraw';
        $data->amount  = $request->amount ;
        $user = User::find(Auth::user()->id);
        // The first 1K withdrawal per transaction is free
        if($user->account_type == 'individual' && $request->amount <= 1000){
            $data->fee = 0.0;
        }
         //Apply the appropriate withdrawal rate based on the user's account type
        elseif($user->account_type == 'individual'){
            $data->fee = 0.015;
        }
        elseif($user->account_type == 'business'){
            $data->fee = 0.025;
        }
        $chargeTotal = $data->fee / $request->amount * 100 ;
     //   dd($chargeTotal);

        $user->balance =  $user->balance - ($request->amount + $chargeTotal);
        $user->save();

        $data->date  = Carbon::now();
        $data->save();
        return redirect('withdrawal');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $deposit = transaction::find($id);
        return view('withdraw.edit',compact('deposit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $deposit = transaction::find($id);
        $deposit->user_id = Auth::user()->id;
        $deposit->transaction_type = 'withdraw';
        $deposit->amount  = $request->amount ;
        $deposit->fee  = 0.015;
        $deposit->date  = Carbon::now();
        $deposit->save();
        return redirect('withdrawal');
    }
}
