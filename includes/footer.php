<footer class="text-center theme fixed-bottom" id="footer">&copy; copyright 2019 मेरी local दुकान</footer>

<script>
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
</script>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>
