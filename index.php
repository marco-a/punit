<?php

/**
 * Copyright (c) 2019 marco-a
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
*/

\array_shift($argv);

require_once __DIR__."/core.php";

if (!\sizeof($argv)) {

	\fwrite(\STDERR, "punit [options] -- <files>

--bootstrap <path>
	Include <path> in every test.

--max-execution-time <milliseconds>
	Limit execution time to <milliseconds>.
	Needs to be a multiple of 10 milliseconds.
	0 means unlimited.
	Default is unlimited.

--max-memory-usage <value>
	Sets memory limit for each test to <value>.
	Note: uses ini setting `memory_limit'.
	Default is php's own memory limit.

--continue
	Continue if a test failed.

--no-newline
	Do not add a line to the unit test's output.

--no-diff
	Do not show difference between output and expected output.

--report-format <format>
	Specify output format:
		- oneline
		Prints result in one line. (default)
		- json
		Prints result in one line in json.

--use-php-binary <path>
	Use php binary located at <path>.
	Default is result of `which php'.

--use-php-ini <path>
	Use php ini located at <path>.
	Default is none.
");

	exit(2);
}

$args = punit\parse_args($argv);

if (\is_string($args)) {
	\fwrite(\STDERR, "$args\n");
	exit(2);
}

$main = require __DIR__."/main.php";

# locate php binary
if ($args["context"]["use_php_bin"] === NULL) {
	$default_php_binary = punit\tool\locate_php_binary();

	if (!\is_array($default_php_binary)) {
		\fwrite(\STDERR, "Failed to locate php binary: $default_php_binary\n");
		exit(1);
	}

	$args["context"]["use_php_bin"] = $default_php_binary[0];
}

# print php version
{
	$php_version = punit\tool\get_php_version($args["context"]["use_php_bin"]);

	if (!\is_array($php_version)) {
		\fwrite(\STDERR, "Failed to get php version: $php_version\n");
		exit(1);
	}

	\fwrite(\STDERR, "Using PHP version: ".$php_version[0]."\n");
}

# check environment variables
{
	$environment_variables = [
		"continue" => NULL,
		"no_newline" => NULL,
		"no_diff" => NULL
	];

	foreach ($environment_variables as $variable => &$value) {
		$key = "PUNIT_".\strtoupper($variable);
		$value = punit\tool\read_environment_variable($key);

		if ($value !== NULL) {
			\fwrite(\STDERR, "ENV $key: Setting --$variable.\n");

			$args["context"][$variable] = true;
		}
	}
}

$main($args["files"], $args["context"]);
