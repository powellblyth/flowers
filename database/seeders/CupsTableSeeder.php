<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('cups')->delete();

        \DB::table('cups')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => 'Cowen Bowl',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 28,
                    'winning_criteria' => 'The winner of greatest number of points in section 2',
                    'sort_order' => 10,
                    'num_display_results' => 2,
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'Clifford Bragg Cup',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 77,
                    'winning_criteria' => 'The winner of greatest number of points in section 3',
                    'sort_order' => 20,
                    'num_display_results' => 2,
                ),
            2 =>
                array(
                    'id' => 3,
                    'name' => 'Petersham Perpetual Cup',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 10,
                    'winning_criteria' => 'The winner of greatest number of points in section 4',
                    'sort_order' => 30,
                    'num_display_results' => 2,
                ),
            3 =>
                array(
                    'id' => 4,
                    'name' => 'James Clark Memorial Cup',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 28,
                    'winning_criteria' => 'The winner of greatest number of points in section 5',
                    'sort_order' => 40,
                    'num_display_results' => 2,
                ),
            4 =>
                array(
                    'id' => 5,
                    'name' => 'Philip Carr Challenge Cup',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 24,
                    'winning_criteria' => 'The winner of greatest number of points in section 6',
                    'sort_order' => 50,
                    'num_display_results' => 2,
                ),
            5 =>
                array(
                    'id' => 6,
                    'name' => 'Violet Lincoln Memorial Salver',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 18,
                    'winning_criteria' => 'The winner of greatest number of points in section 7',
                    'sort_order' => 60,
                    'num_display_results' => 2,
                ),
            6 =>
                array(
                    'id' => 7,
                    'name' => 'Edmonds Cup',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 61,
                    'winning_criteria' => 'The winner of greatest number of points in section 9',
                    'sort_order' => 70,
                    'num_display_results' => 2,
                ),
            7 =>
                array(
                    'id' => 8,
                    'name' => 'Pamela Griffiths Cup',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 13,
                    'winning_criteria' => 'Greatest number of points (Junior Floral)',
                    'sort_order' => 80,
                    'num_display_results' => 2,
                ),
            8 =>
                array(
                    'id' => 9,
                    'name' => 'The Kathleen and Harold Sharp Trophy',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 28,
                    'winning_criteria' => 'For the winner of Class 28',
                    'sort_order' => 90,
                    'num_display_results' => 2,
                ),
            9 =>
                array(
                    'id' => 10,
                    'name' => 'The Mary Turner Cup',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 35,
                    'winning_criteria' => 'For the winner of Class 87',
                    'sort_order' => 100,
                    'num_display_results' => 2,
                ),
            10 =>
                array(
                    'id' => 11,
                    'name' => 'PHS Top Tray',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 10,
                    'winning_criteria' => 'Best in Top Tray category',
                    'sort_order' => 110,
                    'num_display_results' => 3,
                ),
            11 =>
                array(
                    'id' => 12,
                    'name' => 'PHS Top Vase',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 67,
                    'winning_criteria' => 'Best in Top Vase',
                    'sort_order' => 120,
                    'num_display_results' => 3,
                ),
            12 =>
                array(
                    'id' => 13,
                    'name' => 'Banksian Medal',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => 26,
                    'winning_criteria' => 'The largest total amount of points in the whole of the horticultural classes at the Show, or who has the highest number of place points within the vegetable, fruit, flower and plant sections (Exclusions apply)',
                    'sort_order' => 130,
                    'num_display_results' => 4,
                ),
            13 =>
                array(
                    'id' => 14,
                    'name' => 'Anthony Rampton Memorial Prize',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => 27,
                    'winning_category' => '80b',
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => 'Most meritorious photograph exhibit',
                    'sort_order' => 140,
                    'num_display_results' => 2,
                ),
            14 =>
                array(
                    'id' => 15,
                    'name' => 'Cowen Cup',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => 35,
                    'winning_category' => '96b',
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => 'Most Meritorious Exhibit of Children\'s Art',
                    'sort_order' => 150,
                    'num_display_results' => 2,
                ),
            15 =>
                array(
                    'id' => 16,
                    'name' => 'Best in Show Artwork Rosette',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => 35,
                    'winning_category' => '96b',
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => 'Best in show - Adult or Children\'s art',
                    'sort_order' => 160,
                    'num_display_results' => 2,
                ),
            16 =>
                array(
                    'id' => 17,
                    'name' => 'The North Trophy',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => 79,
                    'winning_category' => '62',
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => 'The cookery exhibit that gives the judge the most pleasure',
                    'sort_order' => 170,
                    'num_display_results' => 2,
                ),
            17 =>
                array(
                    'id' => 18,
                    'name' => 'Harry Thorne Memorial Cup',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => 1,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => 'Most Meritorious exhibit of vegetables in the show',
                    'sort_order' => 180,
                    'num_display_results' => 2,
                ),
            18 =>
                array(
                    'id' => 24,
                    'name' => 'Lambert Memorial Bowl & Worshipful company of gardener\'s Diploma of Excellence',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => 3,
                    'winning_category' => '10',
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => 'Best entry for any rose in any category',
                    'sort_order' => 240,
                    'num_display_results' => 2,
                ),
            19 =>
                array(
                    'id' => 25,
                    'name' => 'Anne Millard Cup',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => 15,
                    'winning_category' => '83',
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => 'Best Junior Floral',
                    'sort_order' => 250,
                    'num_display_results' => 2,
                ),
            20 =>
                array(
                    'id' => 26,
                    'name' => 'John Grapes Memorial Prize',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => 28,
                    'winning_category' => '28',
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => 'Most Meritorious Exhibit of Flowers in the show',
                    'sort_order' => 260,
                    'num_display_results' => 2,
                ),
            21 =>
                array(
                    'id' => 27,
                    'name' => 'The Worshipful Company of Gardeners; Certificate of Merit (floral decoration)',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => 28,
                    'winning_category' => '60',
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => 'Best Floral entry',
                    'sort_order' => 270,
                    'num_display_results' => 2,
                ),
            22 =>
                array(
                    'id' => 28,
                    'name' => 'RHS Certificate of Merit (Junior Floral, Fruit and Vegetables)',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => 35,
                    'winning_category' => '87',
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => 'Best Junior Floral, Fruit & Vegetable entry',
                    'sort_order' => 280,
                    'num_display_results' => 2,
                ),
            23 =>
                array(
                    'id' => 29,
                    'name' => 'Col Bromhead Memorial Cup Rosette and Certifiate',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => 28,
                    'winning_category' => '28',
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => 'Best in Show in either fruit, flowers or vegetables',
                    'sort_order' => 290,
                    'num_display_results' => 2,
                ),
            24 =>
                array(
                    'id' => 30,
                    'name' => 'The Worshipful Company of Gardeners’ Certificate of Merit in Horticulture',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => 'The winner of greatest number of points in section 1',
                    'sort_order' => 1,
                    'num_display_results' => 2,
                ),
            25 =>
                array(
                    'id' => 31,
                    'name' => 'The Alf Gundry Memorial Prize',
                    'created_at' => null,
                    'updated_at' => null,
                    'direct_winner' => null,
                    'winning_category' => null,
                    //                'calculated_cup_winner' => null,
                    'winning_criteria' => ' The winner of Class 57(a).',
                    'sort_order' => 35,
                    'num_display_results' => 2,
                ),
        ));


    }
}
