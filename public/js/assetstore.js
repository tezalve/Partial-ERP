$(document).ready(function($) {
    //initialize datepicker

   

    //initialize datatable
    recieve_voucher_table = $("#recieve-voucher-table").DataTable({
      "searching": false,
      "paging": false,
      "ordering": false,
      "autoWidth": false,
      "bInfo": false,
        "footerCallback": function ( row, data, start, end, display ) {
            api = this.api(), data;
        },  
      drawCallback: function() {
          var $item_info_name = $('.item_info_name_dtbl').select2({
            placeholder: 'Enter a Item Name',
            allowClear: true,
            ajax: {
              dataType: 'json',
              url: "/getItemInfo_data",
              delay: 100,
              data: function(params) {
                return {
                  term: params.term
                }
              },
              processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                  results: data
                };
              },
            }
          });
      }           
    });

$vendor = $('.vendor').select2({
              placeholder:'Select Vendor Name',
              allowClear: true,

                ajax: {
                    dataType: 'json',
                    url: "/getVendorInfo_data",
                    delay: 250,         
                  data: function(params) {
                      return {
                        term: params.term
                      }
                  },
                    processResults: function (data, params) {
                      params.page = params.page || 1;
                      return {
                        results: data,
                        pagination: {
                          more: (params.page * 30) < data.total_count
                        }
                      };
                    },
                 cache: true         
            }
     });


  $vendor.on("select2:select", function (e) {
        $("#address").val($(this).select2('data')['0']['street_address']);
        $("#email").val($(this).select2('data')['0']['email']);
        $("#phone").val($(this).select2('data')['0']['phone_no']);
        $("#person").val($(this).select2('data')['0']['name']);
        $("#mobile").val($(this).select2('data')['0']['mobile_no']);
 
    })

    $vendor.on("select2:unselect", function (e) { 
      $("#address").val('');
      $("#email").val('');
      $("#phone").val('');
      $("#person").val('');
      $("#mobile").val('');
    });




    qty_info   = 0;
    price_info = 0;

    totalcalculat = function(){
      qty_info  = 0;
      price_info = 0;
    //  $('#price').val(qty_info.toFixed(2));
     // $('#qty').val(price_info.toFixed(2));
      $(".qty_info").each(function () {

      
            //add only if the value is number
            if (!isNaN(this.value) && this.value.length != 0) {
             
                qty_info += parseFloat(this.value);

            }
        });

      
      $(".price_info").each(function () {
      
            //add only if the value is number
            if (!isNaN(this.value) && this.value.length != 0) {
                price_info += parseFloat(this.value);
            }
        });   


   

      $( api.column( 1 ).footer() ).html(qty_info.toFixed(2));
      $( api.column( 3 ).footer() ).html(price_info.toFixed(2));







      $('#total-qty').val(qty_info.toFixed(2));
      $('#total-price').val(price_info.toFixed(2));           
    };  

    totalcalculat();
    $("#recieve-voucher-table tbody tr").on('keyup', function() {
      totalcalculat();
    });
    var cheque_info_ststus = false;
    //When add button clicked
    $('#add').click(function(event){


      event.preventDefault();
      //add array to data
      var item_info_name = $("#item_info_name option:selected").text();
      var serial_name = $("#serial option:selected").text();
      
       if(serial_name == 'Yes'){
          serial_name2='No';
       }else{
          serial_name2='Yes';
       }

      item_id     = $("#item_info_name").val();
      serial     = $("#serial").val();
       if(serial == '1'){
          serial2='2';
       }else{
          serial2='1';
       }
      item_id     = $("#item_info_name").val();

      remarks    = $("#remarks").val();
      qty        = $("#qty").val();
      price      = $('#price').val();
      qty        = intVal($("#qty").val());
      price      = intVal($('#price').val());
 
       var amount = (qty*price).toFixed(2);


      // need to add tally condition

      if(isBlank(item_id)){
        alert("You can't add without Item");
        return;
      }

      if (isBlank(qty) && isBlank(price)){
        alert("qty or price can't be blank");
        return;       
      }

        if(qty<0){
        alert("You can't add without valid Quantity");
        return;
      }

        if(price<0){
        alert("You can't add without valid Price");
        return;
      }

      if (qty<0 && price<0){
        alert("can't be add same row in qty and price value");
        return;
      }

      var tableSize   = $('#recieve-voucher-table tbody tr').length;
      qty_row     = 0;
      price_row    = 0;

      for (i = 0; i < tableSize; i++) { 

     
        if(recieve_voucher_table.cell(i,2).nodes().to$().find('input').val()>0){
          qty_row = qty_row+1;
        }

        if(recieve_voucher_table.cell(i,3).nodes().to$().find('input').val()>0){
          price_row = price_row+1;
        }
      }

 
      var dropdown = '<select class="form-control serial " name="serial[]" style="width: 100%;" >'+
                     '<option value="'+serial+'" selected>'+serial_name+'</option>'+
                     '<option value="'+serial2+'">'+serial_name2+'</option>'+
                     '</select>'

      console.log(dropdown);
      var entry = [
        '<select class="form-control select2 item_info_name_dtbl" name="item_info_name[]" style="width: 100%;"><option value="'+item_id+'">'+item_info_name+'</option></select>',
        '<input  type="number"  name="qty_info[]"     class="form-control qty_info" placeholder="Quantity"  style="width: 100%;text-align:center; "  value="'+qty+'"    onclick="this.select();">',
        '<input  type="number"  name="price_info[]"    class="form-control " placeholder="Price" style="width: 100%;text-align:center;"  value="'+price+'"   onclick="this.select();">',
        '<input  type="text"  name="amount[]" readonly class="form-control price_info"  style="width: 100%;text-align:center;"  value="'+amount+'"   onclick="this.select();">',
        dropdown,
        // ' <select class="form-control serial " name="serial[]" style="width: 100%;" ><option value="'+serial+'" selected>'+serial_name+'</option></select>',
        '<button class="btn btn-danger btn-block delete-button btn-flat" id="' + '" style="padding: 3px 10px;">Delete</button>',
      ];
      $("#qty").val('');
      $('#price').val('');   
      $('#amount').val('');   


      recieve_voucher_table.row.add(entry).draw(false);
      dataLoad();
      totalcalculat();
    });


        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };
      
  $('#recieve-voucher-table tbody').on( 'keyup', 'tr', function () {

      quantity = $(this).find('td:eq(1)').find('input').val();
      unitprice = $(this).find('td:eq(2)').find('input').val();
      $(this).find('td:eq(3)').find('input').val((parseFloat(unitprice)*parseFloat(quantity)).toFixed(2));
      totalcalculat();
  });


})



    //delete row on button click
