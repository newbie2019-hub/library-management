<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'author_id' => 'required|exists:authors,id',
            'isbn_no' => 'required|string|unique:books,isbn_no'.$this->id,
            'title' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'quantity' => 'required|integer',
            'price' => 'nullable|integer',
            'pages' => 'nullable|integer',
            'edition' => 'nullable|string',
            'publisher' => 'nullable|string',
            'series' => 'nullable|string',
            'cover_photo' => 'nullable|string',
            'published_at' => 'nullable|date',
            'purchased_at' => 'nullable|date'
        ];
    }
}
