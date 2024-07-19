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

interface StorageInterface {

    /**
     * Check if the record is in storage
     * @param  string  $host Host name
     */
    public function hasRecord(string $host): bool;

    /**
     * Retrieve record from storage
     * @param  string $host Host name
     */
    public function getRecord(string $host): ?BimiRecord;

    /**
     * Save record to storage
     * @param  string     $host   Host name
     * @param  BimiRecord $record BIMI record
     */
    public function saveRecord(string $host, BimiRecord $record): void;
}
