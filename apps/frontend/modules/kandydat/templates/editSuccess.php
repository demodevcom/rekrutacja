<h1>Edycja danych kandydata
<img src="http://wste.edu.pl/rekrutacja/web/images/listwa4.jpg">
</h1>

<?php if ($sf_user->hasFlash('notice')): ?>
	<h3><font color="#70A476">Dane zostały zmienione</font></h3>
<?php endif ?>

<?php if ($sf_user->hasFlash('error')): ?>
	<h3><font color="red">Błąd podczas aktualizacji danych</font></h3>
<?php endif ?>

<?php include_partial('form_edit', array('form' => $form)) ?>
