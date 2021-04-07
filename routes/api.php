
<?php

use Illuminate\Http\Request;
use App\Masterlist;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {
    //    Route::resource('task', 'TasksController');

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_api_routes
});

Route::get('/permit_type_checklist/{permit}', 'MasterlistController@getPermitChecklist');

Route::post('/checklist/update/{id}', 'ChecklistController@updateStatus');

Route::post('/checklist/add', 'ChecklistController@create');

Route::post('/checklist/delete/{id}', 'ChecklistController@deleteChecklist');

Route::get('/permit_type_bill/{id}', 'DataController@getPermitBills');

Route::post('/save-billing-fee/{id}', 'DataController@updateBillFee');

Route::get('/billing-details/{billing}', 'BillingController@getBillDetails');

Route::post('/billing-pay/{billing}', 'BillingController@payBill');

Route::post('/save-new-bill/{id}', 'DataController@savePermitBill');

Route::post('/bill-delete/{id}', 'DataController@deleteBill');

Route::get('/getChecks/{permit}','DataController@getChecks');

Route::post('/deleteCheck/{id}', 'DataController@deleteChecks');

Route::post('/saveCheck/{id}', 'DataController@saveChecks');

Route::get('/getGraphData', function(){
        
    $year = date('Y');
   	$sag = [];
   	$ore = [];
   	for ($i=1; $i != 13 ; $i++) {

   		$from = $year.'-'.$i.'-1';
   		$to = $year.'-'.$i.'-31';

   		$SAG = Masterlist::whereBetween('created_at', [$from, $to])->where('type', 1)->count();
   		$ORE = Masterlist::whereBetween('created_at', [$from, $to])->where('type', 2)->count();
   		
   		array_push($sag, $SAG);
   		array_push($ore, $ORE);

   	}
   	$obj = array(
   			'SAG' => $sag,
   			'ORE' => $ore
   		);
   	return $obj;
});

#Prduction and sales

Route::post('/addMonthlyReport/{masterlist}', 'MasterlistController@addMonthlyReport');

Route::get('/getReport/{report}', 'ReportController@show');

Route::post('/updateProduction/{production}', 'ProductionController@edit');

Route::post('/deleteProduction/{production}', 'ProductionController@destroy');

Route::post('/createProduction/{report}', 'ProductionController@create');

Route::post('/updateReport/{report}', 'ReportController@store');

#settings user management

Route::get('/user/{user}', 'UserController@show');

Route::post('/user/{user}', 'UserController@store');

Route::post('/createUser', 'UserController@create');

#change pass
Route::post('/profile/change-password', 'UserController@updatePassword');

#penalty admin

Route::post('/penalty/addPost', 'BillingController@newPenalty');
Route::get('/penalty/{billing}', 'BillingController@updateGet');
Route::post('/penalty/{billing}', 'BillingController@updatePost');

#chat
Route::post('/sendMessage', 'PortalController@sendChat');

Route::get('/msg/{chat}', 'ChatController@show');