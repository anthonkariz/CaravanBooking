<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class Users extends Controller
{
    //

    public function index()
    {
        return User::select('id', 'name', 'email', 'role')->get();
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',
            'type' => 'required'
        ]);
        $request['password'] = bcrypt($request['password']);
        User::create($request->all());

    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        //  $user->password = bcrypt($request->password);
        $user->save();
        return $user;
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);
        $user->password = bcrypt($request->password);
        $user->save();
        return $user;
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }
}
