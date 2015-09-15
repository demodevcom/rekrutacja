<?php

class Prosba {
	public $data = array();
	private $indent = 10; 		// wcięcie dla punktacji
	private $kandydat;
	
	public function __construct($kandydat) {
		$this->kandydat = $kandydat;
		$this->data[] = 'Sucha Beskidzka, dnia ';
		$this->data[] = 'imię i nazwisko';
		$this->data[] = 'adres';
		$this->data[] = 'Nr telefonu/email';
		$this->data[] = 'DZIEKAN';
		$this->data[] = 'Wydziału $WYDZIAŁ$';
		$this->data[] = 'Wyższej Szkoły Turystyki i Ekologii';
		$this->data[] = 'w Suchej Beskidzkiej';
		$this->data[] = 'Zwracam się z prośbą o przyjęcie na studia: $TYP$';
		$this->data[] = 'Kierunek: $KIERUNEK$';
		$this->data[] = 'Tryb: $TRYB$';
		$this->data[] = 'podpis';
	}
	
	public function generate($pdf, $fileName = null) {
	  	$pdf->SetUTF8(true);		
		$pdf->Open();
		$pdf->SetAutoPageBreak(true, 18); // automatyczne łamanie strony przy ustawieniu dolnego marginesu.
	    $pdf->SetMargins(24, 24, 24);
		$pdf->AddPage();
		$pdf->AliasNbPages(); 
		
		// określa dla rozmiaru strony A4 określa szerokość tekstu pomiędzy marginesami
		$pageWidth =  210 - $pdf->lMargin - $pdf->rMargin;
			
		$pdf->SetStyle("akb","serif","B",9,"0,0,0"); // ustawia styl czcionki dla danego znacznika (krój, wielkość, kolor)
		$pdf->SetFont('serif','',10);
		//$pdf->Bold(); // włączam pogrubienie
		$pdf->Cell($pageWidth, 5, $this->data[0] . date('Y-m-d'), 0,1,'R');//Sucha Beskidzka dnia
		$pdf->Ln(20);//odstęp w pionie
		$pdf->Cell($pageWidth, 4, $this->kandydat->getImiona() . ' ' . $this->kandydat->getNazwisko(), 0,1,'J');
		$pdf->SetFont('serif','',7);
		$pdf->Cell($pageWidth, 1, $this->data[1], 0,1,'J');
		$pdf->SetFont('serif','',10);
		$pdf->Ln(2);
		if (strlen($this->kandydat->getZameldowanieUlica()) > 0)
			$pdf->Cell($pageWidth, 4, $this->kandydat->getZameldowanieUlica() . ' ' . $this->kandydat->getZameldowanieDomNr() . (strlen($this->kandydat->getZameldowanieMieszkanieNr()) > 0 ? '/'.$this->kandydat->getZameldowanieMieszkanieNr() : ''), 0,1,'J');
		else
			$pdf->Cell($pageWidth, 4, $this->kandydat->getZameldowanieMiasto() . ' ' . $this->kandydat->getZameldowanieDomNr() . (strlen($this->kandydat->getZameldowanieMieszkanieNr()) > 0 ? '/'.$this->kandydat->getZameldowanieMieszkanieNr() : ''), 0,1,'J');
		$pdf->SetFont('serif','',7);
		$pdf->Cell($pageWidth, 1, $this->data[2], 0,1,'J');
		$pdf->SetFont('serif','',10);		
		$pdf->Ln(2);
		$pdf->Cell($pageWidth, 4, $this->kandydat->getZameldowanieKod() . ' ' . $this->kandydat->getZameldowanieMiasto(), 0,1,'J');		
		$pdf->Cell($pageWidth, 5, $this->kandydat->getTelefonNr() . '/' . $this->kandydat->getEmail(), 0,1,'J');
		$pdf->SetFont('serif','',7);
		$pdf->Cell($pageWidth, 2, $this->data[3], 0,1,'J');
		$pdf->SetFont('serif','',12);
		$pdf->Ln(10);		
		$pdf->Bold();
		$pdf->Cell($pageWidth, 5, $this->data[4], 0,1,'R');
		$wydzial = strtoupper($this->kandydat->getKierunek());
		if ($wydzial == 'POLITOLOGIA')
			$wydzial = 'NAUK SPOŁECZNYCH';
		$pdf->Cell($pageWidth, 5, str_replace('$WYDZIAŁ$', $wydzial, $this->data[5]), 0,1,'R');
		$pdf->Cell($pageWidth, 5, $this->data[6], 0,1,'R');
		$pdf->Cell($pageWidth, 5, $this->data[7], 0,1,'R');
		$pdf->SetFont('serif','',10);		
		$pdf->Ln(15);
		$pdf->Unbold();
		sfContext :: getInstance()->getLogger()->debug('Typ studiów: ' .  $this->kandydat->getStudiaTyp());
		$typ = $this->kandydat->getStudiaTyp() == 'mgr' ? 'magisterskie' : 'licencjackie/inżynierskie';
		$pdf->Cell($pageWidth, 5, '    ' . str_replace('$TYP$', $typ, $this->data[8]), 0,1,'J');				
		$pdf->Cell($pageWidth, 5, str_replace('$KIERUNEK$', $this->kandydat->getKierunek(), $this->data[9]), 0,1,'J');		
		$tryb = $this->kandydat->getStacjonarneString();
 		$pdf->Cell($pageWidth, 5, str_replace('$TRYB$', $tryb, $this->data[10]), 0,1,'J');		
		$pdf->Ln(15);
 		$pdf->Cell($pageWidth, 5, '......................................', 0,1,'R');		
		$pdf->SetFont('serif','',7);		
 		$pdf->Cell($pageWidth, 2, '                     podpis           ', 0,1,'R');		
				
		
		$pdf->buffer = htmlspecialchars_decode($pdf->buffer);
		if ($fileName == null)
			$pdf->Output();
		else
			$pdf->Output($fileName, "F");
	}	
}