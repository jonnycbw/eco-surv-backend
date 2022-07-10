<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\{BreedClient, Breed};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $breedClient = new BreedClient();
        $response = $breedClient->listAll();
        $decoded = json_decode($response, true);
        $breeds = array_keys(Arr::get($decoded, 'message', []));

        foreach($breeds as $breed){
            Breed::create(['name'=>$breed]);
        }
    }
}
