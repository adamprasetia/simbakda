<section class="content-header">
	<h1>
		<?php echo $title ?>
		<small><?php echo $subtitle ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo anchor('home','<span class="glyphicon glyphicon-home"></span> '.$this->lang->line('home'))?></li>
		<li class="active"><?php echo $title ?></li>
	</ol>
</section>
<section class="content">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation"><?php echo anchor($index.'/add'.get_query_string(),$this->lang->line('new')) ?></li>
		<li role="presentation" class="active"><?php echo anchor($index.get_query_string(),$this->lang->line('list')) ?></li>
	</ul>
	<?php echo $this->session->flashdata('alert')?>
	<div class="box box-default">
		<div class="box-body">
			<?php echo form_open($index.'/search'.get_query_string(null,'offset'),array('class'=>'form-inline'))?>
				<div class="form-group">
					<?php echo form_dropdown('limit',array('10'=>'10','50'=>'50','100'=>'100'),set_value('limit',$this->input->get('limit')),'onchange="submit()" class="form-control input-sm"')?> 
				</div>
				<?php echo $this->general->get_filter($field); ?>
			<?php echo form_close()?>
			<?php echo form_open($index.'/delete'.get_query_string(),array('class'=>'form-check-delete'))?>
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
			<button id="delete-btn" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> <?php echo $this->lang->line('delete_by_checked') ?></button>
		</div>
	</div>

</section>