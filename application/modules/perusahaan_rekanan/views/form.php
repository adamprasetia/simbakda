<section class="content-header">
	<h1>
		<?php echo $title ?>
		<small><?php echo $heading ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo anchor('home','<span class="glyphicon glyphicon-home"></span> '.$this->lang->line('home'))?></li>
	  <li><?php echo anchor($breadcrumb,$this->lang->line('list'))?></li>
	  <li class="active"><?php echo $heading?></li>
	</ol>
</section>

<section class="content">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><?php echo $add_btn ?></li>
		<li role="presentation"><?php echo $list_btn ?></li>
	</ul>
	<?php echo $this->session->flashdata('alert')?>
	<?php echo form_open_multipart($action)?>
	<div class="box box-default">
		<div class="box-header owner">
			<?php echo $owner?>
		</div>
		<div class="box-body">
			<div class="form-group form-inline">
				<?php echo form_label($this->lang->line('code'),'code',array('class'=>'control-label'))?>
				<?php echo form_input(array('name'=>'code','class'=>'form-control input-sm','maxlength'=>'15','autocomplete'=>'off','value'=>set_value('code',(isset($row->code)?$row->code:'')),'required'=>'required','autofocus'=>'autofocus'))?>
				<small><?php echo form_error('code')?></small>
			</div>
			<div class="form-group form-inline">
				<?php echo form_label($this->lang->line('name'),'name',array('class'=>'control-label'))?>
				<?php echo form_input(array('name'=>'name','class'=>'form-control input-sm','maxlength'=>'100','size'=>'60','autocomplete'=>'off','value'=>set_value('name',(isset($row->name)?$row->name:'')),'required'=>'required'))?>
				<small><?php echo form_error('name')?></small>
			</div>
			<div class="form-group form-inline">
				<?php echo form_label("Bentuk",'perusahaan_bentuk',array('class'=>'control-label'))?>
				<?php echo form_dropdown('perusahaan_bentuk',$this->general_model->dropdown('perusahaan_bentuk','Bentuk'),set_value('perusahaan_bentuk',(isset($row->perusahaan_bentuk)?$row->perusahaan_bentuk:'')),'required=required class="form-control input-sm select2"')?>
				<small><?php echo form_error('perusahaan_bentuk')?></small>
			</div>						
			<div class="form-group form-inline">
				<?php echo form_label('Alamat','alamat',array('class'=>'control-label'))?>
				<?php echo form_textarea(array('name'=>'alamat','class'=>'form-control input-sm','rows'=>'3','cols'=>'100','maxlength'=>'200','autocomplete'=>'off','value'=>set_value('alamat',(isset($row->alamat)?$row->alamat:'')),'required'=>'required'))?>
				<small><?php echo form_error('alamat')?></small>
			</div>
			<div class="form-group form-inline">
				<?php echo form_label('Pimpinan','pimpinan',array('class'=>'control-label'))?>
				<?php echo form_input(array('name'=>'pimpinan','class'=>'form-control input-sm','maxlength'=>'50','size'=>'60','autocomplete'=>'off','value'=>set_value('pimpinan',(isset($row->pimpinan)?$row->pimpinan:'')),'required'=>'required'))?>
				<small><?php echo form_error('pimpinan')?></small>
			</div>
			<div class="form-group form-inline">
				<?php echo form_label("Bank",'bank',array('class'=>'control-label'))?>
				<?php echo form_dropdown('bank',$this->general_model->dropdown('bank','Bank'),set_value('bank',(isset($row->bank)?$row->bank:'')),'required=required class="form-control input-sm select2"')?>
				<small><?php echo form_error('bank')?></small>
			</div>						
			<div class="form-group form-inline">
				<?php echo form_label('Rekening','rekening',array('class'=>'control-label'))?>
				<?php echo form_input(array('name'=>'rekening','class'=>'form-control input-sm','maxlength'=>'50','size'=>'60','autocomplete'=>'off','value'=>set_value('rekening',(isset($row->rekening)?$row->rekening:'')),'required'=>'required'))?>
				<small><?php echo form_error('rekening')?></small>
			</div>
		</div>
		<div class="box-footer">
			<button class="btn btn-success btn-sm" type="submit" onclick="return confirm('Are you sure')"><span class="glyphicon glyphicon-save"></span> <?php echo $this->lang->line('save') ?></button>
			<?php echo anchor($breadcrumb,'<span class="glyphicon glyphicon-repeat"></span> '.$this->lang->line('cancel'),array('class'=>'btn btn-danger btn-sm'))?>
		</div>
	</div>
	<?php echo form_close()?>
</section>
