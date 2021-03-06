<input id="index" type="hidden" name="index">
<div class="form-group form-inline">
	<?php echo form_label('Barang','kode_barang',array('class'=>'control-label'))?>
	<?php echo form_dropdown('kode_barang',$this->general_model->dropdown('barang','Barang'),'','id="kode_barang" class="form-control input-sm"')?>
	<small><?php echo form_error('kode_barang')?></small>
</div>			
<div class="form-group form-inline">
  <?php echo form_label('Merk','merk',array('class'=>'control-label'))?>
  <?php echo form_input(array('id'=>'merk','name'=>'merk','class'=>'form-control input-sm','maxlength'=>'100','size'=>'50','autocomplete'=>'off'))?>
  <small><?php echo form_error('merk')?></small>
</div>
<div class="form-group form-inline">
  <?php echo form_label('Jumlah','jumlah',array('class'=>'control-label'))?>
  <?php echo form_input(array('id'=>'jumlah','name'=>'jumlah','class'=>'form-control input-sm input-uang','maxlength'=>'20','size'=>'10','autocomplete'=>'off'))?>
  <small><?php echo form_error('jumlah')?></small>
</div>
<div class="form-group form-inline">
  <?php echo form_label('Harga','harga',array('class'=>'control-label'))?>
  <?php echo form_input(array('id'=>'harga','name'=>'harga','class'=>'form-control input-sm input-uang','maxlength'=>'20','size'=>'20','autocomplete'=>'off'))?>
  <small><?php echo form_error('harga')?></small>
</div>
<div class="form-group form-inline">
	<?php echo form_label('Total','total',array('class'=>'control-label'))?>
	<?php echo form_input(array('id'=>'total','name'=>'total','class'=>'form-control input-sm input-uang','autocomplete'=>'off','readonly'=>'true'))?>
</div>
<div class="form-group form-inline">
  <?php echo form_label('Invent','invent',array('class'=>'control-label'))?>
  <?php echo form_dropdown('invent',array(''=>'','ya'=>'Ya','tidak'=>'Tidak'),'','id="invent" class="form-control input-sm"')?>
  <small><?php echo form_error('invent')?></small>
</div>      
<div class="form-group form-inline">
  <?php echo form_label('No SP2D','no_sp2d',array('class'=>'control-label'))?>
  <?php echo form_input(array('id'=>'no_sp2d','name'=>'no_sp2d','class'=>'form-control input-sm','maxlength'=>'100','size'=>'50','autocomplete'=>'off'))?>
  <small><?php echo form_error('no_sp2d')?></small>
</div>
<div class="form-group form-inline">
  <?php echo form_label('Tanggal SP2D','tgl_sp2d',array('class'=>'control-label'))?>
  <?php echo form_input(array('id'=>'tgl_sp2d','name'=>'tgl_sp2d','class'=>'form-control input-sm input-tanggal','maxlength'=>'10','size'=>'50','autocomplete'=>'off'))?>
  <small><?php echo form_error('tgl_sp2d')?></small>
</div>
<div class="form-group form-inline">
  <?php echo form_label('PPN','ppn',array('class'=>'control-label'))?>
  <?php echo form_input(array('id'=>'ppn','name'=>'ppn','class'=>'form-control input-sm input-uang','autocomplete'=>'off'))?>
  <small><?php echo form_error('ppn')?></small>
</div>
<div class="form-group form-inline">
  <?php echo form_label('Keterangan','keterangan',array('class'=>'control-label'))?>
  <?php echo form_input(array('id'=>'keterangan','name'=>'keterangan','class'=>'form-control input-sm','maxlength'=>'100','size'=>'50','autocomplete'=>'off'))?>
  <small><?php echo form_error('keterangan')?></small>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    var app = {
      kode_barang:$('#kode_barang'),
      jumlah:$('#jumlah'),
      harga:$('#harga'),
      total:$('#total')
    };

    app.kode_barang.select2({
        placeholder: "- Barang -",
        dropdownAutoWidth:'true',
        width: 'auto',    
        ajax: {
        url: '<?php echo base_url() ?>index.php/api/barang',
        dataType: 'json',
        processResults: function (data) {
              return {
                  results: $.map(data, function (item) {
                      return {
                          text: item.name,
                          id: item.code
                      }
                  })
              };
          }
      }
    });

    app.jumlah.keyup(function(){
      app.calculate_total()
    });

    app.harga.keyup(function(){
      app.calculate_total()
    });

    app.calculate_total = function(){
      var jumlah = parseInt(app.jumlah.val().replace(/,/g,''));
      var harga = parseInt(app.harga.val().replace(/,/g,''));
      var total = jumlah*harga;
      app.total.val(number_format(total.toString()));
    }
  });
</script>