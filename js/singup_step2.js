$('document').ready(function(){
    
    $('#file').change(function() {
               
                $('#creast-holder').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> uploading...');
                var fd = new FormData(document.getElementById("form")); 
                
                $.ajax({
                  url: "includes/upload_crest.php",
                  type: "POST",
                  data: fd,
                  processData: false,  // tell jQuery not to process the data
                  contentType: false   // tell jQuery not to set contentType
                }).done(function( data ) {
                   
                    if(data == 'error'){
                        $('#creast-holder').html('');
                        swal(
                          'Ooops..',
                          'An error occured. please make sure you are connected to the internet.',
                          'error'
                        )
                        
                    }else{
                        $('#creast-holder').html('');
                        $('#creast-holder').css('background-image','url(image_uploads_crests/'+data+')');
                    }
                    
                });
                return false;
            });
    
    //register command
        var submit = false;
        $('#submit').on('click',function(){
          
            if(!submit){
                submit = true;
                    var school_name = $('#school_name').val();
                    var numbers = $('#numbers').val();
                    var address = $('#address').val();
                    var moto = $('#moto').val();
                    var country = $('#country').val();
                    var city = $('#city').val();
                    var sms_id = $('#sms_id').val();
                    
                    //send ajax request
                    $(this).html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');

                     $.post("includes/registration_step2.php",{school_name:school_name,numbers:numbers,address:address,moto:moto,country:country,city:city,sms_id:sms_id},
                          function(data){
                             console.log(data);
                             if(data == "success"){
                                 $('#submit').html('Success');
                                 $('#submit').toggleClass('btn-success');
                                 window.open('verify_registration.php','_self');
                             }else{
                                 submit = false;
                                 $('.form-area').prepend(data);
                                 $('#submit').html('Continue');
                                 
                                
                             }
                        }
                   )
            }
            
        });

});
function msg_close(){
    $('.panel').css('display','none');
}