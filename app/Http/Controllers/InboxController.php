<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use \App\Models\Message;

class InboxController extends Controller
{

    public function index() {
        // Show just the users and not the admins as well
        $users = User::where('utype', 'ADM')->orderBy('id', 'DESC')->get();

        if (auth()->user()->utype === 'ADM') {
            $messages = Message::where('user_id', auth()->id())->orWhere('receiver', auth()->id())->orderBy('id', 'DESC')->get();
        }

        return view('home', [
            'users' => $users,
            'messages' => $messages ?? null
        ]);
    }

    public function show($id) {

        $usr=User::find($id);
   if ($usr->utype == null){
            abort(404);
        }
        else if (auth()->user()->utype === 'SADM' && $usr->utype ==='ADM') {
             $sender = User::findOrFail($id);

        $users = User::with(['message' => function($query) {
            return $query->orderBy('created_at', 'DESC');
        }])->where('utype', 'ADM')
            ->orderBy('id', 'DESC')
            ->get();

        if (auth()->user()->utype === 'ADM') {
            $messages = Message::where('user_id', auth()->id())->orWhere('receiver', auth()->id())->orderBy('id', 'DESC')->get();
        } else {
            $messages = Message::where('user_id', $sender)->orWhere('receiver', $sender)->orderBy('id', 'DESC')->get();
        }

        return view('show', [
            'users' => $users,
            'messages' => $messages,
            'sender' => $sender,
        ]);
        }
        else{
            abort(404);
        }

       
    }

}
