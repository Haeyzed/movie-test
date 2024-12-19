<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListMoviesRequest extends BaseRequest
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
            /**
             * @query
             *
             * Search query to filter users by name.
             *
             * This parameter allows you to search for users whose names contain the given string.
             * The search is case-insensitive.
             */
            'search' => ['nullable', 'string', 'max:255'],

            /**
             * @query
             *
             * Number of items to return per page.
             *
             * Specify the number of users to include in each page of results.
             * @example 50
             * @default 15
             */
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
