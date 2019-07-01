<?php

namespace punit;

function run_test($test, $context) {
	$command  = \escapeshellcmd($context["use_php_bin"]);
	if ($context["use_php_ini"] !== NULL) {
		$command .= " -c ".\escapeshellarg($context["use_php_ini"]);
	}

	$command .= " -f ".\escapeshellarg($test["code_to_run"]);

	// create stdout and stderr streams
	list($stdout_handle, $stdout_file) = tool\create_temporary_file();
	list($stderr_handle, $stderr_file) = tool\create_temporary_file();

	$proc = safe\proc_open($command, [
		1 => $stdout_handle,
		2 => $stderr_handle
	], $pipes, "/");

	safe\stream_set_blocking($stdout_handle, false);
	safe\stream_set_blocking($stderr_handle, false);

	$exit_code = -1;
	$max_ticks = $context["max_execution_time"] / 10;
	$n_ticks = 0;
	$timeout = false;

	$start_time = tool\millis();

	while (true) {
		$proc_status = \proc_get_status($proc);

		if (!$proc_status["running"]) {
			$exit_code = $proc_status["exitcode"];

			break;
		}

		if ($max_ticks !== 0 && $n_ticks >= $max_ticks) {
			\proc_terminate($proc);
			$timeout = true;
			break;
		}

		// sleep for 10ms
		\usleep(10E3);
		++$n_ticks;
	}

	if (!$context["no_newline"]) {
		safe\fwrite($stdout_handle, "\n");
	}

	\fclose($stdout_handle);
	\fclose($stderr_handle);
	\proc_close($proc);

	return [
		"timeout" => $timeout,
		"exit_code" => $exit_code,
		"duration" => tool\millis() - $start_time,
		"stdout" => $stdout_file,
		"stderr" => $stderr_file
	];
}
