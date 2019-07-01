<?php

namespace punit\safe;

function stream_set_blocking($handle, $blocking) {
	if (!@\stream_set_blocking($handle, $blocking)) {
		throw new \Error("Failed to set stream blocking");
	}
}
