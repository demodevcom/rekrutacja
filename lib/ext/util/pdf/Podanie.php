<?php
class Podanie {
	
	private $indent = 10; 		// wcięcie dla punktacji
	private $kandydat;
	
	public function __construct($kandydat) {
		$this->kandydat = $kandydat;
	}
	
	public function generateMsc($pdf, $fileName = null) {
	  	$pdf->SetUTF8(true);		
		$pdf->Open();
		$pdf->SetAutoPageBreak(true, 18); // automatyczne łamanie strony przy ustawieniu dolnego marginesu.
	    $pdf->SetMargins(24, 24, 24);
		$pdf->AddPage();
		$pdf->AliasNbPages(); 
		$pdf->setFillColor(255, 255, 255);
		// określa dla rozmiaru strony A4 określa szerokość tekstu pomiędzy marginesami
		$pageWidth =  210 - $pdf->lMargin - $pdf->rMargin;
			
		$pdf->SetStyle("akb","serif","B",9,"0,0,0"); // ustawia styl czcionki dla danego znacznika (krój, wielkość, kolor)
		$pdf->SetFont('serif','',12);	
		$pdf->Cell($pageWidth, 5, 'Nr faktury: .........................        Sucha Beskidzka, dnia ' . date('Y-m-d'), 0,1,'J');
		$pdf->Ln(10);
		$pdf->SetFont('serif','',12);	
		$pdf->Bold();
		$pdf->Cell($pageWidth, 5, 'Dziekan WSTiE', 0,1,'R');
		$pdf->Cell($pageWidth, 5, 'w Suchej Beskidzkiej', 0,1,'R');				
		$pdf->Ln(10);
		$pdf->SetFont('serif','',16);
		$pdf->Cell($pageWidth, 5, 'FORMULARZ ZGŁOSZENIOWY', 0,1,'C');							
		$pdf->Cell($pageWidth, 5, 'STUDIA II STOPNIA', 0,1,'C');							
		$pdf->Cell($pageWidth, 5, 'Rok akademicki ' . date('Y') . '/' . (((int)date('y'))+1), 0,1,'C');							
		$pdf->Unbold();
		$pdf->Ln(4);
		$pdf->SetFont('serif','',12);	
		$pdf->SetDrawColor(0, 0, 0);
		//wyrysowanie tabelki
		for($y = 0; $y<4; $y++) //poziome linie
			$pdf->Line($pdf->lMargin, $pdf->getY()+15*$y, $pdf->lMargin + $pageWidth, $pdf->getY()+15*$y);
		$pdf->Line($pdf->lMargin, $pdf->getY(), $pdf->lMargin, $pdf->getY()+45);
		$pdf->Line($pdf->lMargin+$pageWidth, $pdf->getY(), $pdf->lMargin+$pageWidth, $pdf->getY()+45);		
		for($x = 0; $x<4; $x++) //pionowe linie, pełna wysokość tabelki
			$pdf->Line($pdf->lMargin + $pageWidth/8*3 + $x*$pageWidth/8, $pdf->getY(), $pdf->lMargin + $pageWidth/8*3 + $x*$pageWidth/8, $pdf->getY()+45);
		//ostatnie 3 pionowe linie
		$pdf->Line($pdf->lMargin + $pageWidth/8, $pdf->getY()+15, $pdf->lMargin + $pageWidth/8, $pdf->getY()+45);
		$pdf->Line($pdf->lMargin + $pageWidth/4, $pdf->getY()+15, $pdf->lMargin + $pageWidth/4, $pdf->getY()+45);
		$pdf->Line($pdf->lMargin + $pageWidth/8*7, $pdf->getY()+15, $pdf->lMargin + $pageWidth/8*7, $pdf->getY()+45);
		//wypisanie tektów w tabelce
		$pdf->SetFont('serif','',8);
		$pdf->Bold();	
		$pdf->Cell($pageWidth/8*3, 5, 'Wypełnia dziekanat WSTiE', 0,0,'L');							
		$pdf->Unbold();
		$pdf->Cell($pageWidth/8*2, 4, 'Data', 0,0,'L');
		$pdf->Cell($pageWidth/8*3, 4, 'Nr albumu', 0,0,'L');
		$pdf->Ln();							
		//ustawiamy wcięcie
		$pdf->SetX($pdf->lMargin + $pageWidth/8*3);
		$pdf->Cell($pageWidth/8*2, 4, 'wpływu', 0,0,'L');
		$pdf->Cell($pageWidth/8*3, 4, 'Jeżeli był', 0,0,'L');
		$pdf->Ln();							
		$pdf->SetX($pdf->lMargin + $pageWidth/8*5);
		$pdf->Cell($pageWidth/8*3, 4, 'st. WSTiE', 0,0,'L');
		$pdf->Ln(8);
		$pdf->Cell($pageWidth/8*2, 4, 'Świadectwo', 0,0,'L');	
		$pdf->Cell($pageWidth/8*2, 4, 'Zdjęcia', 0,0,'L');
		$pdf->Cell($pageWidth/8*2, 4, 'Ks. wojsk.', 0,0,'L');
		$pdf->Cell($pageWidth/8*2, 4, 'Dyplom', 0,0,'L');
		$pdf->Ln();
		$pdf->Cell($pageWidth/8*4, 4, 'maturalne', 0,0,'L');	
		$pdf->Cell($pageWidth/8*2, 4, '/ksero/', 0,0,'L');	
		$pdf->Cell($pageWidth/8*2, 4, 'uk. st. I', 0,0,'L');	
		$pdf->Ln();
		$pdf->SetX($pdf->lMargin + $pageWidth/8*6);
		$pdf->Cell($pageWidth/8*2, 4, 'stopnia', 0,0,'L');	
		$pdf->Ln(8);
		$pdf->Cell($pageWidth/8*2, 4, 'Dowód osob.', 0,0,'L');	
		$pdf->Cell($pageWidth/8*2, 4, 'Opłata', 0,0,'L');
		$pdf->Cell($pageWidth/8*2, 4, 'Zaśw. od ', 0,0,'L');
		$pdf->Cell($pageWidth/8*2, 4, 'Życiorys/CV', 0,0,'L');
		$pdf->Ln();
		$pdf->Cell($pageWidth/8*2, 4, '/ksero/', 0,0,'L');	
		$pdf->Cell($pageWidth/8*2, 4, 'wpisowa', 0,0,'L');
		$pdf->Cell($pageWidth/8*2, 4, 'lekarza', 0,0,'L');
		$pdf->Ln(20);
		//punktowany tekst			
		$pdf->SetFont('serif','',12);
		$pdf->Bold();
		$pdf->Cell($pageWidth, 7, '1. Tryb studiów: ' . mb_strtoupper($this->kandydat->getStacjonarneString(), 'utf-8'), 0,1,'L');							
		$pdf->Unbold();
								
		$pdf->Bold();
		$pdf->Cell($pageWidth, 7, '2. Interesuje mnie specjalność: ' . mb_strtoupper($this->kandydat->getSpecjalnoscString(), 'utf-8'), 0,1,'L');							
		$pdf->Unbold();
									
		$pdf->Bold();
		$pdf->Cell($pageWidth, 7, '3. Dane personalne', 0,1,'L');							
		$pdf->Unbold();
		$pdf->SetX($pdf->lMargin + $this->indent);
		$pdf->Cell(($pageWidth-$this->indent)/2, 7, 'a. Nazwisko: ' . $this->kandydat->getNazwisko(), 0,0,'L');							
		$pdf->Cell(($pageWidth-$this->indent)/2, 7, 'Imiona: ' . $this->kandydat->getImiona(), 0,0,'L');							
		$pdf->Ln();
		$pdf->SetX($pdf->lMargin + $this->indent);
		$pdf->Cell(($pageWidth-$this->indent), 7, 'b. Nazwisko panieńskie (u mężatek): ............................................', 0,0,'L');							
		$pdf->Ln();
		
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('4. '), 7, '4. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('4. '), 7, 'Data i miejsce urodzenia: ', 0,1,'L');							
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('4. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('4. '), 7, 'rok: 19' . substr($this->kandydat->getPesel(), 0, 2) . ' miesiąc: ' . substr($this->kandydat->getPesel(), 2, 2) . ' dzień: ' . substr($this->kandydat->getPesel() , 4, 2) . ' w: ' . $this->kandydat->getUrodzenieMiejsce(), 0, 1, 'L');
				
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('5. '), 7, '5. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('5. '), 7, 'Imiona rodziców: ' . $this->kandydat->getMatkaImie() . ' ' . $this->kandydat->getOjciecImie(), 0,1,'L');							
		
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('6. '), 7, '6. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('6. '), 7, 'Adres stałego zameldowania: ', 0,1,'L');							
		$pdf->SetX($pdf->lMargin + $this->indent);
		//$pdf->Cell($pageWidth-$this->indent, 7, 'ulica: ' .  mb_strtoupper($this->kandydat->getZameldowanieUlica(), 'utf-8') . ' ' . $this->kandydat->getZameldowanieDomNr() . '/' . $this->kandydat->getZameldowanieMieszkanieNr(), 0,1,'L');							
		$pdf->SetX($pdf->lMargin + $this->indent);
		$pdf->Cell($pageWidth-$this->indent, 7, 'koda: ' . $this->kandydat->getZameldowanieKod() . ' miejscowość: ' . $this->kandydat->getZameldowanieMiasto(), 0,1,'L');							
		$pdf->SetX($pdf->lMargin + $this->indent);
		$pdf->Cell($pageWidth-$this->indent, 7, 'województwo: ' . $this->kandydat->getZameldowanieWojewodztwo(), 0,1,'L');							
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('7. '), 7, '7. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('7. '), 7, 'Numer telefonu: ' . $this->kandydat->getTelefonNr(), 0,1,'L');							
		if (strlen($this->kandydat->getMobileNr())) {
			$pdf->SetX($pdf->lMargin + $pdf->GetStringWidth('7. '));
			$pdf->Cell($pageWidth-$pdf->GetStringWidth('7. '), 7, 'telefon komorkowy: ' . $this->kandydat->getMobileNr(), 0,1,'L');							
		}

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('8. '), 7, '8. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('8. '), 7, 'Adres email: ' . $this->kandydat->getEmail(), 0,1,'L');							

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('9. '), 7, '9. ', 0,0,'L');							
		$pdf->Unbold();
		if (strlen($this->kandydat->getKorespondencjaMiasto()) > 0 && strlen($this->kandydat->getKorespondencjaDomNr()) > 0) {
			$pdf->Cell($pageWidth - $pdf->GetStringWidth('9. '), 7, 'Adres korespondencyjny:', 0,1,'L');							
			$pdf->SetX($pdf->lMargin + $this->indent);
			$pdf->Cell($pageWidth-$this->indent, 7, 'ulica: ' . mb_strtoupper($this->kandydat->getKorespondencjaUlica(), 'utf-8') . ' ' . $this->kandydat->getKorespondencjaDomNr() . '/' . $this->kandydat->getKorespondencjaMieszkanieNr(), 0,1,'L');							
			$pdf->SetX($pdf->lMargin + $this->indent);
			$pdf->Cell($pageWidth-$this->indent, 7, 'kod: ' . $this->kandydat->getKorespondencjaKod() . ' miejscowość: ' . $this->kandydat->getKorespondencjaMiasto(), 0,1,'L');							
		}
		else
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('9. '), 7, 'Adres korespondencyjny: taki sam jak zameldowania', 0,1,'L');							

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('10. '), 7, '10. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('10. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('10. '), 7, 'Seria i nr dowodu osobistego: ' . $this->kandydat->getDowodOsobistyNr(), 0, 1, 'L');

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('11. '), 7, '11. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('11. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('11. '), 7, 'PESEL: ' . $this->kandydat->getPesel(), 0, 1, 'L');

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('12. '), 7, '12. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('12. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('12. '), 7, 'NIP: ' . $this->kandydat->getNip(), 0, 1, 'L');

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('13a. '), 7, '13a. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('13a. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('13a. '), 7, 'Ukończona szkoła średnia: ', 0, 1, 'L');
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('13a. '));
		$pdf->MultiCell($pageWidth - $pdf->GetStringWidth('13a. '), 7, $this->kandydat->getSzkolaSrednia(), 0, 1, 'J');
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('13a. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('13a. '), 5, 'Rok ukończenia: ' . $this->kandydat->getSzkolaSredniaRokUkonczenia(), 0, 1, 'L');

		$pdf->SetUTF8(true);

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('13b. '), 7, '13b. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('13b. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('13b. '), 7, 'Ukończone studia I stopnia: ', 0, 1, 'L');
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('13b. '));
		$pdf->MultiCell($pageWidth - $pdf->GetStringWidth('13b. '), 7, $this->kandydat->getSkonczoneStudia(), 0, 1, 'J');
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('13b. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('13b. '), 5, 'Rok ukończenia: ' . $this->kandydat->getSkonczoneStudiaRokUkonczenia(), 0, 1, 'L');

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('14. '), 7, '14. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('14. '));
		$pdf->MultiCell($pageWidth - $pdf->GetStringWidth('14. '), 7, 'Stosunek do służby wojskowej: ' . $this->kandydat->getStosunekDoSluzbyWojskowej(), 0, 1, 'L');
		if ($this->kandydat->getStosunekDoSluzbyWojskowej() == 'uregulowany') {
			$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('14. '));
			$pdf->MultiCell($pageWidth - $pdf->GetStringWidth('14. '), 7, 'Seria i nr książeczki wojskowej: ' . $this->kandydat->getKsiazeczkaWojskowaNr(), 0, 1, 'L');			
		}
			
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('15. '), 7, '15. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('15. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('15. '), 7, 'Renta inwalidzka: ' . ($this->kandydat->getNiepelnosprawny() == '1' ? 'tak':'nie'), 0, 1, 'L');
		if ($this->kandydat->getNiepelnosprawny() == '1') {
			$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('15. '));
			$pdf->Cell($pageWidth - $pdf->GetStringWidth('15. '), 7, 'Grupa: ......................................', 0, 1, 'L');
		}

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('16. '), 7, '16. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('16. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('16. '), 7, 'Informacje o źródle utrzymania kandydata: ............................', 0, 1, 'L');

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('17. '), 7, '17. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('17. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('17. '), 7, 'Nazwa i miejsce zakładu pracy: ...............................................', 0, 1, 'L');
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('17. '), 7, '...................stanowisko: ................................................', 0, 1, 'L');
		
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('18. '), 7, '18. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('18. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('18. '), 7, 'O szkole dowiedziałem się z: ' . $this->kandydat->getSkadWiem(), 0, 1, 'L');
		
		
		//zgoda na przetwarzanie danych
		$pdf->SetFont('serif','',8);
		$pdf->Ln(10);
		$pdf->setX($pdf->lMargin);
		$pdf->Italic();
		$pdf->Cell($pageWidth, 7, 'Wyrażam zgodę na przetwarzanie i wykorzystywanie moich danych osobowych przez Wyższą Szkołę', 0, 1, 'L');
		$pdf->Cell($pageWidth, 7, 'Turystyki i Ekologii dla celów postępowania kwalifikacyjnego i dokumentowania przebiegu', 0, 1, 'L');
		$pdf->Cell($pageWidth, 7, 'zgodnie z art. 6 ustawy z dnia 29.08.97 r. o ochronie danych osobowych', 0, 1, 'L');
		$pdf->Cell($pageWidth, 7, '(Dz. U. z 1997 r. Nr 133 poz 883 z późniejszymi zmianami)', 0, 1, 'L');		
		
		$pdf->Ln(5);
		$pdf->setX($pdf->lMargin);
		$pdf->Italic();
		$pdf->Cell($pageWidth, 7, 'Wyrażam zgodę na umieszczanie zdjęć na stronie internetowej i w materiałach reklamowych WSTE.', 0, 1, 'L');
		$pdf->Cell($pageWidth, 7, 'Prawdziwość danych zawartych w podaniu potwierdzam własnoręcznym podpisem.', 0, 1, 'L');		
		$pdf->Unitalic();

		$pdf->SetFont('serif','',12);		
		$pdf->Ln(10);
		$pdf->setX($pdf->lMargin);
		$pdf->Cell($pageWidth, 7, 'Sucha Beskidzka, dnia: .......................    ............................', 0, 1, 'L');
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('Sucha Beskidzka, dnia: .......................    ....'));
		$pdf->SetFont('serif','',8);
		$pdf->Cell($pageWidth, 7, 'podpis kandydata', 0, 1, 'L');
		
		$pdf->AddPage();
		$pdf->SetFont('serif','',12);
		$pdf->setX($pdf->lMargin);
		$pdf->Bold();
		$pdf->Cell($pageWidth, 7, 'Wypełnić w razie odejścia', 0, 1, 'L');		
		$pdf->Unbold();
		$pdf->Ln(10);
		$pdf->Cell($pageWidth, 7, 'Potwierdzam odbiór', 0, 1, 'L');		
		$pdf->setX($pdf->lMargin + 10);
		$pdf->Cell($pageWidth, 7, '* świadectwa dojrzałości w oryginale z ukończenia', 0, 1, 'L');		
		$pdf->setX($pdf->lMargin + 10);		
		$pdf->Cell($pageWidth, 7, '..........................................................................................', 0, 1, 'L');		
		$pdf->setX($pdf->lMargin + 10);
		$pdf->Cell($pageWidth, 7, 'Miejscowość: ............................. nr świadectwa: ......... z dnia: .............', 0, 1, 'L');		
		$pdf->setX($pdf->lMargin + 10);
		$pdf->Cell($pageWidth, 7, '* oraz indeksu o nr albumu: ................................', 0, 1, 'L');		
		$pdf->setX($pdf->lMargin + 10);
		$pdf->Cell($pageWidth, 7, '* dyplomu /cz.AiB/ z ukończenia st. I stopnia w: ........................................', 0, 1, 'L');		
		$pdf->setX($pdf->lMargin + 10);
		$pdf->Cell($pageWidth, 7, '.......................................................... w ........................................', 0, 1, 'L');		

		$pdf->Ln(10);
		$pdf->Cell($pageWidth, 7, 'Data: ..............................                   ....................................', 0, 1, 'L');		
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('Data: ..............................                   .......'));
		$pdf->SetFont('serif','',8);
		$pdf->Cell($pageWidth, 7, 'podpis', 0, 1, 'L');
		
		
		$pdf->buffer = htmlspecialchars_decode($pdf->buffer);
		if ($fileName == null)
			$pdf->Output();
		else
			$pdf->Output($fileName, "F");

	}

	public function generateBsc($pdf, $fileName = null) {
	  	$pdf->SetUTF8(true);		
		$pdf->Open();
		$pdf->SetAutoPageBreak(true, 18); // automatyczne łamanie strony przy ustawieniu dolnego marginesu.
	    $pdf->SetMargins(24, 24, 24);
		$pdf->AddPage();
		$pdf->AliasNbPages(); 
		$pdf->setFillColor(255, 255, 255);
		// określa dla rozmiaru strony A4 określa szerokość tekstu pomiędzy marginesami
		$pageWidth =  210 - $pdf->lMargin - $pdf->rMargin;
			
		$pdf->SetStyle("akb","serif","B",9,"0,0,0"); // ustawia styl czcionki dla danego znacznika (krój, wielkość, kolor)
		$pdf->SetFont('serif','',12);	
		$pdf->Cell($pageWidth, 5, 'Nr faktury: .........................        Sucha Beskidzka, dnia ' . date('Y-m-d'), 0,1,'J');
		$pdf->Ln(10);
		$pdf->SetFont('serif','',12);	
		$pdf->Bold();
		$pdf->Cell($pageWidth, 5, 'Dziekan WSTiE', 0,1,'R');
		$pdf->Cell($pageWidth, 5, 'w Suchej Beskidzkiej', 0,1,'R');				
		$pdf->Ln(10);
		$pdf->SetFont('serif','',16);
		$pdf->Cell($pageWidth, 5, 'PODANIE', 0,1,'C');
		$pdf->Unbold();
		$pdf->Ln(4);
		$pdf->SetFont('serif','',12);	
		$pdf->SetDrawColor(0, 0, 0);

		$pdf->Ln(5);
		//punktowany tekst			
		$pdf->SetFont('serif','',12);
		$pdf->Cell($pageWidth, 9, 'Proszę o przyjęcie mnie na studia: ' . mb_strtoupper($this->kandydat->getStacjonarneString(), 'utf-8'), 0,1,'L');							
		$pdf->Cell($pageWidth, 9, 'w Wyższej Szkole Turystyki i Ekologii', 0,1,'C');							

		$pdf->Cell($pageWidth, 7, 'na kierunek: ' . strtoupper($this->kandydat->getKierunekString()), 0,1,'L');							
		$pdf->Cell($pageWidth, 7, 'specjalność: ' . strtoupper($this->kandydat->getSpecjalnoscString()), 0,1,'L');							

		$pdf->Ln(2);
		$pdf->Cell($pageWidth, 7, 'Wybieram język: ' . $this->kandydat->getJezyk() . (strlen($this->kandydat->getJezyk2() > 0) ? ' /główny/  '.$this->kandydat->getJezyk2().' /dodatkowy/' : ''), 0,1,'L');									
		$pdf->Cell($pageWidth, 5, 'Stopień zaawansowania: ....................' . (strlen($this->kandydat->getJezyk2() > 0) ? ' /główny/ ..................... /dodatkowy/' : ''), 0,1,'L');									
		$pdf->SetFont('serif','',7);
		$pdf->Cell($pageWidth, 7, '/podać stopień zaawansowania: zaawansowany, średni, początkowujący/', 0,1,'C');									
		$pdf->SetFont('serif','',12);
		$pdf->Ln(2);		
		$pdf->Cell($pageWidth, 7, 'język zdawany na maturze: ...................................', 0,1,'L');							
		
		

		$pdf->Ln(5);
		
									
		$pdf->Bold();
		$pdf->Cell($pageWidth, 7, '1. Dane personalne', 0,1,'L');							
		$pdf->Unbold();
		$pdf->SetX($pdf->lMargin + $this->indent);
		$pdf->Cell(($pageWidth-$this->indent)/2, 7, 'a. Nazwisko: ' . $this->kandydat->getNazwisko(), 0,0,'L');							
		$pdf->Cell(($pageWidth-$this->indent)/2, 7, 'Imiona: ' . $this->kandydat->getImiona(), 0,0,'L');							
		$pdf->Ln();
		$pdf->SetX($pdf->lMargin + $this->indent);
		$pdf->Cell(($pageWidth-$this->indent), 7, 'b. Nazwisko panieńskie (u mężatek): ............................................', 0,0,'L');							
		$pdf->Ln();
		
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('2. '), 7, '2. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('2. '), 7, 'Data i miejsce urodzenia: ', 0,1,'L');							
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('2. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('2. '), 7, 'rok: 19' . substr($this->kandydat->getPesel(), 0, 2) . ' miesiąc: ' . substr($this->kandydat->getPesel(), 2, 2) . ' dzień: ' . substr($this->kandydat->getPesel() , 4, 2) . ' w: ' . $this->kandydat->getUrodzenieMiejsce(), 0, 1, 'L');
				
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('3. '), 7, '3. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('3. '), 7, 'Imiona rodziców: ' . $this->kandydat->getMatkaImie() . ' ' . $this->kandydat->getOjciecImie(), 0,1,'L');							
		
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('4. '), 7, '4. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('4. '), 7, 'Adres stałego zameldowania: ', 0,1,'L');							
		$pdf->SetX($pdf->lMargin + $this->indent);
		$pdf->Cell($pageWidth-$this->indent, 7, 'ulica: ' . strtoupper($this->kandydat->getZameldowanieUlica()) . ' ' . $this->kandydat->getZameldowanieDomNr() . '/' . $this->kandydat->getZameldowanieMieszkanieNr(), 0,1,'L');							
		$pdf->SetX($pdf->lMargin + $this->indent);
		$pdf->Cell($pageWidth-$this->indent, 7, 'kod: ' . $this->kandydat->getZameldowanieKod() . ' miejscowość: ' . $this->kandydat->getZameldowanieMiasto(), 0,1,'L');							
		$pdf->SetX($pdf->lMargin + $this->indent);
		$pdf->Cell($pageWidth-$this->indent, 7, 'województwo: ' . $this->kandydat->getZameldowanieWojewodztwo(), 0,1,'L');							
		
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('5. '), 7, '5. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('5. '), 7, 'Numer telefonu: ' . $this->kandydat->getTelefonNr(), 0,1,'L');							
		if (strlen($this->kandydat->getMobileNr())) {
			$pdf->SetX($pdf->lMargin + $pdf->GetStringWidth('5. '));
			$pdf->Cell($pageWidth-$pdf->GetStringWidth('5. '), 7, 'telefon komorkowy: ' . strtoupper($this->kandydat->getMobileNr()), 0,1,'L');							
		}

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('6. '), 7, '6. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('6. '), 7, 'Adres email: ' . $this->kandydat->getEmail(), 0,1,'L');							

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('7. '), 7, '7. ', 0,0,'L');							
		$pdf->Unbold();
		if (strlen($this->kandydat->getKorespondencjaMiasto()) > 0 && strlen($this->kandydat->getKorespondencjaDomNr()) > 0) {
			$pdf->Cell($pageWidth - $pdf->GetStringWidth('7. '), 7, 'Adres korespondencyjny:', 0,1,'L');							
			$pdf->SetX($pdf->lMargin + $this->indent);
			$pdf->Cell($pageWidth-$this->indent, 7, 'ulica: ' . strtoupper($this->kandydat->getKorespondencjaUlica()) . ' ' . $this->kandydat->getKorespondencjaDomNr() . '/' . $this->kandydat->getKorespondencjaMieszkanieNr(), 0,1,'L');							
			$pdf->SetX($pdf->lMargin + $this->indent);
			$pdf->Cell($pageWidth-$this->indent, 7, 'kod: ' . $this->kandydat->getKorespondencjaKod() . ' miejscowość: ' . $this->kandydat->getKorespondencjaMiasto(), 0,1,'L');							
		}
		else
			$pdf->Cell($pageWidth - $pdf->GetStringWidth('7. '), 7, 'Adres korespondencyjny: taki sam jak zameldowania', 0,1,'L');							

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('8. '), 7, '8. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('8. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('8. '), 7, 'Seria i nr dowodu osobistego: ' . $this->kandydat->getDowodOsobistyNr(), 0, 1, 'L');

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('9. '), 7, '9. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('9. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('9. '), 7, 'Narodowść: ............................... Obywatelstwo: ........................' , 0, 1, 'L');
		
		
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('10. '), 7, '10. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('10. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('10. '), 7, 'PESEL: ' . $this->kandydat->getPesel(), 0, 1, 'L');

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('11. '), 7, '11. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('11. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('11. '), 7, 'NIP: ' . $this->kandydat->getNip(), 0, 1, 'L');

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('12a. '), 7, '12a. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('12a. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('12a. '), 7, 'Ukończona szkoła średnia: ', 0, 1, 'L');
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('12a. '));
		$pdf->MultiCell($pageWidth - $pdf->GetStringWidth('12a. '), 7, $this->kandydat->getSzkolaSrednia(), 0, 1, 'J');
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('12a. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('12a. '), 5, 'Rok ukończenia: ' . $this->kandydat->getSzkolaSredniaRokUkonczenia(), 0, 1, 'L');

		$pdf->SetUTF8(true);

		if (strlen($this->kandydat->getSkonczoneStudia()) > 0) {
			$pdf->Bold();
			$pdf->Cell($pdf->GetStringWidth('12b. '), 7, '12b. ', 0,0,'L');							
			$pdf->Unbold();
			$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('12b. '));
			$pdf->Cell($pageWidth - $pdf->GetStringWidth('12b. '), 7, 'Ukończone studia I stopnia: ', 0, 1, 'L');
			$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('12b. '));
			$pdf->MultiCell($pageWidth - $pdf->GetStringWidth('12b. '), 7, $this->kandydat->getSkonczoneStudia(), 0, 1, 'J');
			$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('12b. '));
			$pdf->Cell($pageWidth - $pdf->GetStringWidth('12b. '), 5, 'Rok ukończenia: ' . $this->kandydat->getSkonczoneStudiaRokUkonczenia(), 0, 1, 'L');
		}
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('13. '), 7, '12. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('13. '));
		$pdf->MultiCell($pageWidth - $pdf->GetStringWidth('13. '), 7, 'Stosunek do służby wojskowej: ' . $this->kandydat->getStosunekDoSluzbyWojskowej(), 0, 1, 'L');
		if ($this->kandydat->getStosunekDoSluzbyWojskowej() == 'uregulowany') {
			$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('13. '));
			$pdf->MultiCell($pageWidth - $pdf->GetStringWidth('13. '), 7, 'Seria i nr książeczki wojskowej: ' . $this->kandydat->getKsiazeczkaWojskowaNr(), 0, 1, 'L');			
		}
			
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('14. '), 7, '14. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('14. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth('14. '), 7, 'Renta inwalidzka: ' . ($this->kandydat->getNiepelnosprawny() == '1' ? 'tak':'nie'), 0, 1, 'L');
		if ($this->kandydat->getNiepelnosprawny() == '1') {
			$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('14. '));
			$pdf->Cell($pageWidth - $pdf->GetStringWidth('14. '), 7, 'Grupa: ......................................', 0, 1, 'L');
		}

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('15. '), 7, '15. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('15. '));
		$pdf->MultiCell($pageWidth - $pdf->GetStringWidth('15. '), 7, 'Informacje o źródle utrzymania kandydata: ............................', 0, 1, 'L');

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('16. '), 7, '16. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('16. '));
		$pdf->MultiCell($pageWidth - $pdf->GetStringWidth('16. '), 7, 'O szkole dowiedziałem się z: ' . $this->kandydat->getSkadWiem(), 0, 1, 'L');

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('17. '), 7, '17. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('17. '));
		$pdf->MultiCell($pageWidth - $pdf->GetStringWidth('17. '), 7, 'Inne informacje, które kandydat powinien podać', 0, 1, 'L');
		
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth(' 1. '), 7, ' 1. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth(' 1. '));
		$pdf->MultiCell($pageWidth - $pdf->GetStringWidth(' 1. '), 7, 'Studiuję: ............................................................................', 0, 1, 'L');
		$pdf->MultiCell($pageWidth - $pdf->GetStringWidth(' 1. '), 7, '.................................................................................', 0, 1, 'L');
		
		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('2. '), 7, ' 2. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth(' 2. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth(' 2. '), 7, 'Nazwa i miejsce zakładu pracy: ...............................................', 0, 1, 'L');
		$pdf->Cell($pageWidth - $pdf->GetStringWidth(' 2. '), 7, '...................stanowisko: ................................................', 0, 1, 'L');

		$pdf->Bold();
		$pdf->Cell($pdf->GetStringWidth('3. '), 7, ' 3. ', 0,0,'L');							
		$pdf->Unbold();
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth(' 3. '));
		$pdf->Cell($pageWidth - $pdf->GetStringWidth(' 3. '), 7, 'Basen: grupa ' . $this->kandydat->getPlywanieGrupa(), 0, 1, 'L');
		
		//zgoda na przetwarzanie danych
		$pdf->SetFont('serif','',8);
		$pdf->Ln(10);
		$pdf->setX($pdf->lMargin);
		$pdf->Italic();
		$pdf->Cell($pageWidth, 7, 'Wyrażam zgodę na przetwarzanie i wykorzystywanie moich danych osobowych przez Wyższą Szkołę', 0, 1, 'L');
		$pdf->Cell($pageWidth, 7, 'Turystyki i Ekologii dla celów postępowania kwalifikacyjnego i dokumentowania przebiegu', 0, 1, 'L');
		$pdf->Cell($pageWidth, 7, 'zgodnie z art. 6 ustawy z dnia 29.08.97 r. o ochronie danych osobowych', 0, 1, 'L');
		$pdf->Cell($pageWidth, 7, '(Dz. U. z 1997 r. Nr 133 poz 883 z późniejszymi zmianami)', 0, 1, 'L');		
		
		$pdf->Ln(5);
		$pdf->setX($pdf->lMargin);
		$pdf->Italic();
		$pdf->Cell($pageWidth, 7, 'Wyrażam zgodę na umieszczanie zdjęć na stronie internetowej i w materiałach reklamowych WSTE.', 0, 1, 'L');
		$pdf->Cell($pageWidth, 7, 'Prawdziwość danych zawartych w podaniu potwierdzam własnoręcznym podpisem.', 0, 1, 'L');		
		$pdf->Unitalic();

		$pdf->Ln(10);
		$pdf->SetFont('serif','',12);
		$pdf->setX($pdf->lMargin);
		$pdf->Cell($pageWidth, 7, 'Sucha Beskidzka, dnia: .......................    ............................', 0, 1, 'L');
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('Sucha Beskidzka, dnia: .......................    ....'));
		$pdf->SetFont('serif','',8);
		$pdf->Cell($pageWidth, 7, 'podpis kandydata', 0, 1, 'L');
		
		
		$pdf->AddPage();
		$pdf->SetFont('serif','',12);
		$pdf->setX($pdf->lMargin);
		$pdf->Bold();
		$pdf->Cell($pageWidth, 7, 'Wypełnić w razie odejścia', 0, 1, 'L');		
		$pdf->Unbold();
		$pdf->Ln(10);
		$pdf->Cell($pageWidth, 7, 'Potwierdzam odbiór świadectwa dojrzałości w oryginale z ukończenia', 0, 1, 'L');		
		$pdf->Cell($pageWidth, 7, '..........................................................................................', 0, 1, 'L');		
		$pdf->Cell($pageWidth, 7, 'Miejscowość: ............................. nr świadectwa: ......... z dnia: .............', 0, 1, 'L');				
		$pdf->Cell($pageWidth, 7, 'oraz indeksu o nr albumu: ................................', 0, 1, 'L');		

		$pdf->Ln(20);
		$pdf->Cell($pageWidth, 7, 'Data: ..............................                   ....................................', 0, 1, 'L');		
		$pdf->setX($pdf->lMargin + $pdf->GetStringWidth('Data: ..............................                   .......'));
		$pdf->SetFont('serif','',8);
		$pdf->Cell($pageWidth, 7, 'podpis', 0, 1, 'L');
		
		$pdf->buffer = htmlspecialchars_decode($pdf->buffer);
		if ($fileName == null)
			$pdf->Output();
		else
			$pdf->Output($fileName, "F");

	}

}