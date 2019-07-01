<?php

namespace punit\safe;

function ftell($handle) {
	$position = @\ftell($handle);

	if ($position === false) {
		throw new \Error("Failed to get file position");
	}

	return $position;
}
