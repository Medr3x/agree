<?php


namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use App\Models\Card;
use App\Rules\AssignCard;

class AssignCardRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {   
        return user()->can('assign-card');
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
                'card' => ['required', 'exists:cards,id', new AssignCard]
            ]);
        }
        return $rules;
    }
}