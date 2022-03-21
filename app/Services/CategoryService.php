<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\Category;

class CategoryService extends BaseService
{
    protected $excludedRequestParams = ['parent_code'];
    /**
     * @param $request
     * @param $modelClass
     * @param array $additionalData
     * @return mixed
     */
    public function store($request, $modelClass, $additionalData = [])
    {
        $additionalData['created_by'] = user()->id;
        $additionalData['parent_id'] = Category::where('sku_id','=',$request['parent_code'])->first()->id;
        $data = array_merge($this->getRequestData($request), $additionalData);
        $this->model = $modelClass::query()->create($data);
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
        $additionalData['parent_id'] = Category::where('sku_id','=',$request['parent_code'])->first()->id;
        $data = array_merge($this->getRequestData($request), $additionalData);
        $model->update($data);
        $this->model = $model;
        return $this->model;
    }
}