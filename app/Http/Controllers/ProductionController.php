<?php

namespace App\Http\Controllers;

use App\Production;
use App\Report;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Report $report)
    {
       $production = Production::create([
            'materials' => $request->materials,
            'p_quantity' => $request->p_quantity,
            'p_value' => $request->p_value,
            's_quantity' => $request->s_quantity,
            's_value' =>$request->s_value,
            'm_inventory_q' => $request->mi_quantity,
            'm_inventory_v' => $request->mi_value,
            'fee_payable' => $request->fee_payable,
            'tax_payable' => $request->tax_payable,
            'buyer_address' => $request->buyer_address,
            'report_id' => $report->id
        ]);

        return ['production'=> $production, 'message' => 'Data saved'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function show(Production $production)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function edit(Production $production, Request $request)
    {
        $production->materials = $request->materials;
        $production->p_quantity = $request->p_quantity;
        $production->p_value = $request->p_value;
        $production->s_quantity = $request->s_quantity;
        $production->s_value = $request->s_value;
        $production->m_inventory_q = $request->mi_quantity;
        $production->m_inventory_v = $request->mi_value;
        $production->fee_payable = $request->fee_payable;
        $production->tax_payable = $request->tax_payable;
        $production->buyer_address = $request->buyer_address;

        $production->save();

        return $production;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Production $production)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Production $production)
    {
        $production->delete();

        return ['message' => 'Sales Report Deleted'];
    }
}
