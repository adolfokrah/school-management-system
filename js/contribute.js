function contribute(id){
    var amount = document.getElementById(id);
    amount1 = amount.options[amount.selectedIndex].value;
    
    
    document.getElementById('btn'+id).innerHTML = 'Please wait....';
    document.getElementById('btn'+id).className = 'label label-warning';
    document.getElementById(id).setAttribute('disabled','fasle');
    document.getElementById('btn'+id).setAttribute('disabled','fasle');
    
    //send ajax request
     $.post("includes/contibute.php",{request_id:id,c_amount:amount1},
                      function(data){
                        //console.log(data);
                       $('#btn'+id).css('display','none');
                       document.getElementsByClassName('row'+id)[0].className = 'warning';
                       alert(data);
                    }
               )
}


function contribute1(id){
    var amount = document.getElementById(id);
    amount1 = amount.options[amount.selectedIndex].value;
    
    
    document.getElementById('btn'+id).innerHTML = 'Please wait....';
    document.getElementById('btn'+id).className = 'label label-warning';
    document.getElementById(id).setAttribute('disabled','fasle');
    document.getElementById('btn'+id).setAttribute('disabled','fasle');
    
    //send ajax request
     $.post("includes/rescue_contribution.php",{request_id:id,c_amount:amount1},
                      function(data){
                        //console.log(data);
                       $('#btn'+id).css('display','none');
                       document.getElementsByClassName('row'+id)[0].className = 'warning';
                       alert(data);
                    }
               )
}