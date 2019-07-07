<?php

namespace punit;

function read_test_meta($file) {
	$handle = safe\fopen($file, "rb");
	$first_line = \trim(\fgets($handle));

	// ignore files that do not start with punit
	if (\substr($first_line, 0, 5) !== "punit") {
		\fclose($handle);
		return NULL;
	}

	$_options = (object)[];

	// look for options
	$options = \explode(",", $first_line);
	// 1st element is always punit
	\array_shift($options);

	foreach ($options as $option) {
		$option = \trim($option);

		switch ($option) {
			case "comments":
				$_options->comments = true;
			break;

			case "skip":
				$_options->skip = true;
			break;

			default:
				throw new \Error("Unknown punit option `$option'");
		}
	}

	return [
		$handle,
		$_options
	];
}
