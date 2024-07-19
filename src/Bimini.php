<?php

declare(strict_types = 1);

/**
 * Bimini
 * Easily check and retrieve BIMI records from a host
 * @author  biohzrdmx <github.com/biohzrdmx>
 * @license MIT
 */

namespace Bimini;

use Bimini\Storage\StorageInterface;

class Bimini {

    /**
     * StorageInterface implementation
     */
    protected StorageInterface $storage;

    /**
     * Constructor
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage) {
        $this->storage = $storage;
    }

    /**
     * Check if host has BIMI record
     * @param  string  $host  Host name
     */
    public function hasRecord(string $host): bool {
        return $this->storage->hasRecord($host);
    }

    /**
     * Get BIMI record from host
     * @param  string $host  Host name
     */
    public function getRecord(string $host): ?BimiRecord {
        $record = $this->storage->getRecord($host);
        if ($record) {
            $this->storage->saveRecord($host, $record);
            return $record;
        }
        return null;
    }
}
