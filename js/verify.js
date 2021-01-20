function verify(id){
    $('#'+id).change(function() {
                console.log("submit event"+id);
                var btn = 'btn'+id;
        
                document.getElementById(btn).innerHTML = 'Please wait...';
                var fd = new FormData(document.getElementById("form"+id)); 
                fd.append("label", id);
                $.ajax({
                  url: "includes/verify.php",
                  type: "POST",
                  data: fd,
                  processData: false,  // tell jQuery not to process the data
                  contentType: false   // tell jQuery not to set contentType
                }).done(function( data ) {
                
                    if(data=='Invalid file'){
                        
                        alert('Failed! Reason: Invalid file');
                        document.getElementById(btn).innerHTML = 'varify';
                        
                    }else{
                        console.log(data);
                        
                        //$('#messages').append(data);
                        document.getElementById('btn'+id).className = 'label label-primary';
                        document.getElementById(btn).innerHTML = 'processed';
                    }
                    
                    
                });
                return false;
            });
}

function verify2(id){
    $('#'+id).change(function() {
                console.log("submit event"+id);
                var btn = 'btn'+id;
                var amount = document.getElementById('amt'+id);
                amount1 = amount.options[amount.selectedIndex].value;
                document.getElementById(btn).innerHTML = 'Please wait...';
                var fd = new FormData(document.getElementById("form"+id)); 
                fd.append("label", id);
                fd.append("amount",amount1)
                $.ajax({
                  url: "includes/verify_contribute.php",
                  type: "POST",
                  data: fd,
                  processData: false,  // tell jQuery not to process the data
                  contentType: false   // tell jQuery not to set contentType
                }).done(function( data ) {
                
                    if(data=='Invalid file'){
                        
                        alert('Failed! Reason: Invalid file');
                        document.getElementById(btn).innerHTML = 'contribute';
                        
                    }else{
                        console.log(data);
                        
                        //$('#messages').append(data);
                        $('#'+btn).css('display','none');
                    }
                    
                    
                });
                return false;
            });
}