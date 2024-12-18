<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    protected $fillable = ['title'];
    protected $table = 'attributes';


    public function Options():HasMany
    {
        return $this->hasMany(AttributeOption::class,'attribute_id','id');
    }
}
