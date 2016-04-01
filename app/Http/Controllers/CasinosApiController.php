<?php

namespace BedeCasino\Http\Controllers;

use Illuminate\Http\Request;
use BedeCasino\Repositories\CasinosRepository;
use BedeCasino\Repositories\Contracts\CasinoRespositoryInterface;

/**
 * Class CasinosApiController
 *
 * @package BedeCasino\Http\Controllers
 */
class CasinosApiController extends Controller
{
    /**
     * @var
     */
    protected $casinos;

    /**
     * @var
     */
    protected $request;

    /**
     * CasinosApiController constructor.
     *
     * @param CasinoRespositoryInterface $casinos
     * @param \Illuminate\Http\Request   $request
     */
    public function __construct(CasinoRespositoryInterface $casinos, Request $request)
    {
        $this->casinos = $casinos;
        $this->request = $request;
    }

    /**
     * Find results with optional support
     * for location based results
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // check if location specific search
        if ($this->request->has('longitude', 'latitude')) {
            $results = $this->casinos->withinDistance(
                $this->request->get('longitude'),
                $this->request->get('latitude'),
                $this->request->get('radius')
            );

            return response()->json($results);
        }

        $results = $this->casinos->all();

        if (!empty($results)) {
            return response()->json($results);
        }

        // 404 suggests the resource is non existent,
        // when in fact the request was successful, just no data
        return response()->json([], 204);
    }
}
