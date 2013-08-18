#!/bin/bash
cat | bin/chickenasm | bin/eggsemble | bin/chicken "$@"
