<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Breed, BreedClient};
use Illuminate\Support\Arr;
use App\Http\Resources\BreedResource;


class BreedController extends Controller
{

    public function index()
    {
        $breeds = Breed::all();
        return BreedResource::collection($breeds);
    }

    public function show(Breed $breed)
    {
        return response()->json(['data' => new BreedResource($breed)], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        $breed = Breed::create($data);
        return response()->json(['created' => true, 'data' => new BreedResource($breed)], 201);
    }

    public function update(Request $request, Breed $breed)
    {
        $data = $request->validate([
            'name' => 'sometimes'
        ]);

        $breed->update($data);

        return response()->json(['updated' => true, 'data' => new BreedResource($breed)], 200);
    }

    public function destroy(Breed $breed)
    {
        $breed->delete();
        return response()->json(['deleted' => true], 200);
    }


    public function listAllFromAPI()
    {
        $breedClient = new BreedClient();
        $breeds = $breedClient->listAll();
        return response()->json(['data' => json_decode($breeds, true)], 200);
    }

    public function showFromAPI($breed_id)
    {
        $breedClient = new BreedClient();
        $result = $breedClient->find($breed_id);
        $breed = Arr::get(json_decode($result, true), 'message', []);
        return response()->json(['data' => ["images" => $breed]], 200);
    }

    public function random()
    {
        $breedClient = new BreedClient();
        $breed = $breedClient->random();
        return response()->json(['data' => ["breed" => $breed]], 200);
    }


    public function imageForBreed(Request $request, $breed_id)
    {
        $breedClient = new BreedClient();
        $image = $breedClient->imageForBreed($breed_id);
        return response()->json(['data' => json_decode($image, true)], 200);
    }
}
