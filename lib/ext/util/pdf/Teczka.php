<?php

class Teczka {
	private $indent = 10; 		// wcięcie dla punktacji
	private $kandydat;
	
	public function __construct($kandydat) {
		$this->kandydat = $kandydat;
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
		$pdf->SetFont('serif','',12);
		//$pdf->Bold(); // włączam pogrubienie
		$pdf->Cell($pageWidth, 5, $this->kandydat->getNazwisko(), 0,1,'L');
		$pdf->SetFont('serif','',7);
		$pdf->Cell($pageWidth, 1, '    nazwisko', 0,1,'J');
		$pdf->SetFont('serif','',12);
		$pdf->Ln(5);//odstęp w pionie
		$pdf->Cell($pageWidth, 5, $this->kandydat->getImiona(), 0,1,'L');
		$pdf->SetFont('serif','',7);
		$pdf->Cell($pageWidth, 1, '    imiona', 0,1,'J');
		
		$pdf->Ln(40);//odstęp w pionie
		
		$pdf->SetFont('serif','',16);
		$pdf->Bold();
		$pdf->Cell($pageWidth, 5, 'Kierunek: ' . strtoupper($this->kandydat->getKierunek()), 0,1,'L');
		$pdf->Ln(5);//odstęp w pionie
		$pdf->Cell($pageWidth, 5, '            Tryb: ' . $this->kandydat->getStacjonarneString(), 0,1,'L');		
		$pdf->SetFont('serif','',10);		
		$pdf->Unbold();
		$pdf->buffer = htmlspecialchars_decode($pdf->buffer);
		if ($fileName == null)
			$pdf->Output();
		else
			$pdf->Output($fileName, "F");
	}	
}