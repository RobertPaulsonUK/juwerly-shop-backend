<?php

namespace App\Models;

use App\Traits\HasPageUrl;
use Illuminate\Database\Eloquent\Model;

class PaymentTutorialPage extends Model
{
    use HasPageUrl;

    protected $table = 'payment_tutorial_pages';

    protected $fillable = [
        'title',
        'description',
        'content'
    ];
}
