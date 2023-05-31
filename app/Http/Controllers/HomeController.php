<?php

namespace App\Http\Controllers;

use App\Models\chat;
use App\Models\course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function all_chat(Request $request)
    {
        // $data = chat::latest();
        //disable ONLY_FULL_GROUP_BY
        // DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");

        $data = DB::table('chats')->select('users.name as name', 'users.email as email', 'chats.*')->leftJoin('users', 'users.id', '=', 'chats.user_id')

            ->groupBy('chats.user_id')
            ->orderBy('chats.id', 'DESC')
            // ->distinct('chats.user_id')
            // ->latest();
            // ->first();
            ->get();

        // dd($data);

        //re-enable ONLY_FULL_GROUP_BY
        // DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        // dd($data);
        if ($request->search) {
            $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        // $data = $data->paginate($request->length);

        return response(['data' => $data], 200);
    }
    public function user_chat(Request $request)
    {
        $user = Auth::User();

        // $data = chat::latest();
        $data = chat::select('users.name as name', 'users.email as email', 'chats.*')
            ->leftJoin('users', 'users.id', '=', 'chats.user_id');
        if ($request->user_id) {
            $data = $data->where('chats.user_id', $request->user_id);
        } else {
            $data = $data->where('chats.user_id', $user->id);
        }
        $data = $data->latest();

        if ($request->search) {
            $data = $data->where('description', 'LIKE', '%' . $request->search . '%');
        }
        $data = $data->paginate($request->length);

        return response(['data' => $data], 200);
    }
    public function store_server(Request $request)
    {
        $user = Auth::User();

        $this->validate($request, [
            'description' => 'required|string',
        ]);

        chat::create([
            'user_id' => $user->id,
            'is_server' => 1,
            'description' => $request->description,
        ]);

        return response(['message' => 'success'], 200);
    }

    public function store_chat(Request $request)
    {
        $user = Auth::User();

        $this->validate($request, [
            'description' => 'required|string',
        ]);

        chat::create([
            'user_id' => $user->id,
            'description' => $request->description,
        ]);

        return response(['message' => 'success'], 200);
    }
}
