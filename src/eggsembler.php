<?php

namespace igorw\chicken;

use iter;

/** @api */
function eggsemble($code) {
    $lines = explode("\n", $code);
    $lines = reject(__NAMESPACE__.'\\eggsemble_is_blank', $lines);
    $lines = reject(__NAMESPACE__.'\\eggsemble_is_comment', $lines);
    $lines = iter\map(__NAMESPACE__.'\\eggsemble_line', $lines);
    $lines = iter\values($lines);
    return iter\toArray($lines);
}

function complement(callable $pred) {
    return function () use ($pred) {
        return !call_user_func_array($pred, func_get_args());
    };
}

function reject(callable $pred, $iterable) {
    return iter\filter(complement($pred), $iterable);
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
