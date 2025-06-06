<?php

namespace App\Http\Controllers\Admin;

use App\Models\Estate;
use App\Models\Area;
use App\Models\Customer;
use App\Models\GalleryImage;
use App\Http\Requests\StoreEstateRequest;
use App\Http\Requests\UpdateEstateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $estates = DB::table('estates')
        ->join('customers', 'customers.id', '=', 'estates.customer_id')
        ->join('areas', 'areas.id', '=', 'estates.area_id')
        ->select('estates.id', 'estates.cover_image', 'areas.area', DB::raw("CONCAT(customers.name, ' ', customers.surname) as customerName"), 'estates.name as estateName', 'estates.type', 'estates.price', 'estates.mq', 'estates.address' )
        ->get();
        // dd($estates);
        return Inertia::render('estates/Index', [
            'estates' => $estates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $areas = Area::all();
        $customers = Customer::all();
        return Inertia::render('estates/Create', [ 'areas' => $areas, 'customers' => $customers ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstateRequest $request)
    {
        $form_data = $request->validated();
        
        $all_data = $request->all();
        
        if($request->hasFile('cover_image')){
            $path = Storage::disk('public')->put('estates_cover', $all_data['cover_image']);
            $form_data['cover_image'] = $path; 
        }

        $estate = new Estate();
        $all_data['parking_space'] == null ? $form_data['parking_space'] = false : $form_data['parking_space'] = true;
        $all_data['balcony'] == null ? $form_data['balcony'] = false : $form_data['balcony'] = true;
        $all_data['garden'] == null ? $form_data['garden'] = false : $form_data['garden'] = true;
        $all_data['elevator'] == null ? $form_data['elevator'] = false : $form_data['elevator'] = true;
        $form_data['area_id'] = $all_data['area_id'];
        $form_data['customer_id'] = $all_data['customer_id'];

        $estate->fill($form_data);
        $estate->save();

        if($request->has('gallery')){
            $images = $all_data['gallery'];

            foreach($images as $image){
                $path = Storage::disk('public')->put('estate_gallery_image', $image);

                $data_image['estate_id'] = $estate->id;
                $data_image['path'] = $path;

                $galleryImage = new GalleryImage();
                $galleryImage->fill($data_image);
                $galleryImage->save();
            }
        }

        return redirect()->route('admin.estates.index')->with('message', 'Immobile aggiunto correttamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Estate $estate)
    {   
        $estate_id = $estate->id;
        $estate = DB::table('estates')
        ->join('customers', 'customers.id', '=', 'estates.customer_id')
        ->join('areas', 'areas.id', '=', 'estates.area_id')
        ->select('estates.id', 'estates.cover_image', 'areas.area', DB::raw("CONCAT(customers.name, ' ', customers.surname) as customerName"), 'estates.name as estateName', 'estates.type', 'estates.price', 'estates.mq', 'estates.address', 'estates.city', 'estates.number_rooms', 'estates.number_bathrooms', 'estates.garden', 'estates.elevator', 'estates.parking_space', 'estates.balcony', 'estates.energetic_efficency', 'estates.description',  
        DB::raw("(SELECT GROUP_CONCAT(gallery_images.path) 
                  FROM gallery_images 
                  WHERE gallery_images.estate_id = estates.id) as galleryImages") 
        )
        ->where('estates.id', $estate_id)
        ->get();
        return Inertia::render('estates/Show', ['estate' => $estate[0]]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estate $estate)
    {   
        $areas = Area::all();
        $customers = Customer::all();
        $estate_id = $estate->id;
        $estate = DB::table('estates')
        ->join('customers', 'customers.id', '=', 'estates.customer_id')
        ->join('areas', 'areas.id', '=', 'estates.area_id')
        ->select('estates.id', 'estates.cover_image', 'estates.area_id', 'areas.area', DB::raw("CONCAT(customers.name, ' ', customers.surname) as customerName"), 'estates.name as estateName', 'estates.type', 'estates.sale_type', 'estates.price', 'estates.mq', 'estates.address', 'estates.city', 'estates.number_rooms', 'estates.number_bathrooms', 'estates.garden', 'estates.elevator', 'estates.parking_space', 'estates.balcony', 'estates.energetic_efficency', 'estates.description', 'estates.customer_id',  
        DB::raw("(SELECT GROUP_CONCAT(gallery_images.path) 
                  FROM gallery_images 
                  WHERE gallery_images.estate_id = estates.id) as galleryImages") 
        )
        ->where('estates.id', $estate_id)
        ->get();
        return Inertia::render('estates/Edit', ['estate' => $estate[0], 'areas' => $areas, 'customers' => $customers]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstateRequest $request, Estate $estate)
    {
       
        $form_data = $request->validated();
        $all_data = $request->all();
        
        if($request->hasFile('cover_image')){
            $path = Storage::disk('public')->put('estates_cover', $all_data['cover_image']);
            $form_data['cover_image'] = $path; 
        }

        

        $all_data['parking_space'] == null ? $form_data['parking_space'] = false : $form_data['parking_space'] = true;
        $all_data['balcony'] == null ? $form_data['balcony'] = false : $form_data['balcony'] = true;
        $all_data['garden'] == null ? $form_data['garden'] = false : $form_data['garden'] = true;
        $all_data['elevator'] == null ? $form_data['elevator'] = false : $form_data['elevator'] = true;
        $form_data['area_id'] = $all_data['area_id'];
        $form_data['customer_id'] = $all_data['customer_id'];

        $estate->update($form_data);
        

        if($request->has('new_gallery')){
            $images = $all_data['new_gallery'];

            foreach($images as $image){
                $path = Storage::disk('public')->put('estate_gallery_image', $image);

                $data_image['estate_id'] = $estate->id;
                $data_image['path'] = $path;

                $galleryImage = new GalleryImage();
                $galleryImage->fill($data_image);
                $galleryImage->save();
            }
        }

        return redirect()->route('admin.estates.index')->with('message', 'Immobile aggiunto correttamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estate $estate)
    {   
        if($estate->cover_image != null){
            Storage::disk('public')->delete($estate->cover_image);
        }
        
        foreach($estate->gallery_images as $image){
            Storage::disk('public')->delete($image->path);
        }

        $estate->delete();
        return redirect()->route('admin.estates.index');
    }
}
