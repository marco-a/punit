<?php

namespace punit\tool;

function millis() {
	return (int)(\microtime(true) * 1E3);
}
