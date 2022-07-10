<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Park;


class User extends Model
{
    protected $guarded = ['id'];

    public function parks()
    {
        return $this->morphedByMany(Park::class, 'userable');
    }

    public function breeds()
    {
        return $this->morphToMany(Breed::class, 'breedable');
    }

    
    
}
