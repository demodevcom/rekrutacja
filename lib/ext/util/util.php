<?php

if (!function_exists("utl_dump_array")) { //zabezpieczenie przed wilokrotnym includem

function getMicrotime() {
	list($usec, $sec) = explode(" ", microtime());
	return ((float) $usec + (float)$sec);
}

function utl_dump_array($title, $var) {
	switch (strtolower(gettype($var))) {
		case 'integer':
		case 'double':
		case 'boolean':
		case 'bool':
		case 'string':
			echo $var;
		break;
		case 'null':
			echo 'null';
		break;
		case 'array':
			echo '<table border = "1">' . "\n";
			echo "<CAPTION ALIGN=top>" . $title . "</CAPTION>" . "\n";
			//while ( list($key, $val) = each($var) ) {
			foreach ($var as $key=>$val) {	
				echo '<tr><td align = "left" valign = "top">' . "\n";
				echo $key;
				echo '</td><td>' . "\n";
				utl_dump_array("",$val);
				echo '</td></tr>' . "\n";
			}
			echo '</table>' . "\n";
		break;
		case 'object':
			echo '<table border = "1">' . "\n";
			echo "<CAPTION ALIGN=top>" . $title . "</CAPTION>" . "\n";
			//while ( list($key, $val) = each($var) ) {
			foreach ($var as $key=>$val) {	
				echo '<tr><td align = "left" valign = "top">' . "\n";
				echo $key;
				echo '</td><td>' . "\n";
				echo $val;
				utl_dump_array("",$val);
				echo '</td></tr>' . "\n";
			}
			echo '</table>' . "\n";		
		break;
		default:
			echo 'Unknown data type.';
		break;
	}
}

function utl_dump_array2string($title, $var) {
	$ret = '';
	switch (gettype($var)) {
		case 'integer':
		case 'double':
		case 'boolean':
		case 'bool':
		case 'string':
			$ret .= $var;
		break;
		case 'NULL':
			$ret .= 'null';
		break;		
		case 'array':
			$ret .= '<table border = "1">' . "\n";
			$ret .= "<CAPTION ALIGN=top>" . $title . "</CAPTION>" . "\n";
			while ( list($key, $val) = each($var) ) {
				$ret .= '<tr><td align = "left" valign = "top">' . "\n";
				$ret .= $key;
				$ret .= '</td><td>' . "\n";
				$ret .= utl_dump_array2string(" ",$val);
				$ret .= '</td></tr>' . "\n";
			}
			$ret .= '</table>' . "\n";
		break;
		default:
			$ret .= 'Unknown data type.';
		break;
	}
	return $ret;
}

/**
 * Formatuje nr rachunku bankowego
 */
function utl_format_bank_no($nr) {
	$formatted = substr($nr, 0, 2);
	$split = str_split(substr($nr, 2), 4);
	foreach ($split as $four)
		$formatted .= ' ' . $four;
	return $formatted;
}

function utl_getextension($str, $sep='.') {		
	return strrchr($str, $sep);
}


function utl_geturlfile($url) {
	if (strpos($url, '/') > 0 )
		return strrchr($url, '/');
	else
		return $url;
}

/**
 * Zwraca pierwszy leksem z stringu.
 */
function utl_firsttoken($str, $sep = ' ') {
	$pos = strpos($str, $sep);
	if (!$pos)
		return $str;
	else
		return substr($str, 0, $pos);	
}

function utl_getfilename($str) {
	return substr($str, 0, strlen($str)-4);	
} 

function utl_readINIfile ($filename, $commentchar) {
	if (!file_exists($filename))
		return false;
	$array1 = file($filename);
	$section = '';
	foreach ($array1 as $filedata) {
		$dataline = trim($filedata);
		$firstchar = substr($dataline, 0, 1);
		if ($firstchar!=$commentchar && $dataline!='') {
			//It's an entry (not a comment and not a blank line)
			if ($firstchar == '[' && substr($dataline, -1, 1) == ']') {
				//It's a section
				$section = strtolower(substr($dataline, 1, -1));
			}
			else {
				//It's a key...
				$delimiter = strpos($dataline, '=');
				if ($delimiter > 0) {
					//...with a value
					$key = strtolower(trim(substr($dataline, 0, $delimiter)));
					$value = trim(substr($dataline, $delimiter + 1));
					if (substr($value, 1, 1) == '"' && substr($value, -1, 1) == '"') {
						$value = substr($value, 1, -1);
					}
					$array2[$section][$key] = stripcslashes($value);
				}
				else {
						//...without a value
						$array2[$section][strtolower(trim($dataline))]='';
				}
			}
		}
		else{
			//It's a comment or blank line.  Ignore.
		}
	}
	return $array2;
}

/**
 * Metoda czyta plik ini nie interpretujc nazw sekcji - wstawia sekcje 
 * kolejno do tablicy, numerujac je od.
 */
function utl_readMultiINIfile ($filename, $commentchar) {
	if (!file_exists($filename))
		return false;
	$array1 = file($filename);
	$section = '';
	$sectionNum = 0;			// id sekcji
	foreach ($array1 as $filedata) {
		$dataline = trim($filedata);
		$firstchar = substr($dataline, 0, 1);
		if ($firstchar!=$commentchar && $dataline!='') {
			//It's an entry (not a comment and not a blank line)
			if ($firstchar == '[' && substr($dataline, -1, 1) == ']') {
				//It's a section
				$section = $sectionNum;
				$sectionNum++;
			}
			else {
				//It's a key...
				$delimiter = strpos($dataline, '=');
				if ($delimiter > 0) {
					//...with a value
					$key = strtolower(trim(substr($dataline, 0, $delimiter)));
					$value = trim(substr($dataline, $delimiter + 1));
					if (substr($value, 1, 1) == '"' && substr($value, -1, 1) == '"') {
						$value = substr($value, 1, -1);
					}
					$array2[$section][$key] = stripcslashes($value);
				}
				else {
					//...without a value
					$array2[$section][strtolower(trim($dataline))]='';
				}
			}
		}
		else{
			//It's a comment or blank line.  Ignore.
		}
	}
	return $array2;
}

function utl_writeINIfile ($filename, $array1, $commentchar, $commenttext) {
	$handle = fopen($filename, 'wb');
	if ($commenttext!='')	{
		$comtext = $commentchar.
		str_replace(	$commentchar, "\r\n".$commentchar,
						str_replace (	"\r", $commentchar,
										str_replace(	"\n", $commentchar,
														str_replace(	"\n\r", $commentchar,
																		str_replace("\r\n", $commentchar, $commenttext)
														)
										)
						)
					);
		if (substr($comtext,	-1,	1)==$commentchar &&	substr($comtext, -1, 1)!=$commentchar)
			$comtext =	substr($comtext, 0,	-1);		
		fwrite ($handle,	$comtext."\r\n");
	}
	foreach ($array1 as $sections	=> $items) {
		//Write the section
		if (isset($section))
			fwrite ($handle, "\r\n");
		//$section =	ucfirst(preg_replace('/[\0-\37]|[\177-\377]/', "-",	$sections));
		$section	= ucfirst(preg_replace('/[\0-\37]|\177/', "-", $sections));
		fwrite ($handle,	"[".$section."]\r\n");
		foreach ($items as $keys	=> $values)	{
			//Write the key/value pairs
			//$key	= ucfirst(preg_replace('/[\0-\37]|=|[\177-\377]/', "-",	$keys));
			$key =	ucfirst(preg_replace('/[\0-\37]|=|\177/', "-", $keys));
			if	(substr($key, 0, 1)==$commentchar)
				$key =	'-'.substr($key, 1);
			$value	= ucfirst(addcslashes($values,''));
			fwrite	($handle, '	   ' . $key . '	= ' . $value . "\r\n");
		}
	}
	fclose($handle);
}

function utl_getNameOfTheDay() {
	$day = date("D");
	return day2Dzien($day);
}

function utl_getNameOfTheMonth() {
	$month = date("m");
	$zwr = 'stycznia';
	switch ($month) {
		case '01':	$zwr = 'stycznia';
		break;
		case '02':	$zwr = 'lutego';
		break;
		case '03':	$zwr = 'marca';
		break;
		case '04':	$zwr = 'kwietnia';
		break;
		case '05':	$zwr = 'maja';
		break;
		case '06':	$zwr = 'czerwca';
		break;
		case '07':	$zwr = 'lipca';
		break;
		case '08':	$zwr = 'sierpnia';
		break;
		case '09':	//$zwr = 'wrze&#347nia';
			$zwr = 'września';
		break;
		case '10':	//$zwr = 'pa&#378dziernika';
			$zwr = 'października';
		break;
		case '11':	$zwr = 'listopada';
		break;
		case '12':	$zwr = 'grudnia';
		break;
		default:	$zwr = 'stycznia';
	}
	return $zwr;
}

function utl_formatdate($str) {
	$time = strtotime($str);
	return date('Y', $time) . '-' . date('m', $time) . '-' . date('d', $time) . ' ' . date('H:i', $time);	
}


/**
 * Ile elementow (wartosci) drugiej tablicy wyst?puje w pierwszej tablicy jako wartosc. Jesli 3 patametr
 * = true to jak klucz tez. 
 * 
 */
function utl_array_in_array($arr1, $arr2, $keyalso=false) {
	$zwr = 0;
	foreach ($arr2 as $value) {
		if ($keyalso) {
			//nie liczymy podw?jnie jak klucz i wartosc jest taka sama
			if (array_key_exists($value, $arr1))
				$zwr++;
			else
			if (in_array ($value, $arr1))
				$zwr++;					
		}
		else {
			if (in_array ($value, $arr1))
				$zwr++;		
		}
	}
	return $zwr;
}
 

function utl_date_diff($earlierDate, $laterDate) {
	$earlierDate = strtotime($earlierDate);
	$laterDate = strtotime($laterDate);
	$ret = array('days'=>0,'hours'=>0,'minutes'=>0,'seconds'=>0);
	$totalsec = $laterDate - $earlierDate;
	if ($totalsec >= 86400) {
	$ret['days'] = floor($totalsec/86400);
	$totalsec = $totalsec % 86400;
	}
	if ($totalsec >= 3600) {
	$ret['hours'] = floor($totalsec/3600);
	$totalsec = $totalsec % 3600;
	}
	if ($totalsec >= 60) {
	$ret['minutes'] = floor($totalsec/60);
	}
	$ret['seconds'] = $totalsec % 60;
	return $ret;
}

function utl_date_add($date, $days, $hours = 0, $minutes = 0, $format='Y-m-d H:i:s') {
	$t0 = strtotime($date);
	$t1 = $t0 + $days*86400 + $hours*3600 + $minutes*60;
	return date($format, $t1);
}

/**
 * Kasuje zawartosc podanego katalogu pliki podanego typu starsze niz jedna godzina od teraz.
 * domy?lnie aktualna data: date("Y-m-d")
 */
function utl_rmdir2($dir, $ext) {
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				//echo "filename: $file : " . "<br>\n";
				$diff = utl_date_diff(date ("Y-m-d H:i", @filemtime($file)), date ("Y-m-d H:i"));
				if (utl_getextension($file) == $ext && $diff['days']*24+$diff['hours'] > 1)
					unlink($dir . '/' . $file);
			}
			closedir($dh);
		}
	}	
}

