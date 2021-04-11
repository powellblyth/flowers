<?php


namespace App\Nova\Fields;


use Laravel\Nova\Fields\Badge;


class RangeBadge extends Badge
{
    /**
     * Resolve the Badge's CSS classes based on the field's value.
     *
     * @return string
     */
    public function resolveBadgeClasses()
    {
        asort($this->map);
        foreach ($this->map as $threshold => $thing) {
            if ($this->value < $threshold) {
                return ($this->types[$threshold]);
            }
        }
        return $this->defaultClass;
    }

}
