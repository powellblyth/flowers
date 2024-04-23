<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Section;
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

    /**
     * Create a new job instance.
     */
    public function __construct(protected Show $oldShow, protected Show $newShow)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->oldShow->is($this->newShow)) {
            throw new InvalidArgumentException('You have to specify different shows');
        }

        if ($this->newShow->categories()->count() > 0) {
            throw new InvalidArgumentException('Looks like that Show has already been created.');
        }

        if ($this->oldShow->categories()->count() == 0) {
            throw new InvalidArgumentException('Looks like source Show doesn\'t have any categories');
        }

        if ($this->oldShow->sections()->count() == 0) {
            throw new InvalidArgumentException('Looks like source Show doesn\'t have any sections');
        }
        $this->oldShow->sections()
            ->orderBy('number')
            ->get()
            ->each(function (Section $section) {
                $newSection = $section->replicate();
                $newSection->show()->associate($this->newShow);
                $newSection->clonedFrom()->associate($section);
                $newSection->save();

                // Gather all categories from the old year
                $categories = $this->oldShow->categories()
                    ->inOrder()
                    ->get();
                $categories->each(function (Category $category) use ($newSection) {
                    $newCategory = $category->replicate(['show_id']);
                    $newCategory->save();
                    $newCategory->cups()->attach($category->cups);
                    $newCategory->show()->associate($this->newShow);
                    $newCategory->judgeRoles()->saveMany($category->judgeRoles);
                    $newCategory->cloned_from = $category->id;
                    $newCategory->section()->associate($newSection);
                    $newCategory->save();
                });
            });
    }
}
