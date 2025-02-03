<?php

namespace App\Models;

use App\Traits\HasPageUrl;
use Illuminate\Database\Eloquent\Model;

class ContactsPage extends Model
{
    use HasPageUrl;

    protected $table = 'contacts_pages';
    protected $fillable = [
        'title',
        'description',
        'content'
    ];
}
