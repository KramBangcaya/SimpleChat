<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('api',['role:super-admin|admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('list permission'), 403, 'You do not have the required authorization.');
        $data = Permission::latest();
        if($request->search){
                $data = $data->where('name','LIKE', '%'.$request->search.'%');
        }
        $data= $data->paginate($request->length);
        return response(['data' => $data], 200);
    }
    public function index_all()
    {
        $data = Permission::all();
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
        abort_if(Gate::denies('create permission'), 403, 'You do not have the required authorization.');
        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('cache:clear');
        $this->validate($request,[
            'name' => 'required|string|unique:permissions,name',
            'guard_name' => 'required|string',
        ]);
        Permission::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);
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
     * @param  int  $
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('edit permission'), 403, 'You do not have the required authorization.');
        $this->validate($request,[
            'name' => 'required|string|unique:permissions,name,'.$request->id,
            'guard_name' => 'required|string',
        ]);
        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response(['message' => 'success'], 200);
    }
}
