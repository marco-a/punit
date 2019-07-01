<?php

namespace punit\safe;

function fopen($path, $mode) {
	$fp = @\fopen($path, $mode);

	if (!\is_resource($fp)) {
		throw new \Error("Failed to open file `$path'");
	}

	return $fp;
}
