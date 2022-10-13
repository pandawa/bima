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
                    'name' => 'required',
                    'url'  => 'required|url',
                ],
            ]
        ],
    ],
)]
class CreateInstance
{
    public function __construct(public readonly string $name, public readonly string $url)
    {
    }

    public function handle(): Instance
    {
        return Instance::create([
            'name'   => $this->name,
            'url'    => $this->url,
            'secret' => sha1(uniqid()),
        ]);
    }
}
