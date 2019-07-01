<?php

\set_error_handler(function($_, $message) {
	# Ignore @
	if (\error_reporting() === 0) return;

	throw new \Error($message);
});

\set_exception_handler(function($exception) {
	$message = $exception->getMessage();
	$file = $exception->getFile();
	$line = $exception->getLine();
	$trace = $exception->getTraceAsString();

	@\fwrite(\STDERR, "Unhandled exception: $message.\n");
	@\fwrite(\STDERR, "File: $file\n");
	@\fwrite(\STDERR, "Line: $line\n");
	@\fwrite(\STDERR, "$trace\n");

	exit(127);
});

\error_reporting(\E_ALL | \E_STRICT);
