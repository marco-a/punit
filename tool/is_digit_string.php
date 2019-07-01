<?php

namespace punit\tool;

function is_digit_string($string) {
	static $digits = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

	for ($i = 0; $i < \strlen($string); ++$i) {
		if (!\in_array($string[$i], $digits)) {
			return false;
		}
	}

	return true;
}
