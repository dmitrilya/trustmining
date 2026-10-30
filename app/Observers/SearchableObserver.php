<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class SearchableObserver
{
    public function created(Model $model): void
    {
        if (method_exists($model, 'syncSearchable')) $model->syncSearchable(true);
    }

    public function updated(Model $model): void
    {
        if (method_exists($model, 'syncSearchable')) $model->syncSearchable();
    }

    public function deleted(Model $model): void
    {
        if (method_exists($model, 'deleteSearchable')) $model->deleteSearchable();

        if (method_exists($model, 'syncSearchableDependents')) $model->syncSearchableDependents(true);
    }
}
