<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Billing;
use App\Masterlist;
use App\User;
use App\History;
use Auth;

class BillingController extends Controller
{
    public function index(){
        $list = Masterlist::whereHas('billings', function($q){
                $q->where('status', 0);
            })->with('billings')->get();
        if(Auth::user()->role != 1){
            $list = Masterlist::with('billings')->get();
        }
    	
    	return view('adminlte::billing.index')->with(compact('list'));
    }

    public function show(Masterlist $masterlist){

    	$billings = $masterlist->billings->where('status', 0);
    	$total = $masterlist->billings->where('status', 0)->sum('fee');
        if (Auth::user()->role != 1) {
            $billings = $masterlist->billings;
            $total = $masterlist->billings->sum('fee');
        }
    	return view('adminlte::billing.counter')->with(compact('masterlist', 'billings', 'total'));
    }

    public function getBillDetails(Billing $billing){
    	return $billing;
    }

    public function payBill(Billing $billing, Request $request){
        if(!empty($request->api_token)){
            
            $billing->or_no = $request->or_no;
            $billing->date_paid = Date('Y-m-d');
            $billing->status = 1;
            $billing->save();
            $user = User::where('id', $request->user_id)->first();
            if ($user->role == 0 || $user->role == 1) {
                History::create([
                    'action' => 'Paid '.$billing->name,
                    'added_by' => $user->id,
                    'author' => $user->name,
                    'masterlist_id' => $billing->masterlist_id,
                    'url' => url('/masterlist/').'/'.$billing->masterlist_id
                ]);
            }
            return ['message' => 'Payment done', 'type' => 'success'];
        }else{
            return ['message' => 'Action is unauthorized!', 'type' => 'warning'];
        }
    }

    public function newPenalty(Request $request){
        if(!empty($request->api_token)){
            
            $bill = Billing::create([
                        'fee' => $request->fee,
                        'name' => $request->name,
                        'masterlist_id' => $request->masterlist_id,
                        'type' => 1
                    ]);
            $user = User::where('id', $request->user_id)->first();
            if ($user->role == 0 || $user->role == 2) {
                History::create([
                    'action' => 'Penalty Added. Description: '.$bill->name,
                    'added_by' => $user->id,
                    'author' => $user->name,
                    'masterlist_id' => $bill->masterlist_id,
                    'url' => url('/masterlist/').'/'.$bill->masterlist_id
                ]);
            }
            return ['message' => 'Penalty added', 'type' => 'success', 'bill'=>$bill];
        }else{
            return ['message' => 'Action is unauthorized!', 'type' => 'warning'];
        }
    }

    public function updateGet(Billing $billing){
        return $billing;
    }

    public function updatePost(Billing $billing, Request $request){
       if(!empty($request->api_token)){
            $billing->name = $request->name;
            $billing->fee = $request->fee;
            $billing->or_no = $request->or_no;
            $billing->save();
            return ['message' => 'Data updated', 'type' => 'success', 'bill'=>$billing];
        }else{
            return ['message' => 'Action is unauthorized!', 'type' => 'warning'];
        }
    }
}
