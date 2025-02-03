<?php

namespace App\Models;

use App\Traits\HasPageUrl;
use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    use HasPageUrl;

    protected $table = 'about_pages';
    protected $fillable = [
        'title',
        'description',
        'content'
    ];
}
