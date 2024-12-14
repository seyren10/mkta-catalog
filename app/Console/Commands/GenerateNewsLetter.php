<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

use App\Services\EntraMailService;

use App\Models\Product;

class GenerateNewsLetter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-news-letter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = Carbon::now()->subDays(7);
        $end = Carbon::now();

        $products = Product::whereBetween('created_at', [$start, $end])
                    ->get();

        $template = "emails.news_letter";
        $data = [
            "products" => $products
        ];

        $mail_message = view($template, $data)->render();

        $email = new EntraMailService;
        $test = $email->sendMail("New Products from MK Themed Attractions", $mail_message, config('api.new_details_notifications.email'), true); // Pass true for HTML email
    }
}
