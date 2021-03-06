<?php

/**
 * Test: Nette\Caching\Storages\MemcachedStorage expiration test.
 */

use Nette\Caching\Storages\MemcachedStorage,
	Nette\Caching\Cache,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';


if (!MemcachedStorage::isAvailable()) {
	Tester\Environment::skip('Requires PHP extension Memcache.');
}


$key = 'nette-expiration-key';
$value = 'rulez';

$cache = new Cache(new MemcachedStorage('localhost'));


// Writing cache...
$cache->save($key, $value, [
	Cache::EXPIRATION => time() + 3,
]);


// Sleeping 1 second
sleep(1);
Assert::truthy( $cache->load($key) );


// Sleeping 3 seconds
sleep(3);
Assert::null( $cache->load($key) );
