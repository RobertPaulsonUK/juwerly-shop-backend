<?php

namespace App\Models;

use App\Traits\HasPageUrl;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    protected $table = 'home_pages';
    protected $fillable = [
        'title',
        'description',
        'intro',
        'stocks',
        'about',
        'categories'
    ];

    protected $casts = [
        'intro' => 'array',
        'stocks' => 'array',
        'about' => 'array',
        'categories' => 'array'
    ];

    public function getUrlAttribute():string
    {
        return config('app.frontend_url');
    }
}
