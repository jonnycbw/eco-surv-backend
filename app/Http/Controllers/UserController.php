<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User};
use Illuminate\Support\Arr;
use App\Http\Resources\UserResource;


class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        return response()->json(['data' => new UserResource($user)], 200);
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        $user = User::create($data);
        return response()->json(['created' => true, 'data' => new UserResource($user)], 201);
    }

    public function update(Request $request, Breed $breed)
    {
        $data = $request->validate([
            'name' => 'sometimes'
        ]);

        $user->update($data);

        return response()->json(['updated' => true, 'data' => new UserResource($user)], 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['deleted' => true], 200);
    }

    public function associate(Request $request, User $user)
    {
        $data = $request->validate([
            'type' => 'required',
            'id' => 'required'
        ]);

        if(Arr::get($data, 'type') == "park")
        {
            $user->parks()->syncWithoutDetaching([Arr::get($data, 'id')]);
            return response()->json(['success' => true, 'parks'=>$user->parks ], 200);     
        }
       
        if(Arr::get($data, 'type') == "breed")
        {
            $user->breeds()->syncWithoutDetaching([Arr::get($data, 'id')]);
            return response()->json(['success' => true, 'breeds'=>$user->breeds ], 200);
        }

        return response()->json(['success' => false, 'message'=>'The was an error, check that you have provided the correct type & id'], 404);

    }


}
