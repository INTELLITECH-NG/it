<?php

namespace App\Http\Controllers;

use Alert;
use Auth;
use Response;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('user.index',['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'Asc')->get();
        return view("user.create",['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->email == null ){
            Alert::warning('You must have to Add Email Address.', 'One Second Please!')->persistent('Close');
            return back();
        }

        $duplicate = User::where('email',$request->email)->first();

        if($duplicate == null){
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('123456'),
            ]);
            $user->attachRole($request->role);
            Alert::success('You Have Successfully Added User.', 'Successfully Stored!')->autoclose(3000);
            return redirect()->route('user.index');
        }else{
            Alert::error('Sorry The Email Address Already Exist.', 'Duplicate Entry!')->persistent('Close');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::orderBy('name', 'Asc')->get();
        $userRole = $user->roles[0]->display_name;
        return view('user.edit',['user' => $user, 'roles' => $roles]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPersonal()
    {
        $user = Auth::user();
        return view('user.auth',['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);
        if($request->new_password == null || $request->con_password == null ){
            Alert::warning('You must have to insert all Passwords.', 'One Second Please!')->persistent('Close');
            return back();
        }elseif ($request->new_password != $request->con_password) {
            Alert::warning('New Password and Confirm Password Did not Matched.', 'One Second Please!')->persistent('Close');
            return back();
        }
        $user->update([
                'password' => bcrypt($request->new_password),
            ]);
        Alert::success('You Have Successfully Updated The Password.', 'Successfully Updated!')->autoclose(3000);
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->email == null ){
            Alert::warning('You must have to Add Email Address.', 'One Second Please!')->persistent('Close');
            return back();
        }

        $user = User::find($id);
        $duplicate = null;
        if($user->email != $request->email){
            $duplicate = User::where('email',$request->email)->first();
        }

        if($duplicate == null){
            $data = $request->all();
            $user->update($data);
            Alert::success('You Have Successfully Updated the User.', 'Successfully Updated!')->autoclose(3000);
        }else{
            Alert::success('Sorry The Email Address Already Exist.', 'Duplicate Entry!')->autoclose(3000);
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $count = User::count();
        if($count>1){
            User::find($request->id)->delete();
            return Response::json(array(
                    'success' => true
                )); 
        }else{
            return Response::json(array(
                    'success' => false
                )); 
        }
    }
}
