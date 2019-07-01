<?php

namespace punit\tool;

function get_php_version($binary) {
	$command = \escapeshellcmd($binary)." -r 'echo phpversion();'";
	$version = @\exec($command, $_, $exit_code);

	if ($exit_code !== 0) {
		return "php -r return exited with code $exit_code.";
	}

	return [$version];
}
