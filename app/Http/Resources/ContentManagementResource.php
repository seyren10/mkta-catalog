<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ContentManagementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed> 
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        $restricted_products = $request->session()->get('restricted_products', array());
        $jsonData = json_decode($data['data']);
        foreach ($jsonData as $key => $comp) {
            // Check if 'component' and required properties exist
            if (empty($comp->component->props->children)) {
                continue;
            }
            foreach ($comp->component->props->children as $current) {
                // Ensure 'data' and 'selectedProducts' exist
                if (empty($current->data->selectedProducts)) {
                    continue;
                }
                // Filter out restricted products
                $temp =(collect($current->data->selectedProducts)->whereNotIn('id', $restricted_products));
                $current->data->selectedProducts = array_values($temp->toArray());
            }
        }
        $data['data'] = json_encode($jsonData);

        return $data;
    }
}
