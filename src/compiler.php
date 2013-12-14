<?php

namespace igorw\chicken;

use iter;

/** @api */
class CompilerException extends \RuntimeException {
}

/** @api */
function compile($code) {
    $lines = explode("\n", $code);
    $lines = iter\map(__NAMESPACE__.'\\line_chicken_count', $lines);
    return iter\toArray($lines);
}

function line_chicken_count($line) {
    if ('' === $line) {
        return 0;
    }
    $chickens = explode(' ', $line);
    $invalidChickens = iter\filter(iter\fn\operator('!==', 'chicken'), $chickens);
    $invalidChickens = iter\values($invalidChickens);
    $invalidChickens = iter\toArray($invalidChickens);
    if ($invalidChickens) {
        throw new CompilerException(
            sprintf('The following invalid chickens were found: %s',
                json_encode($invalidChickens)));
    }
    return count($chickens);
}
