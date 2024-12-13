<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\BCProductService;
use App\Services\EntraMailService;

use App\Mail\NewProductMail;

use App\Models\Product;
use App\Models\NewProductNotfication as NewProductNotificationModel;

use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;

class NewProductNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:new-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notifications for new products added during the current week.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bcProductService = new BCProductService();
        $productData = $bcProductService->get_products();
        $products = $productData["data"] ?? [];

        $product_count = 0;
        $mail_message = "<p>Hi,</p>";
        $mail_message .= "<p>New Product has been created.<br>Please check the URL and complete the missing details!</p>";

        foreach ($products as $product) {
            $apiUpdatedAt = Carbon::parse($product['updated_at']);

            $existsInProducts = Product::find($product["id"]);
            $existsInNotifications = NewProductNotificationModel::where('product_id', $product["id"])->exists();

            if (!$existsInProducts && $apiUpdatedAt->isCurrentWeek() && !$existsInNotifications) {
                $token = $bcProductService->generateToken();

                $mail_message .= "<hr>";
                $mail_message .= "<p><b>SKU:</b> ".$product["id"]."<br>";
                $mail_message .= "<b>Product:</b> ".$product["title"]."<br><br>";
                $mail_message .= "<b>URL:</b> ".$token."</p>";

                // Log New Product Notification
                NewProductNotificationModel::create([
                    'token' => $token,
                    'product_id' => $product["id"],
                ]);

                $product_count += 1;
            }
        }

        $mail_message .= "<hr>";
        $mail_message .= "<p>Best Regards,<br>".config('mail.from.name')."</p>";

        // Send Email
        $email = new EntraMailService;
        $test = $email->sendMail("New Product", $mail_message, config('api.new_details_notifications.email'), true); // Pass true for HTML email

        $this->info($product_count . ' new product(s) processed.');
    }
}
