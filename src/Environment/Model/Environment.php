<?php

declare(strict_types=1);

namespace Bima\Environment\Model;

use Bima\Instance\Model\Instance;
use Pandawa\Annotations\Resource\ApiResource;
use Pandawa\Component\Eloquent\Model;
use Pandawa\Component\Eloquent\Relations\HasMany;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
#[ApiResource(
    uri: 'environments',
    routeGroup: 'api',
    middleware: ['auth'],
    except: ['delete'],
    options: [
        'store' => [
            'rules' => [
                [
                    'constraints' => [
                        'name' => 'required|string',
                    ]
                ]
            ]
        ],
        'update' => [
            'rules' => [
                [
                    'constraints' => [
                        'name' => 'required|string',
                    ]
                ]
            ]
        ]
    ]
)]
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
