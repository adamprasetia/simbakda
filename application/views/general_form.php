<?php foreach ($field as $f): ?>
	<div class="form-group form-inline">
	<?php if ($f['field']): ?>
		<?php if ($f['type']=='string'): ?>
			<?php echo form_label($f['name'],$f['id'],array('class'=>'control-label'))?>
			<?php echo form_input(array('id'=>$f['id'],'name'=>$f['id'],'class'=>'form-control input-sm','maxlength'=>$f['size'],'size'=>$f['width'],'autocomplete'=>'off','value'=>set_value($f['id'],(isset($row->{$f['id']})?$row->{$f['id']}:''))))?>
			<small><?php echo form_error($f['id'])?></small>
		<?php elseif ($f['type']=='date'): ?>
			<?php echo form_label($f['name'],$f['id'],array('class'=>'control-label'))?>
			<?php echo form_input(array('id'=>$f['id'],'name'=>$f['id'],'class'=>'form-control input-sm input-tanggal','maxlength'=>$f['size'],'size'=>$f['width'],'autocomplete'=>'off','value'=>set_value($f['id'],(isset($row->{$f['id']})?format_dmy($row->{$f['id']}):''))))?>
			<small><?php echo form_error($f['id'])?></small>
		<?php elseif ($f['type']=='number'): ?>
			<?php echo form_label($f['name'],$f['id'],array('class'=>'control-label'))?>
			<?php echo form_input(array('id'=>$f['id'],'name'=>$f['id'],'class'=>'form-control input-sm input-uang','maxlength'=>$f['size'],'size'=>$f['width'],'autocomplete'=>'off','value'=>set_value($f['id'],(isset($row->{$f['id']})?$row->{$f['id']}:''))))?>
			<small><?php echo form_error($f['id'])?></small>
		<?php elseif ($f['type']=='dropdown'): ?>	
			<div class="form-group form-inline">
				<?php echo form_label($f['name'],$f['id'],array('class'=>'control-label'))?>
				<?php echo form_dropdown($f['id'],$this->general_model->dropdown($f['id'],$f['name']),set_value($f['id'],(isset($row->{$f['id']})?$row->{$f['id']}:'')),'id="'.$f['id'].'" class="form-control input-sm select2"')?>
				<small><?php echo form_error($f['id'])?></small>
			</div>									
		<?php elseif ($f['type']=='dropdown_ajax'): ?>	
			<div class="form-group form-inline">
				<?php echo form_label($f['name'],$f['id'],array('class'=>'control-label'))?>
				<?php echo form_dropdown($f['id'],$this->general_model->dropdown($f['id'],$f['name']),set_value($f['id'],(isset($row->{$f['id']})?$row->{$f['id']}:'')),'id="'.$f['id'].'" class="form-control input-sm"')?>
				<small><?php echo form_error($f['id'])?></small>
			</div>									
		<?php endif ?>
	<?php endif ?>
	</div>
<?php endforeach ?>