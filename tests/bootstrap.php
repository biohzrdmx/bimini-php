<?php

declare(strict_types = 1);

/**
 * Bimini
 * Easily check and retrieve BIMI records from a host
 * @author  biohzrdmx <github.com/biohzrdmx>
 * @license MIT
 */

# Define the absolute path
define( 'BASE_DIR', dirname( dirname(__FILE__) ) );

# Composer initialization
if ( file_exists( BASE_DIR . '/vendor/autoload.php' ) ) {
    include BASE_DIR . '/vendor/autoload.php';
}
