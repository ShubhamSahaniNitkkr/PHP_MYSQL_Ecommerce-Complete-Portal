<br><br>
<footer class="text-center theme fixed-bottom" id="footer">&copy; copyright 2019 मेरी local दुकान</footer>

<script>

function update_kilo(){
var qtystring='';
  for(var i=1;i<3;i++)
  {
    if($('#qty'+i)!='')
    {
      qtystring+=$('#qty'+i).val()+',';
    }
  }
  $('#qty_field').val(qtystring);
}

function get_sub_category(selected){
  if(typeof selected === 'undefined'){
    var selected='';
  }

  var parent_id=$('#category').val();
  $.ajax({
    url:'/Ecommerce/admin/parser/child_categories.php',
    method:"post",
    data: {parent_id:parent_id, selected:selected},
    success:function(data){
      $('#sub_category').html(data);
    },
    error:function(){
      alert("something not working");
    }
  });
}
$('select[name="category"]').change(function(){
  get_sub_category();
});

</script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
