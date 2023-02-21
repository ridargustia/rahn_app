<?php if (is_grandadmin()) { ?>
<div class="form-group">
    <label>Instansi<span style="color: red">*</span></label>
    <?php echo form_dropdown('', $get_all_combobox_instansi, $user->instansi_id, $instansi_id) ?>
</div>
<?php } ?>
<div class="form-group">
    <label>Cabang<span style="color: red">*</span></label>
    <?php echo form_dropdown('', $get_all_combobox_cabang, $user->cabang_id, $cabang_id) ?>
</div>