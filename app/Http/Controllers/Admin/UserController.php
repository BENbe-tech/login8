<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    //   $users = User::all();
    $users = User::paginate(10);
      return view('admin.users.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.users.create',['roles'=>Role::all()]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //
        $validatedData = $request->validated();

        // $user = User::create($request->except(['_token','roles']));
        $user = User::create($validatedData);

        $user->roles()->sync($request->roles);

       $request->session()->flash('success','you have created the user');
       return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        //

        return view('admin.users.edit'
        ,[
            'roles'=>Role::all(),
            'user'=>User::find($id)

        ]);
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
        //
        //$user = User::findOrFail($id);
        $user = User::find($id);

        if(!$user){
            $request->session()->flash('error','you can not edit this user.');

            return redirect(route('admin.users.index'));
        }

        $user->update($request->except(['_token','roles']));
        $user->roles()->sync($request->roles);

        $request->session()->flash('success','you have edited the user');
        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //
        User::destroy($id);

        $request->session()->flash('success','you have deleted the user');
        return redirect(route('admin.users.index'));
    }
}
