<?php

namespace punit\safe;

function hash_file($algo, $file) {
	$hash = \hash_file($algo, $file);

	if ($hash === false) {
		throw new \Error("Failed to hash file `$file'");
	}

	return $hash;
}
