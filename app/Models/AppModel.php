<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{
    // TODO: Implement casting for all models: created_at, updated_at, deleted_at

    /** @var bool */
    protected bool $useBusinessScope = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($this->useBusinessScope) {
            static::addGlobalScope(new Scopes\BusinessScope());
        }
    }

}
