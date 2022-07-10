<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    protected $guarded = ['id'];

    public function users()
    {
        return $this->morphToMany(User::class, 'userable');
    }

    public function breeds()
    {
        return $this->morphToMany(Breed::class, 'breedable');
    }
    
}
