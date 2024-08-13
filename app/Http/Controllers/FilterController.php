<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilterResource;
use App\Models\Filter;
use App\Models\FilterChoice;
use App\Models\ProductFilter;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    #region Default Functions
    public function index()
    {
        return FilterResource::collection(Filter::get());
    }
    public function store(Request $request)
    {
        $curFilter = Filter::create(
            array(
                "icon" => $request->icon,
                "title" => $request->title,
                "description" => $request->description,
            )
        );
        if ($request->has('choices')) {
            foreach ($request->choices as $key => $value) {
                FilterChoice::create(
                    array(
                        "filter_id" => $curFilter->id,
                        "value" => $value,
                    )
                );
            }
        }
        return response()->noContent();
    }
    public function show(Filter $filter)
    {
        return new FilterResource($filter);
    }
    public function update(Request $request, Filter $filter)
    {
        $filter->title = $request->title;
        $filter->icon = $request->icon;
        $filter->description = $request->description;
        if ($request->has('choices')) {
            foreach ($request->choices as $key => $value) {
                if ($value["id"] == -1) {
                    FilterChoice::create(
                        array(
                            "filter_id" => $filter->id,
                            "value" => $value["value"],
                        )
                    );
                } else {
                    $curChoice = FilterChoice::where("id", $value["id"]);
                    if ($curChoice->get()->count() == 1) {
                        $curChoice = $curChoice->get()->first();
                        $curChoice->value = $value["value"];
                        $curChoice->save();
                    }
                }
            }
        }
        $filter->save();
        return response()->noContent();
    }
    public function destroy(Filter $filter)
    {
        $filter->delete();
        return response()->noContent();
    }
    #endregion
    #region Custom Functions
    public static function batchUpdate(Request $request)
    {
        foreach ($request->filters as $key => $value) {
            $curFilter = Filter::where('id', $key)->with([])->first();
            $allowContinue = [
                !($curFilter === null),
                array_key_exists('data', $value),
                array_key_exists('options', $value),
            ];

            if (in_array(false, $allowContinue)) {
                continue;
            }

            #region Product Info Update
            foreach ($value['data'] as $col => $data) {
                $curFilter[$col] = $data;
            }
            $curFilter->save();
            #endregion

            foreach ($value['options'] as $optionID => $optionData) {
                $curOption = FilterChoice::where('id', $optionID)->where('filter_id', $curFilter->id)->first();
                $allowContinue = [
                    !($curOption === null),
                    array_key_exists('append', $optionData),
                    array_key_exists('remove', $optionData),
                ];

                if (in_array(false, $allowContinue)) {
                    continue;
                }

                foreach ($optionData['append'] as $keyIndex => $appendData) {

                    $isAllowed = ProductFilter::where('product_id', $appendData['id'])
                        ->where('filter_id', $curFilter->id, )
                        ->where('filter_choice_id', $curOption->id)->get()->count() === 0;
                    if ($isAllowed) {
                        ProductFilter::create(
                            array(
                                'product_id' => $appendData['id'],
                                'filter_id' => $curFilter->id,
                                'filter_choice_id' => $curOption->id,
                            )
                        );
                    }

                }
                foreach ($optionData['remove'] as $keyIndex => $removeData) {
                    ProductFilter::where('product_id', $removeData)
                        ->where('filter_id', $curFilter->id, )
                        ->where('filter_choice_id', $curOption->id)
                        ->delete();
                }
            }

        }
        return response()->noContent(200);
    }
    #endregion
}
