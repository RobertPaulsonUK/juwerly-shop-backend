<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $table = 'menu_items';
    protected $fillable = [
        'title',
        'url',
        'menu_id',
        'parent_id',
        'sort'
    ];
    /**
     * @return HasMany
     */
    public function children():HasMany
    {
        return $this->HasMany(MenuItem::class,'parent_id','id');
    }

    /**
     * @return BelongsTo
     */
    public function parentItem():BelongsTo
    {
        return $this->belongsTo(MenuItem::class,'parent_id','id');
    }

    /**
     * @return BelongsTo
     */
    public function menu():BelongsTo
    {
        return $this->belongsTo(Menu::class,'menu_id','id');
    }
}
