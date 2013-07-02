# chicken-php

PHP implementation of the [Chicken VM](http://torso.me/chicken), ported from
JavaScript.

## Usage

Quine:

    $ echo chicken | bin/chicken

Cat:

    $ echo chicken | bin/chicken foo <<EOF
    chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken chicken
    chicken chicken chicken chicken chicken chicken

    EOF
