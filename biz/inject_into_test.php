<?php

namespace punit;

function inject_into_test($test, $things) {
	list($ncode_handle, $ncode_path) = tool\create_temporary_file();

	$code_handle = safe\fopen($test["code_to_run"], "rb");

	$i = 0;
	while (($line = \fgets($code_handle)) !== false) {
		// i=0 <?php
		// i=1 ...
		if ($i++ === 1) {
			$punit_require = "require ".\var_export(__DIR__."/../test-env/load.php", true);
			$things = \var_export($things, true);
			$things = \str_replace("\n", "", $things);
			safe\fwrite($ncode_handle, "$punit_require;\punit\init($things);\n");
		}

		safe\fwrite($ncode_handle, $line);
	}

	\fclose($ncode_handle);

	return [
		"description" => $test["description"],
		"code_to_run" => $ncode_path,
		"expected_output" => $test["expected_output"]
	];
}
