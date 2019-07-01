<?php

namespace punit;

function print_statistics($statistics, $report_format) {
	$n_tests = $statistics["tests"]["passed"] + $statistics["tests"]["failed"];

	$duration = tool\millis() - $statistics["start_time"];

	if ($report_format === "oneline") {
		$duration = \number_format($duration / 1E3, 2);

		echo "Ran $n_tests tests in $duration seconds\n";
	} else {
		echo \json_encode([
			"duration" => $duration,
			"tests" => $statistics["tests"]
		])."\n";
	}
}
