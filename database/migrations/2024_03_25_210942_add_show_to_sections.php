<?php

use App\Models\Category;
use App\Models\Cup;
use App\Models\Section;
use App\Models\Show;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Except for show 1, duplicate all the categories
        Show::where('id', '<>', 1)->orderBy('start_date', 'asc')->each(function (Show $show) {
            print("\ndoing show " . $show->id);
            Section::whereNull('show_id')->each(function (Section $section) use ($show) {
                print("\ndoing section " . $section->id);
                $newSection = $section->replicate();
                $newSection->show()->associate($show);
                $newSection->save();
                print("\nnew section " . $newSection->id);
                print("\nnew section show " . $newSection->show->id);
                $section->categories()
                    ->forShow($show)
                    ->each(function (Category $category) use ($show, $newSection) {
                        print("\ncagtegory " . $category->id);
                        $category->section()->associate($newSection);
                        print("\ncagtegory section " . $category->section->id);
                        $category->save();
                    });
                // Where a cup related to a section before, relate it to the new section
                Cup::where('section_id', $section->id)
                    ->each(function (Cup $cup) use ($newSection, $show) {
                        print("\ncup " . $cup->id);

                        DB::table('cup_section_show')->insert(
                            ['cup_id' => $cup->id, 'section_id' => $newSection->id, 'show_id' => $show->id]
                        );
                    });
            });
        });
        $showNumber1 = \App\Models\Show::find(1);
        // Save the remaining
        Section::whereNull('show_id')->each(function (Section $section) use ($showNumber1) {
            $section->show()->associate($showNumber1);
            $section->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Section::where('show_id', '<>', 1)->each(function (Section $section) {
            $section->delete();
        });
        Section::where('show_id', 1)->each(function (Section $section) {
            $section->show_id = null;
            $section->save();
        });
    }
};
