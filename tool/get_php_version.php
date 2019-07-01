<?php

namespace punit\tool;

function get_php_version($binary) {
	$command = \escapeshellcmd($binary)." -r 'echo phpversion();'";
	$version = @\exec($command." 2>&1", $_, $exit_code);

	if ($exit_code !== 0) {
		return "php -r 'echo phpversion();' exited with code $exit_code.";
	}

	return [$version];
}
