<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Category;
use App\CupToCategory;

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
        $categories = Category::where('year', (int) $yearFrom)->get();
        foreach ($categories as $category) {
            $newCategory = new Category();
            $newCategory->year = $yearTo;
            $newCategory->name = $category->name;
            $newCategory->section = $category->section;
            $newCategory->number = $category->number;
            $newCategory->price = $category->price;
            $newCategory->late_price = $category->late_price;
            $newCategory->sortorder = $category->sortorder;
            $newCategory->first_prize = $category->first_prize;
            $newCategory->second_prize = $category->second_prize;
            $newCategory->third_prize = $category->third_prize;
            $newCategory->save();

            $cupToCategories = CupToCategory::where('category', $category->id)->get();
            foreach ($cupToCategories as $cupToCategory) {
                $newCupToCategory = new CupToCategory();
                $newCupToCategory->cup_id = $cupToCategory->cup;
                $newCupToCategory->category_id = $newCategory->id;
                $newCupToCategory->save();
            }
        }

//insert into categories (
//categories.name,
//section,
//created_at,
//updated_at,
//number,
//price,
//late_price,
//sortorder,
//first_prize,
//second_prize,
//third_prize, categories.year) 
//(select 
//categories.name,
//section,
//created_at,
//updated_at,
//number,
//price,
//late_price,
//sortorder,
//first_prize,
//second_prize,
//third_prize,
//2018 from categories where year=2017)


        var_dump($this->arguments());
        die();
    }
}
