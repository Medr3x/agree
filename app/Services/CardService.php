<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\Card;
use App\Models\Category;
use App\Models\User;
use App\Models\UserCard;
use App\Events\DeletedMedia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CardService extends BaseService
{
    protected $excludedRequestParams = ['category_code','image'];
    /**
     * @param $request
     * @param $modelClass
     * @param array $additionalData
     * @return mixed
     */
    public function store($request, $modelClass, $additionalData = [])
    {
        $additionalData['created_by'] = user()->id;
        $additionalData['category_id'] = Category::where('sku_id','=',$request['category_code'])->first()->id;
        $data = array_merge($this->getRequestData($request), $additionalData);
        $this->model = $modelClass::query()->create($data);
        $this->saveImage($request);
        return $this->model;
    }
    /**
     * @param $request
     * @param $model
     * @param array $additionalData
     * @return mixed
     */
    public function update($request, $model, $additionalData = [])
    {
        $additionalData['updated_by'] = user()->id;
        $additionalData['category_id'] = Category::where('sku_id','=',$request['category_code'])->first()->id;
        $data = array_merge($this->getRequestData($request), $additionalData);
        $model->update($data);
        $this->model = $model;
        $this->saveImage($request);
        return $this->model;
    }

    /**
     * @param $request
     * @param $model
     */
    public function destroy($request, $model)
    {
        if ( !empty($model->image) ){
            Storage::delete('public/'.$model->image);
        }
        $model->update(['updated_by' => user()->id]);
        $model->delete();
    }

    protected function saveImage($request){

        if(isset($request['image']) && !empty($request['image'])){

            if ( !empty($this->model->image) ){
                Storage::delete('public/'.$this->model->image);
            }

            $image_64 = $request['image'];

            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
           
            $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
             
            $image = str_replace($replace, '', $image_64); 
          
            $image = str_replace(' ', '+', $image); 
        
            $imageName = Str::slug(date('YmdHis')).'.'.$extension;

            Storage::disk('public')->put($this->model->file_folder.'/'.$imageName, base64_decode($image));

            $this->model->update(['image'=> $this->model->file_folder.'/'.$imageName]);
        }
    }

    /**
     * @param $request
     * @param $model
     */
    public function assignCard($request)
    {
        user()->cards()->attach($request->card);
        return Card::find($request->card);
    }
    /**
     * @param $request
     * @param $model
     */
    public function returnCard($request)
    {
        user()->cards()->detach($request->card);
        return Card::find($request->card);
    }
    
    /**
     * @param $request
     * @param $model
     */
    public function returnAllCards()
    {
        user()->cards()->sync([]);
    }
}