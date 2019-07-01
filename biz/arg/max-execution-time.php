<?php

namespace punit;

return (function() {

	return function($max_execution_time) {
		if (!tool\is_digit_string($max_execution_time)) {
			return "$max_execution_time: not a number.";
		}

		$max_execution_time = (int)$max_execution_time;

		if (0 > $max_execution_time) {
			return "$max_execution_time: must be 0 or greater.";
		} else if (($max_execution_time % 10) !== 0) {
			return "$max_execution_time: must be a multiple of 10 milliseconds.";
		}

		return [$max_execution_time];
	};

})();
