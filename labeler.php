<?php

/**
 * @link https://github.com/tom--/labeler
 * @copyright Copyright (c) 2015 Spinitron, LLC
 * @license ISC https://opensource.org/licenses/ISC
 */

namespace spinitron\labeler;

require __DIR__ . '/vendor/autoload.php';

$delimiter = ',';
$input = STDIN;
$output = STDOUT;
$script = array_shift($argv);

$usage = <<<STRING
$script [-t] [in [out]]
  -t   use tab separators rather than commas
  in   input file name, or - for for stdin
  out  output file name, or - for for stdout

STRING;

$arg = array_shift($argv);
if ($arg === '-t') {
    $delimiter = "\t";
    $arg = array_shift($argv);
} elseif ($arg && $arg[0] === '-') {
    if ($arg !== '-h' && $arg !== '--help'){
        Labeler::logerr("invalid option: $arg\n");
    }
    Labeler::logerr($usage);
    exit(1);
}
if ($arg) {
    if ($arg !=='-') {
        $input = fopen($arg, 'r');
        if ($input === false) {
            Labeler::logerr("cannot open input file: $arg\n" . $usage);
            exit(1);
        }
    }
    $arg = array_shift($argv);
}
if ($arg) {
    if ($arg !=='-') {
        $output = fopen($arg, 'r');
        if ($output === false) {
            Labeler::logerr("cannot open input file: $arg\n" . $usage);
            exit(1);
        }
    }
}

$labeler = new Labeler();

while (!feof($input)) {
    $item = fgetcsv($input, 0, $delimiter);
    if ($item === false) {
        break;
    }

    if (count($item) === 2) {
        $item[] = '';
    }

    if (count($item) > 2) {
        $cleaned = $labeler->cleanup($item[0], $item[1], $item[2]);
        fputcsv($output, $cleaned, $delimiter);
    }
}
