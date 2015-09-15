<?php
/*
 * Created on 2008-08-21
 *
 * Dopary.
 */

class StringGenerator {
	private static $vowels = array('a', 'o', 'e', 'u', 'y', '5', '2', '3', '4');
	private static $consonants = array('b', 'c', 'd', 'f', 'q', 'w', 'r', 't', 'p', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'm', 'n');

	public static function generateString($length) {
		$zwr = '';
		for ($i=0; $i<$length; $i++) {
			if (mt_rand(0, 100) < 30) { //losujemy czy samogłoska czy spółgłoska
				$pos = mt_rand(0, count(self::$consonants) - 1);
				$zwr .= self::$consonants[$pos];
			}
			else {
				$pos = mt_rand(0, count(self::$vowels) - 1);
				$zwr .= self::$vowels[$pos];				
			}
		}
		return $zwr;
	}
	
	public static function replacePolish($str) {
		$replace = array (	'ę' => 'e', 'ó' => 'o', 'ą' => 'a', 'ś' => 's', 'ł' => 'l', 'ż' => 'z', 'ź' => 'z', 'ć' => 'c', 'ń' => 'n', 
							'Ę' => 'E', 'Ó' => 'O', 'Ą' => 'A', 'Ś' => 'S', 'Ł' => 'L', 'Ż' => 'Z', 'Ź' => 'Z', 'Ć' => 'C', 'Ń' => 'N'
					);
		return strtr($str, $replace);
		
	}
	
}
?>