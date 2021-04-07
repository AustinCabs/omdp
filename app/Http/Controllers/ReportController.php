<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Masterlist;
use App\Permittype;
use App\Type;
use App\Report;
use App\Production;
use App\Employment;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        $permitTypes = Permittype::all();
        $types = Type::all();
        $reports = Report::with('masterlist')->get();
        if($request->has('query_type')){
            $permitType = $request->permitType;
            $date = $request->date;

            $query = Report::query();
            $query->where('permittype_id', $permitType);

            if(!empty($date)){
                $query->where('date', $date);
            }

            $reports = $query->get();
            return view('adminlte::reports.index')->with(compact('reports','permitTypes', 'types'));
        }
            
        return view('adminlte::reports.index')->with(compact('reports','permitTypes', 'types'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function generateReport(Request $request){
        if($request->type == "month"){
            ReportController::exportMonthReport($request);
        }else{
            ReportController::exportYearReport($request);
        }
    }

    public function exportYearReport(Request $request){
        ini_set('memory_limit','-1');
        ob_end_clean();
        ob_start();
        $day1 = date('Y-m').'-01';
        $day_last = date('Y-m-t');
        $query = Report::where('date', $request->date);
        $valid_permits = Masterlist::whereBetween('expiry_date', [$day1, $day_last])->count();
        $issued_permits = Masterlist::whereBetween('date_issued', [$day1, $day_last])->count();
        $file = resource_path('assets/files/reports/monthly-report-template.xlsx');
        $permitTypes = Permittype::all();
        $filename = "annual-report ".date("Y", strtotime( $request->date));
        \Excel::load($file, function($reader) use ($query, $valid_permits, $issued_permits,$permitTypes, $request){
            $reader->sheet('FORM 1', function($sheet) use ($query, $valid_permits, $issued_permits, $permitTypes, $request){
                $sheet->cell('A9', function($cell) use ($request){
                    $cell->setValue(date("Y", strtotime( $request->date) ));
                });
                $sheet->cell('C2', function($cell) use ($issued_permits){
                    $cell->setValue($issued_permits);
                });

                $sheet->cell('C3', function($cell) use ($valid_permits){
                    $cell->setValue($valid_permits);
                });

                $row = 11;
                foreach ($permitTypes as $permit) {
                    $productions = Production::whereHas('report', function($q) use ($permit, $request){
                        $year = date("Y", strtotime( $request->date));
                        $from = $year."-01";
                        $to = $year."-12";
                        $q->where('permittype_id', $permit->id)->whereBetween('date', [$from, $to]);
                    })->with('report')->get();
                    if(count($productions) != 0 ){
                        $sheet->appendRow($row, [$permit->name]);
                        $sheet->cells('A'.$row, function($cells){
                            $cells->setFontWeight('bold');
                        });
                        $row++;

                    
                        foreach ($productions as $report) {
                            $masterlist = Masterlist::where('id', $report->report->masterlist_id)->first();
                            $employment = Employment::where('report_id', $report->report_id)->first();
                             $sheet->appendRow($row, [
                                $report->materials,
                                $masterlist->owner_name,
                                $masterlist->permit_no,
                                $masterlist->tin_no,
                                'm³',
                                $report->p_quantity,
                                $report->p_value,
                                '',
                                $report->m_inventory_q,
                                $report->m_inventory_v,
                                $employment->o_male+$employment->s_male,
                                $employment->o_female+$employment->s_female,
                                $masterlist->contact_no,
                                $report->report->days_of_operation,
                                $masterlist->prk.' '.$masterlist->brgy.', '.$masterlist->municipality.' '.$masterlist->province
                            ]);
                            $row++;
                        }
                               
                    }
                        
                }
            });
        })->setFilename($filename)->export('xlsx');
    }

    public function exportMonthReport(Request $request){
        ini_set('memory_limit','-1');
        ob_end_clean();
        ob_start();
        $day1 = date('Y-m').'-01';
        $day_last = date('Y-m-t');
        $query = Report::where('date', $request->date);
        $valid_permits = Masterlist::whereBetween('expiry_date', [$day1, $day_last])->count();
        $issued_permits = Masterlist::whereBetween('date_issued', [$day1, $day_last])->count();
        $file = resource_path('assets/files/reports/monthly-report-template.xlsx');
        $permitTypes = Permittype::all();
        $filename = "monthly-report ".date("M Y", strtotime( $request->date));
        \Excel::load($file, function($reader) use ($query, $valid_permits, $issued_permits,$permitTypes, $request){
            $reader->sheet('FORM 1', function($sheet) use ($query, $valid_permits, $issued_permits, $permitTypes, $request){
                $sheet->cell('A9', function($cell) use ($request){
                    $cell->setValue(date("M Y", strtotime( $request->date) ));
                });
                $sheet->cell('C2', function($cell) use ($issued_permits){
                    $cell->setValue($issued_permits);
                });

                $sheet->cell('C3', function($cell) use ($valid_permits){
                    $cell->setValue($valid_permits);
                });

                $row = 11;
                foreach ($permitTypes as $permit) {
                    $productions = Production::whereHas('report', function($q) use ($permit, $request){
                        $q->where('permittype_id', $permit->id)->where('date', $request->date);
                    })->with('report')->get();
                    if(count($productions) != 0 ){
                        $sheet->appendRow($row, [$permit->name]);
                        $sheet->cells('A'.$row, function($cells){
                            $cells->setFontWeight('bold');
                        });
                        $row++;

                    
                        foreach ($productions as $report) {
                            $masterlist = Masterlist::where('id', $report->report->masterlist_id)->first();
                            $employment = Employment::where('report_id', $report->report_id)->first();
                             $sheet->appendRow($row, [
                                $report->materials,
                                $masterlist->owner_name,
                                $masterlist->permit_no,
                                $masterlist->tin_no,
                                'm³',
                                $report->p_quantity,
                                $report->p_value,
                                '',
                                $report->m_inventory_q,
                                $report->m_inventory_v,
                                $employment->o_male+$employment->s_male,
                                $employment->o_female+$employment->s_female,
                                $masterlist->contact_no,
                                $report->report->days_of_operation,
                                $masterlist->prk.' '.$masterlist->brgy.', '.$masterlist->municipality.' '.$masterlist->province
                            ]);
                            $row++;
                        }
                               
                    }
                        
                }
            });
        })->setFilename($filename)->export('xlsx');
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Report $report)
    {
        try {
            $employment = Employment::where('report_id', $report->id)->first();
            $employment->o_male = $request->o_male;
            $employment->o_female = $request->o_female;
            $employment->s_male = $request->s_male;
            $employment->s_female = $request->s_female;
            $employment->save();

            $report->date = $request->date;
            $report->days_of_operation = $request->days_of_operation;
            $report->prepared_by = $request->prepared_by;
            $report->save();
            return ['type' => 'success', 'message' => 'Report Updated'];
        } catch (Exception $e) {
            return ['type' => 'error', 'message' => $e];
        }
        


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Masterlist  $masterlist
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {   
        $production = Production::where('report_id', $report->id)->get();
        $employment = Employment::where('report_id', $report->id)->get();
        $data = [
            'report' => $report,
            'production' => $production,
            'employment' => $employment
        ];
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Masterlist  $masterlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Masterlist $masterlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Masterlist  $masterlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Masterlist $masterlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Masterlist  $masterlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Masterlist $masterlist)
    {
        //
    }
}
