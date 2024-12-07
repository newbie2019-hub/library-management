<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookUpdateRequest extends FormRequest
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
            'author_id' => 'sometimes|required|exists:authors,id',
            'isbn_no' => [
                'required',
                Rule::unique('books', 'isbn_no')->ignore($this->book)
            ],
            'title' => 'sometimes|required|string',
            'categories' => 'sometimes|array',
            'categories.*' => 'sometimes|exists:categories,id',
            'quantity' => 'sometimes|required|integer',
            'price' => 'sometimes|nullable|integer',
            'pages' => 'sometimes|nullable|integer',
            'edition' => 'sometimes|nullable|string',
            'publisher' => 'sometimes|nullable|string',
            'series' => 'sometimes|nullable|string',
            'cover_photo' => 'sometimes|nullable|string',
            'published_at' => 'sometimes|nullable|date',
            'purchased_at' => 'sometimes|nullable|date'
        ];
    }
}
