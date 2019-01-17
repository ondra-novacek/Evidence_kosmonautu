<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Resources\Cosmonaut as CosmonautResource;
use App\Cosmonaut;
use App\Services\PayUService\Exception;
use App\Http\Requests\StoreCosmonaut;


class CosmonautController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all cosmonauts using resources with extra data to simplify pagination on front-end
        // it is also being ordered by surname in asc order
        $cosmonauts = Cosmonaut::orderBy('surname', 'asc')->paginate(7);
        return CosmonautResource::collection($cosmonauts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCosmonaut $request)
    {
        // backend validation of data, returns 422 error if it fails
        // see Http\Request\StoreCosmonaut file for more info about validation
        $request->validated();
        
        // for updating and creating new cosmonaut
        // if id not found -> we have to create new else update (the existing one)
        $cosmonaut = $request->isMethod('put') ? Cosmonaut::findOrFail($request->cosmonaut_id) : new Cosmonaut();

        $cosmonaut->name = $request->input('name');
        $cosmonaut->surname = $request->input('surname');
        $cosmonaut->superpower = $request->input('superpower');
        $cosmonaut->date_of_birth = $request->input('birth');

        $cosmonaut->save();
        return new CosmonautResource($cosmonaut);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get cosmonaut
        $cosmonaut = Cosmonaut::findOrFail($id);

        // return single article as a resource
        return new CosmonautResource($cosmonaut);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get cosmonaut
        $cosmonaut = Cosmonaut::findOrFail($id);

        // delete the article
        $cosmonaut->delete();

        // return back the deleted article
        return new CosmonautResource($cosmonaut);
    }
}
