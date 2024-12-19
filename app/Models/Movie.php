<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Movie
 *
 * Represents a movie entity with support for multiple photos.
 *
 * @package App\Models
 */
class Movie extends Model
{
    /** @use HasFactory<\Database\Factories\MovieFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'release_date',
        'rating',
        'ticket_price',
        'country',
        'genre',
        'photo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'photo' => 'array',
    ];

    /**
     * Get the full URLs of the photos.
     *
     * @return array<string> An array of full URLs for the movie's photos.
     */
    public function getPhotoUrlsAttribute(): array
    {
        return array_map(fn($photo) => asset('storage/' . $photo), $this->photo ?? []);
    }
}
