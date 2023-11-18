<?php

declare(strict_types=1);

namespace Bima\Environment\Model;

use Bima\Instance\Model\Instance;
use Pandawa\Component\Eloquent\Model;
use Pandawa\Component\Eloquent\Relations\HasMany;


class Environment extends Model
{
    protected $appends = ['instances_count'];

    public function instances(): HasMany
    {
        return $this->hasMany(Instance::class, 'environment_id');
    }

    public function getInstancesCountAttribute(): int
    {
        return $this->instances()->count();
    }
}
