<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form id="kandydat_form" action="<?php echo url_for('kandydat/changeImage'.(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <div class="form_nav">
          	<a href="<?php echo url_for('kandydat/index') ?>">Lista</a>          	
          </div>
          <input type="submit" value="Zapisz" />
        </td>
      </tr>
    </tfoot>
    <tbody>
    	<?php $fieldsList = array(
		      'zdjecie'      
    	); 
    	?>
      	<?php foreach ($fieldsList as $key): ?>
  	  	<tr>
  	  		<th><?php 
  	  			echo $form[$key]->renderLabel();
  	  			echo ($form['zdjecie']->getValue()=='' ? '<br /><br /> Brak zdjęcia.' : image_tag('/uploads/'.$kandydatLogin.'/'.$form['zdjecie']->getValue(),array('width'=>'180')));
  	  			?></th>
  	  		<td>
  	  			<?php 
  	  				$attr = array();
  	  				
  	  				if($form[$key]->hasError()) 
  	  					$attr['class'] = 'input_error';
  	  					  	  				
  	  				echo $form[$key]->render($attr);
  	  			?>  
  	  			<span class="form_error"><?php echo $form[$key]->renderError(); ?></span> 			
  	  		</td>  	  		
  	  	</tr>  	  	  	  
  	  	
  	  	<?php endforeach; ?>  	
  
    </tbody>
  </table>
</form>
