<?php

namespace igorw\chicken;

use Functional as F;

/** @api */
function eggsemble($code) {
    $lines = explode("\n", $code);
    $lines = F\reject($lines, __NAMESPACE__.'\\eggsemble_is_blank');
    $lines = F\reject($lines, __NAMESPACE__.'\\eggsemble_is_comment');
    $lines = F\map($lines, __NAMESPACE__.'\\eggsemble_line');
    return array_values($lines);
}

function eggsemble_is_blank($line) {
    return '' === $line;
}

function eggsemble_is_comment($line) {
    return 0 === strpos($line, '#');
}

function eggsemble_line($line) {
    $opcodes = [
        'axe'       => 0,
        'chicken'   => 1,
        'add'       => 2,
        'fox'       => 3,
        'rooster'   => 4,
        'compare'   => 5,
        'pick'      => 6,
        'peck'      => 7,
        'fr'        => 8,
        'bbq'       => 9,
    ];

    $op = strtolower($line);

    if (preg_match('#^push (\d+)$#', $op, $match)) {
        return 10 + (int) $match[1];
    }

    if (isset($opcodes[$op])) {
        return $opcodes[$op];
    }

    throw new \InvalidArgumentException(sprintf("Got invalid instruction '%s'", $op));
}
