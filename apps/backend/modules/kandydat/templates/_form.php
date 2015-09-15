<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form id="kandydat_form" action="<?php echo url_for('kandydat/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <div class="form_nav">
          	<a href="<?php echo url_for('kandydat/index') ?>">Lista</a>
          	<?php if (!$form->getObject()->isNew()): ?>
	          	<?php echo link_to('Usuń', 'kandydat/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Czy na pewno usunąć kadydata?')) ?>
    	      <?php endif; ?>
          </div>
          <input type="submit" value="<?php echo (!$form->getObject()->isNew() ? 'Zapisz' : 'Dodaj') ?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
    	<?php $fieldsList = array(
		      'imiona',
		      'nazwisko',
		      'plec',
		      'urodzenie_miejsce',
		      'narodowosc',
		      'obywatelstwo',
    	      'matka_imie',
		      'ojciec_imie',
		      'pesel',
		      'dowod_osobisty_nr',
		      'nip',
		      'telefon_nr',
		      'mobile_nr',
		      
		      'zameldowanie_ulica',
		      'zameldowanie_dom_nr',
      		  'zameldowanie_mieszkanie_nr',
    	      'zameldowanie_kod',
    	      'zameldowanie_miasto',
    		  'zameldowanie_wojewodztwo',
    		  
    	      'korespondencja',    	
		      'korespondencja_ulica',
		      'korespondencja_dom_nr',
		      'korespondencja_mieszkanie_nr',
		      'korespondencja_kod',
		      'korespondencja_miasto',
		      'korespondencja_wojewodztwo',
    	      
		      'stosunek_do_sluzby_wojskowej',
    	      'ksiazeczka_wojskowa_nr',
    	      'wku_miasto',
    	      'niepelnosprawny',		
    		  
    		  'szkola_srednia',
			  'szkola_srednia_rok_ukonczenia',
    	      'skonczone_studia',
		      'skonczone_studia_rok_ukonczenia',
    	      'inne_studia',		      
		      
    	      'kierunek',
		      'specjalnosc',		      
		      'stacjonarne',
		      'studia_typ',
    		  'jezyk',
		      'jezyk2',
    		  'plywanie_grupa',
		          	
		      'email',
			  'login',
		      
		      'skad_wiem',

		      'pytanie_haslo',
		      'odpowiedz_haslo',
		      
		      'przelew_zaksiegowany',
		      'dokumenty_dotarly',
		      'szkola_komentarz',
		      
		      
    	); 
    	?>
      	<?php 
      	foreach ($fieldsList as $key): ?>
  	  	<tr>
  	  		<th><?php 
  	  		
  	  			echo $form[$key]->renderLabel(); 
/*
  	  			if ((!$form->getObject()->isNew())&&($key=='zdjecie')) {
  	  				echo image_tag('/uploads/'.$form['login']->getValue().'/'.$form['zdjecie']->getValue(),array('width'=>'180'));
	  	  		}
	  	  		*/
  	  		?></th>
  	  		<td>
  	  			<?php echo $form[$key]->render(($form[$key]->hasError() ? array('class'=>'input_error') : array()));?>  	 
  	  			<span class="form_error"><?php echo $form[$key]->renderError(); ?></span> 			
  	  		</td>  	  		
  	  	</tr>  	  	  	  
  	  	
  	  	<?php endforeach; ?>  	
  
    </tbody>
  </table>
</form>
