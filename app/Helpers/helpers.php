<?php

/*
|--------------------------------------------------------------------------
| Global helpers
|--------------------------------------------------------------------------
|
| The ijinnakes code base calls the following global functions:
| crypto(), formatPhoneNumber(), removeSpecialChars() and sendReply().
| Their original definitions were not part of the shipped source tree, so
| they are re-implemented here with equivalent behaviour:
|
|  - crypto()             symmetric AES-256-CBC encrypt/decrypt bound to APP_KEY
|  - formatPhoneNumber()  normalises Indonesian numbers to the 62… format
|  - removeSpecialChars() strips everything except [A-Za-z0-9] (URL safe)
|  - sendReply()          posts a WhatsApp message to the configured gateway
|
| Each function is guarded with function_exists() so an application level
| override can still take precedence.
|
*/

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

if (! function_exists('crypto')) {
    /**
     * Encrypt or decrypt a string using the application key.
     *
     * @param  string|null  $value
     * @param  string  $action  Either "encrypt" or "decrypt".
     */
    function crypto($value, string $action = 'encrypt'): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $key = hash('sha256', (string) config('app.key'), true);
        $cipher = 'AES-256-CBC';
        $ivLength = openssl_cipher_iv_length($cipher);

        if ($action === 'encrypt') {
            $iv = random_bytes($ivLength);
            $encrypted = openssl_encrypt((string) $value, $cipher, $key, OPENSSL_RAW_DATA, $iv);

            if ($encrypted === false) {
                return null;
            }

            return base64_encode($iv.$encrypted);
        }

        $payload = base64_decode((string) $value, true);

        if ($payload === false || strlen($payload) <= $ivLength) {
            return null;
        }

        $iv = substr($payload, 0, $ivLength);
        $encrypted = substr($payload, $ivLength);

        $decrypted = openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        return $decrypted === false ? null : $decrypted;
    }
}

if (! function_exists('formatPhoneNumber')) {
    /**
     * Normalise an Indonesian phone number to the 62xxxxxxxxxx format.
     */
    function formatPhoneNumber(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }

        $phone = preg_replace('/[^0-9+]/', '', $phone);

        if ($phone === '' || $phone === null) {
            return '';
        }

        if (str_starts_with($phone, '+')) {
            $phone = substr($phone, 1);
        }

        if (str_starts_with($phone, '0')) {
            return '62'.substr($phone, 1);
        }

        if (str_starts_with($phone, '8')) {
            return '62'.$phone;
        }

        return $phone;
    }
}

if (! function_exists('removeSpecialChars')) {
    /**
     * Strip every character that is not a letter or a digit.
     */
    function removeSpecialChars(?string $value): string
    {
        return preg_replace('/[^A-Za-z0-9]/', '', (string) $value) ?? '';
    }
}

if (! function_exists('sendReply')) {
    /**
     * Send a WhatsApp message through the configured gateway.
     *
     * @return bool True when the gateway acknowledged the message.
     */
    function sendReply(?string $phone, ?string $message): bool
    {
        $endpoint = config('app.wa2_host') ?: config('app.wa_host');

        if (empty($endpoint) || empty($phone)) {
            Log::warning('sendReply() skipped: gateway or phone number missing.', [
                'phone' => $phone,
            ]);

            return false;
        }

        try {
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->post($endpoint, [
                    'phone' => formatPhoneNumber($phone),
                    'message' => $message,
                ]);

            if (! $response->successful()) {
                Log::warning('sendReply() gateway responded with an error.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('sendReply() failed: '.$e->getMessage(), ['phone' => $phone]);

            return false;
        }
    }
}