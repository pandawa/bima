<?php

declare(strict_types=1);

namespace Bima\Instance\Command;

use Bima\Instance\Model\Instance;
use Pandawa\Annotations\Resource\ApiMessage;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
#[ApiMessage(
    uri: 'instances',
    methods: ['post'],
    routeGroup: 'api',
    middleware: ['auth'],
    options: [
        'rules' => [
            [
                'constraints' => [
                    'name'           => 'required',
                    'url'            => 'required|url',
                    'environment_id' => 'required|numeric|exists:environments,id',
                ],
            ],
        ],
    ],
)]
class CreateInstance
{
    public function __construct(
        public readonly string $name,
        public readonly string $url,
        public readonly int $environmentId,
    ) {
    }

    public function handle(): Instance
    {
        return Instance::create([
            'name'           => $this->name,
            'url'            => $this->url,
            'environment_id' => $this->environmentId,
            'secret'         => Instance::generateSecret(),
        ]);
    }
}
