<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($kandydat->getId(), 'kandydat_kandydat_edit', $kandydat) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_imiona">
  <?php echo $kandydat->getImiona() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_nazwisko">
  <?php echo $kandydat->getNazwisko() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_kierunek">
  <?php echo $kandydat->getKierunekString() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_specjalnosc" style="width: 150px;">
  <?php echo $kandydat->getSpecjalnoscString() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_stacjonarne">
  <?php echo ($kandydat->getStacjonarne() == 0) ? 'stacjonarne' : 'niestacjonarne'  ?>
</td>
<td class="sf_admin_text sf_admin_list_td_studia_typ">
  <?php echo $kandydat->getStudiaTyp() ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php echo $kandydat->getCreatedAt() ? format_date($kandydat->getCreatedAt(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_text sf_admin_list_td_studia_typ">
  <?php echo ($kandydat->getDokumentyDotarly() ? 'tak' : 'nie'); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_studia_typ">
  <?php echo ($kandydat->getPrzelewZaksiegowany() ? 'tak' : 'nie'); ?>
</td>
