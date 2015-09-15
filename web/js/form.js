function specjalnosci_dla_kierunku(kierunek) {
	var specjalnosci = null;
	
	switch(kierunek) {
		case 'informatyka':
			specjalnosci: new Array();
			specjalnosci = {
					systemy: 'Systemy baz danych',
					inzynieria: 'Inżynieria oprogramowania',
					technologie: 'Technologie multimedialne i grafika komputerowa'	
			};
			break;
			
		case 'politologia':
			specjalnosci = new Array();
			specjalnosci = {
					komunikacja: 'Komunikacja społeczna',
					manager: 'Manager projektów europejskich', 
					polityka: 'Polityka regionalna i samorządowa'
			};
			break;
		case 'turystyka i rekreacja':
			specjalnosci = new Array();
			if ($('#kandydat_studia_typ_mgr').attr('checked')) {
				specjalnosci = {
						miedzynarodowa: 'Turystyka międzynarodowa',
						zarzadzanie_turystyka: 'Zarządzanie turystyką i rekreacją',
						informatyka_w_turystyce: 'Informatyka w sektorze turystycznym',
						zarzadzanie_promocja_regionalna: 'Zarządzanie promocją regionalną i lokalną'
				};
			}
			else {
				specjalnosci = {
						obsluga: 'Obsługa ruchu turystycznego',
						hotelarstwo: 'Hotelarstwo i Gastronomia',
						zarzadzanie: 'Zarządzanie w turystyce', 
						turystyka: 'Turystyka międzynarodowa'
				};			
			}
			break;
	}
	
	$('#kandydat_specjalnosc').empty();
	$('#kandydat_filters_specjalnosc').empty();
	
	if(specjalnosci!=null) {
		
		
		for (key in specjalnosci) {	
			$('#kandydat_specjalnosc').append('<option value="'+key+'">'+specjalnosci[key]+'</option>');
		}
		
		// backend filters	
		$('#kandydat_filters_specjalnosc').append('<option value="all"></option>');
		for (key in specjalnosci) {	
			$('#kandydat_filters_specjalnosc').append('<option value="'+key+'">'+specjalnosci[key]+'</option>');
		}
		
	}
	
	$('#kandydat_specjalnosc option').each(function () {
        if($(this).val()==specjalnosc) {
        	$(this).attr('selected',true);
        }
      });
	
	$('#kandydat_filters_specjalnosc option').each(function () {
        if($(this).val()==specjalnosc) {
        	$(this).attr('selected',true);
        }
      });
}

function jezyki_dla_kierunku(kierunek) {
	// jezyk1
	var jezyki1 = null;
	switch(kierunek) {
		case 'informatyka':
			jezyki1 = new Array('angielski');
			break;
		default:
			jezyki1 = new Array('angielski','niemiecki','francuski','wloski');
			break;
		}
		if(jezyki1!=null) {	
			$('#kandydat_jezyk').empty();
			
			for (key in jezyki1) {	
				$('#kandydat_jezyk').append('<option value='+jezyki1[key]+'>'+jezyki1[key]+'</option>');
			}
		}
		
		$('#kandydat_jezyk option').each(function () {
	        if($(this).val()==jezyk) {
	        	$(this).attr('selected',true);
	        }
	      });
	// jezyk2
	var jezyki2 = null;
	$('#kandydat_jezyk2').removeAttr('disabled');
	switch(kierunek) {
		case 'informatyka':
			jezyki2 = new Array();
			$('#kandydat_jezyk2').attr('disabled',true);
			$('#kandydat_studia_typ_mgr').attr('disabled',true);
			$('#kandydat_studia_typ_inz').attr('checked', true);
			break;
		case 'turystyka i rekreacja':
			jezyki2 = new Array('brak', 'angielski','niemiecki','francuski','wloski');
			$('#kandydat_studia_typ_mgr').removeAttr('disabled');
			break;
		default:
			jezyki2 = new Array('brak', 'angielski','niemiecki','francuski','wloski');
			$('#kandydat_studia_typ_mgr').attr('disabled',true);
			$('#kandydat_studia_typ_inz').attr('checked', true);
			break;
		}
		if(jezyki2!=null) {
			$('#kandydat_jezyk2').empty();
			
			for (key in jezyki2) {	
				$('#kandydat_jezyk2').append('<option value='+jezyki2[key]+'>'+jezyki2[key]+'</option>');
			}
		}
		
		$('#kandydat_jezyk2 option').each(function () {
	        if($(this).val()==jezyk2) {
	        	$(this).attr('selected',true);
	        }
	      });
}

function korespondencja(rozwin) {
	var fields = new Array('ulica','dom_nr','mieszkanie_nr','kod', 'miasto', 'wojewodztwo');
	if(rozwin) {
		for (key in fields) {
			$('#kandydat_korespondencja_'+fields[key]).parent().parent().show();
		}	
	} else {
		for (key in fields) {
			$('#kandydat_korespondencja_'+fields[key]).parent().parent().hide();
		}
	}
}


$(document).ready(function() {
	$('#kandydat_studia_typ_mgr').attr('disabled',true);
	specjalnosci_dla_kierunku($('#kandydat_kierunek').val());
	jezyki_dla_kierunku($('#kandydat_kierunek').val());
	korespondencja($('#kandydat_korespondencja').is(':checked'));
	
	
	$('input[name=kandydat[stacjonarne]]').change(function() {		
		if($(this).val()!="0") {
			$('#kandydat_plywanie_grupa').attr('disabled',true);
			}
		else {
			$('#kandydat_plywanie_grupa').removeAttr('disabled');
			}
		});
	
	$('#kandydat_kierunek').change(function() {
		// specjalnosci
		specjalnosci_dla_kierunku($('#kandydat_kierunek').val());
		//jezyki
		jezyki_dla_kierunku($('#kandydat_kierunek').val());	
	});
	
	$('#kandydat_filters_kierunek').change(function(){
		specjalnosci_dla_kierunku($('#kandydat_filters_kierunek').val());
	});

	$('#kandydat_studia_typ_mgr').change(function(){
		specjalnosci_dla_kierunku($('#kandydat_kierunek').val());
	});

	$('#kandydat_studia_typ_inz').change(function(){
		specjalnosci_dla_kierunku($('#kandydat_kierunek').val());
	});

	
	$('#kandydat_korespondencja').change(function() {
		korespondencja($(this).is(':checked'));	
		});
	});