<?php foreach ($field as $f): ?>
	<?php if ($f['filter']): ?>
		<?php if ($f['type']=='string' || $f['type']=='memo'): ?>
			<div class="form-group">
				<?php echo form_input(array('name'=>$f['id'],'value'=>$this->input->get($f['id']),'autocomplete'=>'off','placeholder'=>$f['name'].'..','onchange=>"submit()"','class'=>'form-control input-sm'))?>
			</div>			
		<?php elseif ($f['type']=='date'): ?>
			<div class="form-group">
				<?php echo $f['name'].':'; ?>
				<?php echo form_input(array('name'=>$f['id'].'_from','value'=>$this->input->get($f['id'].'_from'),'autocomplete'=>'off','placeholder'=>$this->lang->line('from'),'class'=>'form-control input-sm input-tanggal'))?>
				<?php echo form_input(array('name'=>$f['id'].'_to','value'=>$this->input->get($f['id'].'_to'),'autocomplete'=>'off','placeholder'=>$this->lang->line('to'),'class'=>'form-control input-sm input-tanggal'))?>
			</div>			
		<?php elseif ($f['type']=='number'): ?>
			<div class="form-group">
				<?php echo form_input(array('name'=>$f['id'],'value'=>$this->input->get($f['id']),'autocomplete'=>'off','placeholder'=>$f['name'].'..','onchange=>"submit()"','class'=>'form-control input-sm'))?>
			</div>			
		<?php elseif ($f['type']=='dropdown'): ?>	
			<div class="form-group">
				<?php echo form_dropdown($f['id'],$this->general_model->dropdown($f['id'],$f['name']),$this->input->get($f['id']),'class="form-control input-sm select2" onchange="submit()"')?>
			</div>			
		<?php endif ?>
	<?php endif ?>
<?php endforeach ?>
<button class="btn btn-primary btn-sm" type="submit"><span class="glyphicon glyphicon-filter"></span> Filter</button>