<?php
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

--max-memory-usage <value>
	Sets memory limit for each test to <value>.
	Note: uses ini setting `memory_limit'.

--continue
	Continue if a test failed.

--report-format <format>
	Specify output format:
		- oneline
		Prints result in one line. (default)
		- json
		Prints result in one line in json.

--use-php-binary <path>
	Use php binary located at <path>.

--use-php-ini <path>
	Use php ini located at <path>.
");

	exit(2);
}

$args = punit\parse_args($argv);

if (\is_string($args)) {
	\fwrite(\STDERR, "$args\n");
	exit(2);
}

$main = require __DIR__."/main.php";
$main($args["files"], $args["context"]);
