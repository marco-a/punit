<?php

namespace punit\safe;

function proc_open($cmd, $spec, &$pipes, $cwd = NULL, $env = NULL) {
	$handle = @\proc_open($cmd, $spec, $pipes, $cwd, $env);

	if (!\is_resource($handle)) {
		throw new \Error("Failed to proc_open `$cmd'");
	}

	return $handle;
}
