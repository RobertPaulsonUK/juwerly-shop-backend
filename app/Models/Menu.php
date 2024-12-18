<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = [
        'title'
    ];

    /**
     * @return HasMany
     */
    public function menuItems():HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
