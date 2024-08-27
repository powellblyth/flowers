<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class MergeUserLog
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class MergeUserLog extends Model
{
    use HasFactory;

    protected static $unguarded = true;

    public $attributes = [
    ];

    public $casts = [
        'metadata' => 'json',
    ];

    /****   Attributes   ****/

    /****   Scopes   ****/

    /****   Relations   ****/

    public function mergeFromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function mergeToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
    /****   Checks   ****/

    /****   Methods   ****/

    /****   Statics   ****/

}
