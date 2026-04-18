<?php

declare(strict_types=1);

/**
 * Minimum line coverage gate.
 *
 * Usage: php bin/check-coverage.php <clover.xml> <min-percent>
 *
 * Exits 0 if line coverage is >= threshold, 1 otherwise.
 */

if ($argc < 3) {
    fwrite(STDERR, "Usage: php bin/check-coverage.php <clover.xml> <min-percent>\n");
    exit(2);
}

$cloverPath = $argv[1];
$threshold = (float)$argv[2];

if (!is_file($cloverPath)) {
    fwrite(STDERR, "Coverage file not found: {$cloverPath}\n");
    exit(2);
}

$xml = simplexml_load_file($cloverPath);
if ($xml === false || !isset($xml->project->metrics)) {
    fwrite(STDERR, "Unable to parse coverage file: {$cloverPath}\n");
    exit(2);
}

$metrics = $xml->project->metrics;
$statements = (int)$metrics['statements'];
$covered = (int)$metrics['coveredstatements'];

if ($statements === 0) {
    fwrite(STDERR, "No statements found in coverage report.\n");
    exit(2);
}

$percent = ($covered / $statements) * 100;
printf("Line coverage: %.2f%% (threshold %.2f%%)\n", $percent, $threshold);

if ($percent + 1e-9 < $threshold) {
    fwrite(STDERR, sprintf("Coverage %.2f%% is below required %.2f%%.\n", $percent, $threshold));
    exit(1);
}

exit(0);
