<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'url', 'description', 'created_at', 'updated_at'];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
