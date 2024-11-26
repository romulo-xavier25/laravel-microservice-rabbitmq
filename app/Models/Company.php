<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'category_id', 'name', 'url', 'phone', 'whatsapp', 'email',
        'facebook', 'instagram', 'youtube', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