function utl_rmdir($dir, $ext) {
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if (utl_getextension($file) == $ext)
					unlink($dir . '/' . $file);
			}
			closedir($dh);
		}
	}	
}

function utl_lsdir($dir) {
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				echo "filename: $file : " . ', last modified: ' . date ("Y-m-d H:i", @filemtime($file)) . "<br>\n";
				$diff = utl_date_diff(date ("Y-m-d H:i", @filemtime($file)), date ("Y-m-d H:i"));
				echo 'Roznica od teraz, dni: ' . $diff['days'] . ', godziny: ' . $diff['hours']. '<br>';
			}
			closedir($dh);
		}
	}		
}



function utl_isgraphicsextension($ext) {
	$ext = strtolower($ext);
	$imgarr = array(1 => '.jpg', 2 => '.gif', 3 => '.png', 4 => '.bmp', 5 => '.tif', 6 => '.jpeg');
	//array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');
	$result = array_search($ext, $imgarr);
	//utl_p("Result: $result"	
	if (array_search($ext, $imgarr) == false)
		return false;
	return true;
}
 
function utl_day2Dzien($day) {
	$zwr = 'niedziela';
	switch($day) {
		case 0:
			$zwr = 'niedziela';
		break;
		case 1:
		case 'Mon':
			$zwr = 'poniedziałek';
		break;
		case 2:
		case 'Tue':
			$zwr = 'wtorek';
		break;
		case 3:
		case 'Wed': //$zwr = '&#347roda';
			$zwr = 'środa';
		break;
		case 4:
		case 'Thu':
			$zwr = 'czwartek';
		break;
		case 5:
		case 'Fri': //$zwr = 'pi&#261tek';
			$zwr = 'piątek';
		break;
		case 6:
		case 'Sat':
			$zwr = 'sobota';
		break;
		case 7:
		case 'Sun':
			$zwr = 'niedziela';
		break;
		default:
			$zwr = 'niedziela';
	}
	return $zwr;
}

