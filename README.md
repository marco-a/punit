# punit

**p**unit (**php** unit) is a _small_ unit testing tool for the scripting language [PHP](https://php.net).

## why?

While `phpunit` is a great option, it has too many options in my opinion.

I'm writing my own small PHP project and I wanted something lightweight to test my code.

```
punit [options] -- <files>

--bootstrap <path>
	Include <path> in every test.

--max-execution-time <milliseconds>
	Limit execution time to <milliseconds>.
	Needs to be a multiple of 10 milliseconds.
	0 means unlimited.
	Default is unlimited.

--max-memory-usage <value>
	Sets memory limit for each test to <value>.
	Note: uses ini setting `memory_limit'.
	Default is php's own memory limit.

--continue
	Continue if a test failed.

--no-newline
	Do not add a line to the unit test's output.

--no-diff
	Do not show difference between output and expected output.

--report-format <format>
	Specify output format:
		- oneline
		Prints result in one line. (default)
		- json
		Prints result in one line in json.

--use-php-binary <path>
	Use php binary located at <path>.
	Default is result of `which php'.

--use-php-ini <path>
	Use php ini located at <path>.
	Default is none.
```

## running example test

```
$ ./punit -- ./test
Using PHP version: 7.2.19
[pass] This is an example test.                                                            34 ms
Ran 1 tests in 0.04 seconds
```

## environment variables

You can set `--continue`, `--no-newline` and `--no-diff` via
environment variables.

```
PUNIT_CONTINUE
PUNIT_NO_NEWLINE
PUNIT_NO_DIFF
```

The value of these environment variables is not checked.
