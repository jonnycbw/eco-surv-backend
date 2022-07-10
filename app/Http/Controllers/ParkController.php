<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Park};
use Illuminate\Support\Arr;
use App\Http\Resources\ParkResource;


class ParkController extends Controller
{

    public function index()
    {
        $parks = Park::all();
        return ParkResource::collection($parks);
    }

    public function show(Park $park)
    {
        return response()->json(['data' => new ParkResource($park)], 200);
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        $park = Park::create($data);
        return response()->json(['created' => true, 'data' => new ParkResource($park)], 201);
    }

    public function update(Request $request, Breed $breed)
    {
        $data = $request->validate([
            'name' => 'sometimes'
        ]);

        $park->update($data);

        return response()->json(['updated' => true, 'data' => new ParkResource($park)], 200);
    }

    public function destroy(Park $park)
    {
        $park->delete();
        return response()->json(['deleted' => true], 200);
    }


}
