<section class="content-header">
	<h1>
		<?php echo $title ?>
		<small><?php echo $subtitle ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo anchor('home','<span class="glyphicon glyphicon-home"></span> '.$this->lang->line('home'))?></li>
	  <li><?php echo anchor($index.get_query_string(),$this->lang->line('list'))?></li>
	  <li class="active"><?php echo $title?></li>
	</ol>
</section>
<section class="content">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><?php echo $tab ?></li>
		<li role="presentation"><?php echo anchor($index.get_query_string(),$this->lang->line('list')) ?></li>
	</ul>
	<?php echo $this->session->flashdata('alert')?>
	<?php echo form_open($action)?>
	<div class="box box-default">
		<div class="box-header owner">
			<?php echo $owner?>
		</div>
		<div class="box-body">
			<?php echo $this->general->get_form($field,(isset($row)?$row:'')); ?>
		</div>
	</div>
	<div class="box box-default">
		<div class="box-header">
			Detail
		</div>
		<div class="box-body">
			<div class="table-responsive form-inline">
				<button id="add-detail-btn" type="button" class="btn btn-primary btn-sm">
					<span class="glyphicon glyphicon-plus"></span> <?php echo $this->lang->line('new') ?>
				</button>			
				<table id="detail-table" class="table table-bordered">
					<tr>
						<?php foreach ($field_detail as $row): ?>
							<?php if ($row['table']): ?>
								<th><?php echo $row['name'] ?></th>
								<?php if ($row['id']=='harga'): ?>
									<th>Total</th>
								<?php endif ?>
							<?php endif ?>							
						<?php endforeach ?>
						<th><?php echo $this->lang->line('action') ?></th>
					</tr>
					<?php if (isset($row_detail)): ?>
						<?php $total_all=0;foreach ($row_detail as $row): ?>
							<tr>
								<?php foreach ($field_detail as $rows): ?>
									<?php if ($rows['field']): ?>
										<input type="hidden" name="<?php echo $rows['id'] ?>[]" value="<?php echo $row->{$rows['id']} ?>">		
									<?php endif ?>							
								<?php endforeach ?>
								<?php foreach ($field_detail as $rows): ?>
									<?php if ($rows['table']): ?>
										<?php if ($rows['type']=='number'): ?>
											<td class="<?php echo $rows['id'] ?>" align="right"><?php echo number_format($row->{$rows['id']}) ?></td>
										<?php elseif ($rows['type']=='date'): ?>
											<td class="<?php echo $rows['id'] ?>"><?php echo format_dmy($row->{$rows['id']}) ?></td>
										<?php else: ?>
											<td class="<?php echo $rows['id'] ?>"><?php echo $row->{$rows['id']} ?></td>
										<?php endif ?>
									<?php endif ?>
									<?php if ($rows['id']=='harga'): ?>
										<td class="total" align="right"><?php echo number_format($row->jumlah*$row->harga) ?></td>
									<?php endif ?>
								<?php endforeach ?>

								<td>
									<button type="button" onclick="detail.editDetail(this)" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span> <?php echo $this->lang->line("edit") ?></button>
									&nbsp;
									<button type="button" onclick="detail.editDetail(this)" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> <?php echo $this->lang->line("delete") ?></button>
								</td>
							</tr>							
						<?php $total_all+=$row->jumlah*$row->harga;endforeach ?>
					<?php endif ?>
				</table>
			</div>
		</div>
		<div class="box-footer">
			<p id="total_all">Total : <strong><?php echo (isset($total_all)?number_format($total_all):"0") ?></strong></p>
		</div>				
	</div>
	<div class="box box-default">
		<div class="box-footer">
			<button class="btn btn-success btn-sm" type="submit" onclick="return confirm('Are you sure')"><span class="glyphicon glyphicon-save"></span> <?php echo $this->lang->line('save') ?></button>
			<?php echo anchor($index.get_query_string(),'<span class="glyphicon glyphicon-repeat"></span> '.$this->lang->line('cancel'),array('class'=>'btn btn-danger btn-sm'))?>
		</div>		
	</div>
	<?php echo form_close()?>
