<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'url', 'phone', 'whatsapp', 'email',
        'facebook', 'instagram', 'youtube', 'is_active'
    ];

    public function companies()
    {
        return $this->belongsTo(Category::class);
    }
}
