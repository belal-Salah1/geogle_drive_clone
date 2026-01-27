<?php

namespace App\Http\Requests;

use App\Models\File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ParentIdBaseRequest extends FormRequest
{
    public ?file $parent = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->parent = File::query()->where('id', $this->input('parent_id'))->first();
        if ($this->parent && ! $this->parent->isRoot() && ! $this->parent->isOwnedBy(Auth::id())) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_id' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value === null) {
                        return; // Allow null values
                    }

                    $exists = File::where('id', $value)
                        ->where('is_folder', 1)
                        ->where('created_by', Auth::id())
                        ->exists();

                    if (! $exists) {
                        $fail('The selected parent folder is invalid.');
                    }
                },
            ],
        ];
    }
}
