<h1>Przypominanie hasła</h1>

<div id="error">
    <font color="red">
    <?php if ($sf_user->hasFlash('error')): ?>
  	<?php echo $sf_user->getFlash('error') ?>
	<?php endif; ?>
	</font>    
</div>

<div id="notice">
    <b>
    <?php if ($sf_user->hasFlash('notice')): ?>
  	<?php echo $sf_user->getFlash('notice') ?>
	<?php endif; ?>
	</b>    
</div>

<p>
	Pytanie: <?php echo $kandydat->getPytanieHaslo() ?>
</p>
<p>
<form id="kandydat_form" action="<?php echo url_for('kandydat/remind2') ?>" method="post">
  <table id="login_form">
    <tfoot>
      <tr>
        <th >
          <input type="submit" value="Generuj hasło" />
        </th>
        <td>&nbsp</td>
      </tr>
    </tfoot>
    <tbody>
  	  	<tr>
  	  		<th><?php 
  	  			echo $form['odpowiedz']->renderLabel();
  	  		?></th>
  	  		<td>
  	  			<?php echo $form['odpowiedz']->render(($form['odpowiedz']->hasError() ? array('class'=>'input_error') : array()));?>  	 
  	  			<span class="form_error"><?php echo $form['odpowiedz']->renderError(); ?></span> 			
  	  		</td>  	  		
  	  	</tr>
    </tbody>
  </table>  
</form>

</p>