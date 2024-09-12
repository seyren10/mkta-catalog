<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Truncate extends Command
{
    protected $signature = 'truncate:database';
    protected $description = 'Backup the database to individual SQL files for each table with structure and data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $type = $this->choice('What do you want to truncate?', ['table', 'arc'], 0);
        $this->info($type);

        if ($type === 'table') {
            $this->truncateSingleTable();
        } elseif ($type === 'arc') {
            $this->truncateMultipleTables();
        }
    }
    protected function truncate($table){
        try {

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table($table)->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->info("Table '{$table}' has been truncated.");
        } catch (\Throwable $th) {
            $this->error('Operation failed. Invalid Table Name: ' . $table);
        }
    }
    protected function truncateTable()
    {
        $key = $this->ask('Enter the name of the table to truncate');
        if ($this->confirm("Are you sure you want to truncate the table '{$key}'?")) {
            self::truncate($key);
        } else {
            $this->info('Operation cancelled.');
        }
    }
    protected function truncateMultipleTables()
    {
        $key = $this->ask('Enter the Arc Name');

        // Split the input into an array of table names
        
        $tables = [
            "products_arc" => [
                'products',
                'product_categories',
                'product_components',
                'product_exemptions',
                'product_filters',
                'product_images',
                'product_restrictions',
                'product_tags',
                'recommended_products',
                'related_products'
            ],
            "categories_arc" => [
                'categories',
                'product_categories'
            ],
            "notifications_arc" =>[
                'notifications'
            ],
            "wishlist_arc" =>[
                'user_wishlists',
                'non_wishlist_users'
            ],
            "related_products_arc" => [
                'related_products'
            ],
            "recommended_products_arc" => [
                'recommended_products'
            ],
            "filter_arc" =>[
                'filters',
                'filter_choices',
                'product_filters'
            ],
            "job_arc" => [
                'failed_jobs',
                'jobs',
                'job_batches'
            ],
            "area_arc" =>[
                'area_codes',
                'user_areas'
            ],
            "company_arc" =>[
                'company_codes',
                'user_companies'
            ]
        ];
        if ($this->confirm("Are you sure you want to truncate the arc '{$key}'?")) {
            if(
                array_key_exists($key, $tables)
            ){
                foreach ($tables[$key] as $table) {
                    self::truncate($table);
                }
            }else{
                $this->error("Invalid '{$key}' command.");
            }
            
        } else {
            $this->info("Operation cancelled for the arc '{$key}'.");
        }

    }

}
