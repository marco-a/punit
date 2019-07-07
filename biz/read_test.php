<?php

namespace punit;

function read_test($path, $test_options, $handle) {
	// save position
	$position = safe\ftell($handle);
	// read description
	$description = \trim(\fgets($handle));

	// undo fgets if no description is available
	if ($description === "<?php") {
		$description = "";
		safe\fseek($handle, $position, \SEEK_SET);
	}

	// code file
	list($code_handle, $code_file) = tool\create_temporary_file();
	// expected output file
	list($eout_handle, $eout_file) = tool\create_temporary_file();

	$__DIR__ = \dirname(safe\realpath($path));
	$__FILE__ = safe\realpath($path);

	while (($line = \fgets($handle)) !== false) {
		// fix __DIR__ and __FILE__
		$line = \str_replace([
			"__DIR__",
			"__FILE__"
		], [
			\var_export($__DIR__, true),
			\var_export($__FILE__, true)
		], $line);

		safe\fwrite($code_handle, $line);

		// code section is done
		if (\trim($line) === "?>") break;
	}

	\fclose($code_handle);

	// copy expected output
	while (($line = \fgets($handle)) !== false) {
		// ignore lines starting with `#'
		// if $test_options->comments is set.
		if (\property_exists($test_options, "comments")) {
			if (\substr($line, 0, 1) === "#") {
				continue;
			}
		}

		safe\fwrite($eout_handle, $line);
	}

	\fclose($eout_handle);

	return [
		"description"     => $description,
		"expected_output" => $eout_file,
		"code_to_run"     => $code_file
	];
}
