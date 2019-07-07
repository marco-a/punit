<?php

namespace punit;

function discover_tests($directory, $emit) {

	$handle = safe\opendir($directory);

	while (($entry = safe\readdir($handle)) !== false) {
		$entry_path = safe\realpath("$directory/$entry");

		if (\is_dir($entry_path)) {
			discover_tests($entry_path, $emit);
		} else if (\substr($entry, -4, 4) === ".php") {
			// read test header
			$tmp = read_test_meta($entry_path);

			if (\is_array($tmp)) {
				list($fp, $test_options) = $tmp;

				$emit($fp, $test_options, $entry_path);

				\fclose($fp);
			}
		}
	}

}
