<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CountryRestriction
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();

        // Allow local development
        if (in_array($ip, ['127.0.0.1', '::1'])) {
            return $next($request);
        }

        // Cached lookup
        $cacheKey = "geo_country_{$ip}";
        $countryCode = Cache::get($cacheKey);

        if (!$countryCode) {
            $countryCode = $this->getCountryCode($ip);
            Cache::put($cacheKey, $countryCode ?? 'XX', now()->addDays(30));
        }

        // ---------------------------------
        // Country Rules
        // ---------------------------------
        if ($countryCode === 'IN' || $countryCode === 'UK' || trim($countryCode) == '') {
            return $next($request);
        }

        if ($countryCode === 'US') {
            // Allow only Google IPs in US
            if (!$this->isGoogleIp($ip)) {
                return response(
                    "<h2>Access Denied</h2><p>Only Google-based IPs are allowed from the US. Your IP: {$ip}</p>",
                    403
                )->header('Content-Type', 'text/html; charset=UTF-8');
            }
        }

        // Block everything else
        if (!in_array($countryCode, ['IN', 'UK', 'US', 'XX'])) {
            return response(
                "<h2>Access Denied</h2><p>Our services are not available in your region ({$countryCode}) – {$ip}.</p>",
                403
            )->header('Content-Type', 'text/html; charset=UTF-8');
        }

        return $next($request);
    }

    private function getCountryCode($ip): ?string
    {
        $apis = [
            "https://ipwho.is/{$ip}",
            "https://ipapi.co/{$ip}/country/"
        ];

        foreach ($apis as $api) {
            $ch = curl_init($api);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 3,
                CURLOPT_CONNECTTIMEOUT => 3,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_USERAGENT => 'CountryRestrictionMiddleware/1.0',
            ]);

            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                $data = json_decode($response, true);
                if (is_array($data) && isset($data['country_code'])) {
                    return strtoupper(trim($data['country_code']));
                }

                if (strlen(trim($response)) === 2) {
                    return strtoupper(trim($response));
                }
            }
        }

        return null;
    }

    /**
     * Check if IP belongs to Google ASN
     */
    private function isGoogleIp(string $ip): bool
    {
        $cacheKey = "asn_lookup_{$ip}";
        $asn = Cache::get($cacheKey);

        if (!$asn) {
            $ch = curl_init("https://ipwho.is/{$ip}");
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 3,
                CURLOPT_CONNECTTIMEOUT => 3,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]);
            $response = curl_exec($ch);
            curl_close($ch);

            $asn = '';
            if ($response) {
                $data = json_decode($response, true);
                $asn = strtoupper($data['connection']['asn'] ?? '');
            }

            // Cache ASN result
            Cache::put($cacheKey, $asn, now()->addDays(30));
        }

        // Google ASN typically starts with AS15169
        return str_starts_with($asn, 'AS15169');
    }
}
