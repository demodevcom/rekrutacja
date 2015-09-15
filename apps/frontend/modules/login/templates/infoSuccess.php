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
