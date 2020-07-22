<?php

namespace App\Jobs;

use App\Category;
use App\Show;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class CreateNewShowJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Show $oldShow;
    protected Show $newShow;

    /**
     * Create a new job instance.
     *
     * @param Show $oldShow
     * @param Show $newShow
     */
    public function __construct(Show $oldShow, Show $newShow)
    {
        $this->oldShow = $oldShow;
        $this->newShow = $newShow;
        //
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
            ->where('status', '<>', 'deleted')
            ->orderBy('sortorder', 'asc')
            ->get();
        foreach ($categories as $category) {
            $newCategory = new Category();
            $newCategory->show()->associate($this->newShow);
            $newCategory->name         = $category->name;
            $newCategory->number       = $category->number;
            $newCategory->price        = $category->price;
            $newCategory->late_price   = $category->late_price;
            $newCategory->sortorder    = $category->sortorder;
            $newCategory->first_prize  = $category->first_prize;
            $newCategory->second_prize = $category->second_prize;
            $newCategory->third_prize  = $category->third_prize;
            $newCategory->section_id   = $category->section_id;
            $newCategory->cloned_from  = $category->id;
            $newCategory->status       = $category->status;
            $newCategory->save();

            $newCategory->cups()->attach($category->cups);

        }


        DB::table('entrants')->whereNotNull('age')->increment('age', 1);        //
    }
}
