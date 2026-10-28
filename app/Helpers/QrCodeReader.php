<?php

namespace App\Helpers;

use RuntimeException;

/*
|--------------------------------------------------------------------------
| QR code reader
|--------------------------------------------------------------------------
|
| ijinnakes called BaconQrCode\Decoder\Decoder::decode() directly. That class
| does not exist in bacon/bacon-qr-code v3 (the decoder was dropped), so the
| call is isolated here and resolved against whatever decoder is available at
| runtime:
|
|   1. BaconQrCode\Decoder\Decoder  (bacon/bacon-qr-code v2)
|   2. the "zbarimg" binary         (apt package zbar-tools)
|
| When neither is available a RuntimeException is thrown with an actionable
| message instead of a fatal "class not found" error.
|
*/

class QrCodeReader
{
    /**
     * Decode the first QR code found in an image file.
     */
    public static function decodeFile(string $path): ?string
    {
        if (! is_file($path)) {
            throw new RuntimeException("QR source file not found: {$path}");
        }

        if (class_exists(\BaconQrCode\Decoder\Decoder::class)) {
            $result = \BaconQrCode\Decoder\Decoder::decode(file_get_contents($path));

            return $result?->getText();
        }

        if (self::hasBinary('zbarimg')) {
            $output = shell_exec('zbarimg --quiet --raw '.escapeshellarg($path).' 2>/dev/null');
            $text = trim((string) $output);

            return $text === '' ? null : $text;
        }

        throw new RuntimeException(
            'No QR decoder available: bacon/bacon-qr-code v3 no longer ships a decoder. '.
            'Install the zbar-tools package (zbarimg) in the runtime image, or add a '.
            'dedicated QR decoding library.'
        );
    }

    protected static function hasBinary(string $binary): bool
    {
        if (! function_exists('shell_exec')) {
            return false;
        }

        return trim((string) shell_exec('command -v '.escapeshellarg($binary).' 2>/dev/null')) !== '';
    }
}