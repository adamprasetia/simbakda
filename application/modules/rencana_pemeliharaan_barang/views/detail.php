<input id="index" type="hidden" name="index">
<?php echo $this->general->get_form($field_detail,(isset($row)?$row:'')); ?>
<script type="text/javascript">
  $('#harga').parent().after('<div class="form-group form-inline"><label for="total" class="control-label">Total</label> <input type="text" name="total" value="" id="total" class="form-control input-sm input-uang" readonly="readonly"><small></small></div>');
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#barang').select2({
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

    $('#jumlah').keyup(function(){
      calculate_total()
    }); 
    $('#harga').keyup(function(){
      calculate_total()
    });   
    $('#total').attr('readonly','true');
    function calculate_total(){
      var jumlah = parseInt($('#jumlah').val().replace(/,/g,''));
      var harga = parseInt($('#harga').val().replace(/,/g,''));
      var total = jumlah*harga;
      $('#total').val(number_format(total.toString()));      
    }
  });
</script>