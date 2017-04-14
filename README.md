Diffie-Hellman Key Exchange (PHP)
============
This is an academic example of the diffie-hellman key exchange in PHP. It is  not meant to be used for any real world purpose. The values of $p; $g; $a; $b are generated randomly as per the Diffie-Hellman protocol.

Requirements
============

This library requires `PHP >= 7.x` and the `GNU Multiple Precision/GMP` functions enabled in PHP's `Mathematical Extensions` (http://php.net/manual/en/book.gmp.php)
without this it will NOT work. This application is meant to handle very large integers, tested as high as 3072 bits.

Installation
============
Application can be run from anywhere. On windows, you can just put it in the same folder as your PHP binary.

Usage
============
Run via terminal. The program takes the size of the prime number p in the specified bit range.

Command:

`php ./diffie-hellman.php 32`

Output:

`The value of p selected: 2205759217`

`The value of g selected: 2000375980`

`The value of a selected by Alice: 2016295672`

`The value of b selected by Bob: 1146783380`

`The value of A sent to Bob by Alice: 591592312`

`The value of B sent to Bob by Alice: 287287597`

`Shared Key: 218785632`

License
============

This is free and unencumbered software released into the public domain for educational purposes.