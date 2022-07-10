<?php

namespace App\Models;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\{Arr};

class BreedClient
{

    protected $base_url = "https://dog.ceo/api";
    public $currentClient = null;

    public function find($breed_id)
    {

        return $this->callAPI("get", "/breed/${breed_id}/images");
    }

    public function listAll()
    {
        return $this->callAPI("get", "/breeds/list/all");
    }

    public function random()
    {
        // get a random item from the list 
        $allBreedsResponse = json_decode($this->listAll(), true);
        $breeds = Arr::get($allBreedsResponse, "message", []);
        $randomItem = array_rand($breeds);
        return $randomItem;
    }

    public function imageForBreed($breed_id)
    {
        return $this->callAPI("get", "/breed/${breed_id}/images/random");
    }


    public function callAPI($method, $endpoint, $options = [])
    {
        try {
            // perform the API call
            $defaultHeaders = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];

            $client = new GuzzleClient([
                'base_uri' => $this->base_url,
                'headers' => $defaultHeaders
            ]);

            $this->currentClient = $client;
            // dd($this->base_url . $endpoint);
            $response = $client->request($method, $this->base_url . $endpoint, $options)->getBody()->getContents();

            // dd($response);
        } catch (RequestException $e) {
            $response =  $e->getResponse();
            logger($e->getMessage());
        }

        return $response;
    }
}
