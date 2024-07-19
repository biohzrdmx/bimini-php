<?php

declare(strict_types = 1);

/**
 * Bimini
 * Easily check and retrieve BIMI records from a host
 * @author  biohzrdmx <github.com/biohzrdmx>
 * @license MIT
 */

namespace Bimini;

use JsonSerializable;
use RuntimeException;
use InvalidArgumentException;

class BimiRecord implements JsonSerializable {

    /**
     * BIMI version
     */
    protected string $version = '';

    /**
     * Logo URL
     */
    protected string $logo = '';

    /**
     * Certificate URL
     */
    protected string $certificate = '';

    /**
     * Constructor
     * @param string $version     BIMI version
     * @param string $logo        Logo URL
     * @param string $certificate Certificate URL
     */
    public function __construct(string $version, string $logo, string $certificate) {
        $this->version = $version;
        $this->logo = $logo;
        $this->certificate = $certificate;
    }

    /**
     * Create a BimiRecord instance from a TXT record
     * @param  array  $record Array with TXT record
     */
    public static function fromTxtRecord(array $record): BimiRecord {
        if (! isset( $record['txt'] ) ) {
            throw new InvalidArgumentException('$record must be a valid TXT record');
        }
        $parts = explode(';', $record['txt']);
        $parts = array_map('trim', $parts);
        $version = '';
        $logo = '';
        $certificate = '';
        foreach ($parts as $part) {
            $parts = explode('=', $part);
            if ( count($parts) == 2 ) {
                switch ( $parts[0] ) {
                    case 'v':
                        $version = $parts[1];
                    break;
                    case 'l':
                        $logo = $parts[1];
                    break;
                    case 'a':
                        $certificate = $parts[1];
                    break;
                }
            }
        }
        if ($version) {
            return new BimiRecord($version, $logo, $certificate);
        } else {
            throw new RuntimeException('Invalid BIMI record'); // @codeCoverageIgnore
        }
    }

    public static function fromArray(array $array): BimiRecord {
        $version = $array['version'] ?? '';
        $logo = $array['logo'] ?? '';
        $certificate = $array['certificate'] ?? '';
        if ($version) {
            return new BimiRecord($version, $logo, $certificate);
        } else {
            throw new InvalidArgumentException('Invalid BIMI record'); // @codeCoverageIgnore
        }
    }

    /**
     * Check if record has version
     */
    public function hasVersion(): bool {
        return !!$this->version;
    }

    /**
     * Check if record has logo
     */
    public function hasLogo(): bool {
        return !!$this->logo;
    }

    /**
     * Check if record has certificate
     */
    public function hasCertificate(): bool {
        return !!$this->certificate;
    }

    /**
     * Get version from record
     */
    public function getVersion(): string {
        return $this->version;
    }

    /**
     * Get logo URL from record
     */
    public function getLogo(): string {
        return $this->logo;
    }

    /**
     * Get certificate URL from record
     */
    public function getCertificate(): string {
        return $this->certificate;
    }

    /**
     * @inheritdoc
     */
     public function jsonSerialize(): mixed {
        return [
            'version' => $this->version,
            'logo' => $this->logo,
            'certificate' => $this->certificate,
        ];
     }
}
