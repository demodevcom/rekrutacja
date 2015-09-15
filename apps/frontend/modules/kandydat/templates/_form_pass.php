<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form id="kandydat_form" action="<?php echo url_for('kandydat/changePass?id='.$form->getObject()->getId()) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <div class="form_nav">          	
			<a href="<?php echo url_for('kandydat/show') ?>">Powrót</a>
          </div>
          <input type="submit" value="<?php echo (!$form->getObject()->isNew() ? 'Zapisz' : 'Dodaj') ?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
    	<?php $fieldsList = array(
		      'haslo',
    		  'haslo2'		      
    	)
    	?>
      	<?php foreach ($fieldsList as $key): ?>
  	  	<tr>
  	  		<th><?php 
  	  			echo $form[$key]->renderLabel();

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
