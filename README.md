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

--max-memory-usage <value>
	Sets memory limit for each test to <value>.
	Note: uses ini setting `memory_limit'.

--continue
	Continue if a test failed.

--no-newline
	Do not add a line to the unit test's output.

--report-format <format>
	Specify output format:
		- oneline
		Prints result in one line. (default)
		- json
		Prints result in one line in json.

--use-php-binary <path>
	Use php binary located at <path>.

--use-php-ini <path>
	Use php ini located at <path>.
```
