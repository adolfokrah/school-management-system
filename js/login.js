$('document').ready(function(){
    
    
    //register command
        var submit = false;
        $('#login').on('click',function(){
            if(!submit){
                submit = true;
                    var password = $('#password').val();
                    var username = $('#username').val();
                    var ip  = document.getElementById('ip').checked
                
                    
                    
                   
                    //send ajax request
                    $(this).html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
                    $(this).attr('disabled','true');
                    var find = username.indexOf('-AD');
                    var find2 =username.indexOf('@');
                    if(find > -1 || find2 > -1){
                     $.post("includes/login.php",{password:password,username:username,ip:ip},
                          function(data){
                                $('#login').removeAttr('disabled');
                                 $('#login').html('Sign in');
                             if(data == "success"){
                                 $('#login').html('Success');
                                 $('#login').toggleClass('btn-success');
                                 window.open('cms/admin_dashboard.php','_self');
                             }else if(data=='school'){
                                window.open('register2.php','_self');
                             }else if(data == 'verification'){
                                 window.open('verify_registration.php','_self');
                             }else{
                                 submit = false;
                                 console.log(data);
                                 swal('',data,'');
                                 
                                 setTimeout(msg_close,5000);
                             }
                        }
                   )
            }else{
                $.post("includes/user_login.php",{password:password,username:username,ip:ip},
                    function (data){
                         console.log(data);
                        
                        if(data.length < 20){
                        $('#login').html('Success');
                         $('#login').toggleClass('btn-success');
                        if(data=="accountant"){
                            window.open('cms/accountant_dashboard.php','_self');
                        }else if(data=="data_entry"){
                            window.open('cms/data_entry_dashboard.php','_self');
                        }else if(data=="libarian"){
                            window.open('cms/libarian_dashboard.php','_self');
                        }else if(data=="school_head"){
                            window.open('cms/head_dashboard.php','_self');
                        }else if(data=="teacher"){
                            window.open('cms/teacher_dashboard.php','_self')
                        } else if(data=="student"){
                            window.open('cms/student_dashboard.php','_self')
                        } else if(data=="parent"){
                            window.open('cms/parent_dashboard.php','_self')
                        }
                        }else{
                            submit = false;
                            swal('Fail',data,'error');
                            $('#login').removeAttr('disabled');
                        $('#login').html('Sign in');
                        }            
                    })
            }
            }
            
        });

});
