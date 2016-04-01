<?php

namespace BedeCasino\Http\Controllers;

use Validator;
use BedeCasino\Http\Requests;
use Illuminate\Http\Request;
use BedeCasino\Repositories\Contracts\CasinoRespositoryInterface;

/**
 * Class CasinosManageController
 *
 * @package BedeCasino\Http\Controllers
 */
class CasinosManageController extends Controller
{
    /**
     * Resource path
     */
    const RESOURCE_PATH = 'manage/';

    /**
     * @var \BedeCasino\Repositories\CasinosRepository
     */
    protected $casinos;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Rules to validate request against
     * @var array
     */
    protected $rules = [
        'name'           => 'required',
        'web_address'    => 'active_url',
        'longitude'      => 'required|numeric',
        'latitude'       => 'required|numeric',
        'opening_times'  => 'string',
    ];

    /**
     * CasinosManageController constructor.
     *
     * @param CasinoRespositoryInterface $casinos
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(CasinoRespositoryInterface $casinos, Request $request)
    {
        $this->middleware('auth');
        $this->casinos  = $casinos;
        $this->request = $request;
    }

    /**
     * Show manage dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.home', [
            'casinos' => $this->casinos->all()
        ]);
    }

    /**
     * Edit a record
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('admin.edit', [
            'casino' => $this->casinos->find($id),
        ]);
    }

    /**
     * Edit a record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a record
     * @return mixed
     */
    public function store()
    {
        $validator = Validator::make($this->getPermittedRequestFields(), $this->rules);

        if ($validator->fails()) {
            return \Redirect::to(static::RESOURCE_PATH . 'create')->withErrors($validator)->withInput();
        }

        $this->casinos->store($this->getPermittedRequestFields());
        \Session::flash('message', 'Successfully added casino!');
        return \Redirect::to(static::RESOURCE_PATH);
    }

    /**
     * Update a record
     * @param $id
     *
     * @return mixed
     */
    public function update($id)
    {
        $validator = Validator::make($this->getPermittedRequestFields(), $this->rules);

        if ($validator->fails()) {
            return \Redirect::to(static::RESOURCE_PATH . $id . '/edit')->withErrors($validator)->withInput();
        }

        $this->casinos->update($id, $this->getPermittedRequestFields());
        \Session::flash('message', 'Successfully updated casino!');
        return \Redirect::to(static::RESOURCE_PATH . $id . '/edit')->withInput();
    }

    /**
     * Destroy a record
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        $this->casinos->destroy($id);
        \Session::flash('message', 'Successfully deleted casino!');
        return \Redirect::to(static::RESOURCE_PATH);
    }

    /**
     * Show a record
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json([
            'status' => 'Not Implemented'
        ]);
    }

    /**
     * Get request fields that are permitted
     * @return array Rules
     */
    protected function getPermittedRequestFields()
    {
        return $this->request->only(array_keys($this->rules));
    }
}
