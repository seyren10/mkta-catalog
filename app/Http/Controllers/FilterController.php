<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use App\Models\FilterChoice;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index()
    {
        return array(
            "data" => Filter::get()
        );
    }
    public function store(Request $request)
    {
        $curFilter = Filter::create(
            array(
                "icon" => $request->icon,
                "title"=> $request->title,
                "description"=> $request->description,
            )
        );
        if($request->has('choices')){
            foreach ($request->choices as $key => $value) {
                FilterChoice::create(
                    array(
                        "filter_id" => $curFilter->id,
                        "value"  => $value
                    )
                );
            }
        }
        return response()->noContent();
    }
    public function show(Filter $filter)
    {
        return array(
            "data" => $filter
        );
        return response()->noContent();
    }
    public function update(Request $request, Filter $filter)
    {
        $filter->title = $request->title;
        $filter->icon = $request->icon;
        $filter->description = $request->description;
        if($request->has('choices')){
            foreach ($request->choices as $key => $value) {
                if($value["id"] == -1){
                    FilterChoice::create(
                        array(
                            "filter_id" => $filter->id,
                            "value"  => $value["value"]
                        )
                    );
                }else{
                    $curChoice = FilterChoice::where("id", $value["id"]);
                    if( $curChoice->get()->count() == 1 ){
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
}
