# bimini-php

Easily check and retrieve BIMI records from a host

### Basic usage

First require `biohzrdmx/bimini-php` with Composer.

Then create a `Bimini` instance; for that you must pass an `StorageInterface` implementation and this package includes a simple file system storage adapter named `FileSystemStorage`:

```php
$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'output';
$storage = new FileSystemStorage($path);
$bimini = new Bimi($storage);
```

The `FileSystemStorage` implementation uses a local directory to store the result of the DNS record queries, to minimize network requests; you may also write your own storage adapters for database, Redis, Memcached or any other persistance mechanism, just implement the `StorageInterface` methods.

Now that you have a `Bimini` instance you can query any host, for example you can check for the existence of a record with the `hasRecord` method:

```php
$ret = $bimini->hasRecord('example.com');
```

Or retrieve the complete record with the `getRecord` method:

```php
$record = $bimini->getRecord('example.com');
```

Once you have the record you can check its properties with the `has-` methods (`hasVersion`, `hasLogo`, `hasCertificate`) or retrieve the actual properties with the `get-` methods (`getVersion`, `getLogo`, `getCertificate`), for example:

```php
if ( $record->hasLogo() ) {
    $url = $record->getLogo();
}
```

Actually there is only one BIMI version, so the `getVersion` method should always return `BIMI1` for a valid record.

Both `getLogo` and `getCertificate` methods return a URL to the respective resource (the SVG image or the PEM file). The library does not validate these URLs, it only returns the value stored in the BIMI record; it's up to you if you want to render the SVG file or check the VMC certificate.

### Licensing

This software is released under the MIT license.

Copyright © 2024 biohzrdmx

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

### Credits

**Lead coder:** biohzrdmx [github.com/biohzrdmx](http://github.com/biohzrdmx)
