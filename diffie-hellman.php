<?php
/***************************************************
 * Diffie-Hellman Key Exchange (PHP)
 * 
 * @author      John Cuppi
 * @code        
 * @license     http://unlicense.org/UNLICENSE
 * @version		0.1
 * @updated     1:53 PM Friday, April 14, 2017
 *
 * @description This is an academic example of the 
 * diffie-hellman key exchange. It is 
 * not meant to be used for any real
 * world purpose.
 ****************************************************/
 
// Enable this to check equations with a static value
DEFINE("HARDCODED_EXAMPLE", 0); 
 
class DiffieHellman
{	

	public  $p; // prime modulus
	public  $g; // generator
	private $a; // Alice's private number
	private $b; // Bob's private number
		
	/**
	* Compute values of p; g; a; and b randomly based on input argument
	* Ouput shared key generated; can handle input of at least 1024 bit
	*
	* @return void
	*/
	
	public function __construct() {
	global $argv;
			
		// Check if numeric
		if(!is_numeric($argv[1]) || !$argv[1] || $argv[1] < 3) {
			exit("The input was not numeric, please try again");
		}
		
		$is_prime = false;
		
		$range = $this->decimal_range( $argv[1] );
		
		// Alice and Bob agree publicly on a prime mod, and generator
		// The number must be prime so it is checked with gmp_prob_prime
		
		while($is_prime != true) {
			
			// Check if prime from the bit range specified
			$p = gmp_random_range( $range['min'], $range['max'] );
			
			// Check if prime or not
			
			if(gmp_prob_prime ( $p, 100 )) {
				$is_prime = true;
			} else {
				unset($p);
			}
		}

		if(HARDCODED_EXAMPLE) $p = gmp_strval("23");
		print "The value of p selected: {$p}\n";

		// The generator is a number Zp where $g is between 2 and p-1 but must be a prime base
		// num^p−1 ≡ 1 (mod p) if p is prime, if num is generator, num !≡  0 (mod p)
		// If b is any primitive root mod p, then the set of all primitive roots , mod p is exactly b^k | gcd ( p−1 , k ) = 1
		
		// Note: This is not great -- not an optimal way at all of computing the generator.
		
		$is_primitive_root = 0;
		
		while(!$is_primitive_root) {
			$g = gmp_strval(gmp_random_range(2, gmp_sub($p, 1)));
			$n_to_pm1 = gmp_powm(gmp_strval($g), gmp_sub($p, 1), $p);
			
			if( $n_to_pm1 == 1) {
				$is_primitive_root = 1;
			}
		}
		
		
		if(HARDCODED_EXAMPLE) $g = gmp_strval("5");
		print "The value of g selected: {$g}\n";
		
		// Alice selects her private random number between [1, p-1] (securely)
		$a =  gmp_strval(gmp_random_range(1, gmp_sub($p, 1)));
		if(HARDCODED_EXAMPLE) $a = gmp_strval("6");	

		print "The value of a selected by Alice: {$a}\n";
				
		// Bob selects his private random number between [1, p-1] (securely)
		$b =  gmp_strval(gmp_random_range(1, gmp_sub($p, 1)));
		if(HARDCODED_EXAMPLE) $b = gmp_strval("15");	
		
		print "The value of b selected by Bob: {$b}\n";

		// Alice calculates $g^$a % $p 
		// This is the Value of A sent to Bob publicly
		$A_value = gmp_powm($g, $a, $p);
		print "The value of A sent to Bob by Alice: {$A_value}\n";
				 
		// Bob calculates $g^$a % $p 
		// This is the Value of B sent to Alice publicly
		$B_value = gmp_powm($g, $b, $p);
		print "The value of B sent to Bob by Alice: {$B_value}\n";
		
		// Alice takes Bob's public result ($B_value) and raises it 
		// to the power of her private number ($a) to get the
		// shared key shared between them and then take mod $p
		
		$shared_key = gmp_powm($B_value, $a, $p);
	
		print "Shared Key: ". $shared_key;
	}

	/**
	* Takes in a value for bits, and finds the range
	* numbers within amount of bits specifcied.
	* Ex: $bits = 5, then $min = 16 and $max = 31
	*
	* @return array
	*/
	
	
	public function decimal_range( $bits ) {
		$min = gmp_init(str_pad(1, $bits, 0, STR_PAD_RIGHT), 2);   
		$max = gmp_init(str_pad(1, $bits, 1, STR_PAD_RIGHT), 2);
		
		return array('min'=> $min, 'max'=> $max, 'range'=>"{$min}-{$max}");
	}
	
}

$DiffieHellman = new DiffieHellman();

?>