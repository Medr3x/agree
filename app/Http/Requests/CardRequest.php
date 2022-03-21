<?php


namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use App\Models\Card;
use App\Rules\Base64;
class CardRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Card::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Card::class);
        $rules = parent::rules();

        if ($this->isStore() || $this->isUpdate()) {
            $rules = array_merge($rules, [
                'atk'  => 'nullable|digits_between:1,4',
                'def' => 'nullable|digits_between:1,4',
                'qty_star' => 'nullable|digits_between:1,2|max:12',
            ]);
        }
        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => [
                    'required',
                    'max:50',
                    'regex:/^[A-ZÑÁÉÍÓÚÜ]([a-zA-Z\sñÑáéíóúÁÉÍÓÚüÜ])*$/' // empieza por una mayuscula y solo puede contener letras y espacios
                ],
                'first_edition' => 'required|in:0,1',
                'serial_code' => 'required|min:8',
                'category_code' => 'required|exists:categories,sku_id',
                'description' => 'required|min:3|max:180',
                'price' => 'required|numeric',
                'card_creation_date' => 'required|date',
                'sku_id' => [
                    'required',
                    'max:25',
                    Rule::unique('cards')->whereNull('deleted_at')
                ],
                'image' => ['required', new Base64]
            ]);
        }
        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
                'name' => [
                    'nullable',
                    'max:50',
                    'regex:/^[A-ZÑÁÉÍÓÚÜ]([a-zA-Z\sñÑáéíóúÁÉÍÓÚüÜ])*$/' // empieza por una mayuscula y solo puede contener letras y espacios
                ],
                'first_edition' => 'nullable|in:0,1',
                'serial_code' => 'nullable|min:8',
                'category_code' => 'nullable|exists:categories,sku_id',
                'description' => 'nullable|min:3|max:180',
                'price' => 'nullable|numeric',
                'card_creation_date' => 'nullable|date',
                'sku_id' => [
                    'nullable',
                    'max:25',
                    Rule::unique('cards')->whereNull('deleted_at')->ignore($this->model->id)
                ],
                'image' => ['nullable', new Base64]
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

            'category_code.exists' => 'El codigo de categoria enviado no es existe'
        ];
    }
}