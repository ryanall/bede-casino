<?php

namespace BedeCasino\Repositories;

use BedeCasino\Casino;
use BedeCasino\Repositories\Contracts\CasinoRespositoryInterface;

/**
 * Class CasinosEloquentRepository
 *
 * @package BedeCasino\Repositories
 */
class CasinosEloquentRepository implements CasinoRespositoryInterface
{
    /**
     * Default location radius miles if not provided
     */
    const DEFAULT_RADIUS = 600;

    /**
     * @var \BedeCasino\Casino
     */
    protected $model;

    /**
     * CasinosEloquentRepository constructor.
     *
     * @param \BedeCasino\Casino $model
     */
    public function __construct(Casino $model)
    {
        $this->model = $model;
    }

    /**
     * @param $longitude
     * @param $latitude
     * @param $radius
     *
     * @return mixed
     */
    public function withinDistance($longitude, $latitude, $radius)
    {
        $radius = ($radius) ? $radius : static::DEFAULT_RADIUS ;

        if (isset($longitude, $latitude)) {
            return $this->model->filterByLocation(
                $latitude,
                $longitude,
                $radius
            )->get();
        }
    }

    /**
     * Store record
     * @param array $fields
     *
     * @return bool
     */
    public function store(array $fields)
    {
        foreach ($fields as $key => $value) {
            $this->model->{$key} = $value;
        }
        
        return $this->model->save();
    }

    /**
     * Retrieve all records
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Update a record
     * @param       $id
     * @param array $fields
     *
     * @return mixed
     */
    public function update($id, array $fields)
    {
        $result = $this->find($id);
        
        foreach ($fields as $key => $value) {
            $result->{$key} = $value;
        }
        
        return $result->save();
    }

    /**
     * Find record by ID
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * Destroy a record by ID
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }
}
