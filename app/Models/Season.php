<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_month',
        'start_date',
        'end_month',
        'end_date',
    ];
    protected $appends = [
        'actual_start_date',
        'actual_end_date',

    ];
    protected $with = ['categories'];
    public function getActualStartDateAttribute()
    {
        return Carbon::createFromDate(Carbon::now()->year, $this->start_month, $this->start_date)->toFormattedDateString();
    }
    public function getActualEndDateAttribute()
    {
        $curYear = Carbon::now()->year;
        if ($this->end_month < $this->start_month) {
            $curYear++;
        }
        return Carbon::createFromDate($curYear, $this->end_month, $this->end_date)->toFormattedDateString();
    }

    /**
     * Get all of the comments for the season
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(SeasonCategory::class, 'season_id', 'id');
    }
    public function category_keys()
    {
        return $this->hasMany(SeasonCategory::class, 'season_id', 'id')->select('category_id');
    }
}
