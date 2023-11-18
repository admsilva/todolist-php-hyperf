<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;
use Ramsey\Uuid\Uuid;

class User extends Model
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
    protected ?string $table = 'users';

    /**
     * @var string
     */
    protected string $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected array $fillable = ['uuid', 'name', 'email', 'password'];

    /**
     * The attributes that are dates
     *
     * @var array|string[]
     */
    protected array $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected array $casts = ['uuid' => 'string', 'name' => 'string', 'email' => 'string', 'password' => 'string'];

    /**
     * The attributes that should be hidden
     *
     * @var array|string[]
     */
    protected array $hidden = ['password', 'deleted_at'];

    /**
     * Boot creating
     *
     * @return void
     */
    public function creating(): void
    {
        $this->{$this->getKeyName()} = Uuid::uuid4();
    }
}