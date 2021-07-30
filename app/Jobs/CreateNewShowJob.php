<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Show;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class CreateNewShowJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Show $oldShow;
    protected Show $newShow;

    /**
     * Create a new job instance.
     */
    public function __construct( Show $oldShow,  Show $newShow)
    {
        $this->oldShow = $oldShow;
        $this->newShow = $newShow;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if ((int) $this->oldShow->id == (int) $this->newShow->id) {
            throw new InvalidArgumentException('You have to specify different shows');
        }

        if ($this->newShow->categories()->count() > 0) {
            throw new InvalidArgumentException('Looks like that Show has already been created.');
        }

        if ($this->oldShow->categories()->count() == 0) {
            throw new InvalidArgumentException('Looks like source Show doesn\'t exist');
        }

        // Gather all categories from the old year
        $categories = $this->oldShow->categories()
            ->orderBy('sortorder')
            ->get();
        foreach ($categories as $category) {
            /**
             * @var Category $category
             */
            $newCategory = $category->replicate(['show_id']);
            $newCategory->save();
            $newCategory->cups()->attach($category->cups);
            $newCategory->show()->associate($this->newShow);
            $newCategory->cloned_from = $category->id;
            $newCategory->save();
        }
    }
}
