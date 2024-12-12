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

        $newProducts = [];

        foreach ($products as $product) {
            $apiUpdatedAt = Carbon::parse($product['updated_at']);

            $existsInProducts = Product::find($product["id"]);
            $existsInNotifications = NewProductNotificationModel::where('product_id', $product["id"])->exists();

            if (!$existsInProducts && $apiUpdatedAt->isCurrentWeek() && !$existsInNotifications) {
                $newProducts[] = $product;
            }
        }

        foreach ($newProducts as $newProduct) {
            $token = $bcProductService->generateToken();

            $mail_message = "New Product has been created please check click the URL and complete the missing details! \n Token: ".$token."\n SKU: ".$newProduct["id"]."\n Product: ".$newProduct["title"];

            // Send Email
            $email = new EntraMailService;
            $test = $email->sendMail("New Product", $mail_message, "carlog@mkthemedattractions.com.ph");

            // Log New Product Notification
            NewProductNotificationModel::create([
                'token' => $token,
                'product_id' => $newProduct["id"],
            ]);
        }

        $this->info(count($newProducts) . ' new product(s) processed.');
    }
}
