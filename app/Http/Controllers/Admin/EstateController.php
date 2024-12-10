<?php

namespace App\Http\Controllers\Admin;

use App\Models\Estate;
use App\Http\Requests\StoreEstateRequest;
use App\Http\Requests\UpdateEstateRequest;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('estates/Index', [
            'message' => 'Messaggio pagina'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Estate $estate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estate $estate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstateRequest $request, Estate $estate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estate $estate)
    {
        //
    }
}