function utl_spaceposition($text, $nr) {
	if ($nr < strlen($text))
		$pos = strpos ($text, ' ', $nr-10); //znajduje spacj? w tekscie
	else
		$pos = strlen($text);
	return $pos;
}

 function o($m) {
 	echo("<br><b>[" . $m . "]</b><br>");
 };
 
 function utl_make_date($year, $month, $day) {
 	if ($month < 10) $month = "0$month";
 	if ($day < 10) $day = "0$day";
 	if ($month == 2 && $day > 29) $day = 29;
 	return "$year-$month-$day";	
 }
  
 function utl_tokenize_date($date) {
 	return array( 'year' => substr($date, 0, 4), 'month' => substr($date, 5, 2), 'day' => substr($date, 8, 2));	
 }
 
 function utl_joinarray($a) {
  $re=preg_replace('/[+]+$/','',join("+",$a));
  return preg_replace('/[+]+/','+',$re);
 };
 
 function utl_getarray($from,$to, $order='ASC') {
	$re = array();
	if ($to < $from) {
		return null;
	};
	if ($order != 'DESC') {
		for($i=$from;$i<=$to;$i++)
			$re[]=$i;
	}
	else {
		for($i=$to;$i>=$from;$i--)
			$re[]=$i;		
	}
	return $re;
 };


