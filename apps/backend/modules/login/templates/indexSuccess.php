<h1>Witaj w panelu administracyjnym</h1>

<!-- flashe pomocnicze, do wywalenia -->
<div id="notice">
    <?php if ($sf_user->hasFlash('aNotice')): ?>
  	<?php echo $sf_user->getFlash('aNotice') ?>
	<?php endif; ?>    
</div>

<div id="error">
    <?php if ($sf_user->hasFlash('aError')): ?>
  	<?php echo $sf_user->getFlash('aError') ?>
	<?php endif; ?>    
</div>

<?php //utl_dump_array('POST', $_POST) ?>
<?php //utl_dump_array('SESSION', $_SESSION) ?>

<?php include_partial('login', array('loginForm' => $form)) ?>