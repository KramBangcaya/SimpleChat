<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // abort_if(Gate::denies('list user'), 403, 'You do not have the required authorization.');
        $data = User::with('roles', 'permissions')->latest();
        if ($request->search) {
            $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $data = $data->paginate($request->length);
        return response(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // $user->assignRole($request->role['name']);
        // foreach ($request->permissions as $permission) {
        //     $user->givePermissionTo($permission['name']);
        // }
        return response(['message' => 'success'], 200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->password);
        $this->validate($request, [
            'name' => 'required|string|unique:users,name,' . $request->id,
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'required|sometimes',
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        // dd($user, $request->password);
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
        foreach ($user->permissions as $permission) {
            $user->revokePermissionTo($permission['name']);
        }
        foreach ($request->permissions as $permission) {
            $user->givePermissionTo($permission['name']);
        }
        return response(['message' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response(['message' => 'success'], 200);
    }
}
