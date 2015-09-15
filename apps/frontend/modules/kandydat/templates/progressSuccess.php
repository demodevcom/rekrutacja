<div id="kandydat_form" class="kandydat_show">
<h1>Postęp rekrutacji</h1>
<p>
	<a href="<?php echo url_for('kandydat/main') ?>">Powrót</a>
	<br />
</p>
<br />
<table>
  <tbody>
  	  	<tr>
  	  		<th>Czy wpłynęły dokumenty</th>
  	  		<td>
				<?php echo ($kandydat->getDokumentyDotarly() == '1' ? 'tak' : 'nie') ?>
  	  		</td>  	  		
  	  	</tr>
  	  	<tr>	
  	  		<th>Czy przelew został zaksięgowany</th>
  	  		<td>
				<?php echo ($kandydat->getPrzelewZaksiegowany() == '1' ? 'tak' : 'nie') ?>
  	  		</td>  	  		
  	  	</tr>
  	  	<tr>
  	  		<th>Informacje z WSTE</th>
  	  		<td>
				<?php echo $kandydat->getSzkolaKomentarz() ?>
  	  		</td>  	  		
  	  	</tr>
  </tbody>
</table>
<div class="form_nav">
<a href="<?php echo url_for('kandydat/main') ?>">Powrót</a>
<a href="<?php echo url_for('kandydat/edit') ?>">Edytuj</a>
<a href="<?php echo url_for('kandydat/formChangePass') ?>">Zmień hasło</a>
<a href="<?php echo url_for('kandydat/editImage') ?>">Zmień zdjęcie</a>
<a href="<?php echo url_for('login/logout') ?>">Wyloguj się</a>

</div>
</div>