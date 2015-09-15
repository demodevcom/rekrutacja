<?php //include_stylesheets_for_form($loginForm) ?>
<?php //include_javascripts_for_form($loginForm) ?>

<?php //echo form_tag_for($loginForm, '@login') ?>

<form id="kandydat_form" action="<?php echo url_for('@default?module=login&action=index') ?>" method="post">
  <table id="login_form">
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" value="Zaloguj się" />
        </td>
      </tr>
    </tfoot>

    <tbody>
      <?php echo $loginForm ?>
    </tbody>
  </table>
</form>