<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereIn('role', [0, 1, 2])->get();

        return view('adminlte::settings.user-management.index')->with(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        
        if(!empty($request->api_token) && $request->auth_role == 3 || $request->auth_role == 2 ){
            $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role' => $request->role,
                    'status' => $request->status,
                    'password' => bcrypt('password'),
                    'remember_token' => str_random(10),
                    'api_token' => str_random(20)
                ]);

            return ['message' => 'User saved!', 'type' => 'success'];
        }else{
            return ['message' => 'Invalid Action!', 'type' => 'error'];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        if(!empty($request->api_token) && $request->auth_role == 3 || $request->auth_role == 2 ){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->status = $request->status;

            $user->save();

            return ['message' => 'User saved!', 'type' => 'success'];
        }else{
            return ['message' => 'Invalid Action!', 'type' => 'error'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Request $request)
    {
        if (!empty($request->api_token) && $request->role == 2 || $request->role == 3) {
            return $user;
        }else{
            return ['message' => 'Invalid Action!', 'status' => 'error'];
        }
    }

    public function showProfile(User $user){
        return view('adminlte::auth.profile')->with(compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function updateProfile(Request $request, User $user){
        try {
            $user->name = $request->name; 
            $user->email = $request->email;
            $user->gender = $request->gender;

            $user->save();

           return Redirect::to('/profile/'.$user->id)->with('message', 'User Updated!');

        } catch (Exception $e) {
            return Redirect::to('/profile/'.$user->id)->with('error', $e);
        }
    }

    public function updatePassword(Request $request){
        $auth = User::where('id', $request->id )->first();
        if (empty($request->password) || empty($request->password1)) {
            return ['message'=>'Password is invalid', 'status'=>'error'];
        }else if ( $request->has('password') && (Hash::check($request->password, $auth->password) ) ){

                if( $request->password2 == $request->password1 ){   
                    $auth->password = bcrypt($request->password1);
                    $auth->save();
                    return ['message' => 'Password Updated', 'status' => 'success'];
                }else{
                    return ['message'=>'New Password does not match', 'status'=>'error'];
                }
        }else{
            return ['message'=>'Old Password does not match', 'status'=>'error'];
        }  
    }

    public function resetPassword(User $user){
        $user->password = bcrypt('password');
        $user->save();
        return Redirect::to('/settings/users')->with('message', 'Reset Password Done!');
    }
}
