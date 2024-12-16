<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $areas = Area::all('id', 'area');
        
        return Inertia::render('areas/Index', [
            'areas' => $areas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('areas/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAreaRequest $request)
    {
        
        $form_data = $request->validated();
        $area = new Area();
        $area->fill($form_data);

        $area->save();

        return redirect()->route('admin.areas.index')->with('message', 'Area inserita correttamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {   
        return Inertia::render('areas/Edit', ['area' => $area]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAreaRequest $request, Area $area)
    {   
        $form_data = $request->validated();
        $area->update($form_data);

        return redirect()->route('admin.areas.index')->with('message', 'Area aggiornata correttamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        //
    }
}
