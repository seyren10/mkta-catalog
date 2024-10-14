<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\UserServices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Truncate extends Command
{
    protected $signature = 'retrieve-restrictions';
    protected $description = 'Backup the database to individual SQL files for each table with structure and data';


    protected $serv;
    public function __construct( UserServices $serve )
    {
        $this->serv = $serve;
        parent::__construct();
    }

    public function handle()
    {
        $serv = UserServices::class;
        $users = User::get();
        foreach ($users as $key => $user) {
            Log::info($user->email);
            $products = $this->serv->getRestrictedProducts($user);
            Log::info(implode(',', $products));
        }
    }
   

}
