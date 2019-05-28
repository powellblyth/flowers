<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Category;

class CreateNewYearDataCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $name = 'data:create-new-year-data {year-from} {year-to}';
    protected $signature = 'data:create-new-year-data {year-from} {year-to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'copies all the data from one year to another';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        //
        $yearFrom = $this->argument('year-from');
        $yearTo = $this->argument('year-to');
        if (!is_numeric($yearFrom)) {
            throw new \Symfony\Component\Console\Exception\InvalidArgumentException('From Year must be numeric');
        }
        if (!is_numeric($yearTo)) {
            throw new \Symfony\Component\Console\Exception\InvalidArgumentException('To Year must be numeric');
        }
        if ((int) $yearTo == (int) $yearFrom) {
            throw new \Symfony\Component\Console\Exception\InvalidArgumentException('You have to specify different years');
        }

        if (Category::where('year', $yearTo)->first() instanceof Category) {
            throw new \Symfony\Component\Console\Exception\InvalidArgumentException('Looks like that Year To has already been created.');
        }

        if (!Category::where('year', $yearFrom)->first() instanceof Category) {
            throw new \Symfony\Component\Console\Exception\InvalidArgumentException('Looks like that Year From doesn\'t exist');
        }

        // Gather all categories from the old year
        $categories = Category::where('year', (int) $yearFrom)->orderBy('sortorder', 'asc')->get();
        foreach ($categories as $category) {
            $newCategory = new Category();
            $newCategory->year = $yearTo;
            $newCategory->name = $category->name;
//            $newCategory->section = $category->section;
            $newCategory->number = $category->number;
            $newCategory->price = $category->price;
            $newCategory->late_price = $category->late_price;
            $newCategory->sortorder = $category->sortorder;
            $newCategory->first_prize = $category->first_prize;
            $newCategory->second_prize = $category->second_prize;
            $newCategory->third_prize = $category->third_prize;
            $newCategory->section_id = $category->section_id;
            $newCategory->save();

            $newCategory->cups()->attach($category->cups);

        }




        var_dump($this->arguments());
        die();
    }
}
