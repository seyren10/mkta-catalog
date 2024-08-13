<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();
        #region Parents
        Category::insert([(new CategoryData('New Product Items'))->toArray()]); //   1
        Category::insert([(new CategoryData('Christmas'))->toArray()]); //   2
        Category::insert([(new CategoryData('Halloween'))->toArray()]); //   3
        Category::insert([(new CategoryData('Easter'))->toArray()]); //   4
        Category::insert([(new CategoryData('Summer & Spring'))->toArray()]); //   5
        Category::insert([(new CategoryData('Animals'))->toArray()]); //   6
        Category::insert([(new CategoryData('Dinosaurs'))->toArray()]); //   7
        Category::insert([(new CategoryData('Pirate'))->toArray()]); //   8
        Category::insert([(new CategoryData('Wild West'))->toArray()]); //   9
        Category::insert([(new CategoryData('Chairs & Tables'))->toArray()]); //   10
        Category::insert([(new CategoryData('Wall Décor'))->toArray()]); //   11
        Category::insert([(new CategoryData('Archway'))->toArray()]); //   12
        Category::insert([(new CategoryData('Photo Op'))->toArray()]); //   13
        Category::insert([(new CategoryData('Foods & Beverages'))->toArray()]); //   14
        Category::insert([(new CategoryData('Comic'))->toArray()]); //   15
        Category::insert([(new CategoryData('Space '))->toArray()]); //   16
        Category::insert([(new CategoryData('Statues'))->toArray()]); //   17
        Category::insert([(new CategoryData('Inlitefi'))->toArray()]); //   18
        // Category::insert([(new CategoryData('Plopsa'))->toArray()]); //   19
        #endregion
        #region Christmas
        $parent = 2;
        $arr = ['Christmas Balls', 'Christmas Characters', 'Elves', 'Reindeers', 'Snowmen', 'Gingerbreads', 'Nutcrackers', 'Sleighs', 'Archways', 'Trees', 'Candies', 'Photo Ops', 'Chairs & Tables', 'Toys', 'Props', 'Winter'];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Halloween
        $parent++;
        $arr = ['Halloween Characters', 'Pumpkins', 'Skeletons', 'Mice', 'Scarecrows', 'Chairs & Tables', 'Trees', 'Coffins', 'ArchwayS', 'Photo Ops', 'Gravestones', 'Props'];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Easter
        $parent++;
        $arr = ['Easter Eggs', 'Easter Characters', 'Bunnies', 'Lambs', 'Chairs & Tables', 'Photo Ops', 'Archways', 'Props', 'Candies'];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region SUMMER & SPRING
        $parent++;
        $arr = ['Flowers', 'Animals', 'Food & Beverages'];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Animals
        $parent++;
        $arr = ['Safari', 'Forest', 'Reptiles', 'Insects', 'Marine', 'Farm', 'Domestic', 'Birds', 'Arctic'];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Dinosaurs
        $parent++;
        $arr = [];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Pirates
        $parent++;
        $arr = ['Pirate Characters', 'Chairs & Tables', 'Crates', 'Barrels', 'Props'];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region WILD WEST
        $parent++;
        $arr = ['Wild West Characters', 'Chairs & Tables', 'Crates', 'Barrels', 'Hays', 'Photo Ops', 'Props'];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region CHAIRS & TABLES
        $parent++;
        $arr = [
            'Christmas',
            'Halloween',
            'Easter',
            'Gingerbreads',
            'Food & Beverages',
            'Animals',
            'Cars',
            'Farm',
            'Pirates',
            'Wild West',
        ];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Wall Decor
        $parent++;
        $arr = [
            'Animals',
            'Pre-Historic',
            'Food & Beverages',
            'Halloween',
            'Cars',
            'Medieval'
        ];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Archway
        $parent++;
        $arr = [ 'Christmas', 'Halloween', 'Easter'];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Photo Op
        $parent++;
        $arr = [ 'Christmas', 'Halloween', 'Easter', 'Food & Beverages', 'All-Year' ];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Foods and Beverages
        $parent++;
        $arr = [ 'Chairs & Tables' ,'Candies' ,'Ice Creams' ,'Archways' ,'Props' ];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Comic
        $parent++;
        $arr = [ 'Panda', 'Penguins', 'Farm Animals', 'Photo Ops', 'Props', 'Play Equipments'];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Space
        $parent++;
        $arr = [ 'Aliens', 'UFO', 'Astronaut'];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Statues
        $parent++;
        $arr = [ 'Stones', 'Christmas', 'Characters', 'Mermaids', 'Comic Sports', 'Celebrities', 'Medieval'];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region InLiteFi
        $parent++;
        $arr = [ 'Christmas', 'Halloween', 'Easter', 'Summer', 'Animals', 'All-Year' ];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
        #region Template
        $parent++;
        $arr = [];
        foreach ($arr as $value) {
            Category::insert([(new CategoryData($value, $parent))->toArray()]);
        }
        #endregion
    }
}

class CategoryData
{

    public function __construct(public $title, public $parent_id = 0, public $description = '', public $file_id = 0)
    {

    }

    public function toArray()
    {
        return [
            "title" => trim(self::sentenceCase($this->title)),
            "description" => $this->description,
            "parent_id" => $this->parent_id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    public function sentenceCase($string)
    {
        $sentences = explode(' ', $string);
        $newString = '';
        foreach ($sentences as $sentence) {
            $newString .= ucfirst(strtolower(trim($sentence))).' ';
        }
        return trim($newString);
    }
}
