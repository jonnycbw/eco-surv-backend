

## Getting started 

To get started with running my tech test, you'll firstly need to create a database and then fill in the database variables in the `.env` file.


## Seeding the data
To run the seeder, navigate to the project directory and run `php artisan db:seed`, this will call the dog.ceo API to return all the breeds and store them in the database.


## Using the API with postman
As the API is setup to accept and return JSON formatted data, you should add the following headers to your requests:

`Accept: application/json`
`Content-Type: application/json`

## Task 1 
In this task I created a class to simplify fetching from the dog.ceo API, I did this to keep the code clean rather than littered with Guzzle requests, this also meant that I didn't need to re-write the logic to fetch the list of breeds from the API. 

I utilised this in the Seeder too to fetch and store the breeds from the API. 

*NOTE* :

 I think I may have misinterpreted something along the way, I was specifically confused with the requirement to expose routes like `/breed` and `/breed/{breed_id}`, my interpretation was to expose some endpoints from laravel to act as a passthrough to the dog.ceo API.  I was anticipating that these routes would be required for the RESTful routes for the next part of the test where the CRUD operations are performed.

This lead me to using `/breeds` for the second task, I hope this suffices.

## Task 2

I hadn't used Redis in projects I'd been working with previously, so this was my first time. I wasn't sure if I had implemented this correctly, but it seems to be working. I added a message to the responses to indicate where the data was provided from (cache / database).

To test this, you'll need to ensure you have a local redis server running and the correct configuration.

## Task 3 - GraphQL 

I've not used graphQL with Laravel before and I didn't manage to get it working with mutations, but I was able to perform some basic queries.

if you navigate to `/graphql-playground` there is an interface that you can use to query the models added to the application

an example query : 

```
{
  breeds{
    id,
    name,
    
    users{
      id,
      name,
      location
    }
  }
}
```


Sample response : 

```
{
  "data": {
    "breeds": [
      {
        "id": "1",
        "name": "affenpinscher",
        "users": []
      },
      {
        "id": "2",
        "name": "african",
        "users": [
          {
            "id": "1",
            "name": "jonny",
            "location": "Preston"
          }
        ]
      }
    ...
    }
}
```










