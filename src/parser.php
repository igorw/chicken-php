<?php

namespace igorw\chicken;

use Functional as F;

/** @api */
class ParserException extends \RuntimeException {
}

/** @api */
function parse($code) {
    $lines = explode("\n", $code);
    return F\map($lines, __NAMESPACE__.'\\line_chicken_count');
}

function line_chicken_count($line) {
    if ('' === $line) {
        return 0;
    }
    $chickens = explode(' ', $line);
    $invalidChickens = F\some($chickens, function ($chicken) {
        return 'chicken' !== $chicken;
    });
    if ($invalidChickens) {
        throw new ParserException();
    }
    return count($chickens);
}
