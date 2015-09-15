<?php
class BankTransferGenerator {

	private $title;
	private $sender;
	private $receiver;
	private $amount;
	private $accont;
	private $bgFile;
	private $fontFile;

	private $quantity = 2;

	private $walut = 'pln';
	private $pelna = 'ZL';

	private $linie = array (
		30,
		63,
		95,
		127,
		156,
		189,
		220,
		251,
		282
	);

	private $jed = array (
		'',
		'jeden',
		'dwa',
		'trzy',
		'cztery',
		'piec',
		'szesc',
		'siedem',
		'osiem',
		'dziewiec'
	);
	private $dzi = array (
		'',
		'dziesiec',
		'dwadziescia',
		'trzydziesci',
		'czterdziesci',
		'piecdziesiat',
		'szescdziesiat',
		'siedemdziesiat',
		'osiemdziesiat',
		'dziewiecdziesiat'
	);
	private $set = array (
		'',
		'sto',
		'dwiescie',
		'trzysta',
		'czterysta',
		'piecset',
		'szescset',
		'siedemset',
		'osiemset',
		'dziewiecset'
	);

	private $nas = array (
		'',
		'jedenascie',
		'dwanascie',
		'trzynascie',
		'czternascie',
		'pietnascie',
		'szestnascie',
		'siedemnascie',
		'osiemnascie',
		'dziewietnascie'
	);

	private $zm = array (
		'ł' => 'l',
		'ą' => 'a',
		'ś' => 's',
		'ć' => 'c',
		'ó' => 'o',
		'ń' => 'n',
		'ż' => 'z',
		'ź' => 'z',
		'ę' => 'e',
		'Ą' => 'a',
		'Ś' => 's',
		'Ż' => 'z',
		'Ł' => 'l',
		'Ć' => 'c',
		'Ó' => 'o',
		'Ń' => 'n',
		'Ź' => 'z'
	);

	/**
	 * @param string $bg - obrazek tła
	 * @param string $font - plik fontów
	 * @param string $t - tytuł przelewu
	 * @param string $s - zleeniodawca
	 * @param string $r - odbiorca
	 * @param string $a - kwota w formacie xx,xx
	 * @param string $no - nr rachunku
	 */
	public function __construct($bg, $font, $t, $s, $r, $a, $no) {
		$this->title = $t;
		$this->sender = $s;
		$this->receiver = $r;
		$this->amount = $a;
		$this->bgFile = $bg;
		$this->account = $no;
		$this->fontFile = $font;
	}

	public function setQuantity($q) {
		$this->quantity = $q;
	}

	private function putText($txt, $black, $l, $im, $graf = 0, $s = 0) {
		$p = 0;
		$txt = strtoupper(substr(strtr($txt, $this->zm), 0, 54));
		for ($i = 0; $i < strlen($txt); $i++) {
			if ($i == 27) {
				$p = 0;
				++ $l;
			}
			if (array_key_exists($l, $this->linie))
				imagettftext($im, 15, 0, 50 + (($p + $s) * 19), $this->linie[$l] + ($graf * 395), $black, $this->fontFile, $txt[$i]);
			$p++;
		}
	}

	public function generate() {
		$ile = str_replace('.', ',', $this->amount);
		$im = imagecreate(610, 395 * $this->quantity);
		$bg = imagecreatefrompng($this->bgFile);
		for ($i = 0; $i <= $this->quantity; $i++) {
			imagecopy($im, $bg, 0, 0 + (395 * $i), 0, 0, 610, 395);
		}
		imagedestroy($bg);

		$white = imagecolorallocate($im, 255, 255, 255);
		$black = imagecolorallocate($im, 0, 0, 0);

		$p = 0;
		$l = 0;

		$kwota = explode(',', $ile);
		$calosc = (int) $kwota[0];
		$reszta = (int) $kwota[1];

		if (function_exists('str_split')) {
			$cyfry = str_split($calosc, 1);
		} else {
			$cyfry = array ();

			$cal = (string) $calosc;

			for ($i = 0; $i < strlen($cal); $i++) {
				$cyfry[] = $cal {
					$i };
			}
		}
		$slownie = '';
		switch (count($cyfry)) {
			case 1 :
				$cyfry[0] = $this->jed[$cyfry[0]];
				break;
			case 2 :
				if ($cyfry[0] == 1) {
					$cyfry[0] = '';
					$cyfry[1] = $this->nas[$cyfry[1]];
				} else {
					$cyfry[0] = $this->dzi[$cyfry[0]];
					$cyfry[1] = $this->jed[$cyfry[1]];
				}
				break;
			case 3 :
				$cyfry[0] = $this->set[$cyfry[0]];
				if ($cyfry[1] == 1) {
					$cyfry[1] = '';
					$cyfry[2] = $this->nas[$cyfry[2]];
				} else {
					$cyfry[1] = $this->dzi[$cyfry[1]];
					$cyfry[2] = $this->jed[$cyfry[2]];
				}
				break;
			case 4 :
				if ($cyfry[0] == 1) {
					$cyfry[0] = 'tysiac';
				} else {
					if ($cyfry[0] <= 4) {
						$cyfry[0] = $this->jed[$cyfry[0]] . ' tysiace';
						;
					} else {
						$cyfry[0] = $this->jed[$cyfry[0]] . ' tysiecy';
						;
					}
				}

				$cyfry[1] = $this->set[$cyfry[1]];
				if ($cyfry[2] == 1) {
					$cyfry[2] = '';
					$cyfry[3] = $this->nas[$cyfry[3]];
				} else {
					$cyfry[2] = $this->dzi[$cyfry[2]];
					$cyfry[3] = $this->jed[$cyfry[3]];
				}
				break;
			default :
				$cyfry = array (
					$calosc
				);
				break;
		}

		$slownie = str_replace(array (
			'  ',
			0
		), array (
			' ',
			''
		), strtoupper(implode(' ', $cyfry)));

		for ($i = 0; $i <= $this->quantity; $i++) {
			$this->putText($this->receiver, $black, 0, $im, $i);
			$this->putText($this->account, $black, 2, $im, $i);

			$this->putText($this->walut, $black, 3, $im, $i, 11);
			$this->putText($ile, $black, 3, $im, $i, 15);

			$this->putText($this->sender, $black, 5, $im, $i);
			$this->putText($this->title, $black, 7, $im, $i);

			imagettftext($im, 13, 0, 49, $this->linie[4] + ($i * 395), $black,  $this->fontFile, $slownie . ' ' . $this->pelna . ' ' . $reszta . '/100 GR');
		}

		//header('Content-type: image/png');
		imagepng($im);
		imagedestroy($im);

	}
}