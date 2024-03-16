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

namespace App\Resource;

use Carbon\Carbon;
use Hyperf\Resource\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        $startAt = Carbon::create($this->start_at)->format('d/m/Y H:i:s');
        $endAt = Carbon::create($this->end_at)->format('d/m/Y H:i:s');
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'priority' => $this->priority,
        ];
    }
}
