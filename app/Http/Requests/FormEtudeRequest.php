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
            'title'=>['required','string', 'min:4','max:35'],
            'slug'=> ['required', 'min:4','regex:/[a-z0-9\-]+$/',Rule::unique('etudes')->ignore($this->route()->parameter('etude'))],
            'resume'=>['required'],
            'active'=>['required'],
            'reglementaire'=>['required'],
            'startyear'=>['required','integer'],
            'stopyear' => ['nullable', 'integer'],
            'frequence'=> ['nullable'],
            'sources' => 'required|array|min:1',
            'sources.*.name' => 'required|string|max:255',
            'zones'=>['array','exists:zones,id','required'],
            'themes'=>['array','exists:themes,id','required'],
            'parametres'=>['array','exists:parametres,id','nullable'],
            'matrices'=>['array','exists:matrices,id','nullable'],
            'types'=>['array','exists:types,id','required'],
            'link_name' => 'nullable|array',
            'link_url' => 'nullable|array',
            'contacts' => 'required|array|min:1',
            'contacts.*.nom' => 'required|string|max:255',
            'contacts.*.prenom' => 'required|string|max:255',
            'contacts.*.mail' => 'required|email|max:255',
            'contacts.*.diffusion_mail' => 'required|boolean',
            'image' => ['image', 'max:3840'],
            'fichiers.*' => 'nullable|mimes:pdf|max:20480',

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
