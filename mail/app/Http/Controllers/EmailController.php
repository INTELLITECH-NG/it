<?php

namespace App\Http\Controllers;

use Alert;
use Excel;
use Carbon\Carbon;
use App\Group;
use App\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
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
        $emails = Email::latest()->get();
        return view('email.index',['emails' => $emails]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::orderBy('name', 'Asc')->get();
        return view('email.create',['groups' => $groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // store
        if($request->email == null ){
            Alert::warning('You must have to Add Email Address.', 'One Second Please!')->persistent('Close');
            return back();
        }

        $duplicate = Email::where('email',$request->email)->first();

        if($duplicate == null){
            $data = $request->all();
            $email = new Email;
            $email->create($data);
            Alert::success('You Have Successfully Stored Email.', 'Successfully Stored!')->autoclose(3000);
            return redirect()->route('email.index');
        }else{
            Alert::error('Sorry The Email Address Already Exist.', 'Duplicate Entry!')->persistent('Close');
            return back();
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email  $email)
    {
        return redirect()->route('email.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $groups = Group::orderBy('name', 'Asc')->get();
        $email = Email::find($id);
        return view('email.edit',['email' => $email,'groups' => $groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if($request->email == null ){
            Alert::warning('You must have to add Email Address.', 'One Second Please!')->persistent('Close');
            return back();
        }


        $email = Email::find($id);
        $duplicate = null;
        if($email->email != $request->email){
            $duplicate = Email::where('email',$request->email)->first();
        }

        if($duplicate == null){
            $data = $request->all();
            $email->update($data);
            Alert::success('You Have Successfully Updated the Email.', 'Successfully Updated!')->autoclose(3000);
        }else{
            Alert::success('Sorry The Email Address Already Exist.', 'Duplicate Entry!')->autoclose(3000);
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Email::find($request->id)->delete();
        return redirect()->route('email.index');
    }

    public function import(){
        $groups = Group::orderBy('name', 'Asc')->get();
        return view('email.import',['groups' => $groups]);
    }

    public function importEmail(Request $request){
        $i = 0;
        if($request->hasFile('sample_file')){
            $extension = $request->file('sample_file')->extension();
            if($extension == 'txt'){
                $data[] = explode(",", file_get_contents($_FILES['sample_file']['tmp_name']));
                foreach ($data[0] as $value) {
                    if( $value != "" ){
                        $arr[] = ['name' => "", 'email' => $value, 'address' => "", 'group_id' => $request->group_id, 'remarks' => "", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                        $i++;
                    }
                }
            }else{
                $path = $request->file('sample_file')->getRealPath();
                $data = Excel::load($path)->get();
                if($data->count()){
                    foreach ($data[0] as $key => $value) {
                        if( $value->email != "" ){
                            $arr[] = ['name' => $value->name, 'email' => $value->email, 'address' => $value->address, 'group_id' => $request->group_id, 'remarks' => $value->remarks, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                            $i++;
                        }
                    }
                }
            }

            if(!empty($arr)){
                DB::table('emails')->insert($arr);
                Alert::success('You have successfully added '. $i .' Emails from list.', 'Congratulations!')->persistent('Close');
                return redirect()->route('email.index');
            }
        }     
    } 
}
