<?php

namespace punit;

function init($things) {
	if ($things["max_memory_usage"] !== NULL) {
		if (!\ini_set("memory_limit", $things["max_memory_usage"])) {
			\fwrite(\STDERR, "punit: Failed to set memory_limit.\n");
			exit(255);
		}
	}

	if ($things["bootstrap"] !== NULL) {
		require $things["bootstrap"];
	}
}

function dump($value) {
	static $dumper = NULL;

	if ($dumper === NULL) {
		$dumper = require __DIR__."/../3rd/dumper/stringify.php";
	}

	$tmp = \array_map($dumper, \func_get_args());

	echo \implode("\n", $tmp);
}
