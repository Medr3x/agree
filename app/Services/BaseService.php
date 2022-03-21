<?php

namespace App\Services;

class BaseService
{
    protected $model;
    protected $presenter = null;
    protected $excludedRequestParams = [];

    /**
     * @param $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getRequestData($request)
    {
        return collect($request)->except($this->excludedRequestParams)->toArray();
    }

    /**
     * @param $request
     * @param $modelClass
     * @param array $additionalData
     * @return mixed
     */
    public function store($request, $modelClass, $additionalData = [])
    {
        $additionalData['created_by'] = user()->id;

        $data = array_merge($this->getRequestData($request), $additionalData);

        $this->model = $modelClass::query()->create($data);

        if (method_exists($this, 'postStore')) {
            $this->postStore($request, $additionalData);
        }

        if (method_exists($this, 'postStoreUpdate')) {
            $this->postStoreUpdate($request, $additionalData);
        }

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

        $data = array_merge($this->getRequestData($request), $additionalData);

        $model->update($data);

        $this->model = $model;

        if (method_exists($this, 'postUpdate')) {
            $this->postUpdate($request, $additionalData);
        }

        if (method_exists($this, 'postStoreUpdate')) {
            $this->postStoreUpdate($request, $additionalData);
        }

        return $this->model;
    }

    /**
     * @param $request
     * @param $model
     */
    public function destroy($request, $model)
    {
        $model->update(['updated_by' => user()->id]);
        $model->delete();
    }

    /**
     * @param null $model
     * @return mixed
     */
    public function getModelDetails($model = null)
    {
        if (!is_null($model)) {
            $this->setModel($model);
        }

        if (!is_null($this->presenter)) {
            $this->model->setPresenter($this->presenter);
        }

        if (method_exists($this->model, 'presenter')) {
            return $this->model->presenter();
        }

        return $model;
    }
}