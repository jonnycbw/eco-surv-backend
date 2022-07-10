<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Breed, BreedClient};
use Illuminate\Support\Arr;
use App\Http\Resources\BreedResource;
use Illuminate\Support\Facades\Redis;


class BreedController extends Controller
{

    public function index()
    {
        $breeds = Breed::all()->each(function($breed){
            Redis::set('breed_' . $breed->id, $breed);
        });

        return BreedResource::collection($breeds);
    }

    public function show($breed_id)
    {
        $cachedBreed = Redis::get('breed_' . $breed_id);

        if(isset($cachedBreed)) {
            $breed = json_decode($cachedBreed, FALSE);
            return response()->json(['message'=>'from cache','data' =>$breed], 200);
        
        }else {
            $breed = Breed::find($breed_id);
            Redis::set('breed_' . $id, $breed->with(['users', 'parks']));
            return response()->json(['message'=>'from db','data' => new BreedResource($breed->with(['users','parks'])->get())], 200);
        }       
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        $breed = Breed::create($data);
        
        Redis::set('breed_' . $breed->id, $breed);
        
        return response()->json(['created' => true, 'data' => new BreedResource($breed)], 201);
    }

    public function update(Request $request, Breed $breed)
    {
        $data = $request->validate([
            'name' => 'sometimes'
        ]);

        $breed->update($data);

        Redis::del('breed_' . $breed->id);
        Redis::set('breed_' . $breed->id, $breed);
        return response()->json(['updated' => true, 'data' => new BreedResource($breed)], 200);
    }

    public function destroy(Breed $breed)
    {
        $breed->delete();
        Redis::del('breed_' . $breed->id);
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
