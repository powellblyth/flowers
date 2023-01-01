<?php


namespace App\Nova\Fields;


use Laravel\Nova\Fields\Badge;


class RangeBadge extends Badge
{
    public $defaultClass;
    /**
     * Resolve the Badge's CSS classes based on the field's value.
     *
     * @return string
     */
    public function resolveBadgeClasses()
    {
        asort($this->map);
        foreach (array_keys($this->map) as $threshold) {
            if ($this->value < $threshold) {
                return ($this->types[$threshold]);
            }
        }
        return $this->defaultClass;
    }

}
