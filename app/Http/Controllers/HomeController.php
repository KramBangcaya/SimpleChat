<?php

namespace App\Http\Controllers;

use App\Models\chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Events\MyEvent;
use App\Events\activeUser;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private chat $ChatRepo;

    public function __construct(chat $ChatRepo)
    {
        $this->middleware('auth');
        $this->ChatRepo = $ChatRepo;
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
        $data = $this->ChatRepo->getAllChat();

        if ($request->search) {
            $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        }

        return response(['data' => $data], 200);
    }
    public function user_chat(Request $request)
    {
        $data = $this->ChatRepo->getUserChat($request);

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


        Mail::send([], [], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Simple Chat')
                ->setBody($user->name . ' Send you a message ', 'text/html');
        });

        broadcast(new MyEvent($user->name . ' Send you a message '));

        chat::create([
            'user_id' => $user->id,
            'description' => $request->description,
        ]);

        return response(['message' => 'success'], 200);
    }

    public function group_chat(Request $request)
    {
        $user = Auth::User();

        $this->validate($request, [
            'description' => 'required|string',
        ]);

        broadcast(new activeUser($request->description, $user));

        return response(['message' => 'success'], 200);
    }
}
