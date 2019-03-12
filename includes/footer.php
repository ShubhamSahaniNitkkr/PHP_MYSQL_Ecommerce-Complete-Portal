<footer class="text-center theme fixed-bottom" id="footer">&copy; copyright 2019 मेरी local दुकान</footer>

<script>
$('#successMessage').delay(1000).fadeOut('slow');

function details_modal_function(id){
  var data={"id":id};
  $.ajax({
    url:'/Ecommerce/includes/details_modal.php',
    method:"post",
    data: data,
    success:function(data){
      $('body').append(data);
      $('#details_modal').modal('toggle');
    },
    error:function(){
      alert("something not working");
    }
  });
}

function update_cart(mod, edit_i ,edit_kil){
  var data={'mode':mod ,'edit_id':edit_i ,'edit_kilo':edit_kil };
  $.ajax({
    url :'/Ecommerce/admin/parser/checkout.php',
    method:'post',
    data:data,
    success : function(data){
      location.reload();
    },
    error : function(){ alert('something went wrong !'); }
  });
}

function add_to_cart() {
  $('#modal_errors').html("");
   var kilo=$('#hkilo').val();
   var error='';
   var data=$('#add_product_form').serialize();

   if(kilo =='')
   {
     error+='<p class="text-danger text-center">You must Choose Kilogram !</p>';
     $('#modal_errors').html(error);
     return;
   }
   else {
     $.ajax({
       url :'/Ecommerce/admin/parser/add_cart.php',
       method:"post",
       data: data,
       success : function(){
         location.reload();
       },
       error : function(){ alert('something went wrong !'); }
     });
   }
}

function back_address(){
  $('#payment-errors').html("");
  $('#step1').css("display","block");
  $('#step2').css("display","none");
  $('#next_button').css("display","inline-block");
  $('#back_button').css("display","none");
  $('#check_out_button').css("display","none");
  $('#shipping_title').html("Shipping Address");
}


function check_address(){
  var data={
    'name' : $('#name').val(),
    'email' : $('#email').val(),
    'address1' : $('#address1').val(),
    'address2' : $('#address2').val(),
    'city' : $('#city').val(),
    'state' : $('#state').val(),
    'zip' : $('#zip').val(),
    'total' : $('#total').val(),
  };

  $.ajax({
    url :'/Ecommerce/admin/parser/check_address.php',
    method:'post',
    data:data,
    success : function(data){
      if(data!='passed'){
        $('#payment-errors').html(data);
      }
      if(data == 'passed'){
        $('#payment-errors').html("");
        $('#step1').css("display","none");
        $('#step2').css("display","block");
        $('#next_button').css("display","none");
        $('#back_button').css("display","inline-block");
        $('#check_out_button').css("display","inline-block");
        $('#shipping_title').html("Card Details");
      }
    },
    error : function(){ alert('something went wrong !'); }
  });
}

</script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>
