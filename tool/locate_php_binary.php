<?php

namespace punit\tool;
use punit\safe as safe;

function locate_php_binary() {
	$path = @\exec("which php 2>&1", $_, $exit_code);

	if ($exit_code !== 0) {
		return "which php exited with code $exit_code.";
	}

	try {
		$real_path = safe\realpath($path);
	} catch (\Error $e) {
		return "$path: no such file or directory.";
	}

	if (!\is_file($real_path)) {
		return "$real_path: not a file.";
	} else if (!\is_executable($real_path)) {
		return "$real_path: not executable.";
	}

	return [$real_path];
}
