<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getAllChat()
    {
        $data = Chat::select('users.name as name', 'users.email as email', 'chats.*')
            ->leftJoin('users', 'users.id', '=', 'chats.user_id')
            ->groupBy('chats.user_id')
            ->orderBy('chats.id', 'DESC')
            ->get();
        return $data;
    }
    public function getUserChat($request)
    {
        $user = Auth::User();

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

        return $data;
    }
}
