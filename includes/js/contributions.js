function view_contributions(id){
    //send ajax request
     $.post("includes/view_contributions.php",{contribute_id:id},
                      function(data){
                        //console.log(data);
                       
                       document.getElementById('content').innerHTML = data;
                       console.log(data);
                    }
               )
}

function validate(id){
    var btn = 'vbtn'+id;
     document.getElementById(btn).innerHTML = 'Please wait';
     $('#vbtn1'+id).css('display','none');
     $.post("includes/validate.php",{contribute_id:id},
                      function(data){
                        //console.log(data);
                       
                        $('#vbtn'+id).css('display','none');
                        $('#vbtn1'+id).css('display','none');
                       console.log(data);
                    }
               )
}
function confirm_c(id){
    $.post("includes/confirm_c_by_admin.php",{contribution_id:id},
           function(data){
             document.getElementById('content').innerHTML = data;
             console.log(data);
            })
}
function validate_by_admin(id){
    
    var btn = 'vbtn'+id;
     document.getElementById(btn).innerHTML = 'Please wait';
     $('#vbtn1'+id).css('display','none');
    $.post("includes/confirm_contribution.php",{contribution_id:id},
           function(data){
            $('#vbtn'+id).css('display','none');
                        $('#vbtn1'+id).css('display','none');
            })
}
function block_user(id){
    var btn = 'vbtn1'+id;
     document.getElementById(btn).innerHTML = 'Please wait';
     $('#vbtn'+id).css('display','none');
    $.post("includes/block_user2.php",{id:id},
           function(data){
            $('#vbtn'+id).css('display','none');
              $('#vbtn1'+id).css('display','none');
            })
}