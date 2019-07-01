<?php

namespace punit\safe;

function readdir($handle) {
	while (true) {
		$entry = \readdir($handle);

		if ($entry === false) return false;

		if (\substr($entry, 0, 1) === ".") continue;

		return $entry;
	}
}
