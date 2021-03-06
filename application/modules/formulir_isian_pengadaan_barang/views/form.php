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
	<?php echo form_open($action)?>
	<div class="box box-default">
		<div class="box-header owner">
			<?php echo $owner?>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group form-inline">
						<?php echo form_label('No Dokumen','nomor',array('class'=>'control-label'))?>
						<?php echo form_input(array('name'=>'nomor','class'=>'form-control input-sm','maxlength'=>'100','size'=>'50','autocomplete'=>'off','value'=>set_value('nomor',(isset($row->nomor)?$row->nomor:'')),'required'=>'required','autofocus'=>'autofocus'))?>
						<small><?php echo form_error('nomor')?></small>
					</div>
					<div class="form-group form-inline">
						<?php echo form_label('Tanggal','tanggal',array('class'=>'control-label'))?>
						<?php echo form_input(array('name'=>'tanggal','class'=>'form-control input-sm input-tanggal','maxlength'=>'10','autocomplete'=>'off','value'=>set_value('tanggal',(isset($row->tanggal)?$row->tanggal:'')),'required'=>'required'))?>
						<small><?php echo form_error('tanggal')?></small>
					</div>					
					<div class="form-group form-inline">
						<?php echo form_label('Nilai Kontrak','nilai_kontrak',array('class'=>'control-label'))?>
						<?php echo form_input(array('name'=>'nilai_kontrak','class'=>'form-control input-sm input-uang','maxlength'=>'100','size'=>'50','autocomplete'=>'off','value'=>set_value('nilai_kontrak',(isset($row->nilai_kontrak)?$row->nilai_kontrak:'')),'required'=>'required','autofocus'=>'autofocus'))?>
						<small><?php echo form_error('nilai_kontrak')?></small>
					</div>
					<div class="form-group form-inline">
						<?php echo form_label('Nilai APBD','nilai_apbd',array('class'=>'control-label'))?>
						<?php echo form_input(array('name'=>'nilai_apbd','class'=>'form-control input-sm input-uang','maxlength'=>'100','size'=>'50','autocomplete'=>'off','value'=>set_value('nilai_apbd',(isset($row->nilai_apbd)?$row->nilai_apbd:'')),'required'=>'required','autofocus'=>'autofocus'))?>
						<small><?php echo form_error('nilai_apbd')?></small>
					</div>
					<div class="form-group form-inline">
						<?php echo form_label('Perusahaan Rekanan','perusahaan_rekanan',array('class'=>'control-label'))?>
						<?php echo form_dropdown('perusahaan_rekanan',$this->general_model->dropdown('perusahaan_rekanan','Perusahaan'),set_value('perusahaan_rekanan',(isset($row->perusahaan_rekanan)?$row->perusahaan_rekanan:'')),'required=required class="form-control input-sm select2"')?>
						<small><?php echo form_error('perusahaan_rekanan')?></small>
					</div>								
				</div>
				<div class="col-md-6">
					<div class="form-group form-inline">
						<?php echo form_label('Jenis Dana','jenis_dana',array('class'=>'control-label'))?>
						<?php echo form_dropdown('jenis_dana',$this->general_model->dropdown('jenis_dana','Jenis Dana'),set_value('jenis_dana',(isset($row->jenis_dana)?$row->jenis_dana:'')),'required=required class="form-control input-sm select2"')?>
						<small><?php echo form_error('jenis_dana')?></small>
					</div>								
					<div class="form-group form-inline">
						<?php echo form_label('Tahun Anggaran','tahun_anggaran',array('class'=>'control-label'))?>
						<?php echo form_dropdown('tahun_anggaran',$this->general_model->dropdown('tahun_anggaran','Tahun Anggaran'),set_value('tahun_anggaran',(isset($row->tahun_anggaran)?$row->tahun_anggaran:'')),'required=required class="form-control input-sm select2"')?>
						<small><?php echo form_error('tahun_anggaran')?></small>
					</div>								
					<div class="form-group form-inline">
						<?php echo form_label('Bukti Pembayaran','bukti_pembayaran',array('class'=>'control-label'))?>
						<?php echo form_dropdown('bukti_pembayaran',$this->general_model->dropdown('bukti_pembayaran','Bukti Pembayaran'),set_value('bukti_pembayaran',(isset($row->bukti_pembayaran)?$row->bukti_pembayaran:'')),'required=required class="form-control input-sm select2"')?>
						<small><?php echo form_error('bukti_pembayaran')?></small>
					</div>								
				</div>
			</div>
		</div>
	</div>
	<div class="box box-default">
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group form-inline">
						<?php echo form_label('Kepemilikan','pemilik',array('class'=>'control-label'))?>
						<?php echo form_dropdown('pemilik',$this->general_model->dropdown('pemilik','Kepemilikan'),set_value('pemilik',(isset($row->pemilik)?$row->pemilik:'')),'required=required class="form-control input-sm select2"')?>
						<small><?php echo form_error('pemilik')?></small>
					</div>								
					<div class="form-group form-inline">
						<?php echo form_label('Wilayah','kabupaten',array('class'=>'control-label'))?>
						<?php echo form_dropdown('kabupaten',$this->general_model->dropdown('kabupaten','Wilayah'),set_value('kabupaten',(isset($row->kabupaten)?$row->kabupaten:'')),'required=required class="form-control input-sm select2"')?>
						<small><?php echo form_error('kabupaten')?></small>
					</div>								
					<div class="form-group form-inline">
						<?php echo form_label('Unit SKPD','bidang_unit',array('class'=>'control-label'))?>
						<?php echo form_dropdown('bidang_unit',$this->general_model->dropdown('bidang','Unit SKPD',array('type'=>'02')),set_value('bidang_unit',(isset($row->bidang_unit)?$row->bidang_unit:'')),'required=required class="form-control input-sm select2"')?>
						<small><?php echo form_error('bidang_unit')?></small>
					</div>			
				</div>
				<div class="col-md-6">
					<div class="form-group form-inline">
						<?php echo form_label('Cara Perolehan','cara_perolehan',array('class'=>'control-label'))?>
						<?php echo form_dropdown('cara_perolehan',$this->general_model->dropdown('cara_perolehan','Cara Perolehan'),set_value('cara_perolehan',(isset($row->cara_perolehan)?$row->cara_perolehan:'')),'required=required class="form-control input-sm select2"')?>
						<small><?php echo form_error('cara_perolehan')?></small>
					</div>								
					<div class="form-group form-inline">
						<?php echo form_label('Dasar Perolehan','dasar_perolehan',array('class'=>'control-label'))?>
						<?php echo form_dropdown('dasar_perolehan',$this->general_model->dropdown('dasar_perolehan','Dasar perolehanan'),set_value('dasar_perolehan',(isset($row->dasar_perolehan)?$row->dasar_perolehan:'')),'required=required class="form-control input-sm select2"')?>
						<small><?php echo form_error('dasar_perolehan')?></small>
					</div>								
					<div class="form-group form-inline">
						<?php echo form_label('a) Nomor','nomor_perolehan',array('class'=>'control-label'))?>
						<?php echo form_input(array('name'=>'nomor_perolehan','class'=>'form-control input-sm','maxlength'=>'100','size'=>'50','autocomplete'=>'off','value'=>set_value('nomor_perolehan',(isset($row->nomor_perolehan)?$row->nomor_perolehan:'')),'required'=>'required'))?>
						<small><?php echo form_error('nomor_perolehan')?></small>
					</div>
					<div class="form-group form-inline">
						<?php echo form_label('b) Tanggal','tanggal_perolehan',array('class'=>'control-label'))?>
						<?php echo form_input(array('name'=>'tanggal_perolehan','class'=>'form-control input-sm input-tanggal','maxlength'=>'10','autocomplete'=>'off','value'=>set_value('tanggal_perolehan',(isset($row->tanggal_perolehan)?$row->tanggal_perolehan:'')),'required'=>'required'))?>
						<small><?php echo form_error('tanggal_perolehan')?></small>
					</div>					
					<div class="form-group form-inline">
						<?php echo form_label('Tahun Perolehan','tahun_perolehan',array('class'=>'control-label'))?>
						<?php echo form_input(array('name'=>'tahun_perolehan','class'=>'form-control input-sm','maxlength'=>'4','size'=>'5','autocomplete'=>'off','value'=>set_value('tahun_perolehan',(isset($row->tahun_perolehan)?$row->tahun_perolehan:'')),'required'=>'required'))?>
						<small><?php echo form_error('tahun_perolehan')?></small>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="box box-default">
		<div class="box-header">
			Detail Barang
		</div>
		<div class="box-body">
			<button id="add-detail-btn" type="button" class="btn btn-primary btn-sm">
				<span class="glyphicon glyphicon-plus"></span> <?php echo $this->lang->line('new') ?>
			</button>			
			<div class="table-responsive form-inline">
				<table id="detail-table" class="table table-bordered">
					<tr>
						<th>Kode Barang</th>
						<th>Nama Barang</th>
						<th>Merk</th>
						<th>Jumlah</th>
						<th>Harga</th>
						<th>Total</th>
						<th>Invent</th>
						<th>No SP2D</th>
						<th>Tgl SP2D</th>
						<th>PPN</th>
						<th>Keterangan</th>
						<th><?php echo $this->lang->line('action') ?></th>
					</tr>
					<?php if (isset($row_detail)): ?>
						<?php $total_all=0;foreach ($row_detail as $row): ?>
							<tr>
								<input type="hidden" name="kode_barang[]" value="<?php echo $row->kode_barang ?>">
								<input type="hidden" name="merk[]" value="<?php echo $row->merk ?>">
								<input type="hidden" name="jumlah[]" value="<?php echo $row->jumlah ?>">
								<input type="hidden" name="harga[]" value="<?php echo $row->harga ?>">
								<input type="hidden" name="invent[]" value="<?php echo $row->invent ?>">
								<input type="hidden" name="no_sp2d[]" value="<?php echo $row->no_sp2d ?>">
								<input type="hidden" name="tgl_sp2d[]" value="<?php echo format_dmy($row->tgl_sp2d) ?>">
								<input type="hidden" name="ppn[]" value="<?php echo $row->ppn ?>">
								<input type="hidden" name="keterangan[]" value="<?php echo $row->keterangan ?>">

								<td class="kode_barang"><?php echo $row->kode_barang ?></td>
								<td class="nama_barang"><?php echo $this->general_model->get_from_field_row('barang','code',$row->kode_barang)->name ?></td>
								<td class="merk"><?php echo $row->merk ?></td>
								<td class="jumlah" align="right"><?php echo number_format($row->jumlah) ?></td>
								<td class="harga" align="right"><?php echo number_format($row->harga) ?></td>
								<td class="total" align="right"><?php echo number_format($row->jumlah*$row->harga) ?></td>
								<td class="invent"><?php echo $row->invent ?></td>
								<td class="no_sp2d"><?php echo $row->no_sp2d ?></td>
								<td class="tgl_sp2d"><?php echo format_dmy($row->tgl_sp2d) ?></td>
								<td class="ppn"><?php echo number_format($row->ppn) ?></td>
								<td class="keterangan"><?php echo $row->keterangan ?></td>
								<td>
									<button type="button" onclick="detail.editDetail(this)" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span> <?php echo $this->lang->line("edit") ?></button>
									&nbsp;
									<button type="button" onclick="detail.deleteDetail(this)" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> <?php echo $this->lang->line("delete") ?></button>
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
			<?php echo anchor($breadcrumb,'<span class="glyphicon glyphicon-repeat"></span> '.$this->lang->line('cancel'),array('class'=>'btn btn-danger btn-sm'))?>
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
		field:['kode_barang','merk','jumlah','harga','total','invent','no_sp2d','tgl_sp2d','ppn','keterangan'],
		addDetailBtn : $('#add-detail-btn')
	}

	detail.addDetailBtn.click(function(){
		detail.addDetail();
	});

	detail.addDetail = function(){
		$('#save-detail-btn').attr("onclick","detail.doAddDetail()");
		detail.field.forEach(function(item,index){
			if (item=='kode_barang') {
				$('#kode_barang').val("").trigger("change");
			}else{
				$('#'+item).val("");
			}
		});
		$('#detail-modal').modal('show');
	};

	detail.doAddDetail = function(){
		var hiddenVar,rowVar;
		detail.field.forEach(function(item,index){
			hiddenVar += '<input type="hidden" name="'+item+'[]" value="'+$('#'+item).val()+'">';
			rowVar += '<td class="'+item+'">'+$('#'+item).val()+'</td>';				
			if (item=='kode_barang') {
				var nama_barang = $('#kode_barang option:selected').text();
				nama_barang = nama_barang.split(" - ");
				nama_barang = nama_barang[1];
				rowVar += '<td class="nama_barang">'+nama_barang+'</td>';
			}
		});
		$('#detail-table').append('<tr>'+hiddenVar+rowVar
			+'<td><button type="button" onclick="detail.editDetail(this)" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span> <?php echo $this->lang->line("edit") ?></button>&nbsp;'
			+'<button type="button" onclick="detail.deleteDetail(this)" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> <?php echo $this->lang->line("delete") ?></button></td>'			
			+'</tr>');
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
			if (item=='kode_barang') {
				var kode_barang = $(t).parent().parent().find('td.kode_barang').html();
				$('#kode_barang').val(kode_barang).trigger("change");
			}else{
				var value = $(t).parent().parent().find('td.'+item).html();
				$('#'+item).val(value);
			}
		});
		
		$('#detail-modal').modal('show');
	};

	detail.doEditDetail = function(){
		var index = $('#index').val();
		var parent = $('#detail-table tbody tr:nth-child('+(parseInt(index)+1)+')'); 
		detail.field.forEach(function(item,index){
			if (item=='kode_barang') {
				var kode_barang = $('#kode_barang').val();
				parent.find('td.kode_barang').html(kode_barang);
				parent.find('input[name="kode_barang[]"]').val(kode_barang);
				var nama_barang = $('#kode_barang option:selected').text();
				nama_barang = nama_barang.split(" - ");
				nama_barang = nama_barang[1];
				parent.find('td.nama_barang').html(nama_barang);
			}else{
				var value = $('#'+item).val();
				parent.find('td.'+item).html(value);
				parent.find('input[name="'+item+'[]"]').val(value);
			}
		});

		detail.totalAll();
		$('#detail-modal').modal('hide');
	};
	detail.deleteDetail = function(t){
		$(t).parent().parent().remove();
		detail.totalAll();
	}		
</script>