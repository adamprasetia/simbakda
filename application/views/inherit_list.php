<section class="content-header">
	<h1>
		<?php echo $title ?>
		<small><?php echo $this->lang->line('list') ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo anchor('home','<span class="glyphicon glyphicon-home"></span> '.$this->lang->line('home'))?></li>
		<li class="active"><?php echo $this->lang->line('list') ?></li>
	</ol>
</section>
<section class="content">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation"><?php echo $add_btn ?></li>
		<li role="presentation" class="active"><?php echo $list_btn ?></li>
	</ul>
	<?php echo $this->session->flashdata('alert')?>
	<div class="box box-default">
		<div class="box-body">
			<?php echo form_open($action,array('class'=>'form-inline'))?>
				<div class="form-group">
					<?php echo form_dropdown('limit',array('10'=>'10','50'=>'50','100'=>'100'),set_value('limit',$this->input->get('limit')),'onchange="submit()" class="form-control input-sm"')?> 
				</div>
				<div class="form-group">
					<?php echo form_input(array('name'=>'search','value'=>$this->input->get('search'),'autocomplete'=>'off','placeholder'=>$this->lang->line('search').'..','onchange=>"submit()"','class'=>'form-control input-sm'))?>
				</div>
				<?php if (isset($index_parent) && isset($tbl_name) && $index_parent==$tbl_name): ?>					
					<div class="form-group">
						<?php echo form_dropdown($index_parent,$this->general_model->dropdown($index_parent,$title_parent,array('type'=>$code_parent)),$this->input->get($index_parent),'class="form-control input-sm select2" onchange="submit()"')?>
					</div>
				<?php endif ?>
				<?php if (isset($index_parent) && isset($tbl_name) && $index_parent!=$tbl_name): ?>
					<div class="form-group">
						<?php echo form_dropdown($index_parent,$this->general_model->dropdown($index_parent,$title_parent),$this->input->get($index_parent),'class="form-control input-sm select2" onchange="submit()"')?>
					</div>
				<?php endif ?>
			<?php echo form_close()?>
			<?php echo form_open($action_delete,array('class'=>'form-check-delete'))?>
			<div class="table-responsive">
				<?php echo $table?>
			</div>
			<?php echo form_close()?>
		</div>
		<div class="box-footer">
			<?php echo form_label($total,'',array('class'=>'label-footer'))?>
			<div class="pull-right">
				<?php echo $pagination?>
			</div>
		</div>		
	</div>
	<div class="box box-default">
		<div class="box-body">
			<?php echo $delete_btn?>
		</div>
	</div>

</section>