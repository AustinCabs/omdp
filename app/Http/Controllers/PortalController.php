<?php

namespace App\Http\Controllers;

use App\Masterlist;
use App\Announcement;
use App\Chat;
use App\Production;
use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\MasterlistController;


class PortalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $announcements = Announcement::all();
        $masterlist = Masterlist::paginate(20);
        return view('welcome')->with(compact('masterlist', 'announcements'));
    }

    public function show(Masterlist $masterlist)
    {   

        $year = date('Y');
        $materials = Production::whereHas('report', function($q) use ($year, $masterlist){
            $q->where('masterlist_id', $masterlist->id)->whereBetween('date', [$year.'-01', $year.'-12']);
        })->groupBy('materials')->get();
        $prod_data = [];
        foreach ($materials as $row) {
            $data = [];
            for ($i=1; $i < 13; $i++) { 
                $month = str_pad($i, 2, '0', STR_PAD_LEFT);

                $prod = Production::where('materials', $row->materials)->whereHas('report', function($q) use ($year, $month, $masterlist){

                            $from = $year."-".$month;
                            $q->where('masterlist_id', $masterlist->id)->where('date', $from);
                        })->first();
                if (!empty($prod)) {
                    array_push($data, $prod->p_quantity);
                }else{
                    array_push($data, 0);
                }
                
            }
            array_push($prod_data, [ 'name' => $row->materials, 'data' => $data]);
        }
        $map = MasterlistController::getMap($masterlist->longhitude.','.$masterlist->latitude);
        return view('adminlte::portal.partials.view')->with(compact('masterlist','map', 'prod_data'));
    }

    public function queryLogInShow(){
        return view('adminlte::portal.partials.query_log');
    }

    public function queryShowDetails(Request $request){
        $masterlist = Masterlist::where('query_code', $request->query_code)->with('billings')->first();
        if($masterlist){
            return view('adminlte::portal.partials.permitee')->with(compact('masterlist'));
        }

        return redirect()->back()->with('errors', ['Invalid query code.']);
        
    }

    public function sendChat(Request $request){
        Chat::create(['contact' => $request->contact, 'msg' => $request->message]);
        return ['message' => 'message sent'];
    }
}
