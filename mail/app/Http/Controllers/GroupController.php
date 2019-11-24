<?php

namespace App\Http\Controllers;

use Alert;
use App\Group;
use App\Email;
use Illuminate\Http\Request;

class GroupController extends Controller
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
        $groups = Group::latest()->get();
        return view('group.index',['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check
        if($request->name == null ){
            Alert::warning('Sorry Sir! You must have to Insert Name.', 'One Second Please!')->persistent('Close');
            return back();
        }

        // store
        $duplicate = Group::where('name',$request->name)->first();

        if($duplicate == null){
            $data = $request->all();
            $group = new Group;
            $group->create($data);
            Alert::success('You Have Successfully Added One Group.', 'Successfully Stored!')->autoclose(3000);
            return redirect()->route('group.index');
        }else{
            Alert::error('Sorry The Group Already Exist.', 'Duplicate Entry!')->persistent('Close');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($group)
    {
        $searchGroup = Group::where('name',$group)->first(); 
        $emails = Email::where('group_id',$searchGroup->id)->latest()->get();
        return view('group.show',['emails' => $emails, 'group'=> $group]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::find($id);
        return view('group.edit',['group' => $group]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // store
        if($request->name == null ){
            Alert::warning('Sorry Sir! You must have to Insert Name.', 'One Second Please!')->persistent('Close');
            return back();
        }

        $duplicate = Group::where('name',$request->name)->first();

        if($duplicate == null){
            $group = Group::find($id);
            $data = $request->all();
            $group->update($data);
            Alert::success('You Have Successfully Updated the Group.', 'Successfully Updated!')->autoclose(3000);
        }else{
            Alert::error('Sorry The Group Already Exist.', 'Duplicate Entry!')->persistent('Close');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Email::where('group_id',$request->id)->update(['group_id' => null]);
        Group::find($request->id)->delete();
        return redirect()->route('group.index');
    }
}
