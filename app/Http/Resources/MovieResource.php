<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * The name of the movie.
             *
             * @var string $name
             * @example "Transformer"
             */
            'name' => $this->name,

            /**
             * The description of the movie.
             *
             * @var string $description
             * @example "A movie about robots that transform into vehicles."
             */
            'description' => $this->description,

            /**
             * The release date of the movie.
             *
             * @var string $release_date
             * @example "2024-12-19"
             */
            'release_date' => $this->release_date,

            /**
             * The rating of the movie.
             *
             * @var int $rating
             * @example 4
             */
            'rating' => $this->rating,

            /**
             * The ticket price of the movie.
             *
             * @var float $ticket_price
             * @example 15.99
             */
            'ticket_price' => $this->ticket_price,

            /**
             * The country of origin of the movie.
             *
             * @var string $country
             * @example "United States"
             */
            'country' => $this->country,

            /**
             * The genre of the movie.
             *
             * @var string|array $genre
             * @example "Action, Sci-Fi"
             */
            'genre' => $this->genre,

            /**
             * The photo URL of the movie poster.
             *
             * @var string $photo
             * @example ["https://example.com/poster.jpg"]
             */
            'photo' => $this->getPhotoUrlsAttribute(),
        ];
    }
}
