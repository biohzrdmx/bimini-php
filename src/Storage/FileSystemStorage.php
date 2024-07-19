<?php

declare(strict_types = 1);

/**
 * Bimini
 * Easily check and retrieve BIMI records from a host
 * @author  biohzrdmx <github.com/biohzrdmx>
 * @license MIT
 */

namespace Bimini\Storage;

use Bimini\BimiRecord;

class FileSystemStorage implements StorageInterface {

    /**
     * Storage directory
     */
    protected string $path;

    /**
     * Storage TTL
     */
    protected int $ttl;

    /**
     * Constructor
     * @param string $path Storage directory
     * @param int    $ttl  Storage TTL
     */
    public function __construct(string $path, int $ttl = 172800) {
        $this->path = $path;
        $this->ttl = $ttl;
    }

    /**
     * @inheritdoc
     */
    public function hasRecord(string $host): bool {
        $cached = implode(DIRECTORY_SEPARATOR, [$this->path, md5($host)]);
        if ( file_exists($cached) && time() - filemtime($cached) < $this->ttl ) {
            return true; // @codeCoverageIgnore
        } else {
            return dns_check_record("default._bimi.{$host}", 'TXT');
        }
    }

    /**
     * @inheritdoc
     */
    public function getRecord(string $host): ?BimiRecord {
        $cached = implode(DIRECTORY_SEPARATOR, [$this->path, md5($host)]);
        $record = null;
        if ( file_exists($cached) && time() - filemtime($cached) < $this->ttl ) {
            $data = file_get_contents($cached);
            $record = $data ? json_decode($data, true) : null;
            if ($record) {
                return BimiRecord::fromArray($record);
            }
        } else {
            $records = dns_get_record("default._bimi.{$host}", DNS_TXT);
            if ($records) {
                $record = array_shift($records);
                if ($record) {
                    return BimiRecord::fromTxtRecord($record);
                }
            }
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function saveRecord(string $host, BimiRecord $record): void {
        $cached = implode(DIRECTORY_SEPARATOR, [$this->path, md5($host)]);
        file_put_contents($cached, json_encode($record));
    }
}