$('#recieve-voucher-table tbody').on( 'click', '.delete-button', function () {
      recieve_voucher_table.row( $(this).parents('tr') ).remove().draw();
      totalcalculat();
});


      dataLoad = function(){
      $("#remarks").val(''),
      $('#item_info_name').val(null).trigger("change");
      $('#item_info_name').select2('open');
      $('#item_info_name').select2('close');      
      }

    stringtohtml = function(html) {
        var el = document.createElement('div');
        el.innerHTML = html;
        return el.childNodes[0];
    }  


      var $item_info_name = $('.item_info_name').select2({
        placeholder: 'Enter Item Info Name',
        allowClear: true,
        ajax: {
          dataType: 'json',
          url: "/getItemInfo_data",
          delay: 100,
          data: function(params) {
            return {
              term: params.term
            }
          },
          processResults: function (data, params) {
            params.page = params.page || 1;
            return {
              results: data
            };
          },
        }
      });

    $item_info_name.on("select2:select", function (e) {
       $("#price").val($(this).select2('data')['0']['cost_price']);
    })

    $item_info_name.on("select2:unselect", function (e) { 
      $("#price").val('');
    });

    $('#qty').on('input', function() {
    
       qty    = $("#qty").val();
       price  = $("#price").val();
       amount = qty*price;
      $("#amount").val(amount.toFixed(2));
    
    });

    $('#price').on('input', function() {
    
     qty        = $("#qty").val();
     price        = $("#price").val();
     amount=qty*price;
     $("#amount").val(amount.toFixed(2));
    
    });

  



    $('#sales_invoice_form').on('submit',(function(e) {
           e.preventDefault();

        $("#btnSubmit").attr("disabled", true);
        $("#btnSubmit").val('Please wait..');


           var formData = new FormData(this);

           $.ajax({
               type:'POST',
               url: $(this).attr('action'),
               data:formData,
               cache:false,
               contentType: false,
               processData: false,
               success:function(data){


                if(data.success == true) {
                      $('#btnSubmit').attr("disabled", false);
                      $("#btnSubmit").val('Submit');
                      window.location.replace('/purchase_order');

                }else{
                      toastr.error(data.messages);
                      $('#btnSubmit').attr("disabled", false);
                      $("#btnSubmit").val('Submit');
                }
                   

               },
            
           });

    }));





