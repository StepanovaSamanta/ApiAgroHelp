<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();

        return \response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {


        $user = new User;
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = $request['password'];
        return \response()->json($user->save());
        //return \response()->json($name,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //$user = User::query()->where("id" , "=",$id);

        $user = User::query()->find($id);
        //$data = User::query()->where("id" ,$id);

        return \response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function login(Request $request)
    {
        $user = User::query()->where('email', $request->email)->get();
//        if(Hash::check($request->password,$user[0]->password)){
        $userId = $user[0]->id;

        $user = User::query()->find($userId);

        if ($user != null) {
            if ($request->password == $user->password) {
                $user->remember_token = Str::random(60);
                $token = $user->createToken($user->name);
                $token = $token->plainTextToken;
                $data = [
                    "user" => Auth::loginUsingId($user->id),
                    "remember_token" => $token
                ];
                return \response()->json($data, 200);
            }
            //return $user->password;
        } else {
            $data = [
                "status" => "User not found",
                "code" => 403
            ];
            return \response()->json($data, 403);

        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::query()->find($id);
        if ($user != null) {
            $user['name'] = $request['name'];
            $user['email'] = $request['email'];
            $user['password'] = $request['password'];
            $user->save();
            return \response()->json("Успешно обновлено",200);
        } else {
            return \response()->json("Данный пользователь не зарегистрирован", 204);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::query()->find($id)->delete();
        return \response()->json($user, 200);
    }
}
