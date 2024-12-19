<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

/**
 * SearchServiceProvider
 *
 * This service provider extends the query builder to add a 'search' method
 * that allows for easy searching across multiple columns and relationships.
 */
class SearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Builder::macro('search', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach ($attributes as $attribute) {
                    $query->orWhere(function ($query) use ($attribute, $searchTerm) {
                        if (str_contains($attribute, '.')) {
                            $relationParts = explode('.', $attribute);
                            $relation = implode('.', array_slice($relationParts, 0, -1));
                            $column = end($relationParts);
                            $query->orWhereHas($relation, function ($query) use ($column, $searchTerm) {
                                $query->where($column, 'LIKE', "%{$searchTerm}%");
                            });
                        } else {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    });
                }
            });

            return $this;
        });
    }
}
