<?php

namespace App\Http\Controllers\Api;

use App\Models\Estate;
use App\Models\GalleryImage;
use App\Http\Requests\StoreEstateRequest;
use App\Http\Requests\UpdateEstateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EstateController extends Controller
{
    
    public function destroy_gallery_image(Request $request)
    {   
        $image = $request->all()['image'];

        $gallery_image = GalleryImage::where('path', $image)->first();
        
        $gallery_image->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    
}
