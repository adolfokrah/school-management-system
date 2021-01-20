$('document').ready(function(){
    
    
    //register command
        var submit = false;
        $('#submit').on('click',function(){
            if(!submit){
                submit = true;
                    var vcode = $('#vcode').val();
                    
                    //send ajax request
                    $(this).html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
                    $(this).attr('disabled',true);
                     $.post("includes/verify_registration.php",{vcode:vcode},
                          function(data){
                               $("#submit").html('Verify');
                               $("#submit").removeAttr('disabled','false');
                               submit = false;
                               console.log(data);
                                $('#activate_btn').html('Activate');
                                $('#activate_btn').removeAttr('disabled','true');
                                if(data=="expired"){
                                    swal('Fail','voucher code expired','error');
                                }else if(data=="used"){
                                    swal('Fail','voucher has already been used','error');
                                }else if(data=="notfound"){
                                    swal('Fail','incorrect voucher code','error');
                                }else{
                                    window.open('cms/print_payment_receipt.php?id='+data,'_blank');
                                    setTimeout(open_file,3000);
                                   
                                }
                        }
                   )
            }
            
        });

});

function open_file(){
     window.open('cms/admin_dashboard.php','_self');
}