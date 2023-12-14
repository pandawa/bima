<?php

declare(strict_types=1);

namespace Bima\License;

use DateTime;
use RuntimeException;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class LicenseManager
{
    const LICENSE_CONFIG_KEY = 'license.key';

    public static function validate(): void
    {
        if (!static::isValid()) {
            throw new RuntimeException('License was not found!');
        }
    }

    public static function isValid(): bool
    {
        if (null !== $license = static::getLicense()) {
            return !static::isExpired($license);
        }

        return false;
    }

    public static function isExpired(array $license): bool
    {
        if ($expiredAt = ($license['expires_at'] ?? null)) {
            return now()->format('Y-m-d') > $expiredAt;
        }

        return true;
    }

    public static function getLicense(): ?array
    {
        if (null !== $licenseKey = config(static::LICENSE_CONFIG_KEY)) {
            try {
                if (null !== $license = static::parseLicense(decrypt($licenseKey))) {
                    return [
                        ...$license,
                        'license_key' => $licenseKey,
                    ];
                }

                return null;
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }

    protected static function parseLicense(string $key): ?array
    {
        $parts = explode('|', $key);

        if (4 !== count($parts)) {
            return null;
        }

        return [
            'name'            => $parts[0],
            'plan'            => $parts[1],
            'expires_at'      => $parts[2],
            'instance_limit'  => $parts[3],
            'expiration_date' => (new DateTime($parts[2]))->format('M d, Y'),
        ];
    }
}
