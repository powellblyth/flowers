<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;
/**
 * @method static Builder orderBy(string $column, ?string $direction=null)
 * @method static Builder where(string|array $column, ?string $valueOrComparator, ?string $value=null)
 * @method static static firstWhere(int $modelId)
 * @method static static findOrFail(int $modelId)
 * @method static static firstOrNew(int $modelId)
 * @method static static firstOrCreate(array $array, array $array)
 * @method static static find(int $modelId)
 * @property int id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Model extends Eloquent
{

}
