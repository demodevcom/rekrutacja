<h1>Operacje</h1>
<p>
	<a href="<?php echo url_for('kandydat/petition') ?>">Drukuj prośbę o przyjęcie</a>
	<br />
	<a href="<?php echo url_for('kandydat/questionaire') ?>">Drukuj podanie na studia</a>
	<br />
	<a href="<?php echo url_for('kandydat/teczka') ?>">Drukuj stronę na teczkę</a>

	<br />
	<a href="<?php echo url_for('kandydat/show') ?>">Podgląd danych</a>

	<br />
	<a href="<?php echo url_for('kandydat/edit') ?>">Edycja danych</a>

	<br />
	<a href="<?php echo url_for('kandydat/progress') ?>">Informacja o postępie rekrutacji</a>

	<br />
	<?php //if ($kandydat->getStudiaTyp() != 'mgr'): ?>
		<a href="<?php echo url_for('kandydat/bankTransfer') ?>">Drukuj blankiet przelewu opłaty wpisowej</a>
	<?php //endif; ?>
	
	<br /><br />
	<a href="<?php echo url_for('login/logout') ?>">Wyloguj</a>
	
	<?php if (strlen($kandydat->getSzkolaKomentarz()) > 0): ?>
		<br /><br />
		<p>
		<font color="red">
		<b>Informacja z Dziekanatu:</b>
		<br />
		<?php echo $kandydat->getSzkolaKomentarz() ?>		
		</font>
		</p>
	<?php endif?>
	
</p>
