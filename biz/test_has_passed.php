<?php

namespace punit;

function test_has_passed($test, $result) {
	if ($result["timeout"]) {
		return false;
	} else if ($result["exit_code"] !== 0) {
		return false;
	}

	$output_match = safe\hash_file("sha512", $test["expected_output"]);

	return safe\hash_file("sha512", $result["stdout"]) === $output_match;
}
