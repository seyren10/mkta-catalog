<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use App\Models\FilterChoice;
use Illuminate\Http\Request;

class FilterChoiceController extends Controller
{
    public function store(Request $request, Filter $filter)
    {
        FilterChoice::create(
            array(
                "filter_id" => $filter->id,
                "value"  => $request->value
            )
        );
        return response()->noContent();

    }
    public function update(Request $request, FilterChoice $filter_choice)
    {
        $filter_choice->value = $request->value;
        $filter_choice->save();
        return response()->noContent();
    }
    public function destroy(FilterChoice $filter_choice)
    {
        $filter_choice->delete();
        return response()->noContent();
    }
}
