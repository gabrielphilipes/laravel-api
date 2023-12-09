<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\{Builder, Model, Scope};
use Illuminate\Support\Facades\Auth;

class BusinessScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $userBusinessLogin = Auth::user()?->business_id ?? null;

        if (!$userBusinessLogin) {
            return;
        }

        $builder->where($builder->getModel()->getTable() . '.business_id', $userBusinessLogin);
    }
}
