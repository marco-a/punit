<?php

namespace punit\safe;

function fseek($handle, $offset, $whence = \SEEK_SET) {
	if (@\fseek($handle, $offset, $whence) !== 0) {
		throw new \Error("Failed to seek file");
	}
}
