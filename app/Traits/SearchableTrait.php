<?php

namespace App\Traits;

use Spatie\Searchable\Search;

trait SearchableTrait
{
    public function performSearch($model, array $fields, $query)
    {
        $searchResults = (new Search())
            ->registerModel($model, $fields)
            ->perform($query);

        // Convert to a standard Laravel collection and format the results
        return collect($searchResults)->map(function ($result) {
            return $this->formatSpecificFields($result);
    });
    }

    private function formatSpecificFields($result)
    {
        if ($result->searchable) {
            $searchable = $result->searchable;
            return [
                'id' => $searchable->id,
                'first_name' => $searchable->first_name,
                'last_name' => $searchable->last_name,
                'email' => $searchable->email,
                'role' => $searchable->getRoleNames()->first(),
            ];
        }

        return [];
    }
}
