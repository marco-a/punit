<?php

namespace punit;

return (function() {
	return function($php_binary) {
		try {
			$real_php_binary = safe\realpath($php_binary);
		} catch (\Error $e) {
			return "$php_binary: no such file or directory.";
		}

		if (!\is_file($real_php_binary)) {
			return "$php_binary: not a file.";
		} else if (!\is_executable($real_php_binary)) {
			return "$php_binary: not executable.";
		}

		return [$real_php_binary];
	};
})();
