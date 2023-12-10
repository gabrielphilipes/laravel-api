<?php

namespace App\Casts;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TimezoneCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $this->setTimezone($value, false);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $this->setTimezone($value, true);
    }

    /**
     * Set the timezone of a given value.
     *
     * @param mixed $value The value to set the timezone for.
     * @param bool $isSet Whether the value is being set or retrieved.
     * @return mixed  The value with the timezone set.
     */
    private function setTimezone(mixed $value, bool $isSet): mixed
    {
        /** @var User|null $user */
        $user = auth()->user();

        if (empty($user)) {
            return $value;
        }

        /**
         * Represents the user's timezone.
         *
         * @var string $userTz The user's timezone in the format of "Continent/City".
         *                     Consult https://www.php.net/manual/en/timezones.php
         */
        $userTz = $user->tz ?? config('app.timezone');
        $appTz  = config('app.timezone');

        if ($isSet) {
            return Carbon::parse($value, $appTz)->timezone($userTz);
        }

        return Carbon::parse($value, $userTz)->timezone($appTz);

    }
}
