<?php

namespace BedeCasino\Repositories\Contracts;

/**
 * Interface CasinoRespositoryInterface
 *
 * @package BedeCasino\Repositories\Contracts
 */
interface CasinoRespositoryInterface
{
    public function all();
    public function find($id);
    public function destroy($id);
    public function store(array $fields);
    public function update($id, array $fields);
    public function withinDistance($longitude, $latitude, $radius);
}
