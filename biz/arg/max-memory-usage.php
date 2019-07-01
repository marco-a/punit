<?php

namespace punit;

return (function() {

	return function($max_memory_usage) {
		static $units = [
			"GiB" => 1024 * 1024 * 1024,
			"MiB" => 1024 * 1024,
			"KiB" => 1024,
			"GB" => 1000 * 1000 * 1000,
			"MB" => 1000 * 1000,
			"KB" => 1000,
			"B" => 1
		];

		// <digits><unit>
		$fetching_unit = false;
		$digits = $unit = "";

		for ($i = 0; $i < \strlen($max_memory_usage); ++$i) {
			$ch = $max_memory_usage[$i];

			if (!tool\is_digit_string($ch)) {
				$fetching_unit = true;
			}

			if ($fetching_unit) {
				$unit .= $ch;
			} else {
				$digits .= $ch;
			}
		}

		if (!\strlen($unit)) {
			$unit = "B";
		}

		if (!\array_key_exists($unit, $units)) {
			return "$max_memory_usage: unknown unit `$unit'.";
		}

		$amount  = (int)$digits;
		$amount *= $units[$unit];

		return [$amount];
	};

})();
