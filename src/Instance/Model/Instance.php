<?php

declare(strict_types=1);

namespace Bima\Instance\Model;

use Bima\Environment\Relation\BelongsToEnvironment;
use Pandawa\Component\Eloquent\Model;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class Instance extends Model
{
    use BelongsToEnvironment;

    public static function generateSecret(): string
    {
        return substr(base64_encode(sha1(uniqid())), 0, 32);
    }
}

