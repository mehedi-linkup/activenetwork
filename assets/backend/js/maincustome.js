
// $(document).on('submit','#loginForm',function(e){
// 	var base_url = window.location.origin+'/';
//         e.preventDefault();
//         var action=$('#action','#loginForm').val();
//         var name=$('#name','#loginForm').val();

//         if (name=='') {

//         }else{

//           $.ajax({
//               url:base_url+'login-form',
//               method:'post',
//               data:new FormData(this),
//               contentType:false,
//               processData:false,
//               success: function(data){
//                 // if (data.trim()=='success') {
                  
//                 //   $('#output').html('Save successfully');
//                 //   location.reload();
//                 // }
//                  $('#error').html(data);
//                 console.log(data);
//               }
//           });
//         }
//       })