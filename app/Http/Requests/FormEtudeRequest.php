<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FormEtudeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'title'=>['required','string', 'min:4',Rule::unique('etudes')->ignore($this->route()->parameter('etude'))],
            'slug'=> ['required', 'min:4','regex:/[a-z0-9\-]+$/',Rule::unique('etudes')->ignore($this->route()->parameter('etude'))],
            'resume'=>['required'],
            'longtitle'=>['required'],
            'active'=>['required'],
            'reglementaire'=>['required'],
            'startyear'=>['required'],
            'stopyear' => ['nullable', 'integer'],
            'frequence'=> ['nullable'],
            'sources'=>['array','exists:sources,id','required'],
            'themes'=>['array','exists:themes,id','required']

        ];
    }
    protected function prepareForValidation() {
        $data = $this->all();

        if (isset($data['active']) && $data['active'] == true) {
            $data['stopyear'] = now()->year;
        }

        $this->merge([
            'slug'=> $this->input('slug') ?: Str::slug($this->input('title')),
            'stopyear' => $data['stopyear'] ?? $this->input('stopyear'),
        ]);
    }
}
