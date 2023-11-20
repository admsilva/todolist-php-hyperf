<?php

declare(strict_types=1);

namespace App\Resource;

use Hyperf\Resource\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * A collection key indicating whether the resource should be preserved.
     *
     * @var bool
     */
    public bool $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'profile' => $this->profile,
        ];
    }
}
