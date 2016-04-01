<?php

namespace BedeCasino;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Casino
 *
 * @package BedeCasino
 */
class Casino extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'web_address', 'longitude', 'latitude', 'opening_times'];

    /**
     * The attributes that should not be returned.
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'created_at'];

    /**
     * Query builder scope to list neighboring locations
     * within a given distance from a given location
     *
     * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  mixed                              $lat    Latitude of given location
     * @param  mixed                              $lng    Longitude of given location
     * @param  integer                            $radius Distance
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopefilterByLocation($query, $lat, $lng, $radius)
    {
        $unit   = 3963.17;
        $lat    = (float) $lat;
        $lng    = (float) $lng;
        $radius = (double) $radius;
        
        return $query->having('distance', '<=', $radius)
            ->select(\DB::raw("*,
                        ($unit * ACOS(COS(RADIANS($lat))
                            * COS(RADIANS(latitude))
                            * COS(RADIANS($lng) - RADIANS(longitude))
                            + SIN(RADIANS($lat))
                            * SIN(RADIANS(latitude)))) AS distance"))->orderBy('distance', 'asc');
    }
}
