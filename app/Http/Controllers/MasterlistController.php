<?php

namespace App\Http\Controllers;

use App\Masterlist;
use Illuminate\Http\Request;
use App\Permittype;
use App\Type;
use Illuminate\Support\Facades\Redirect;
use App\MasterChecklist;
use App\Checklist;
use App\BillingType;
use App\Billing;
use App\History;
use App\Report;
use App\Production;
use App\Employment;
use Auth;
use GeneaLabs\LaravelMaps\Facades\Map;

class MasterlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterlist = Masterlist::orderBy('id', 'desc')->get();

        return view('adminlte::masterlist.index')->with(compact('masterlist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createGet()
    {   
        $masterlist = (object)[
                    'business_name' => '',
                    'owner_name' => '',
                    'permit_no' => '',
                    'prk' => '',
                    'brgy' => '',
                    'municipality' => '',
                    'date_filed' => '',
                    'tin_no' => '',
                    'contact_no' => '',
                    'type' => '',
                    'permittype_id' => '',
                    'area_volume' => '',
                    'longhitude' => '',
                    'latitude' => ''
                ];
        $application_type = 0;
        $permit_types = Permittype::all();
        $types = Type::all();
        return view('adminlte::masterlist.add-new')->with( compact('permit_types','types', 'masterlist', 'application_type'));
    }

    public function createPost(Request $request){

        $this->validate($request, [
            'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'permit_no' => 'required',
            'business_name' => 'required',
            'owner_name' => 'required',
            'prk' => 'required',
            'brgy' => 'required',
            'municipality' => 'required',
            'date_filed' => 'required',
            'tin_no' => 'required',
            'contact_no' => 'required',

            'area_volume' => 'required|not_in:0',
            'permit_type' => 'required|not_in:0',
            'longhitude' => 'required',
            'latitude' => 'required'
        ],
            $messages = [
                'img.required' => 'Field image is required',
                'permit_no.required' => 'Please specify permit number',
                'business_name.required' => 'Business name field is required',
                'owner_name.required' => 'Owner name field is required',
                'date_filed.required' => 'Date filed field is required',
                'area_volume.not_in' => 'Please enter total area in sq. mtrs',
                'permit_type.not_in' => 'Please select permit type',
            ]
        );
        
        try{
            $filename = time().'.'.request()->img->getClientOriginalExtension();
            $query_code = random_int(100000, 999999).date('ymdhms');
            request()->img->move(public_path('field_images'), $filename);
            $application_type = 0;
            if(!empty($request->application_type)){
                $application_type = $request->application_type;
            }
            $bio = Masterlist::create([
                    'img' => $filename,
                    'business_name' => $request->business_name,
                    'owner_name' => $request->owner_name,
                    'permit_no' => $request->permit_no,
                    'prk' => $request->prk,
                    'brgy' => $request->brgy,
                    'municipality' => $request->municipality,
                    'province' => 'South Cotabato',
                    'island' => 'Mindanao',
                    'date_filed' => $request->date_filed,
                    'tin_no' => $request->tin_no,
                    'contact_no' => $request->contact_no,
                    'type' => $request->type,
                    'permittype_id' => $request->permit_type,
                    'area_volume' => $request->area_volume,
                    'longhitude' => $request->longhitude,
                    'latitude' => $request->latitude,
                    'query_code' => $query_code,
                    'application_type' => $application_type
                ]);
            $checklists = Checklist::where('permittype_id', $request->permit_type)->get();
            
            foreach ($checklists as $row) {
                MasterChecklist::create([
                    'name' => $row->name,
                    'masterlist_id' => $bio->id
                ]);
            }
            $permitType = Permittype::where('id', $request->permit_type)->first();
            if(count($permitType->billingTypes) != 0){
                foreach ($permitType->billingTypes as $row) {
                    Billing::create([
                        'fee' => $row->fee,
                        'name' => $row->name,
                        'masterlist_id' => $bio->id
                    ]);
                }
            }
            
            if (Auth::user()->role == 0 || Auth::user()->role == 2) {
                if($application_type == 1){
                    History::create([
                        'action' => 'Permit Rewnewal Filed',
                        'added_by' => Auth::user()->id,
                        'author' => Auth::user()->name,
                        'masterlist_id' => $bio->id,
                        'url' => url('/masterlist/').'/'.$bio->id
                    ]);
                }else{
                   History::create([
                        'action' => 'Permit Filed',
                        'added_by' => Auth::user()->id,
                        'author' => Auth::user()->name,
                        'masterlist_id' => $bio->id,
                        'url' => url('/masterlist/').'/'.$bio->id
                    ]); 
               }   
            }
            return Redirect::to('/masterlist/'.$bio->id)->with('message', 'Data saved');
        } catch (Exception $e) {
            return Redirect::to('/masterlist/addGet')->with('error', $e);
        }
        
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Masterlist  $masterlist
     * @return \Illuminate\Http\Response
     */
    public function show(Masterlist $masterlist)
    {   
        $map = MasterlistController::getMap($masterlist->longhitude.','.$masterlist->latitude);
        $checklist = MasterChecklist::where('masterlist_id', $masterlist->id)->get();
        $history = History::where('masterlist_id', $masterlist->id)->get();
        $checklistDone = MasterChecklist::where('masterlist_id', $masterlist->id)->where('status', 1)->count();
        $checklistCount = MasterChecklist::where('masterlist_id', $masterlist->id)->count();
        $reports = Report::where('masterlist_id', $masterlist->id)->get();
        $penalties = Billing::where('masterlist_id', $masterlist->id)->where('type', 1)->get();
        $billings = Billing::where('masterlist_id', $masterlist->id)->count();
        $paid = Billing::where('masterlist_id', $masterlist->id)->where('status', 1)->count();
        return view('adminlte::masterlist.profile')
            ->with(compact('masterlist', 'checklist', 'history', 'checklistDone', 'checklistCount', 'reports', 'penalties', 'map', 'billings', 'paid'));
    }

    public function updateGet(Masterlist $masterlist){
        $permit_types = Permittype::all();
        $types = Type::all();
        return view('adminlte::masterlist.update')->with(compact('masterlist','permit_types','types'));
    }

    public function updatePost(Masterlist $masterlist, Request $request){
        $this->validate($request, [
            'permit_no' => 'required',
            'business_name' => 'required',
            'owner_name' => 'required',
            'prk' => 'required',
            'brgy' => 'required',
            'municipality' => 'required',
            'date_filed' => 'required',
            'tin_no' => 'required',
            'contact_no' => 'required',

            'area_volume' => 'required|not_in:0',
            'permit_type' => 'required|not_in:0',
            'longhitude' => 'required',
            'latitude' => 'required'
        ],
            $messages = [
                'permit_no.required' => 'Please specify permit number',
                'business_name.required' => 'Business name field is required',
                'owner_name.required' => 'Owner name field is required',
                'date_filed.required' => 'Date filed field is required',
                'area_volume.not_in' => 'Please enter total area in sq. mtrs',
                'permit_type.not_in' => 'Please select permit type',
            ]
        );
        try{
            if ($request->hasFile('img')) {
                $this->validate($request, ['img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:10000']);
                $masterimg = public_path('field_images').'/'.$masterlist->img;
                unlink($masterimg);
                $filename = time().'.'.request()->img->getClientOriginalExtension();
                request()->img->move(public_path('field_images'), $filename);
                $masterlist->img = $filename;
            }
            $masterlist->permit_no = $request->permit_no;
            $masterlist->business_name = $request->business_name;
            $masterlist->owner_name = $request->owner_name;
            $masterlist->prk = $request->prk;
            $masterlist->brgy = $request->brgy;
            $masterlist->municipality = $request->municipality;
            $masterlist->date_filed = $request->date_filed;
            $masterlist->tin_no = $request->tin_no;
            $masterlist->contact_no = $request->contact_no;
            $masterlist->area_volume = $request->area_volume;
            $masterlist->permittype_id = $request->permit_type;
            $masterlist->type = $request->type;
            $masterlist->longhitude = $request->longhitude;
            $masterlist->latitude = $request->latitude;
            $masterlist->save();
            return Redirect::to('/masterlist/'.$masterlist->id)->with('message', 'Data saved');
        } catch (Exception $e) {
            return Redirect::to('/masterlist/updateGet/'.$masterlist->id)->with('error', $e);
        }

    }


    public function getPermitChecklist(Permittype $permit){
        $data = $permit->checklist($permit->id);
        return $data;
    }

    public function changeStatus(Masterlist $masterlist, Request $request){
        $permitType = Permittype::where('id', $masterlist->permittype_id)->first();
        $remarks = nl2br($request->remarks);
        $status = $request->status;

        $validity_unit = $permitType->validity_unit;
        $validity_type = $permitType->validity_type;
        $expiry = "";
        $date_issued = date('Y-m-d');

        if ($status == 1) {
            $masterlist->date_issued = $date_issued;
            if ($permitType->name  == "Mineral Processor") {
                $masterlist->expiry_date = date('Y-m-d', strtotime(date('Y').'-12-31 + 4 years'));
            }else{
                $expiry = MasterlistController::getExpiry($date_issued, $validity_unit, $validity_type);
                $masterlist->expiry_date = $expiry;
            }
        }

        if (Auth::user()->role == 0 || Auth::user()->role == 2) {
            $sw = "Pending";
            if ($status == 1) {
                $sw = "Approved";
            }elseif ($status == 2) {
                $sw = "Declined";
            }
            History::create([
                'action' => 'Permit Application Status changed to '.$sw,
                'added_by' => Auth::user()->id,
                'author' => Auth::user()->name,
                'masterlist_id' => $masterlist->id,
                'url' => url('/masterlist/').'/'.$masterlist->id
            ]);
        }
        

        $masterlist->status = $status;
        $masterlist->remarks = $remarks;

        $masterlist->save();
        return Redirect::to('/masterlist/'.$masterlist->id)->with('message', 'Application Status changed!');
    }

    public function getExpiry($date, $unit, $type){
        $days = 0;
        if ($type == "Years") {
            for ($i=0; $i < $unit; $i++) { 
                $year = date('Y')+$i;
                $days = $days + MasterlistController::cal_days_in_year($year);
            }
        } elseif ($type == "Days") {
            $days = $unit;
        }


        $d = strtotime("+".$days." days", strtotime($date));
        return date("Y-m-d", $d);
    }

    public function cal_days_in_year($year){
        $days = 0;
        for ($month=1; $month <= 12; $month++) { 
            $days = $days + cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }
        return $days;
    }

    public function addMonthlyReport(Request $request, Masterlist $masterlist){
        if (count(json_decode($request->production)) == 0) {
            $message = ['type' => 'error', 'message' => 'Production and sales data is empty'];
            return $message;
        }
        try {
            $validate = Report::where('date', $request->date)->first();
            $message = [];
            if(!$validate){
                $report = Report::create([
                    'date' => $request->date,
                    'days_of_operation' => $request->days_of_operation,
                    'prepared_by' => $request->prepared_by,
                    'masterlist_id' => $request->masterlist_id,
                    'permittype_id' => $masterlist->permittype_id
                ]);
            foreach ( json_decode($request->production) as $row) {
                Production::create([
                        'materials' => $row->materials,
                        'p_quantity' => $row->p_quantity,
                        'p_value' => $row->p_value,
                        's_quantity' => $row->s_quantity,
                        's_value' =>$row->s_value,
                        'm_inventory_q' => $row->mi_quantity,
                        'm_inventory_v' => $row->mi_value,
                        'fee_payable' => $row->fee_payable,
                        'tax_payable' => $row->tax_payable,
                        'buyer_address' => $row->buyer_address,
                        'report_id' => $report->id
                    ]);
            }

            Employment::create([
                    'o_male' => $request->o_male,
                    'o_female' => $request->o_female,
                    's_male' => $request->s_male,
                    's_female' => $request->s_female,
                    'report_id' => $report->id
                ]);
                $message = ['type' => 'success', 'message' => 'Report Added'];
            }else{
                $message = ['type' => 'error', 'message' => 'Duplicate Entry'];
            }
            return $message;
        } catch (Exception $e) {
            $message = ['type' => 'error', 'message' => $e];
            return $message;
        }
       
    }

    public function printPermit(Masterlist $masterlist){
        $type = Type::where('id', $masterlist->type)->first();
        $bills = Billing::where('masterlist_id', $masterlist->id)->where('status', 1)->groupBy('or_no')->get();

        $permit_doc = Permittype::where('id', $masterlist->permittype_id)->first()->doc_name;
        $file = resource_path("assets/files/permits/{$permit_doc}");
        $filename = $masterlist->business_name." PERMIT.docx";
        $temp = resource_path("assets/files/generated/{$filename}");

        \PhpOffice\PhpWord\Settings::setCompatibility(false);
        $document = new \PhpOffice\PhpWord\TemplateProcessor($file);
        $document->setValue('owner_name', $masterlist->owner_name);
        $document->setValue('permit_no', $masterlist->permit_no);
        $document->setValue('prk', $masterlist->prk);
        $document->setValue('brgy', $masterlist->brgy);
        $document->setValue('municipality', $masterlist->municipality);
        $document->setValue('date_issued', MasterlistController::dateToWord($masterlist->date_issued));
        $document->setValue('type', $type->name);
        $document->setValue('area_volume', $masterlist->area_volume);
        $document->setValue('business_name', $masterlist->business_name);
        $document->setValue('expiry_date', MasterlistController::dateToWord($masterlist->expiry_date));
        $document->setValue('hectares', ($masterlist->area_volume/10000));
        $document->setValue('tin_no', $masterlist->tin_no);
        $document->setValue('contact', $masterlist->contact_no);
        $document->setValue('permit_type', $masterlist->application_type == 0 ? 'New' : 'Renewal');
        $ors = "";
        $or_dates = "";
        $idx = 1;
        foreach ($bills as $row) {
            if($idx == 1){
                $ors = $ors.$row->or_no;
                $or_dates = $or_dates.MasterlistController::dateToWord($row->date_paid);
            }else{
                $ors = $ors.", ".$row->or_no;
                $or_dates = $or_dates.", ".MasterlistController::dateToWord($row->date_paid);
            }
            $idx++;
        }
        $document->setValue('ors', $ors);
        $document->setValue('or_dates', $or_dates);

        ob_clean();
        $document->saveAs($temp);
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Content-Length: ' . filesize($temp));
        readfile($temp);
        unlink($temp); // deletes the temporary file
        exit;     
    }

    public function dateToWord($string){
       return date('F j, Y', strtotime($string));
    }

    public function numToWord($data){
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return $f->format($data);
    }

    public static function getMap($directions){
        $config = array();
        $config['center'] = $directions;
        $config['zoom'] = '15';
        $config['draggableCursor'] = 'default';
        Map::initialize($config);

        $marker = array();
        $marker['position'] = $directions;
        Map::add_marker($marker);
        $map = Map::create_map();
        return $map;
    }

    public function renewGet(Masterlist $masterlist, Request $request){
        $permit_types = Permittype::all();
        $types = Type::all();
        $application_type = 1;
        return view('adminlte::masterlist.add-new')->with( compact('permit_types','types', 'masterlist', 'application_type'));
    }
}
