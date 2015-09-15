<?php

class PdfFactory {


/**
 * Tworzy dokument PDF - raporty. <br />
 * Kodowanie treści w utf-8!
 * @param $reportValues - pobiera główną tablicę wartości jakimi będzie uzupełniony raport
 * @param string $filePath - Ścieżka do pliku w jakiej zapisany będzie raport
 * @param string $fileName - Nazwa pliku raportu
 */	
public static function generateReport($reportValues, $filePath = '', $fileName = '') {
// Przepisanie tablicy wartości na zmienne
if($reportValues != null){
  foreach($reportValues AS $key => $value)
    $$key = $value ;
}		

$pdf = new SmartpayPdf();
$draft = new SmartpayPdf();
$pdf->SetUTF8(true);
$draft->SetUTF8(true);		
	
//======================== wybor jezyka ==================================
	$_jezyk = "polski";
	$_vat = '22';
	
require_once sfConfig::get('sf_lib_dir').'/ext/util/pdf/stringsReport.inc';
$string = $strings[$_jezyk];
//$inttotext = $inttotext_data[$_jezyk];			
			
$waluty = array();

$split_invoice = array('848' =>    array(array('percentage' => 60, 'days' => 14),
                                         array('percentage' => 40, 'days' => 60)),
                       '1869' =>   array(array('percentage' => 70, 'days' => 14),
                                         array('percentage' => 30, 'days' => 60)),
                       '9645' =>   array(array('percentage' => 70, 'days' => 14),
                                         array('percentage' => 30, 'days' => 60)),
                       '10698' =>  array(array('percentage' => 20, 'days' => 7),
                                         array('percentage' => 80, 'days' => 14)),
                       '11836' =>  array(array('percentage' => 80, 'days' => 30),
                                         array('percentage' => 20, 'days' => 45)));

$inttotext_data['polski'] = array('1' => array('jednej', 'Pierwsza'), '2' => array('dw?ch','Druga'), 
                   '3' => array('trzech', 'Trzecia'),  '4' => array('czterech','Czwarta')) ;
$inttotext_data['angielski'] = array('1' => array('one', 'First'), '2' => array('two','Second'), 
                   '3' => array('three', 'Third'),  '4' => array('four','Fourth')) ;
                                     


// ===============================  Sekcja danych  =========================
/**
 $_billedClient - klient, dla kt?rego wystawiany jest raport
        +--- number - numer klienta
        +--- name - nazwa klienta
 $_reportNo - numer/oznaczenie raportu
 $_periodId - identyfikator okresu
 $_reportPeriod - okres, kt?rego dotyczy raport
 $_reportDate - data wygenerowania raportu
 $_reportAuthor - autor raportu (osoba generuj?ca raport)
 $string['opis_fv'].$_reportNo - tre?? do umieszczenia na fakturze
 $_clientsList - tablica zawieraj?ca klient?w oraz ich us?ugi. Poni?ej opisana 
 				 jej struktura

$_clientList
      +--- {i}
            +--- name - nazwa klienta
            +--- number - numer klienta
            +--- own_services - us?ugi w?asne
            |          +--- {j}
            |                +--- name - nazwa us?ugi
            |                +--- number - numer us?ugi
            |                +--- connectors - konektory
            |                         +--- {con_name}
            |                                  +--- {k}
            |                                        +--- event - zdarzenie na konektorze
            |                                        +--- count - ilo?? zdarze?
            |                                        +--- prise - cena zdarzenia
            |                                       (+--- value) - warto?? zdarze?
            +--- foreign_services - us?ugi obce
            |             +--- {j}
            |                   +--- event - zdarzebnie na us?udze
            |                   +--- service - nazwa us?ugi
            |                   +--- count - ilo?? zdarze?
            |                   +--- prise - cena zdarzenia
            |                  (+--- value) - warto?? zdarzenia
            +--- frauds - naliczone fraudy (us?ugi obce o typie = 12)
                   (+--- positive) - o warto?ci dodatniej, zwi?kszaj?ce warto?? raportu
                   (+--- negative) - o warto?ci ujemnej, zmniejszaj?ce warto?? raportu

Wyra?enia w nawiasach klamrowych oznaczaj? zmienne, pozosta?e nazwy s? indeksami 
tablicy asocjacyjnej. W nawiasach okr?g?ych zamieszczono warto?ci opcjonalne.
 */
/*
$_billedClient = array('name' => 'Ad. Point Sp. z o.o. Antyradio Katowice', 'number' => '122') ;
$_reportNo = 'KC/2006/2113' ;
$_periodId = '200608' ;
$_reportPeriod = '01.08.2006 00:00 - 31.08.2006 24:00' ;
$_reportDate = date('Y-m-d H:i') ;
$_reportAuthor = 'Łukasz Bielak' ;
$string['opis_fv'] = 'Należność za serwisy multimedialne zgodnie z umową o współpracy i raportem nr '.$_reportNo ;
$_grantedBonuses = 
	array(
     	'current' => array('amount' => 50,'payperiod' => 200902),
     	'topay' => array(
     		'summary' => 200,
     		'periods' => array(
     			array('period' => 200812, 'amount' => 80),
     			array('period' => 200901, 'amount' => 70),
     			array('period' => 200902, 'amount' => 50)
     		)
     	)
   ) ;
$_clientsList = 
   array(
      array(
         'name' => 'Ad. Point Sp. z o.o.',
         'number' => '122',
         'own_services' =>
            array(
               array(
                  'name' => 'Radio Flash Katowice Życzenia',
                  'number' => '2575',
                  'connectors' =>
                     array(
                        'PLUS 7168' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 3,
                                 'prise' => 0.3750,
                                 'currency' => 'PLN'
                              )
                           )
                     )
               ),
               array(
                  'name' => 'Turbo 7168',
                  'number' => '4387',
                  'connectors' =>
                     array(
                        'IDEA 7168' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 12,
                                 'prise' => 0.3750,
                                 'currency' => 'PLN'
                              )
                           ),
                        'PLUS 7168' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 26,
                                 'prise' => 0.3750,
                                 'currency' => 'PLN'
                              )
                           ),
                        'ERA 7168' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 7,
                                 'prise' => 0.3750,
                                 'currency' => 'PLN'
                              )
                           ),
                        'ConVis 8764' =>
                           array(
                              array(
                                 'event' 		=> 'Odebrane SMS Premium',
                                 'count' 		=> 15,
                                 'prise' 		=> 1.3750,
                                 'currency'	=> 'EUR'
                              )
                           )
                     )
               ),
               array(
                  'name' => 'Mundial 7268',
                  'number' => '9352',
                  'connectors' =>
                     array(
                        'IDEA 7268' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 3,
                                 'prise' => 0.7500
                              )
                           ),
                        'PLUS 7268' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 5,
                                 'prise' => 0.7500,
                                 'currency' => 'PLN'
                              )
                           ),
                        'ERA 7268' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 5,
                                 'prise' => 0.7500,
                                 'currency' => 'PLN'
                              )
                           )
                     )
               )
            ),
         'foreign_services' =>
            array(
               array(
                  'event' => 'GM Multimedia Tapeta Brandowana',
                  'service' => 'AutoMotoBiznes GNAMB 9',
                  'count' => 2,
                  'prise' => 1.8000,
                  'currency' => 'PLN'
               ),
               array(
                  'event' => 'GM Multimedia Gra Java',
                  'service' => 'AutoMotoBiznes GNAMB 9',
                  'count' => 1,
                  'prise' => 1.8000,
                  'currency' => 'PLN'
               )
            )
      ),
      array(
         'name' => 'Neo Press (Auto Moto Biznes)',
         'number' => '',
         'own_services' =>
            array(
               array(
                  'name' => 'Radio Flash Katowice Zyczenia',
                  'number' => '2575',
                  'connectors' =>
                     array(
                        'PLUS 7168' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 3,
                                 'prise' => 0.3750,
                                 'currency' => 'PLN'
                              )
                           )
                     )
               ),
               array(
                  'name' => 'Turbo 7168',
                  'number' => '4387',
                  'connectors' =>
                     array(
                        'IDEA 7168' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 12,
                                 'prise' => 0.3750,
                                 'currency' => 'PLN'
                              ),
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 3,
                                 'prise' => 0.3750,
                                 'currency' => 'PLN'
                              )
                           ),
                        'PLUS 7168' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 26,
                                 'prise' => 0.3750,
                                 'currency' => 'PLN'
                              )
                           ),
                        'ERA 7168' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 7,
                                 'prise' => 0.3750,
                                 'currency' => 'PLN'
                              )
                           )
                     )
               ),
               array(
                  'name' => 'Mundial 7268',
                  'number' => '9352',
                  'connectors' =>
                     array(
                        'IDEA 7268' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 3,
                                 'prise' => 0.7500,
                                 'currency' => 'PLN'
                              )
                           ),
                        'PLUS 7268' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 5,
                                 'prise' => 0.7500,
                                 'currency' => 'PLN'
                              )
                           ),
                        'ERA 7268' =>
                           array(
                              array(
                                 'event' => 'Odebrane SMS Premium',
                                 'count' => 5,
                                 'prise' => 0.7500,
                                 'currency' => 'PLN'
                              )
                           )
                     )
               )
            ),
         'foreign_services' =>
            array(
               array(
                  'event' => 'GM Multimedia Tapeta Brandowana',
                  'service' => 'AutoMotoBiznes GNAMB 9',
                  'count' => 2,
                  'prise' => 1.8000,
                  'currency' => 'PLN'
               ),
               array(
                  'event' => 'GM Multimedia Gra Java',
                  'service' => 'AutoMotoBiznes GNAMB 9',
                  'count' => 1,
                  'prise' => 1.8000,
                  'currency' => 'PLN'
               )
            )
      )
   ) ;

*/

// ======================= Sekcja generowania PDF ========================
//$pdf = new PdfReport('P','mm','A4', $_jezyk) ;
$pdf->Open();
$pdf->AddPage('P');
$pdf->SetFont('serif','',10);
$pdf->SetMargins(20, 20, 20);
$pdf->AliasNbPages(); 
// draft to brudnopis dla tego 
$draft->Open();
$draft->AddPage('P');
$draft->SetFont('serif','',10);
$draft->SetMargins(20, 30, 20);
$draft->AliasNbPages(); 

/*   Informacje wst?pne o kliencie, dla kt?rego generowany jest raport   */
$pdf->SetY(25);
$pdf->SetFontSize(12) ;
$pdf->Cell($pdf->GetStringWidth($string['rap_nr']),14,$string['rap_nr'],0,0,'L');
$pdf->Bold() ;
$pdf->Cell(0,14,$_reportNo,0,1,'L');
$pdf->SetFontSize(10) ;
$pdf->Unbold() ;
$pdf->Cell($pdf->GetStringWidth($string['za_okres']),5,$string['za_okres'],0,0,'L') ;
$pdf->Bold() ;
$pdf->Cell(0,5,$_reportPeriod,0,1,'L');
$pdf->Unbold() ;
//$pdf->MultiCell(0,5,$string['w_sprawie'],0,'J');
$pdf->MultiCell(0,5,"w sprawie rozliczeń za ruch SMS premium generowany w ramach umowy pomiędzy Centrum Technologii Mobilnych MOBILTEK S.A. a Klientem:\n  ",0,'J');
// Tu kruczek, na ko?cu dodana jest spacja, gdy? zale?y mi na wolnej linii, a je?li
// tekst w MultiCell ko?czy si? znakiem \n, znak ten jest usuwany z tekstu
$pdf->Bold() ;
$pdf->MultiCell(0,5,$_billedClient['name']."\n ",0,'L');
$pdf->Unbold() ;


/********** Wylistoawanie klient?w i us?ug dla danego Klienta ***********/
// Tabela rozmiar?w kom?rek i ich formatowania
$tables =
   array(
      'own' =>
         array(
            'head' =>
               array(
                  'widths' => array(30,55,20,30,35),
                  'aligns' => array('C','C','C','C','C'),
               ),
            'row' =>
               array(
                  'widths' => array(30,55,20,30,35),
                  'aligns' => array('R','L','R','R','R'),
               ),
            'foot' =>
               array(
                  'widths' => array(85,20,30,35),
                  'aligns' => array('R','R','R','R'),
               )
         ),
      'foreign' =>
         array(
            'head' =>
               array(
                  'widths' => array(50,55,15,20,30),
                  'aligns' => array('C','C','C','C','C'),
               ),
            'row' =>
               array(
                  'widths' => array(50,55,15,20,30),
                  'aligns' => array('L','L','R','R','R'),
               ),
            'foot' =>
               array(
                  'widths' => array(105,15,20,30),
                  'aligns' => array('R','R','R','R'),
               )
         )
   ) ;
$index = 0 ;
$allValue = array() ;
// _clientList to taki tw?r z pliku Report.class.php, w kt?rym przechowywane s? dane o billingach. Na li?cie tej s? us?ugi obce oraz us?ugi w?asne
// to, czy s? to us?ugi obce czy w?asne ustalane jest na podstawie nazwy, kt?ra je?li jest taka sama jak nazwa klienta, dla kt?rego generujemy
// raport stanowi i? s? to w?a?nie us?ugi w?asne
foreach($_clientsList AS $clientNo => $client){
   $clientValue = array() ;
   //if($clientNo > 0 && !($index++ == 0 && $client['name'] == $_billedClient['name'])){
      $pdf->Bold() ;
      $pdf->MultiCell(0,5,'Okres: '.$client['name']."\n",0,'J');
      $pdf->Unbold() ;
   //}
   if(isset($client['own_services']) && sizeof($client['own_services']) > 0){
      //$pdf->Cell(0,5,"Przychody uzyskane na poszczególnych usługach",0,1,'L');
      $pdf->Ln(5);
      $ownServicesSum = array() ;
      $draft_counter = 0 ;
      foreach($client['own_services'] AS $service){
         // Wylistowanie us?ug w?asnych
         // Sprawdzenie wysoko?ci bloku i sprawdzenie, czy nie wykracza poza stron?
         // tak, aby tabelki w ca?o?ci znajdowa?y si? na jednej stronie
         
         //>>> Block
         // Dla potrzeb drafta przeliczamy tak?e ew nowego klienta
         $h_begin = $draft->GetY() ;
         $draft->Cell(0,5,"Usługa ".$service['name'],0,1,'L');
         $draft->SetWidths($tables['own']['head']['widths']);
         $draft->SetAligns($tables['own']['head']['aligns']);
         $draft->Bold();
         $draft->Row(array("Stawka","Zdarzenie","Ilość","Cena","Przychód"),'C');
         $draft->Unbold();
         $draft->SetWidths($tables['own']['row']['widths']);
         $draft->SetAligns($tables['own']['row']['aligns']);
         $serviceValue = array() ;
         $serviceAmount = array() ;
         foreach($service['connectors'] AS $connector => $events){
            for($i = 0; $i < sizeof($events); $i++){
               $draft->Row(
                         array($i == 0 ? $connector : '', $events[$i]['event'],
               		           $events[$i]['count'],@PdfFactory::currency($events[$i]['prise'],0,4,$events[$i]['currency']),
               		           @PdfFactory::currency($events[$i]['amount'],0,2,$events[$i]['currency'])),'C'
                     ) ;
               if(@!isset($serviceValue[$events[$i]['currency']])){
	               @$serviceValue[$events[$i]['currency']] = $events[$i]['amount'] ;
	               @$serviceAmount[$events[$i]['currency']] = $events[$i]['count'] ;
               } else {
               	$serviceValue[$events[$i]['currency']] += $events[$i]['amount'] ;
               	$serviceAmount[$events[$i]['currency']] += $events[$i]['count'] ;
					}
            }
         }
         $draft->SetWidths($tables['own']['foot']['widths']);
         $draft->SetAligns($tables['own']['foot']['aligns']);
         $draft->Bold();
         foreach($serviceAmount as $currency => $value){
         	$draft->Row(array($string['suma'],$serviceAmount[$currency],'',PdfFactory::currency($serviceValue[$currency],0,2,$currency)),'C');
         	/*
         	if(!isset($ownServicesSum[$currency])){
         		$ownServicesSum[$currency] = $serviceValue[$currency] ;
         		$clientValue[$currency] = $serviceValue[$currency] ;
         	} else {
         		$ownServicesSum[$currency] += $serviceValue[$currency] ;
         		$clientValue[$currency] += $serviceValue[$currency] ;
				}
				*/
			}
         $draft->Ln(5);
         $draft->Unbold();
         if($pdf->GetY() + $draft->GetY() - $h_begin > $pdf->GetPageHeight() - $pdf->GetBMargin())
            $pdf->AddPage() ;
         $draft->SetY($h_begin) ;
         //<<< Block
         
         $pdf->Cell(0,5,$string['usluga'].$service['number'].': '.$service['name'],0,1,'L');
         $pdf->SetWidths($tables['own']['head']['widths']);
         $pdf->SetAligns($tables['own']['head']['aligns']);
         $pdf->Bold();
         $pdf->Row(array("Stawka","Zdarzenie","Ilość","Cena","Przychód"),'C');
         $pdf->Unbold();
         $pdf->SetWidths($tables['own']['row']['widths']);
         $pdf->SetAligns($tables['own']['row']['aligns']);
         $serviceValue = array() ;
         $serviceAmount = array() ;
         foreach($service['connectors'] AS $connector => $events){
            for($i = 0; $i < sizeof($events); $i++){
               $pdf->Row(
                         array($i == 0 ? $connector : '', $events[$i]['event'],
               		           $events[$i]['count'],@PdfFactory::currency($events[$i]['prise'],0,4,$events[$i]['currency']),
               		           @PdfFactory::currency($events[$i]['amount'],0,2,$events[$i]['currency'])),'C'
                     ) ;
               if(@!isset($serviceValue[$events[$i]['currency']])){
	               @$serviceValue[$events[$i]['currency']] = $events[$i]['amount'] ;
	               @$serviceAmount[$events[$i]['currency']] = $events[$i]['count'] ;
               } else {
               	$serviceValue[$events[$i]['currency']] += $events[$i]['amount'] ;
               	$serviceAmount[$events[$i]['currency']] += $events[$i]['count'] ;
					}
            }
         }
         $pdf->SetWidths($tables['own']['foot']['widths']);
         $pdf->SetAligns($tables['own']['foot']['aligns']);
         $pdf->Bold();
         foreach($serviceAmount as $currency => $value){
         	$pdf->Row(array($string['suma'],$serviceAmount[$currency],'',PdfFactory::currency($serviceValue[$currency],0,2,$currency)),'C');
         	if(!isset($ownServicesSum[$currency])){
         		$ownServicesSum[$currency] = $serviceValue[$currency] ;
         		$clientValue[$currency] = $serviceValue[$currency] ;
         	} else {
         		$ownServicesSum[$currency] += $serviceValue[$currency] ;
         		$clientValue[$currency] += $serviceValue[$currency] ;
				}
			}
         $pdf->Ln(5);
         $pdf->Unbold();
      }
      $text = "Sumaryczny przychód ze wszystkich usług";
      $waluty = array() ;
      foreach($ownServicesSum as $currency => $value){
	      $pdf->Cell($pdf->GetStringWidth($text),5,$text,0,0) ;
	      $pdf->Bold();
	      if($currency != 'PLN'){
	      	$waluty[] = $currency ;
	      	$exchange_info = ' ('.@PdfFactory::currency($ownServicesSum[$currency] * $_exchangeRates[$currency],0,2).')*' ;
	      } else {
	      	$exchange_info = '' ;
	      }
	      $pdf->Cell(0,5,PdfFactory::currency($ownServicesSum[$currency],0,2,$currency).$exchange_info,0,1);
	      $pdf->Unbold();
		}
		$pdf->Ln(5);
   }
   if(isset($client['foreign_services']) && sizeof($client['foreign_services']) > 0){
      $pdf->Cell(0,5,$string['przych_z_uslug_ob'],0,1,'L');
      $pdf->Ln(5);
      // Wylistowanie us?ug obcych
      
      //>>> Block
      $h_begin = $draft->GetY() ;
      $draft->SetWidths($tables['foreign']['head']['widths']);
      $draft->SetAligns($tables['foreign']['head']['aligns']);
      $draft->Bold();
      $draft->Row(array($string['konektor'],$string['zdarzenie'],$string['liczba'],$string['cena'],$string['przychod']),'C');
      $draft->Unbold();
      $draft->SetWidths($tables['foreign']['row']['widths']);
      $draft->SetAligns($tables['foreign']['row']['aligns']);
      $serviceValue = 0 ;
      $serviceAmount = 0 ;
      foreach($client['foreign_services'] AS $service){
         $draft->Row(
                   array($service['event'],$service['service'],
                         $service['count'],@PdfFactory::currency($service['prise'],0,4),
                         @PdfFactory::currency($service['amount'])),'C'
                   ) ;
         $serviceValue += @$service['amount'] ;
         $serviceAmount += @$service['count'] ;
      }
      $draft->SetWidths($tables['foreign']['foot']['widths']);
      $draft->SetAligns($tables['foreign']['foot']['aligns']);
      $draft->Bold();
      $draft->Row(array('suma',$serviceAmount,'',PdfFactory::currency($serviceValue,0,2)),'C');
      $draft->Unbold();
      if($pdf->GetY() + $draft->GetY() - $h_begin > $pdf->GetPageHeight() - $pdf->GetBMargin())
            $pdf->AddPage() ;
      $draft->SetY($h_begin) ;
      //<<< Block
      
      $pdf->SetWidths($tables['foreign']['head']['widths']);
      $pdf->SetAligns($tables['foreign']['head']['aligns']);
      $pdf->Bold();
      $pdf->Row(array($string['konektor'],$string['zdarzenie'],$string['liczba'],$string['cena'],$string['przychod']),'C');
      $pdf->Unbold();
      $pdf->SetWidths($tables['foreign']['row']['widths']);
      $pdf->SetAligns($tables['foreign']['row']['aligns']);
      $serviceValue = 0 ;
      $serviceAmount = 0 ;
      foreach($client['foreign_services'] AS $service){
         $pdf->Row(
                   array($service['event'],$service['service'],
                         $service['count'],PdfFactory::currency($service['prise'],0,4),
                         @PdfFactory::currency($service['amount'])),'C'
                   ) ;
         $serviceValue += @$service['amount'] ;
         $serviceAmount += $service['count'] ;
      }
      $pdf->SetWidths($tables['foreign']['foot']['widths']);
      $pdf->SetAligns($tables['foreign']['foot']['aligns']);
      $pdf->Bold();
      $pdf->Row(array('suma',$serviceAmount,'',PdfFactory::currency($serviceValue,0,2)),'C');
      $pdf->Unbold();
      $text = $string['sum_przych_z_uslug_ob'];
      $pdf->Cell($pdf->GetStringWidth($text),15,$text,0,0) ;
      $pdf->Bold();
      $pdf->Cell(0,15,PdfFactory::currency($serviceValue,0,2),0,1);
      $pdf->Unbold();
      $clientValue['PLN'] += $serviceValue ;
   }
   // wpis dotycz?cy odlicze?, tzw. fraud?w
   if(@sizeof($client['frauds']) > 0){
      $pdf->Bold() ;
      $pdf->Cell(0,10,$string['rozl_fraud'],0,1);
      $pdf->Unbold() ;
      if($client['frauds']['negative'] != 0){
         $pdf->Cell(0,5,$string['odl_wart_wyn'],0,1) ;
         $pdf->Cell($pdf->GetStringWidth($string['nie_uz_przych']),5,$string['nie_uz_przych'],0,0) ;
         $pdf->Bold() ;
         $pdf->Cell(0,5,PdfFactory::currency($client['frauds']['negative'],0,2),0,1) ;
         $pdf->Unbold() ;
         $pdf->Cell(0,5,$string['wyn_odl'],0,1) ;
         $pdf->Ln(5) ;
         $clientValue['PLN'] += $client['frauds']['negative'] ;
      }
      if($client['frauds']['positive'] != 0){
         $pdf->MultiCell(0,5,$string['dolicz_wart_wyn'],0,1) ;
         $pdf->Cell($pdf->GetStringWidth($string['zostalo_odl']),5,
                   $string['zostalo_odl'],0,0) ;
         $pdf->Bold() ;
         $pdf->Cell(0,5,PdfFactory::currency($client['frauds']['positive'],0,2),0,1) ;
         $pdf->Unbold() ;
         $pdf->Cell(0,5,$string['wyn_dolicz'],0,1) ;
         $pdf->Ln(5) ;
         $clientValue['PLN'] += $client['frauds']['positive'] ;
      }
   }
   // wpis dotycz?cy naliczenia premii. Format danych:
      /**
      $_grantedBonuses = array(
      	'current' => array('amount' => 50,'payperiod' => 200902),
      	'topay' => array(
      		'summary' => 200,
      		'periods' => array(
      			array('period' => 200812, 'amount' => 80),
      			array('period' => 200901, 'amount' => 70),
      			array('period' => 200902, 'amount' => 50)
      		)
      	)
      ) ;
      $client['bonuses'] = $_grantedBonuses ;
      //*/
   // Mamy premie, wi?c nale?y je ?adnie u?o?y?   
   //*
   /* Premie wyeliminowane w wersji dla małych kleintów
   $client['bonuses'] = $_grantedBonuses ;
   if(sizeof($client['bonuses']) > 0){
   	$bonus_part1 = "Premia za obrót wygenerowany na usługach własnych: " ;
   	
   	//$pdf->Cell(0,5,$bonus_1,0,1) ;
      $pdf->Cell($pdf->GetStringWidth($bonus_part1),5,$bonus_part1,0,0) ;
      $pdf->Bold() ;
      $pdf->Cell(0,5,PdfFactory::currency($client['bonuses']['current']['amount'],0,2).".",0,1) ;
      $pdf->Unbold() ;
      if($_periodId != $client['bonuses']['current']['payperiod']){// Je?li nie jest to okres wyp?aty
      	$bonus_part2 = "Powyższa kwota zostanie dołączona do sumy raportu za okres " ;
	      $pdf->Cell($pdf->GetStringWidth($bonus_part2),5,$bonus_part2,0,0) ;
	      $pdf->Bold() ;
	      $pdf->Cell(0,5,substr($client['bonuses']['current']['payperiod'],4,2).'.'.substr($client['bonuses']['current']['payperiod'],0,4).".",0,1) ;
	      $pdf->Unbold() ;
		} else {// Je?li jest okres wyp?aty, wtedy dodajemy zestawienei wpis?w 'premiowych'
	      $pdf->Cell(0,5,"Powyższa kwota została dołączona do sumy bieżacego raportu.",0,1) ;
	      if(isset($client['bonuses']['topay']) && sizeof($client['bonuses']['topay']['periods']) > 0){
		      $pdf->Ln(5) ;
		      $pdf->Cell(0,5,"Wyszczególnienie kwot premii oraz okresów wystąpienia doliczonych do bieżącego raportu:",0,1) ;
		      foreach($client['bonuses']['topay']['periods'] AS $bonus){
		      	$pdf->Cell(10,5,'',0,0) ;
		      	$pdf->Cell(0,5,substr($bonus['period'],4,2).'.'.substr($bonus['period'],0,4).": ".PdfFactory::currency($bonus['amount'],0,2),0,1) ;
				}
				// Dodajemy do kwoty raportu
				$clientValue['PLN'] += $client['bonuses']['topay']['summary'] ;
				$bonus_part2 = "Suma premii dołączonych do bieżącego raportu wynosi: " ;
				$pdf->Cell($pdf->GetStringWidth($bonus_part2),5,$bonus_part2,0,0) ;
				$pdf->Bold() ;
				$pdf->Cell(0,5,PdfFactory::currency($client['bonuses']['topay']['summary'],0,2).".",0,1) ;
      		$pdf->Unbold() ;
			}
		}
      $pdf->Ln(5) ;
      //$clientValue['PLN'] += $client['frauds']['negative'] ;
   }
   //*/
   foreach($clientValue as $currency => $value){
   	if(isset($allValue[$currency]))
   		$allValue[$currency] += $clientValue[$currency] ;
   	else
   		$allValue[$currency] = $clientValue[$currency] ;
	}
}

	
// Faktura mo?e by? podzielona na kilka cz??ci
// >>> Block >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$h_begin = $draft->GetY() ;
$tmp = 0 ;
$non_pln = false ;
foreach($allValue as $currency => $value){
	if($currency != 'PLN' && $currency != ''){
		$tmp += $value * @$_exchangeRates[$currency] ;
	}else
		$tmp += $value ;
}
$allValue = $tmp ;
if(!isset($split_invoice[$_billedClient['number']])){
   // Tytu?em wyja?nienia, tekst jest nast?puj?cy:
   // MOBILTEK wzywa {nazwa_klienta} do wystawienia faktury VAT na kwot? {kwota} + 22% VAT
   $pdf->Bold() ;
   $text = $string['mobiltek_wzywa'].$_billedClient['name'].$string['do_wyst_fv'].
		   PdfFactory::currency($allValue,0,2).(sizeof($waluty) > 0 ? '*':'').$string['plus_vat'] ;
   $draft->MultiCell(0,5,$text);
   $pdf->Unbold() ;
   $draft->Cell(0,5,$string['tresc_fv'],0,1);
   $draft->Italic();
   $draft->MultiCell(0,5,$_invoiceTitle);
   $draft->Unitalic();
   
   $prevCoords = array('x'=>$draft->GetX(),'y'=>$draft->GetY()) ;
   $codeParams = array('w'=>80,'h'=>7) ;
   $baseCoords = array('x'=> $draft->w - $draft->rMargin - $codeParams['w'],'y'=>$draft->h - $codeParams['h'] - $draft->bMargin) ;
   $Xcode = $baseCoords['x'] + ($codeParams['w'] - $draft->GetStringWidth($_reportNo))/2;
   $draft->Code128($baseCoords['x'], $baseCoords['y'], $_reportNo,$codeParams['w'], $codeParams['h']);
   //$draft->SetXY($Xcode,($baseCoords['y']+$codeParams['h']+1));
   $draft->SetXY($prevCoords['x'],$prevCoords['y']) ;
   //$draft->Write(4, $_reportNo);
   
} else {
   // Wypisujemy szczeg??y faktur
   $counted = 0 ;
   $text = $string['mobiltek_wzywa'].$_billedClient['name'].$string['do_wyst'].
            sizeof($split_invoice[$_billedClient['number']]).' ('.
            $inttotext[sizeof($split_invoice[$_billedClient['number']])][0].')'.$string['fv_na_kwote'].
		    PdfFactory::currency($allValue,0,2).(sizeof($waluty) > 0 ? '*':'').$string['plus_vat_z_podzialem']."\n\n" ;
/*
 * Tekst do wy?wietlenia jest nast?puj?cy:
 * MOBILTEK wzywa {nazwa_klienta} do wystawienia {ilosc_faktur} ({ilosc_slownie}) faktur VAT na kwot?
 * {kwota} + 22% z nast?puj?cym podzia?em
 */
   $draft->Bold() ;
   $draft->MultiCell(0,5,$text);
   $draft->Unbold() ;
   for($i = 0; $i < sizeof($split_invoice[$_billedClient['number']]); $i++){
      $text = ($i+1).". ".$inttotext[$i+1][1].
              $string['fv_z'].$split_invoice[$_billedClient['number']][$i]['days'].$string['dniowym_term_pl'].
              $split_invoice[$_billedClient['number']][$i]['percentage'].$string['procent_wart_wyn'].
		      ($i == sizeof($split_invoice[$_billedClient['number']]) - 1 
		      ?
		      PdfFactory::currency(round($allValue - $counted, 2),0,2)
		      :
              PdfFactory::currency(round($allValue * ($split_invoice[$_billedClient['number']][$i]['percentage']) / 100, 2),0,2))
		      .$string['plus_vat_tresc_fv'] ;
/*
 * Tekst wy?wietlany jest nast?puj?cy:
 * {numer}. {numer_slownie} faktura z {ilosc_dni}-dniowym terminem p?atno?ci, opiewa na {ilosc_procent}% 
 * warto?ci wynagrodzenia, czyli {kwota_czesciowa} + 22% VAT.
 * 
 * Tre?? faktury VAT
 */
      $draft->MultiCell(0,5,$text);
      $draft->Italic();
      $draft->MultiCell(0,5,$_invoiceTitle);
      $draft->Unitalic();
      $draft->Ln(5) ;
      $counted += round($allValue * ($split_invoice[$_billedClient['number']][$i]['percentage']) / 100, 2) ;
   }
}
$draft->Ln(5) ;
$draft->Bold();
$draft->Cell(0,5,$string['termin_wyst'],0,1);
$draft->Unbold();
$draft->Cell(0,15,$string['rap_sporz'].$_reportDate,0,1);
$draft->Cell(0,5,$_reportAuthor,0,1);
if(sizeof($waluty) > 0){
	$draft->Ln(5) ;
	foreach($waluty as $waluta){
		if($waluta == 'EUR' || $waluta == 'GBP')
			$draft->Ln(5) ;
		if($waluta == 'GBP')
			$draft->Ln(5) ;
	}
}
if($pdf->GetY() + $draft->GetY() - $h_begin > $pdf->GetPageHeight() - $pdf->GetBMargin())
   $pdf->AddPage() ;
$draft->SetY($h_begin) ;
// <<< Block <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
if(!isset($split_invoice[$_billedClient['number']])){
   // Tytu?em wyja?nienia, tekst jest nast?puj?cy:
   // MOBILTEK wzywa {nazwa_klienta} do wystawienia faktury VAT na kwot? {kwota} + 22% VAT
   $text = $string['mobiltek_wzywa'].$_billedClient['name'].$string['do_wyst_fv'].
		   PdfFactory::currency($allValue,0,2).(sizeof($waluty) > 0 ? '*':'').$string['plus_vat'] ;
   $pdf->Bold() ;
   $pdf->MultiCell(0,5,$text);
   $pdf->Unbold() ;
   $pdf->Cell(0,5,$string['tresc_fv'],0,1);
   $pdf->Italic();
   $pdf->MultiCell(0,5,$_invoiceTitle);
   $pdf->Unitalic();
   
   $prevCoords = array('x'=>$pdf->GetX(),'y'=>$pdf->GetY()) ;
   $codeParams = array('w'=>80,'h'=>7) ;
   $baseCoords = array('x'=> $pdf->w - $codeParams['w'] - $pdf->rMargin,'y'=>$pdf->h - $codeParams['h'] - $pdf->bMargin) ;
   $Xcode = $baseCoords['x'] + ($codeParams['w'] - $pdf->GetStringWidth($_reportNo))/2;
   $pdf->Code128($baseCoords['x'], $baseCoords['y'], $_reportNo,$codeParams['w'], $codeParams['h']);
   //$draft->SetXY($Xcode,($baseCoords['y']+$codeParams['h']+1));
   $pdf->SetXY($prevCoords['x'],$prevCoords['y']) ;
   //$pdf->Write(4, $_reportNo);
} else {
   // Wypisujemy szczeg??y faktur
   $counted = 0 ;
   $text = $string['mobiltek_wzywa'].$_billedClient['name'].$string['do_wyst'].
            sizeof($split_invoice[$_billedClient['number']]).' ('.
            $inttotext[sizeof($split_invoice[$_billedClient['number']])][0].')'.$string['fv_na_kwote'].
		    PdfFactory::currency($allValue,0,2).(sizeof($waluty) > 0 ? '*':'').$string['plus_vat_z_podzialem']."\n\n" ;
/*
 * Tekst do wy?wietlenia jest nast?puj?cy:
 * MOBILTEK wzywa {nazwa_klienta} do wystawienia {ilosc_faktur} ({ilosc_slownie}) faktur VAT na kwot?
 * {kwota} + 22% z nast?puj?cym podzia?em
 */
   $pdf->Bold() ;
   $pdf->MultiCell(0,5,$text);
   $pdf->Unbold() ;
   for($i = 0; $i < sizeof($split_invoice[$_billedClient['number']]); $i++){
      $text = ($i+1).". ".$inttotext[$i+1][1].
              $string['fv_z'].$split_invoice[$_billedClient['number']][$i]['days'].$string['dniowym_term_pl'].
              $split_invoice[$_billedClient['number']][$i]['percentage'].$string['procent_wart_wyn'].
		      ($i == sizeof($split_invoice[$_billedClient['number']]) - 1 
		      ?
		      PdfFactory::currency(round($allValue - $counted, 2),0,2)
		      :
              PdfFactory::currency(round($allValue * ($split_invoice[$_billedClient['number']][$i]['percentage']) / 100, 2),0,2))
		      .$string['plus_vat_tresc_fv'] ;
/*
 * Tekst wy?wietlany jest nast?puj?cy:
 * {numer}. {numer_slownie} faktura z {ilosc_dni}-dniowym terminem p?atno?ci, opiewa na {ilosc_procent}% 
 * warto?ci wynagrodzenia, czyli {kwota_czesciowa} + 22% VAT.
 * 
 * Tre?? faktury VAT
 */
      $pdf->MultiCell(0,5,$text);
      $pdf->Italic();
      $pdf->MultiCell(0,5,$_invoiceTitle);
      $pdf->Unitalic();
      $pdf->Ln(5) ;
      $counted += round($allValue * ($split_invoice[$_billedClient['number']][$i]['percentage']) / 100, 2) ;
   }
}
$pdf->Ln(5) ;
$pdf->Bold();
$draft->Cell(0,5,$string['termin_wyst'],0,1);
$draft->Unbold();
$draft->Cell(0,15,$string['rap_sporz'].$_reportDate,0,1);
$pdf->Cell(0,5,$_reportAuthor,0,1);
/** Przygotowanie zestawienia kurs?w walut **/
if(sizeof($waluty) > 0){
	if(!isset($t_kursy_walut))
		$t_kursy_walut = DbMan::GetTable('sms','kursy_walut') ;
	$kursy_walut = $t_kursy_walut->Select('*','kw_okres_id = \''.$_periodId.'\' AND kw_kurs_bezposredni = true ') ;
	$tmp = array() ;
	
	foreach($kursy_walut as $row){
		// Kursy odwrotne liczone jako odwrotno?? kursu prostego
		$tmp[$row['kw_kod_waluty_dst'].' - '.$row['kw_kod_waluty_src']] = 
			array('kurs' => 1 / $row['kw_kurs'], 'data' => $row['kw_data_kursu']) ;
	}
	
	foreach($kursy_walut as $row){
		// Kursy proste, nadpisanie tych odwrotnych, kt?re maj? podane proste
		$tmp[$row['kw_kod_waluty_src'].' - '.$row['kw_kod_waluty_dst']] = 
			array('kurs' => $row['kw_kurs'], 'data' => $row['kw_data_kursu']) ;
	}
	$kursy_walut = $tmp ;
	$pdf->SetFontSize(8) ; 
	$pdf->Cell(0,7.5,$string['wal_obce'],0,1);
	$exchange_rate_displayed = array() ;
	$i = 1 ; // Iterator do wylistowania kurs?w walut
    sort($waluty);
	foreach($waluty as $waluta){
		if($waluta == 'EUR' ){
			if(!isset($exchange_rate_displayed['EUR'])){
				if(!isset($kursy_walut['EUR - PLN']))
					throw new Exception('Brak kursu EUR - PLN dla okresu '.$_periodId) ;
				$pdf->Cell(0,5,($i++).'. EUR - PLN: '.PdfFactory::currency($kursy_walut['EUR - PLN']['kurs'],0,4,'').$string['bph'].$kursy_walut['EUR - PLN']['data'],0,1);
				$exchange_rate_displayed[$waluta] = true ;
			}
		}
		if($waluta == 'GBP'){
			if(!isset($exchange_rate_displayed['GBP'])){
				if(!isset($kursy_walut['GBP - EUR']))
					throw new Exception('Brak kursu GBP - EUR dla okresu '.$_periodId) ;
				$pdf->Cell(0,5,($i++).'. GBP - EUR: '.PdfFactory::currency($kursy_walut['GBP - EUR']['kurs'],0,4,'').$string['bank_ny'].$kursy_walut['GBP - EUR']['data'],0,1);
				$pdf->Cell(0,5,$string['przewalutowanie'],0,1);
				$exchange_rate_displayed[$waluta] = true ;
			}
		}
	}
}



// Wysyłam PDFa na wyjście. 
$pdf->buffer = htmlspecialchars_decode($pdf->buffer);
if($filePath.$fileName == "")
  $pdf->Output();
else
  $pdf->Output($filePath.$fileName,"F");
//$pdfReport->Output();
/********************************************/	
}
	
	
// ======================== Sekcja dodatkowych funkcji =====================
//*/
/**
 * Funkcja formatuj?ca warto?? wed?ug zadanych paramter?w
 * @param integer $amount Warto?? zapisana jako integer (wcze?niej przemno?ona przez wska?nik)
 * @param integer $in_prec Ilo?? rz?d?w wielko?ci, o jakie zwi?kszona by?a pocz?tkowo warto??
 * @param integer $out_prec Docelowa precyzja
 * @param string $desc Opis waluty (np z?, PLN, EUR)
 * @return string Zwraca zadan? warto?? w postaci float z dodanym przyrostkiem
 */

	public static function currency($amount, $in_prec = 0, $out_prec = 'default', $desc = 'PLN'){
	   if($out_prec == 'default') {
	      // Je?li wyj?ciowa precyzja jest domy?lna wtedy obcinamy do zera, chyba ?e 
	      // liczba ma tak?e niezerowe miejsca dziesi?tne ni?sze ni? 0.01
	      $out_prec = 2 ;
	      while($amount % pow(10,$in_prec - $out_prec)){
	         $out_prec++ ;
	      }
	   }
	   return number_format($amount / pow(10, $in_prec), $out_prec, ',', '.').' '.$desc ;
	}

/**
 * Funkcja zamieniaj?ca zmiennopozycyjn? warto?? na integera z zachowaniem odpowiedniej precyzji
 *
 * @param float $val Warto?? zamieniana
 * @param integer $prec Zak?adana precyzja
 * @return integer Zwr?cona reprezentacja
 */

 public function floattoint($val, $prec){
	   return intval($val * pow(10,$prec)) ;
}
}

?>
