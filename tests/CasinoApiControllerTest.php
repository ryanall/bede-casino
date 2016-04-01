<?php

use \Mockery as m;
use Illuminate\Http\JsonResponse;
use BedeCasino\Http\Controllers\CasinosApiController;

class CasinoApiControllerTest extends TestCase
{
    public function testLocationApiResultsFound()
    {
        $repositoryMock = m::mock('BedeCasino\Repositories\Contracts\CasinoRespositoryInterface');
        $requestMock    = m::mock('Illuminate\Http\Request');

        $longitude = '-1.617780';
        $latitude  = '54.978252';
        $radius    = 5;

        $expectedResult = new JsonResponse([]);

        $requestMock->shouldReceive('has')->with('longitude', 'latitude')->andReturn(true);
        $requestMock->shouldReceive('get')->with('longitude')->andReturn($longitude);
        $requestMock->shouldReceive('get')->with('latitude')->andReturn($latitude);
        $requestMock->shouldReceive('get')->with('radius')->andReturn($radius);

        $repositoryMock->shouldReceive('withinDistance')->with($longitude, $latitude, $radius)->andReturn($expectedResult);

        $controller = new CasinosApiController(
            $repositoryMock,
            $requestMock
        );

        $this->assertEquals($expectedResult->status(), $controller->index()->status());
    }

    public function testNoApiResultsFound()
    {
        $repositoryMock = m::mock('BedeCasino\Repositories\Contracts\CasinoRespositoryInterface');
        $requestMock    = m::mock('Illuminate\Http\Request');

        $expectedResult = new JsonResponse([], 204);
        $requestMock->shouldReceive('has')->with('longitude', 'latitude')->andReturn(false);
        $repositoryMock->shouldReceive('all')->andReturn(null);

        $controller = new CasinosApiController(
            $repositoryMock,
            $requestMock
        );

        $this->assertEquals($expectedResult->status(), $controller->index()->status());
    }

    public function testNoLocationSearchButResultsFound()
    {
        $repositoryMock = m::mock('BedeCasino\Repositories\Contracts\CasinoRespositoryInterface');
        $requestMock    = m::mock('Illuminate\Http\Request');

        $expectedResult = new JsonResponse([], 200);
        $requestMock->shouldReceive('has')->with('longitude', 'latitude')->andReturn(false);
        $repositoryMock->shouldReceive('all')->andReturn(['casino1', 'casino2']);

        $controller = new CasinosApiController(
            $repositoryMock,
            $requestMock
        );

        $this->assertEquals($expectedResult->status(), $controller->index()->status());
    }
}
