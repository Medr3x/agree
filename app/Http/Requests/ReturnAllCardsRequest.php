<?php


namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use App\Models\Card;

class ReturnAllCardsRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return user()->can('return-all-cards');
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
                'cards.*' => ['required', 'exists:cards,id']
            ]);
        }
        return $rules;
    }
}