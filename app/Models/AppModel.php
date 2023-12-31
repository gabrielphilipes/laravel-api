<?php

namespace App\Models;

use App\Casts\TimezoneCast;
use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{
    /** @var bool */
    protected bool $useBusinessScope = false;

    /** @var bool */
    protected bool $useTimezoneCasts = false;

    protected array $timezoneCasts = [
        'created_at',
        'updated_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($this->useBusinessScope) {
            static::addGlobalScope(new Scopes\BusinessScope());
        }
    }

    public function mergeCasts($casts): AppModel|static
    {
        $this->casts = array_merge($this->casts, $casts);

        if (
            count($this->timezoneCasts) > 0 &&
            $this->useTimezoneCasts
        ) {
            $mergeTimezoneCast = [];

            foreach ($this->timezoneCasts as $timezoneCast) {
                $mergeTimezoneCast[$timezoneCast] = TimezoneCast::class;
            }

            $this->casts = array_merge($mergeTimezoneCast, $this->casts);
        }

        return $this;
    }

}
