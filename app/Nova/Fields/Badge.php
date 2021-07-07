<?php


namespace App\Nova\Fields;

/**
 * this class overrides dodgy behaviour from laravel's source
 * Class Badge
 * @package App\Nova\Fields
 */
class Badge extends \Laravel\Nova\Fields\Badge
{
    /**
     * @var string
     */
    public $defaultClass = 'info';

    public function defaultClass(string $default): void
    {
        $this->defaultClass = $default;
    }

    /**
     * Resolve the Badge's CSS classes based on the field's value.
     * This version defaults to Info
     *
     * @return string
     */
    public function resolveBadgeClasses()
    {
        try {
            $string = parent::resolveBadgeClasses();
        } catch (\Exception $e) {
            $string = $this->types[$this->defaultClass];
        } finally {
            return $string;
        }
    }
}
