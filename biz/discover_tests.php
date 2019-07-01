<?php

namespace punit;

function discover_tests($directory, $emit) {

	$handle = safe\opendir($directory);

	while (($entry = safe\readdir($handle)) !== false) {
		$entry_path = safe\realpath("$directory/$entry");

		if (\is_dir($entry_path)) {
			discover_tests($entry_path, $emit);
		} else if (\substr($entry, -4, 4) === ".php") {
			$fp = safe\fopen($entry_path, "rb");

			$first_line = \trim(\fgets($fp));

			if ($first_line === "punit") {
				$emit($fp, $entry_path);
			}

			\fclose($fp);
		}
	}

}
