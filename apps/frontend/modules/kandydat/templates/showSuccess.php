<div id="kandydat_form" class="kandydat_show">
<h1>Dane kandydata</h1>
<p>
	<a href="<?php echo url_for('kandydat/main') ?>">Powrót</a>
	<br />
</p>
<br />
<table>
  <tbody>
  <?php foreach ($fieldList as $key): ?>
  	  	<tr>
  	  		<th><?php echo $formFields[$key] ?></th>
  	  		<td>
  	  			<?php
  	  			 if(in_array($key, array('plec','kierunek','stacjonarne'))) {
  	  			 	$key .= 'string';
  	  			 }
  	  			 $method = 'get'.$key;
  	  			 if ($key == 'zdjecie' ) {
  	  				echo image_tag('/uploads/'.$kandydat->getLogin().'/'.$kandydat->getZdjecie(),array('width'=>'180'));	  	  		
	  	  		 }
  	  			 else if($key == 'studia_typ')
  	  			 	echo $kandydat->getStudiaTypString();
  	  			 else if ($key == 'specjalnosc')
  	  			 	echo $kandydat->getSpecjalnoscString();
  	  			 else if ($key == 'korespondencja_ulica' || $key == 'korespondencja_dom_nr' || $key == 'korespondencja_kod' || $key == 'korespondencja_miasto' || $key == 'korespondencja_wojewodztwo') {
  	  			 	if (mb_strlen($kandydat->$method(), 'utf-8') == 0)
  	  			 		echo 'jak zameldowania';
  	  			 	else
  	  			 		$kandydat->$method();
  	  			 }
  	  			 else 
  	  			 	echo $kandydat->$method();  	  			 
  	  			 
  	  		    ?>  	  			
  	  		</td>  	  		
  	  	</tr>
  <?php endforeach; ?>
  </tbody>
</table>
<div class="form_nav">
<a href="<?php echo url_for('kandydat/edit') ?>">Edytuj</a>
<a href="<?php echo url_for('kandydat/formChangePass') ?>">Zmień hasło</a>
<a href="<?php echo url_for('kandydat/editImage') ?>">Zmień zdjęcie</a>
<a href="<?php echo url_for('login/logout') ?>">Wyloguj się</a>

</div>
</div>