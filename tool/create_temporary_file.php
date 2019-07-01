<?php

namespace punit\tool;
use punit\safe as safe;

function create_temporary_file() {
	$path = \sys_get_temp_dir()."/".\uniqid("punit", true);

	$handle = safe\fopen($path, "x+b");

	return [$handle, safe\realpath($path)];
}
