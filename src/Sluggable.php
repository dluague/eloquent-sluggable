<?php namespace Cviebrock\EloquentSluggable;

use Cviebrock\EloquentSluggable\Services\SlugService;


/**
 * Class Sluggable
 *
 * @package Cviebrock\EloquentSluggable
 */
trait Sluggable
{

    /**
     * Hook into the Eloquent model events to create or
     * update the slug as required.
     */
    public static function bootSluggable()
    {
        static::observe(app(SluggableObserver::class));
    }

    /**
     * Register a slugging model event with the dispatcher.
     *
     * @param \Closure|string $callback
     * @return void
     */
    public static function slugging($callback)
    {
        static::registerModelEvent('slugging', $callback);
    }

    /**
     * Register a slugged model event with the dispatcher.
     *
     * @param \Closure|string $callback
     * @return void
     */
    public static function slugged($callback)
    {
        static::registerModelEvent('slugged', $callback);
    }

    /**
     * Clone the model into a new, non-existing instance.
     *
     * @param  array|null $except
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function replicate(array $except = null)
    {
        $instance = parent::replicate($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    abstract public function sluggable();
}
