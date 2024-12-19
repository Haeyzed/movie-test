<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends BaseRequest
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
             * The name of the movie.
             *
             * This field is required and must be a string.
             *
             * @var string $name
             * @example "Inception"
             */
            'name' => ['required'],

            /**
             * The description of the movie.
             *
             * This field is required and must be a string.
             *
             * @var string $description
             * @example "A mind-bending thriller about dream infiltration."
             */
            'description' => ['required'],

            /**
             * The release date of the movie.
             *
             * This field is required and must be a valid date.
             *
             * @var string $release_date
             * @example "2024-12-19"
             */
            'release_date' => ['required'],

            /**
             * The rating of the movie.
             *
             * This field is required and must be an integer between 0 and 5.
             *
             * @var int $rating
             * @example 4
             */
            'rating' => ['required', 'integer', 'min:0', 'max:5'],

            /**
             * The ticket price for the movie.
             *
             * This field is required and must be a numeric value.
             *
             * @var float $ticket_price
             * @example 15.99
             */
            'ticket_price' => ['required'],

            /**
             * The country of origin for the movie.
             *
             * This field is required and must be a string.
             *
             * @var string $country
             * @example "United States"
             */
            'country' => ['required'],

            /**
             * The genre of the movie.
             *
             * This field is required and must be a string or array of strings.
             *
             * @var string|array $genre
             * @example "Science Fiction"
             */
            'genre' => ['required'],

            /**
             * The photo of the movie poster.
             *
             * This field is required and must be a valid file.
             *
             * @var string $photo
             * @example "poster.jpg"
             */
            'photos' => ['nullable', 'array'],
            'photos.*' => ['file', 'image', 'max:2048'],
        ];
    }
}
