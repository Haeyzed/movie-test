<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListMoviesRequest;
use App\Http\Requests\MovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

/**
 * Class MovieController
 *
 * Handles operations related to movies, including creating, updating, and retrieving movies with multiple photos.
 *
 * @package App\Http\Controllers
 */
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ListMoviesRequest $request The request object containing search and pagination parameters.
     * @return MovieResource|JsonResponse A paginated list of movies.
     */
    public function index(ListMoviesRequest $request): MovieResource|JsonResponse
    {
        $movies = Movie::query()
            ->when($request->input('search'), function ($query) use ($request) {
                $query->search(['name', 'rating'], $request->search);
            })
            ->paginate($request->integer('per_page', config('app.pagination.per_page')));

        return response()->paginatedSuccess($movies, 'Movies retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * Handles multiple photo uploads for a movie.
     *
     * @param MovieRequest $request The request object with validated data.
     * @return MovieResource|JsonResponse The created movie resource.
     */
    public function store(MovieRequest $request): MovieResource|JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photos')) {
            $data['photo'] = $this->uploadPhotos($request->file('photos'));
        }

        $movie = Movie::query()->create($data);

        return response()->created($movie, 'Movie created successfully');
    }

    /**
     * Display the specified resource.
     *
     * Retrieves a single movie along with its associated photos.
     *
     * @param Movie $movie The movie instance to retrieve.
     * @return MovieResource|JsonResponse The retrieved movie resource.
     */
    public function show(Movie $movie): MovieResource|JsonResponse
    {
        return response()->success(new MovieResource($movie), 'Movie retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * Handles multiple photo uploads for a movie.
     *
     * @param MovieRequest $request The request object with validated data.
     * @param Movie $movie The movie instance to update.
     * @return MovieResource|JsonResponse The updated movie resource.
     */
    public function update(MovieRequest $request, Movie $movie): MovieResource|JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photos')) {
            // Delete the old photos if they exist
            if ($movie->photo) {
                foreach ($movie->photo as $photo) {
                    Storage::delete($photo);
                }
            }
            $data['photo'] = $this->uploadPhotos($request->file('photos'));
        }

        $movie->update($data);

        return response()->success($movie, 'Movie updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Movie $movie The movie instance to delete.
     * @return JsonResponse Confirmation of deletion.
     */
    public function destroy(Movie $movie): JsonResponse
    {
        if ($movie->photo) {
            foreach ($movie->photo as $photo) {
                Storage::delete($photo);
            }
        }
        $movie->delete();

        return response()->success($movie, 'Movie deleted successfully');
    }

    /**
     * Upload multiple photos to storage.
     *
     * @param array<\Illuminate\Http\UploadedFile> $photos An array of uploaded photo files.
     * @return array<string> An array of paths for the stored photos.
     */
    private function uploadPhotos(array $photos): array
    {
        return array_map(fn($photo) => $photo->store('movies/photos', 'public'), $photos);
    }
}
