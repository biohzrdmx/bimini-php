<?php

declare(strict_types = 1);

/**
 * Bimini
 * Easily check and retrieve BIMI records from a host
 * @author  biohzrdmx <github.com/biohzrdmx>
 * @license MIT
 */

namespace Bimini\Storage {

    function dns_check_record(string $hostname, string $type = "MX"): bool {
        $record = dirname(__FILE__) . DIRECTORY_SEPARATOR . "{$hostname}.json";
        return file_exists($record);
    }

    function dns_get_record(string $hostname, int $type = DNS_ANY, array &$authoritative_name_servers = null, array &$additional_records = null, bool $raw = false ): array|false {
        $record = dirname(__FILE__) . DIRECTORY_SEPARATOR . "{$hostname}.json";
        if ( file_exists($record) ) {
            return json_decode( file_get_contents($record), true );
        }
        return false;
    }
}

namespace Bimini\Tests {

    use Exception;
    use InvalidArgumentException;

    use PHPUnit\Framework\TestCase;

    use Bimini\Bimini;
    use Bimini\BimiRecord;
    use Bimini\Storage\FileSystemStorage;

    class BimiTest extends TestCase {

        public function testCheckBimiRecord() {
            $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'output';
            $storage = new FileSystemStorage($path);
            $bimini = new Bimini($storage);
            # Try a valid one
            $ret = $bimini->hasRecord('example.com');
            $this->assertTrue($ret);
            # Now one that has not a BIMI record
            $ret = $bimini->hasRecord('example.org');
            $this->assertFalse($ret);
        }

        public function testRetrieveBimiRecord() {
            $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'output';
            $storage = new FileSystemStorage($path);
            $bimini = new Bimini($storage);
            # Try a valid one
            $record = $bimini->getRecord('example.com');
            $this->assertInstanceOf(BimiRecord::class, $record);
            $this->assertTrue($record->hasVersion());
            $this->assertTrue($record->hasLogo());
            $this->assertTrue($record->hasCertificate());
            $this->assertEquals('BIMI1', $record->getVersion());
            $this->assertEquals('https://example.com/bimi_logo.svg', $record->getLogo());
            $this->assertEquals('https://example.com/bimi_vmc.pem', $record->getCertificate());
            # Try again, this time it should be cached
            $record = $bimini->getRecord('example.com');
            $this->assertInstanceOf(BimiRecord::class, $record);
            $this->assertTrue($record->hasVersion());
            $this->assertTrue($record->hasLogo());
            $this->assertTrue($record->hasCertificate());
            $this->assertEquals('BIMI1', $record->getVersion());
            $this->assertEquals('https://example.com/bimi_logo.svg', $record->getLogo());
            $this->assertEquals('https://example.com/bimi_vmc.pem', $record->getCertificate());
            # Now one that has not a BIMI record
            $record = $bimini->getRecord('example.org');
            $this->assertNull($record);
            # This returns an MX record
            try {
                $record = $bimini->getRecord('example.net');
                $this->fail('Should have thrown an InvalidArgumentException');
            } catch (InvalidArgumentException $e) {
                # Ok
            } catch (Exception $e) {
                $this->fail('Should have thrown an InvalidArgumentException');
            }
            # Delete cached records
            $this->deleteRecord($path, 'example.com');
            $this->deleteRecord($path, 'example.org');
            $this->deleteRecord($path, 'example.net');
        }

        protected function deleteRecord(string $path, string $host) {
            $path .= DIRECTORY_SEPARATOR . md5($host);
            if ( file_exists($path) ) {
                unlink($path);
            }
        }
    }
}
