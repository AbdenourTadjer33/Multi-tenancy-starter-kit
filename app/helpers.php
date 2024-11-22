<?php

use Nette\Utils\Random;
use Illuminate\Support\Facades\DB;

if (!function_exists('generateUniqueSubdomain')) {
    /**
     * Generate a unique subdomain string.
     *
     * @param string $prefix       Optional prefix for the subdomain.
     * @param callable $existsFn   A callback function to check if a subdomain exists. It should accept the subdomain as a parameter and return a boolean.
     * @param int $maxAttempts     Maximum attempts to generate a unique subdomain.
     * @return string|null         The unique subdomain, or null if unable to generate.
     */
    function generateUniqueSubdomain(string $prefix = 'store', callable $existsFn = null, int $maxAttempts = 100): ?string
    {
        $attempts = 0;
        $base = $prefix ? rtrim($prefix, '-') . '-' : '';

        do {
            $subdomain = $base . Random::generate(5);
            $attempts++;
        } while ($existsFn ? $existsFn($subdomain) : DB::table('domains')->where('domain', $subdomain)->first() && $attempts < $maxAttempts);

        return $attempts < $maxAttempts ? $subdomain : null;
    }
}
