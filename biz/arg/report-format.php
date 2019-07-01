<?php

namespace punit;

return (function() {

	return function($report_format) {
		if (!\in_array($report_format, ["oneline", "json"])) {
			return "$report_format: unknown format.";
		}

		return [$report_format];
	};

})();
