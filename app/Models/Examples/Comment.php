<?php

namespace App\Models\Examples;

use App\Models\AppModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Comment extends AppModel implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    /** @var string */
    protected $table = 'example_comments';

    /** @var string */
    protected $connection = 'sqlite';

    /**
     * Convert, by default, only the `created_at` and `updated_at` fields
     * in timezone user.
     *
     * Consult `AppModel` for more information
     */
    protected bool $useTimezoneCasts = true;

    /**
     * The fillable property contains an array of attributes
     * that are mass assignable.
     *
     * These attributes can be assigned using the `fill` method
     * or by directly passing an array of values to the constructor.
     *
     * @var string[]
     */
    protected $fillable = [
        'comment',
    ];
}
