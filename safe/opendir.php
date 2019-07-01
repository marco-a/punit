<?php

namespace punit\safe;

function opendir($path) {
	$handle = @\opendir($path);

	if (!\is_resource($handle)) {
		throw new \Error("Failed to open directory `$path'");
	}

	return $handle;
}
