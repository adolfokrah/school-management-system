$('document').ready(function(){
    //make password visible and non visible
    var see = true;
    $('#see_password').on('click',function(){
        
         if(see){
             //set password to visible
             $('#admin_password').attr('type','text');
             //set see to false
             see = false;
             
         }else{
             //set password to invisible
             $('#admin_password').attr('type','password');
             //set see to true
             see = true;
             
         }
        $(this).toggleClass('fa-eye-slash');
        
        
    });
    
        
        //register command
        var submit = false;
        $('#submit').on('click',function(){
            
            if(!submit){
                submit = true;
                    var admin_name = $('#admin_name').val();
                    var admin_email = $('#admin_email').val();
                    var admin_mobile = $('#admin_mobile').val();
                    var admin_password = $('#admin_password').val();
                    var admin_confirm_password = $('#admin_confirm_password').val();

                    //send ajax request
                    $(this).html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');

                     $.post("includes/registration_step1.php",{admin_name:admin_name,admin_email:admin_email,admin_password:admin_password,admin_mobilenumber:admin_mobile,admin_confirm_password:admin_confirm_password},
                          function(data){
                             if(data == "success"){
                                 $('#submit').html('Success');
                                 $('#submit').toggleClass('btn-success');
                                 window.open('register2.php','_self');
                             }else{
                                 submit = false;
                                 swal('',data);
                                 $('#submit').html('Sing up for Easyskul');
                                 
                             }
                        }
                   )
            }
            
        });
    
});

function msg_close(){
    $('.panel').css('display','none');
}