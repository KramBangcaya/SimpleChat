<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProgramController extends Controller
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
        abort_if(Gate::denies('list program'), 403, 'You do not have the required authorization.');
        $data = Program::whereNotNull('created_at');
        if($request->search){
            $data = $data->where('name','LIKE', '%'.$request->search.'%');
        }
        if($request->order_by){
            $data = $data->orderBy($request->order_by, $request->sort_by);
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
        abort_if(Gate::denies('create program'), 403, 'You do not have the required authorization.');
        $this->validate($request,[
            'name' => 'required|string',
            'code' => 'required|string',
            'email' => 'required|email',
            'category' => 'required|string',
        ]);
        Program::create([
            'name' => $request->name,
            'code' => $request->code,
            'email' => $request->email,
            'category' => $request->category,
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('edit program'), 403, 'You do not have the required authorization.');
        $this->validate($request,[
            'name' => 'required|string|unique:programs,name,'.$request->id,
            'code' => 'required|string|unique:programs,code,'.$request->id,
            'email' => 'required|email',
            'category' => 'required|string',
        ]);
        $program = Program::findOrFail($id);
        $program->update([
            'name' => $request->name,
            'code' => $request->code,
            'email' => $request->email,
            'category' => $request->category,
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
        abort_if(Gate::denies('delete program'), 403, 'You do not have the required authorization.');
        $program = Program::findOrFail($id);
        $program->delete();
        return response(['message' => 'success'], 200);
    }
}
