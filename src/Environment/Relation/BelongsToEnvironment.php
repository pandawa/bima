<?php

declare(strict_types=1);

namespace Bima\Environment\Relation;

use Bima\Environment\Model\Environment;
use Pandawa\Component\Eloquent\Relations\BelongsTo;
use Pandawa\Component\Eloquent\Traits\HasRelationshipsTrait;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
trait BelongsToEnvironment
{
    use HasRelationshipsTrait;

    public function environment(): BelongsTo
    {
        return $this->belongsTo(Environment::class);
    }
}
