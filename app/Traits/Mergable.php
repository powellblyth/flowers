<?php

namespace App\Traits;

use Illuminate\Config\Repository;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Mergable
{

    public function mergeConfig(): Attribute
    {
        return new Attribute(
            get: fn($value) => config('merge.' . class_basename(strtolower(static::class)))
        );
    }

    public function getMergableRelations(): array
    {
        return $this->merge_config['just_change_id'];
    }

    public function getPreventIfDifferent(): array
    {
        return $this->merge_config['prevent_if_different'];
    }

    public function canBeMergedInto(Mergable $mergableModel)
    {
        foreach ($this->getPreventIfDifferent() as $badColumn) {
            if ($this->get($badColumn) !== $mergableModel->get($badColumn)) {
                return false;
            }
        }
        if ($this->is($mergableModel)) {
            return false;
        }
        if ($mergableModel::class !== $this::class) {
            return false;
        }
        return $this->merge_config['merge' . Str::plural($this::class)];
    }

    public function merge(Model $mergableModel)
    {
        foreach ($this->getMergableRelations() as $relation) {
            $relation = $mergableModel->{$relation};
            if (!is_null($relation)){
//                $relation->each(function (Model $relationd){
//                    $
//                });
//$this->{$relation()}->associateMany($relation);
            var_dump($relation::class);
            }
        }
    }
}