function utl_replacepolish($str) {
	$polish = array('ą', 'ę', 'ś', 'ć', 'ż', 'ź', 'ń', 'ó', 'ł', 'Ą', 'Ę', 'Ś', 'Ć', 'Ż', 'Ź', 'Ń', 'Ó', 'Ł');
	$replace = array('a', 'e', 's', 'c', 'z', 'z', 'n', 'o', 'l', 'A', 'E', 'S', 'C', 'Z', 'Z', 'N', 'O', 'L');
	return str_replace($polish, $replace, $str);	
}

 
 function utl_log($message, $file=null, $logdir=null) {
 	if ($file != null)
 		$file = basename($file);
 	else 
 		$file = "log";
 	if ($logdir == null) 
 		$logdir = getcwd() . "/log";
 	$fh = fopen($logdir . "/" . $file,"a+");
 	fwrite($fh, date("c") . ": " . $message . "\n");
 	fclose($fh);
 };
  
 function makenumber($str) {
 	return preg_replace('/[^0-9]/','',$str);
 };


/**
 * zwraca w jednej tablicy zawartość tablic get oraz post.
 */
 function getPostGetArrays() {
 	$POST_GET = array();
 	if (isset($_GET))
		foreach ($_GET as $key => $value)
			$POST_GET[$key] = $value;
	if (isset($_POST))
		foreach ($_POST as $key => $value)
			$POST_GET[$key] = $value;
	return $POST_GET;
 }

 function utl_writefile($fileName, $contents) {
 	if ($contents == null || strlen($contents) == 0)
 		return false;
 	$handle = fopen($fileName, 'w');
 	if ($handle) {
 		$bytes = fwrite($handle, $contents);
 		fclose($handle);
 		return $bytes;	
 	}
 	return false;
 }

 function utl_format_telephone_nr($number) {
	$old_number = $number ;
	$number = preg_replace('/[^0-9]/','',$number) ;
	$number = preg_replace('/^0+/','',$number) ;
	if(strlen($number) < 9)
		return -1 ;// Za krótki numer
	if(strlen($number) == 9)
		return '48'.$number ;
	if(strlen($number) == 11)
		return $number ;
	else
		return -2 ;// Błędny format ;
 }
 
}//if z poczatku
  
?>