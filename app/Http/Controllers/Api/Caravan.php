<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Caravan as CaravanModel;
use App\Models\Booking;
use App\Models\Images;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Util\HttpResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Caravan extends Controller
{
    //
    use HttpResponse;

    public function index()
    {
        return CaravanModel::all();
    }

    public function addCaravan(Request $request)
    {

        try {
            $imagesNames = [];

            $validatedData = $request->validate([
                'location' => 'required|max:55',
                'size' => 'required',
                'price' => 'required',
            ]);
            $created =   CaravanModel::create(
                [
                      'location' => $request->location,
                      'size' => $request->size,
                      'price' => $request->price,
                  ]
            );
            if(count($request->images) > 0) {
                $imagesNames = Images::storeImages($request, $created->id); // store images scope
            }
            return $this->successResponse('Caravan added successfully', $imagesNames, 200);

        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }


    }

    public function show($id)
    {
        try {

            $images = [];

            $caravan = CaravanModel::find($id);
            if($caravan->images->count()  > 0) {

                foreach($caravan->images as $image) {
                    $ext =    explode('.', $image->path)[1];
                    $images[] = ['image' =>
                     Storage::disk('images')->exists($image->path) ?
                    'data:image/'.$ext.';base64,' . base64_encode(Storage::disk('images')->get($image->path)) : '',
                    'id' => $image->id,'ext' => $ext];
                }
            }
            $caravansAndImages =  [
                'caravan' => $caravan,
                'images' => $images];
            return $this->successResponse('Caravan details', $caravansAndImages, 200);

        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $caravan = CaravanModel::find($id);
            $caravan->location = $request->location;
            $caravan->size = $request->size;
            $caravan->price = $request->price;
            $caravan->save();
            $ids = [];
            if(count($request->images) > 0) {
                $ids = Images::storeImages($request, $id, 'update'); // store images scope
            }
            return $this->successResponse('Caravan updated successfully', $ids, 200);


        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }


    }

    public function destroy($id)
    {
        try {
            $caravan = CaravanModel::find($id)->delete();

            return $this->successResponse('Caravan deleted successfully', $caravan, 200);

        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

    }


}
