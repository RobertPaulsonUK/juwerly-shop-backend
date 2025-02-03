<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'theme',
        'text',
        'user_id',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public static function createMessage(int $userId, string $theme, string $text):self
    {
        return self::create([
            'theme' => $theme,
            'text' => $text,
            'user_id' => $userId,
        ]);
    }
}
