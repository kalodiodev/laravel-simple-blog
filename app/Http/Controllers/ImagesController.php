<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    /**
     * Get image
     *
     * @param $filename
     * @return mixed
     */
    public function featured($filename)
    {
        if(! Storage::disk('local')->has('images/featured/' . $filename))
        {
            abort(404);
        }

        $file = Storage::get('images/featured/' . $filename);

        return Response::make($file)->header('Content-Type', 'image/jpg');
    }
}
