<?php

namespace punit;

return (function() {
	return function($php_ini) {
		try {
			$real_php_ini = safe\realpath($php_ini);
		} catch (\Error $e) {
			return "$php_ini: no such file or directory.";
		}

		if (!\is_file($real_php_ini)) {
			return "$php_ini: not a file.";
		} else if (!\is_readable($real_php_ini)) {
			return "$php_ini: not readable.";
		}

		return [$real_php_ini];
	};
})();
