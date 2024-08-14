<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Caravan;

class Images extends Model
{
    use HasFactory;
    public $fillable = [
        'path',
        'imageable_id',
        'imageable_type'
    ];
    public function imageable()
    {
        return $this->morphTo();
    }

    public static function scopeStoreImages(Builder $query, $request, $id, $mode = "")
    {
        $allowed =  ['png', 'jpg', 'jpeg' ];
        $imagesNames = [];

        foreach($request->images as $image) {
            $image_64 = $image['data_url'];



            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            if(in_array($extension, $allowed)) {

                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
                // find substring fro replace here eg: data:image/png;base64,
                $image_64 = str_replace($replace, '', $image_64);
                $image_64 = str_replace(' ', '+', $image_64);

                $imageName = Str::random(10).'.'.$extension;
                // save file to disk
                Storage::disk('images')->put($imageName, base64_decode($image_64));

                $imagesNames[] = $imageName;
                if($mode == 'update') {
                    if(isset($image['id'])) {
                        Images::find($image['id'])->update([
                            'path' =>  $imageName,
                        ]);
                    } else {
                        Caravan::find($id)->images()->create([
                            'path' =>  $imageName,
                        ]);
                    }

                } else {
                    Caravan::find($id)->images()->create([
                        'path' =>  $imageName,
                    ]);
                }


                return $imagesNames;

            }
        }
    }
}
