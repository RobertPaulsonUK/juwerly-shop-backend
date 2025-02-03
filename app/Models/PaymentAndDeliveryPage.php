<?php

namespace App\Models;

use App\Traits\HasPageUrl;
use Illuminate\Database\Eloquent\Model;

class PaymentAndDeliveryPage extends Model
{
    use HasPageUrl;

    protected $table = 'payment_and_delivery_pages';
    protected $fillable = [
        'title',
        'description',
        'content'
    ];
}
