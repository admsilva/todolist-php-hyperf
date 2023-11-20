<?php

declare(strict_types=1);

namespace App\Model;

use App\Scopes\FilterByUserAuth;
use Hyperf\Database\Model\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Task extends Model
{
    use SoftDeletes;

    /**
     * The attributes that enabled or disabled auto incrementing
     *
     * @var bool
     */
    public bool $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected ?string $table = 'tasks';

    /**
     * @var string
     */
    protected string $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected array $fillable = ['uuid', 'title', 'description', 'start_at', 'end_at', 'priority', 'user_uuid'];

    /**
     * The attributes that are dates
     *
     * @var array|string[]
     */
    protected array $dates = ['created_at', 'updated_at', 'deleted_at', 'start_at', 'end_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
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
     * The attributes that should be hidden
     *
     * @var array|string[]
     */
    protected array $hidden = ['deleted_at'];

    /**
     * Boot creating
     *
     * @return void
     */
    public function creating(): void
    {
        $this->{$this->getKeyName()} = Uuid::uuid4();
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        static::addGlobalScope(new FilterByUserAuth());
    }
}