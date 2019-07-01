<?php

namespace punit;

function parse_args($argv) {
	$context = [
		"bootstrap" => NULL,
		"max_memory_usage" => NULL,
		"max_execution_time" => 0,
		"use_php_bin" => `which php`,
		"use_php_ini" => "",
		"report_format" => "oneline",
		"continue" => false
	];

	$files = [];
	$double_slash = false;

	while (\sizeof($argv)) {
		$arg = \array_shift($argv);

		if ($double_slash) {
			try {
				$files[safe\realpath($arg)] = true;
			} catch (\Error $e) {
				return "$arg: no such file or directory.";
			}
		} else {
			switch ($arg) {
				case "--bootstrap":
				case "--use-php-ini":
				case "--use-php-bin":
				case "--max-memory-usage":
				case "--max-execution-time":
				case "--report-format":
					$arg_value = \array_shift($argv);

					if ($arg_value === NULL) {
						return "$arg: value required.";
					}

					$validator = require __DIR__."/arg/".\substr($arg, 2).".php";
					$result = $validator($arg_value);

					if (!\is_array($result)) {
						return "$arg: $result";
					}

					$key = \substr($arg, 2);
					$key = \str_replace("-", "_", $key);

					$context[$key] = $result[0];
				break;

				case "--continue":
					$context["continue"] = true;
				break;

				case "--":
					$double_slash = true;
				break;

				default:
					return "$arg: no such option.";
			}
		}
	}

	return [
		"files" => \array_keys($files),
		"context" => $context
	];
}
