<?php

namespace punit\safe;

function fwrite($handle, $data) {
	$bytes_to_write = \strlen($data);
	$bytes_written = @\fwrite($handle, $data);

	if ($bytes_to_write !== $bytes_written) {
		throw new \Error("Partial file write ($bytes_written/$bytes_to_write)");
	}

	return $bytes_written;
}
