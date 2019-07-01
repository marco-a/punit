<?php

namespace punit;

return (function() {
	$fn_run_test = function($handle, $path, $context, &$statistics) {
		$test = read_test($path, $handle);
		$test = inject_into_test($test, [
			"max_memory_usage" => $context["max_memory_usage"],
			"bootstrap" => $context["bootstrap"]
		]);

		$result = run_test($test, [
			"use_php_bin" => $context["use_php_bin"],
			"use_php_ini" => $context["use_php_ini"],
			"max_execution_time" => $context["max_execution_time"],
			"no_newline" => $context["no_newline"]
		]);

		print_test_result($test, $result, $context["report_format"]);

		$test_passed = test_has_passed($test, $result);

		if ($test_passed) {
			$statistics["tests"]["passed"] += 1;
		} else {
			$statistics["tests"]["failed"] += 1;
		}

		return !$test_passed && !$context["continue"];
	};

	return function($files, $context) use(
		$fn_run_test
	) {
		$statistics = [
			"start_time" => tool\millis(),
			"tests" => [
				"passed" => 0,
				"failed" => 0
			]
		];

		$fn_handle_test = function($handle, $path) use(
			$fn_run_test,
			$context,
			&$statistics
		) {
			$stop = $fn_run_test($handle, $path, $context, $statistics);

			if ($stop) {
				print_statistics($statistics, $context["report_format"]);
				exit(255);
			}
		};

		foreach ($files as $file) {
			$file = safe\realpath($file);

			if (\is_dir($file)) {
				discover_tests($file, $fn_handle_test);
			} else {
				$fp = safe\fopen($file, "rb");

				if (\trim(\fgets($fp)) === "punit") {
					$fn_handle_test($fp, $file);
				}

				\fclose($fp);
			}
		}

		print_statistics($statistics, $context["report_format"]);

		if ($statistics["tests"]["failed"] > 0) {
			exit(1);
		}
	};

})();
