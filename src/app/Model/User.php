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

use Hyperf\Database\Model\SoftDeletes;
use Ramsey\Uuid\Uuid;

class User extends Model
{
    use SoftDeletes;

    /**
     * The attributes that enabled or disabled auto incrementing.
     */
    public bool $incrementing = false;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'users';

    protected string $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['uuid', 'name', 'email', 'profile', 'password'];

    /**
     * The attributes that are dates.
     *
     * @var array|string[]
     */
    protected array $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [
        'uuid' => 'string',
        'name' => 'string',
        'email' => 'string',
        'profile' => 'string',
        'password' => 'string',
    ];

    /**
     * The attributes that should be hidden.
     *
     * @var array|string[]
     */
    protected array $hidden = ['password', 'deleted_at'];

    /**
     * Boot creating.
     */
    public function creating(): void
    {
        $this->{$this->getKeyName()} = Uuid::uuid4();
    }
}
