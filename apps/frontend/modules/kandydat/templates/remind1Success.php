<h1>Przypominanie hasła</h1>

<div id="error">
    <font color="red">
    <?php if ($sf_user->hasFlash('error')): ?>
  	<?php echo $sf_user->getFlash('error') ?>
	<?php endif; ?>
	</font>    
</div>


<p>
<form id="kandydat_form" action="<?php echo url_for('kandydat/remind1') ?>" method="post">
  <table id="login_form">
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" value="Dalej" />
        </td>
      </tr>
    </tfoot>
    <tbody>
  	  	<tr>
  	  		<th><?php 
  	  			echo $form['pesel']->renderLabel();
  	  		?></th>
  	  		<td>
  	  			<?php echo $form['pesel']->render(($form['pesel']->hasError() ? array('class'=>'input_error') : array()));?>  	 
  	  			<span class="form_error"><?php echo $form['pesel']->renderError(); ?></span> 			
  	  		</td>  	  		
  	  	</tr>
    </tbody>
  </table>  
</form>

</p>