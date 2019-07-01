<?php

namespace punit;

// oneline:
// [pass] <description>                duration ms
// [fail] <description>                duration ms

function print_test_result($test, $result, $report_format) {
	$pass = test_has_passed($test, $result);

	$description = "<no description>";
	if (\strlen($test["description"])) {
		$description = $test["description"];
	}

	// cut too long description
	$description = \str_pad($description, 80, " ", \STR_PAD_RIGHT);

	$duration = \str_pad($result["duration"], 5, " ", \STR_PAD_LEFT)." ms";
	$duration = "\033[0;34m$duration\033[0m";

	$label = $pass ? "\033[0;32m[pass]" : "\033[0;31m[fail]";

	if ($report_format === "oneline") {
		echo "$label\033[0m $description $duration\n";
	} else {
		echo \json_encode([
			"result" => $pass,
			"description" => $test["description"],
			"duration" => $result["duration"]
		]);
		echo "\n";
	}

	if (!$pass) {
		$a = $test["expected_output"];
		$b = $result["stdout"];

		echo "\033[3;30m";
		system("diff -y $a $b");
		echo "\033[0m";
	}
}