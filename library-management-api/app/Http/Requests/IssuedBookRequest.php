<?php

namespace App\Http\Requests;

use App\Enums\book\DurationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IssuedBookRequest extends FormRequest
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
            'member_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'issued_at' => 'required|date',
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $book = \App\Models\Book::find($this->book_id);

                    if (!$book) {
                        return $fail('The selected book does not exist.');
                    }

                    if ($value > $book->quantity) {
                        return $fail("The quantity must not exceed the available stock ({$book->quantity}).");
                    }
                },
            ],
            'duration' => 'required|numeric|min:1',
            'duration_type' => ['required', Rule::enum(DurationType::class)]
        ];
    }
}
