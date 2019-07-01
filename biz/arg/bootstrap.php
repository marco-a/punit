<?php

namespace punit;

return (function() {

	return function($bootstrap) {
		try {
			$real_bootstrap = safe\realpath($bootstrap);
		} catch (\Error $e) {
			return "$bootstrap: no such file or directory.";
		}

		if (!\is_file($real_bootstrap)) {
			return "$bootstrap: not a file.";
		} else if (!\is_readable($real_bootstrap)) {
			return "$bootstrap: not readable.";
		}

		return [$real_bootstrap];
	};

})();
