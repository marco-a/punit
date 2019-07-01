<?php

namespace punit\safe;

function realpath($path) {
	$real_path = @\realpath($path);

	if ($real_path === false) {
		throw new \Error("Failed to resolve path `$path'");
	}

	return $real_path;
}
