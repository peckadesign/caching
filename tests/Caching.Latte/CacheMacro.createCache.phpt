<?php

/**
 * Test: Nette\Bridges\CacheLatte\CacheMacro createCache()
 */

use Nette\Bridges\CacheLatte\CacheMacro,
	Tester\Assert,
	Nette\Caching\Storages\DevNullStorage,
	Nette\Caching\Cache;


require __DIR__ . '/../bootstrap.php';

test(function() {
	$parents = [];
	$dp = [Cache::TAGS => ['rum', 'cola']];
	$outputHelper = CacheMacro::createCache(new DevNullStorage(), 'test', $parents, $dp);
	Assert::type('Nette\Caching\OutputHelper', $outputHelper);
	Assert::same($dp + [Cache::EXPIRATION => '+ 7 days'], $outputHelper->dependencies);
});

test(function() {
	$parents = [];
	$dp = [Cache::TAGS => ['rum', 'cola']];
	$dpFallback = function() use ($dp) {
		return $dp;
	};
	$outputHelper = CacheMacro::createCache(new DevNullStorage(), 'test', $parents, ['dependencies' => $dpFallback]);
	Assert::same($dp + [Cache::EXPIRATION => '+ 7 days'], $outputHelper->dependencies);
});

test(function() {
	$parents = [];
	$dp = [
		Cache::TAGS => ['rum', 'cola'],
		Cache::EXPIRATION => '+ 1 days'
	];
	$dpFallback = function() use ($dp) {
		return $dp;
	};
	$outputHelper = CacheMacro::createCache(new DevNullStorage(), 'test', $parents, ['dependencies' => $dpFallback]);
	Assert::same($dp, $outputHelper->dependencies);
});
