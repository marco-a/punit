<?php

namespace punit\tool;

function read_environment_variable($name) {
	global $_ENV;

	if (\array_key_exists($name, $_ENV)) {
		return $_ENV[$name];
	}

	$value = \getenv($name);

	if ($value === false) {
		return NULL;
	}

	return $value;
}
