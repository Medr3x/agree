<?php


namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use App\Models\Category;

class CategoryRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Category::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Category::class);

        $rules = parent::rules();
        if ($this->isStore() || $this->isUpdate()) {
            $rules = array_merge($rules, [
                'parent_code' => 'nullable|exists:categories,sku_id'
            ]);
        }
        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => [
                    'required',
                    'max:50',
                    'regex:/^[A-ZÑÁÉÍÓÚÜ]([a-zA-Z\sñÑáéíóúÁÉÍÓÚüÜ])*$/' // empieza por una mayuscula y solo puede contener letras y espacios
                ],
                'sku_id' => [
                    'required',
                    'max:25',
                    'alpha_num', // solo puede contener letras, espacios y numeros
                    Rule::unique('categories')->whereNull('deleted_at')
                ]
            ]);
        }
        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
                'name' => [
                    'nullable',
                    'max:50',
                    'regex:/^[A-ZÑÁÉÍÓÚÜ]([a-zA-Z\sñÑáéíóúÁÉÍÓÚüÜ])*$/' // empieza por una mayuscula y solo puede contener letras y espacios
                ],
                'sku_id' => [
                    'nullable',
                    'max:25',
                    'alpha_num', // solo puede contener letras y numeros
                    Rule::unique('categories')->whereNull('deleted_at')->ignore($this->model->id)
                ]
            ]);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'sku_id.required' => 'Debe ingresar un codigo',
            'sku_id.max' => 'El codigo ingresado es demasiado largo',
            'sku_id.alpha_num' => 'El codigo ingresado solo puede contener Letras y Numeros',       
            'sku_id.unique' => 'El codigo ingresado ya existe',

            'name.required' => 'Debe ingresar un Nombre',
            'name.max' => 'El Nombre ingresado es demasiado largo',
            'name.regex' => 'El Nombre ingresado debe empezar con una Mayuscula y solo puede contener Letras y Espacios',       

            'parent_code.exists' => 'El codigo enviado no es existe'
        ];
    }
}