<?php

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sections')->delete();
        
        \DB::table('sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Novices',
                'number' => '1',
                'notes' => 'Entry to this novice class is open to members who have not won a prize in any previous Petersham Flower Show',
                'judges' => 'Mr R. Bailey & Mrs P. Edwards',
                'image' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Flowers',
                'number' => '2',
                'notes' => NULL,
                'judges' => 'Mr R. Bailey',
                'image' => '<img class="alignleft size-full wp-image-62" title="Winning Rose" src="http://www.petershamhorticulturalsociety.org.uk/wp-content/uploads/2012/03/WinningRose.jpg" alt="A winning rose in our Flowers section" width="225" height="300">',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Fruit',
                'number' => '3',
                'notes' => NULL,
                'judges' => 'Mrs P. Edwards',
                'image' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Vegetables & Produce',
                'number' => '4',
                'notes' => NULL,
                'judges' => 'Mrs P. Edwards',
                'image' => '<img class="alignleft size-full wp-image-63" title="judging vegetables" src="http://www.petershamhorticulturalsociety.org.uk/wp-content/uploads/2012/03/judging-vegetables.jpg" alt="Image of Mr Studman judging vegetables" width="200" height="300">',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Floral Arrangement',
                'number' => '5',
                'notes' => NULL,
                'judges' => 'Mr R. Bailey',
                'image' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Cookery',
                'number' => '6',
                'notes' => NULL,
                'judges' => 'Mr J. Rounce',
                'image' => '<img class="alignleft size-full wp-image-64" title="cakes" src="http://www.petershamhorticulturalsociety.org.uk/wp-content/uploads/2012/03/cakes.jpg" alt="Some cakes waiting to be judged" width="202" height="134">',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Arts & Crafts',
                'number' => '7',
                'notes' => NULL,
                'judges' => 'Mrs C. Tudway & Mr C Bayne',
                'image' => '<img class="alignleft size-full wp-image-66" title="Cushion" src="http://www.petershamhorticulturalsociety.org.uk/wp-content/uploads/2012/03/Cushion.jpg" alt="A prize-winning cushion" width="200" height="300">',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Floral, Fruit & Vegetables',
                'number' => '8',
                'notes' => NULL,
                'judges' => 'Mr R. Bailey and Mrs P. Edwards',
                'image' => '<img class="alignleft size-full wp-image-68" title="wildlife garden" src="http://www.petershamhorticulturalsociety.org.uk/wp-content/uploads/2012/03/wildlife-garden.jpg" alt="A junior wildlife garden" width="300" height="200">',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Cookery, Arts & Crafts',
                'number' => '9',
                'notes' => NULL,
                'judges' => 'Mr Rounce, Mr Bailey, Mr Kimbell, Mrs Tudway, Mrs Edwards &  Mr C Bayne',
                'image' => '<img class="alignleft size-full wp-image-70" title="junior cookery" src="http://www.petershamhorticulturalsociety.org.uk/wp-content/uploads/2012/03/junior-cookery.jpg" alt="Miscellaneous winning junior cookery prizes" width="300" height="200">',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}