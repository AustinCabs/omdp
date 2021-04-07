<?php

namespace App\Http\Controllers;

use App\MasterChecklist;
use Illuminate\Http\Request;
use App\History;
use App\User;
class ChecklistController extends Controller
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
    public function create(Request $request)
    {   
        if(!empty($request->api_token)){
            $data = MasterChecklist::create([
                'name' => $request->name,
                'masterlists_id' => $request->id
            ]);
        return [
            'message' => 'Requirement saved!',
            'name' => $data->name,
            'status' => $data->status,
            'id' => $data->id,
            'type' => 'success'
            ];
        }else{
            return ['message' => 'Action is unauthorized!', 'type' => 'warning'];
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
     * @param  \App\MasterChecklist  $masterChecklist
     * @return \Illuminate\Http\Response
     */
    public function show(MasterChecklist $masterChecklist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MasterChecklist  $masterChecklist
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterChecklist $masterChecklist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MasterChecklist  $masterChecklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterChecklist $masterChecklist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MasterChecklist  $masterChecklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterChecklist $masterChecklist)
    {
        //
    }

    public function updateStatus($id, Request $request){
        $master = MasterChecklist::where('id', $id)->first();
        $master->status = $request->status;
        $master->save();
        $user = User::where('id', $request->user_id)->first();
        $status = 'Done';
        if ($request->status == 0) {
            $status = 'Pending';
        }
        if ($user->role == 0 || $user->role == 2) {
            History::create([
                'action' => $status.' '.$master->name,
                'added_by' => $user->id,
                'author' => $user->name,
                'masterlist_id' => $master->masterlist_id,
                'url' => url('/masterlist/').'/'.$master->masterlist_id
            ]);
        }
        return ['message' => 'Status changed'];
    }

    public function deleteChecklist($id){
        $master = MasterChecklist::where('id', $id)->first();
        $master->delete();
        return ['message' => 'Requirement removed'];
    }
}
