<h1>Logowanie do serwisu</h1>

<!-- flashe pomocnicze, do wywalenia -->
<div id="notice">
    <?php if ($sf_user->hasFlash('notice')): ?>
  	<?php echo $sf_user->getFlash('notice') ?>
	<?php endif; ?>    
</div>

<div id="error">
    <?php if ($sf_user->hasFlash('error')): ?>
  	<?php echo $sf_user->getFlash('error') ?>
	<?php endif; ?>    
</div>

<?php //utl_dump_array('POST', $_POST) ?>
<?php //utl_dump_array('SESSION', $_SESSION) ?>

<?php include_partial('login', array('loginForm' => $form)) ?>