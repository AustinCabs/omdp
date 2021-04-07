<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BillingType;
use App\Permittype;
use Illuminate\Support\Facades\Redirect;
use App\Checklist;

class DataController extends Controller
{
    public function index(){
    	$permitTypes = Permittype::all();
    	return view('adminlte::settings.data-settings.data-settings')
    		->with(compact('permitTypes'));
    }

    public function checklistSettings(){
        $permitTypes = Permittype::with('checks')->get();
        return view('adminlte::settings.data-settings.data-settings')
            ->with(compact('permitTypes'));
    }

    public function create(Request $request){
        $this->validate($request, [
            'doc.*' => 'required|mimes:docx, doc, zip',
            'permit_name' => 'required',
            'validity_type' => 'required',
            'validity_unit' => 'required'
        ],
            $messages = [
                'doc.required' => 'Please select a file',
                'permit_name.required' => 'Permit name is required.'
            ]
        );

        try{
            $filename = request()->doc->getClientOriginalName();
            request()->doc->move(resource_path("assets/files/permits/"), $filename);
            Permittype::create([
                'name' => $request->permit_name,
                'type' => $request->permit_type,
                'validity_unit' => $request->validity_unit,
                'validity_type' => $request->validity_type,
                'doc_name' => $filename
                ]);
            return Redirect::to('/settings/data')->with('message', 'Data saved');
        }catch(Exception $e){
            return Redirect::to('/settings/data')->with('error', $e);
        }
    }

    public function getPermitBills($id){
    	$permitType = Permittype::where('id', $id)->first();
    	return $permitType->billingTypes;
    }

    public function updateBillFee(Request $request, $id){
    	if(!empty($request->api_token)){
    		$data = BillingType::where('id', $id)->first();
	    	$data->fee = $request->fee;
	    	$data->save();
	    	return ['message' => 'Data updated', 'type' => 'success'];
    	}else{
    		return ['message' => 'Action is unauthorized!', 'type' => 'warning'];
    	}
    	
    }

    public function savePermitBill(Request $request, $id){
        if(!empty($request->api_token)){
            $bill = BillingType::create(['name' => $request->name, 'fee' => $request->fee, 'permittype_id'=> $id ]);
            return ['message' => 'Data saved!', 'type' => 'success', 'data' => $bill];
        }else{
            return ['message' => 'Action is unauthorized!', 'type' => 'warning'];
        }
    }

    public function deleteBill(Request $request, $id){
       if(!empty($request->api_token)){
            $bill = BillingType::where('id', $id)->first();
            $bill->delete();
            return ['message' => 'Data deleted!', 'type' => 'success'];
        }else{
            return ['message' => 'Action is unauthorized!', 'type' => 'warning'];
        } 
    }

    public function deletePermit($permittype){
        $permit = Permittype::where('id', $permittype)->first();
        $permit->delete();
        return Redirect::to('/settings/data')->with('message', 'Permit data deleted');
    }

    public function getChecks($permit){
        $data = Permittype::where('id', $permit)->with('checks')->first();
        return $data;
    }

    public function deleteChecks(Request $request, $id){
        
        if(!empty($request->api_token)){
            $check = Checklist::where('id', $id)->first();
            $check->delete();
            return ['message' => 'Data deleted!', 'type' => 'success'];
        }else{
            return ['message' => 'Action is unauthorized!', 'type' => 'warning'];
        } 

    }

    public function saveChecks(Request $request, $id){
        
        if(!empty($request->api_token)){
            $check = Checklist::create([
                'name' => $request->name,
                'permittype_id' => $id
                ]);
            return ['message' => 'Data saved!', 'type' => 'success', 'check' => $check];
        }else{
            return ['message' => 'Action is unauthorized!', 'type' => 'warning'];
        } 

    }
}
