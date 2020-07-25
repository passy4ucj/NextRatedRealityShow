<script type="text/javascript">
  $(document).ready(function(){
          var final_total_amt = $('#final_total_amt').text();
          var count = <?php echo $m; ?>;
          $(document).on('click', '#add_row', function(){
            count++;
            $('#total_item').val(count);
            var html_code = '';
            html_code += '<tr id="row_id_'+count+'">';
            html_code += '<td><span id="sr_no">'+count+'</span></td>';
            html_code += '<td><input type="text" name="item_name[]" id="item_name'+count+'" class="form-control input-sm" /></td>';
            html_code += '<td><input type="text" name="order_item_quantity[]" id="order_item_quantity'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_quantity" /></td>';
            html_code += '<td><input type="text" name="order_item_price[]" id="order_item_price'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_price" /></td>';
            html_code += '<td><input type="text" name="order_item_actual_amount[]" id="order_item_actual_amount'+count+'" data-srno="'+count+'" class="form-control input-sm order_item_actual_amount" readonly /></td>';
            html_code += '<td><input type="text" name="order_item_tax1_rate[]" id="order_item_tax1_rate'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_tax1_rate" /></td>';
            html_code += '<td><input type="text" name="order_item_tax1_amount[]" id="order_item_tax1_amount'+count+'" data-srno="'+count+'" class="form-control input-sm order_item_tax1_amount" readonly /></td>';
            html_code += '<td><input type="text" name="order_item_tax2_rate[]" id="order_item_tax2_rate'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_tax2_rate" /></td>';
            html_code += '<td><input type="text" name="order_item_tax2_amount[]" id="order_item_tax2_amount'+count+'" data-srno="'+count+'" class="form-control input-sm order_item_tax2_amount" readonly /></td>';
            html_code += '<td><input type="text" name="order_item_tax3_rate[]" id="order_item_tax3_rate'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_tax3_rate" /></td>';
            html_code += '<td><input type="text" name="order_item_tax3_amount[]" id="order_item_tax3_amount'+count+'" data-srno="'+count+'" class="form-control input-sm order_item_tax3_amount" readonly /></td>';
            html_code += '<td><input type="text" name="order_item_final_amount[]" id="order_item_final_amount'+count+'" data-srno="'+count+'" class="form-control input-sm order_item_final_amount" readonly /></td>';
            html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td></tr>';
            $('#invoice-item-table').append(html_code);
          });

          $(document).on('click', '.remove_row', function(){
            var row_id = $(this).attr("id");
            var total_item_amount = $('#order_item_final_amount'+row_id).val();
            var final_amount = $('#final_total_amt').text();
            var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
            $('#final_total_amt').text(result_amount);
            $('#row_id_'+row_id).remove();
            count--;
            $('#total_item').val(count);
          });

          function cal_final_total(count) {
            var final_item_total = 0;
            for (var j = 1; j <= count; j++) {
              var quantity = 0;
              var price = 0;
              var actual_amount = 0;
              var tax1_rate = 0;
              var tax1_amount = 0;
              var tax2_rate = 0;
              var tax2_amount = 0;
              var tax3_rate = 0;
              var tax3_amount = 0;
              var item_total = 0;
              quantity = $('#order_item_quantity'+j).val();
              if (quantity > 0) {
                price = $('#order_item_price'+j).val();
                if (price > 0) {
                  actual_amount = parseFloat(quantity) * parseFloat(price);
                  $('#order_item_actual_amount'+j).val(actual_amount);
                  tax1_rate = $('#order_item_tax1_rate'+j).val();
                  if (tax1_rate > 0) {
                    tax1_amount = parseFloat(actual_amount) * parseFloat(tax1_rate)/100;
                    $('#order_item_tax1_amount'+j).val(tax1_amount);
                  }
                  tax2_rate = $('#order_item_tax2_rate'+j).val();
                  if (tax2_rate > 0) {
                    tax2_amount = parseFloat(actual_amount) * parseFloat(tax2_rate)/100;
                    $('#order_item_tax2_amount'+j).val(tax2_amount);
                  }
                  tax3_rate = $('#order_item_tax3_rate'+j).val();
                  if (tax3_rate > 0) {
                    tax3_amount = parseFloat(actual_amount) * parseFloat(tax3_rate)/100;
                    $('#order_item_tax3_amount'+j).val(tax3_amount);
                  }
                  item_total = parseFloat(actual_amount) + parseFloat(tax1_amount) + parseFloat(tax2_amount) + parseFloat(tax3_amount);
                  final_item_total = parseFloat(final_item_total) + parseFloat(item_total);
                  $('#order_item_final_amount'+j).val(item_total);
                }
              }
            }
            $('#final_total_amt').text(final_item_total);
          }

          $(document).on('blur', '.order_item_price', function(){
            cal_final_total(count);
          });
          $(document).on('blur', '.order_item_tax1_rate', function(){
            cal_final_total(count);
          });
          $(document).on('blur', '.order_item_tax2_rate', function(){
            cal_final_total(count);
          });
          $(document).on('blur', '.order_item_tax3_rate', function(){
            cal_final_total(count);
          });
          $('#update_invoice').click(function(){
            if ($.trim($('#order_reciever_name').val()).length == 0) {
              alert("Please Enter Reciever Name");
              return false;
            }
            if ($.trim($('#order_no').val()).length == 0) {
              alert("Please Enter Invoice Number");
              return false;
            }
            if ($.trim($('#order_date').val()).length == 0) {
              alert("Please Select Invoice Date");
              return false;
            }

            for (var no = 1; no <= count; no++) {
              if ($.trim($('#item_name'+no).val()).length == 0) {
              alert("Please Enter Item Name");
              $('#item_name'+no).focus();
              return false;
              }
              if ($.trim($('#order_item_quantity'+no).val()).length == 0) {
              alert("Please Enter Item Quantity");
              $('#order_item_quantity'+no).focus();
              return false;
              }
              if ($.trim($('#order_item_price'+no).val()).length == 0) {
              alert("Please Enter Item Price");
              $('#order_item_price'+no).focus();
              return false;
              }
            }

            $('#invoice_form').submit();
          });
      });

</script>