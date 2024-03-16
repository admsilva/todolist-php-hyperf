<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Model;

use App\Scopes\FilterByUserAuth;
use Hyperf\Database\Model\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Task extends Model
{
    use SoftDeletes;

    /**
     * The attributes that enabled or disabled auto incrementing.
     */
    public bool $incrementing = false;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'tasks';

    protected string $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['uuid', 'title', 'description', 'start_at', 'end_at', 'priority', 'user_uuid'];

    /**
     * The attributes that are dates.
     *
     * @var array|string[]
     */
    protected array $dates = ['created_at', 'updated_at', 'deleted_at', 'start_at', 'end_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [
        'uuid' => 'string',
        'title' => 'string',
        'description' => 'string',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'priority' => 'string',
        'user_uuid' => 'string',
    ];

    /**
     * The attributes that should be hidden.
     *
     * @var array|string[]
     */
    protected array $hidden = ['deleted_at'];

    /**
     * Boot creating.
     */
    public function creating(): void
    {
        $this->{$this->getKeyName()} = Uuid::uuid4();
    }

    public function boot(): void
    {
        parent::boot();

        static::addGlobalScope(new FilterByUserAuth());
    }
}
