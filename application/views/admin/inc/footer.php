 	<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-angle-double-up"></i></button>

    	</section>
      
	</section> 
    <!--main content end-->
</section>
  	<!-- container section start -->

<!-- javascripts -->

<script src="<?php echo base_url().'assets/backend/' ?>js/bootstrap.min.js"></script>
<!-- nice scroll -->
<script src="<?php echo base_url().'assets/backend/' ?>js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url().'assets/backend/' ?>js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url().'assets/backend/' ?>js/sweetalert.js"></script>
<!--custome script for all page-->
<script src="<?php echo base_url().'assets/backend/' ?>js/scripts.js"></script>
<script src="<?php echo base_url().'assets/backend/' ?>js/datatable.js"></script>
<script src="<?php echo base_url().'assets/backend/' ?>js/maincustome.js"></script>
<script src="<?php echo base_url().'assets/backend/' ?>js/jquery-ui.min.js"></script>

<style>
#myBtn {
	display: none;
	position: fixed;
	bottom: 20px;
	right: 30px;
	z-index: 99;
	font-size: 18px;
	border: none;
	outline: none;
	background-color: #107dd3f7;
	color: white;
	cursor: pointer;
	padding: 8px 15px;
	border-radius: 4px;
}

#myBtn:hover {
  	background-color: #555;
}
</style>

<script>
//Get the button
var mybutton = document.getElementById("myBtn");
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

$(document).ready(function() {
	$('.js-example-basic-single').select2();
});
$(document).ready(function(){
  $('#dataTable').DataTable();

  $('#complaintTable').dataTable( {
    "pageLength": 50
  } );

  $('#monthTable').dataTable({
    "pageLength": 25
  } )

 //total amount show
 var total = 0;
 var count_check = 0;
 $(document).on('change','#coll_status',function(){

  var advance_pay =$('#advance_pay').val();
  var amount = $(this).data('amo');
  var adv=0;
// $('#show_net_amount').val(net_amount);

  if ($(this).is(':checked')) {
    count_check++;
    total = total + parseFloat(amount);
   
    if (advance_pay > 0) {
      adv = total > advance_pay ? 0 : parseFloat(advance_pay) - total;
    }
    else{
      adv=0;
    }

  } else{
    total = total-parseFloat(amount);
    count_check--;
    if (advance_pay>0) {
      adv = total > advance_pay ? 0 : parseFloat(advance_pay)-total;
      }
      else{
      adv = 0;
    }
  }
  $('#coll_amount').val(total);
  $('#advance').text(adv);
})
        

function get_filter(class_name){
  var filter = [];
  $('.'+class_name+':checked').each(function(){
      filter.push($(this).val());
  });
  return filter;
}

//due coustomer list 
$(document).on('submit','#viewDueForm',function(e){
  e.preventDefault();
  var action=$('#action','#viewDueForm').val();
  var base_url='<?php echo base_url('due-list') ?>';
      $.ajax({
          url:base_url,
          method:'post',
          data:new FormData(this),
          contentType:false,
          processData:false,
          success: function(data){
            // alert(data);

            $('#showlist').html(data);
            $('#viewDueForm')[0].reset();

            // if (data.trim()=='') {}
            
          }
      });

})

});
</script>
</body>

</html>