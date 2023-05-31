<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
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
        abort_if(Gate::denies('list role'), 403, 'You do not have the required authorization.');
        $data = Role::with('permissions')->latest();
        if($request->search){
                $data = $data->where('name','LIKE', '%'.$request->search.'%');
        }
        $data= $data->paginate($request->length);
        return response(['data' => $data], 200);
    }

    public function index_all()
    {
        $data = Role::with('permissions')->get();
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
        // dd($request->permissions);
        abort_if(Gate::denies('create role'), 403, 'You do not have the required authorization.');
        $this->validate($request,[
            'name' => 'required|string',
            'guard_name' => 'required|string',
        ]);
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);
        foreach ($request->permissions as $permission) {
            $role->givePermissionTo($permission['name']);
        }
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

        abort_if(Gate::denies('edit role'), 403, 'You do not have the required authorization.');
        $this->validate($request,[
            'name' => 'required|string|unique:roles,name,'.$request->id,
            'guard_name' => 'required|string',
        ]);
        $role = Role::with('permissions')->findOrFail($id);

        foreach ($role->permissions as $permission) {
            $role->revokePermissionTo($permission['name']);
        }
        foreach ($request->permissions as $permission) {
            $role->givePermissionTo($permission['name']);
        }
        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);
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
        $permission = Role::findOrFail($id);
        $permission->delete();
        return response(['message' => 'success'], 200);
    }
}
