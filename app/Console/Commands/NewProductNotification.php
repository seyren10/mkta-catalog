<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\BCProductService;
use App\Services\EntraMailService;

use App\Mail\NewProductMail;

use App\Models\Product;
use App\Models\ProductBasicDetail;
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
        // Fetch Product Data
        $bcProductService = new BCProductService();
        $productData = $bcProductService->get_products();
        // End Fetch Products Data

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
                $mail_message .= "<b>Product:</b> ".$product["title"]."<p>";
                $mail_message .= '<p><b>URL:</b> <a href="' . url('/verify-product') . '?token=' . $token . '">' . url('/verify-product') . '?token=' . $token . '</a></p>';

                // Log New Product Notification
                NewProductNotificationModel::create([
                    'token' => $token,
                    'product_id' => $product["id"],
                ]);

                ProductBasicDetail::create([
                    "product_id" => $product["id"],
                    "parent_code" => $product["parent_code"],
                    "title" => $product["title"],
                    "description" => $product["description"],
                    "volume" => ($product["volume"] ?? 0),
                    "weight_net" => ($product["weight_net"] ?? 0),
                    "weight_gross" => ($product["weight_gross"] ?? 0),
                    "dimension_length" => ($product["dimension_length"] ?? 0),
                    "dimension_width" => ($product["dimension_width"] ?? 0),
                    "dimension_height" => ($product["dimension_height"] ?? 0)
                ]);

                $product_count += 1;
            }
        }

        $mail_message .= "<hr>";
        $mail_message .= "<p>Best Regards,<br>".config('mail.from.name')."</p>";

        if($product_count > 0){
            // Send Email
            $email = new EntraMailService;
            $test = $email->sendMail("New Product", $mail_message, config('api.new_details_notifications.email'), true); // Pass true for HTML email
        }

        $this->info($product_count . ' new product(s) processed.');
    }
}
