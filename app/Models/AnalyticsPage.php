<?php

namespace App\Models;

use App\Traits\HasPageUrl;
use Illuminate\Database\Eloquent\Model;

class AnalyticsPage extends Model
{
    use HasPageUrl;

    protected $table = 'analytics_pages';
    protected $fillable = [
        'title',
        'description',
        'content'
    ];
}