</section>
<!-- Modal -->
<div class="modal fade" id="detail-modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Form Detail</h4>
      </div>
      <div class="modal-body">
		<?php echo $this->load->view($index.'/detail') ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel') ?></button>
        <button id="save-detail-btn" type="button" class="btn btn-primary" ><?php echo $this->lang->line('save') ?></button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).on('keyup keypress', 'form input[type="text"]', function(e) {
		if(e.keyCode == 13) {
			e.preventDefault();
			return false;
		}
	});
	function number_format(user_input){
	    var filtered_number = user_input.replace(/[^0-9]/gi, '');
	    var length = filtered_number.length;
	    var breakpoint = 1;
	    var formated_number = '';

	    for(i = 1; i <= length; i++){
	        if(breakpoint > 3){
	            breakpoint = 1;
	            formated_number = ',' + formated_number;
	        }
	        var next_letter = i + 1;
	        formated_number = filtered_number.substring(length - i, length - (i - 1)) + formated_number; 

	        breakpoint++;
	    }

	    return formated_number;
	}

	var detail = {
		field:<?php echo json_encode($field_detail) ?>,
		addDetailBtn : $('#add-detail-btn')
	}

	detail.addDetailBtn.click(function(){
		detail.addDetail();
	});

	detail.addDetail = function(){
		$('#save-detail-btn').attr("onclick","detail.doAddDetail()");
		detail.field.forEach(function(item,index){
			if (item.type = 'dropdown') {
				$('#'+item.id).val("").trigger("change");
			}else{
				$('#'+item.id).val("");
			}
		});
		$('#detail-modal').modal('show');
	};

	detail.doAddDetail = function(){
		var hiddenVar,rowVar;
		detail.field.forEach(function(item,index){
			hiddenVar += '<input type="hidden" name="'+item.id+'[]" value="'+$('#'+item.id).val()+'">';			
			if (item.id=='barang_name') {
				var nama_barang = $('#barang option:selected').text();
				nama_barang = nama_barang.split(" - ");
				nama_barang = nama_barang[1];
				rowVar += '<td class="barang_name">'+nama_barang+'</td>';
			}else{
				rowVar += '<td class="'+item.id+'">'+$('#'+item.id).val()+'</td>';
			}

			if(item.id=='harga'){
				var jumlah = parseInt($('#jumlah').val().replace(/,/g,''));
				var harga = parseInt($('#harga').val().replace(/,/g,''));
				var total = jumlah*harga;
				rowVar += '<td class="total">'+number_format(total.toString())+'</td>';
			}			
		});
		$('#detail-table').append('<tr>'+hiddenVar+rowVar
			+'<td><button type="button" onclick="detail.editDetail(this)" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span> <?php echo $this->lang->line("edit") ?></button>&nbsp;'
			+'<button type="button" onclick="detail.deleteDetail(this)" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> <?php echo $this->lang->line("delete") ?></button></td>'			
			+'</tr>');
		detail.totalAll();
		$('.jumlah,.harga,.total').attr('align','right');
		$('#detail-modal').modal('hide');
	};

	detail.totalAll = function(){
		var count = $('#detail-table tbody tr').length; 
		var total = 0;
		for (var i = 2; i <= count; i++) {
			var parent = $('#detail-table tbody tr:nth-child('+i+')'); 
			var tot = parent.find('td.total').html();	
			total += parseInt(tot.replace(/,/gi, '')); 
		}
		$('#total_all').html('Total : <strong>'+number_format(total.toString())+'</strong>');
	};

	detail.editDetail = function(t){
		$('#save-detail-btn').attr("onclick","detail.doEditDetail()");
		var index = $("#detail-table tr").index($(t).parent().parent());
		$('#index').val(index);

		detail.field.forEach(function(item,index){
			if (item.id=='barang') {
				var barang = $(t).parent().parent().find('td.barang').html();
				$('#barang').val(barang).trigger("change");
			}else{
				var value = $(t).parent().parent().find('td.'+item.id).html();
				$('#'+item.id).val(value);
			}
		});
		
		$('#detail-modal').modal('show');
	};

	detail.doEditDetail = function(){
		var index = $('#index').val();
		var parent = $('#detail-table tbody tr:nth-child('+(parseInt(index)+1)+')'); 
		detail.field.forEach(function(item,index){
			if (item.id=='barang') {
				var barang = $('#barang').val();
				parent.find('td.barang').html(barang);
				parent.find('input[name="barang[]"]').val(barang);
				var barang_name = $('#barang option:selected').text();
				barang_name = barang_name.split(" - ");
				barang_name = barang_name[1];
				parent.find('td.barang_name').html(barang_name);
			}else{
				var value = $('#'+item.id).val();
				parent.find('td.'+item.id).html(value);
				parent.find('input[name="'+item.id+'[]"]').val(value);
			}

			if(item.id=='harga'){
				var jumlah = parseInt($('#jumlah').val().replace(/,/g,''));
				var harga = parseInt($('#harga').val().replace(/,/g,''));
				var total = jumlah*harga;
				parent.find('td.total').html(number_format(total.toString()));
			}			
		});

		detail.totalAll();
		$('#detail-modal').modal('hide');
	};

	detail.deleteDetail = function(t){
		if (confirm('Anda yakin ?')) {
			$(t).parent().parent().remove();
			detail.totalAll();
		}
	}		
</script>