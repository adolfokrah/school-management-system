function post_notice(){
    
    var notice = document.getElementById("notice_text_area").value;

    //check if notice is empty
    if(notice == ""){
        //call sweetalert
        swal(
          'Ooops..',
          'Nothing to post.',
          'error'
        )
    }else{
        $('#post_notice_btn').html('posting...');
        $('#post_notice_btn').attr('disabled','true');

        //post notice
        $.post("../includes/post_notice_ajax.php",{notice:notice},
              function(data){
                 if(data == "success"){
                     //reset elements
                     $('#post_notice_btn').html('Add Notice');
                     $('#post_notice_btn').removeAttr('disabled','false');
                     $('#notice_text_area').val('');

                     //split notice to fit to notice box
                     notice = notice.substr(0,300);
                     $('#view_notice').html(notice);
                     //success alert

                    swal(
                      'Success',
                      'Notice posted successfully.',
                      'success'
                    )
                 }else{
                     //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured when posting. please make sure you are connected to the internet.',
                      'error'
                    )
                     $('#post_notice_btn').html('Add Notice');
                     $('#post_notice_btn').removeAttr('disabled','false');
                 }
            }
       )
    }

}

//delete class
function delete_class(id){
    swal({
      title: 'Are you sure?',
      text: "This will delete all students in the class and unassigned from the class as well",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showCloseButton:true,
      showLoaderOnConfirm:true,
        
      preConfirm:function(){
          return new Promise(function(resolve){
               $.post("../includes/delete_class.php",{id:id},
              function(data){
                   console.log(data);
                  if(data == 'success'){
                      //call ajax
                          swal({
                              title: '',
                              text: "Class successfully deleted",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('manage_class.php','_self');
                              }
                            })
                          
                  }else if(data == 'notempty'){
                         //call sweetalert
                    swal(
                      'Ooops..',
                      'Class(es) not empty',
                      'error'
                    )
                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured. please make sure you are connected to the internet.',
                      'error'
                    )
                  }
              })
              
          })
      }
    })
}

function add_class(){
    var classname = $('#add_class_name').val();
    
    if(classname == ""){
        swal(
              'Ooops..',
              'Clas name needed.',
              'error'
            )
    }else{
    $('#add_class_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
    $('#add_class_btn').attr('disabled','true');
    
    $.post("../includes/add_class_ajax.php",{classname:classname},
              function(data){
                console.log(data);
                $('#add_class_btn').html('Add Class');
                $('#add_class_btn').removeAttr('disabled','false');
        
                  if(data == 'success'){
                      $('#add_class_name').val('');
                      swal(
                      'Success',
                      classname+' added successfully.',
                      'success'
                    )
                    
                  }else if(data == 'found'){
                     swal(
                      'Sorry..',
                      classname+' already exist.',
                      'error'
                    ) 
                  }else{
                     swal(
                      'Ooops..',
                      'An error occured when adding. please make sure you are connected to the internet.',
                      'error'
                    )  
                  }
              })
    }
    
}

function edit_class(id){
    $.post("../includes/edit_class.php",{id:id,show:'show'},
              function(data){
                   $('#edit_form').html(data);
              })
}
function edit_class_action(id){
    var classname = $('#edit_class_name').val();
    if(classname == ""){
        swal(
              'Ooops..',
              'Class name needed.',
              'error'
            )
    }else{
    $('#edit_class_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
    $('#edit_class_btn').attr('disabled','true');
    $.post("../includes/edit_class.php",{id:id,classname:classname},
              function(data){
                   
                    
                    if(data == 'success'){
                     window.open('manage_class.php','_self');
                    
                  }else if(data == 'found'){
                     swal(
                      'Sorry..',
                      'Class already exist.',
                      'error'
                    ) 
                  }else{
                     swal(
                      'Ooops..',
                      'An error occured when adding. please make sure you are connected to the internet.'+data,
                      'error'
                    )  
                  }
        
              })
    }
}

function delete_all_classes(){
    var value = $('#result_box').html();
     if(value.length==106){
         swal(
          'Ooops..',
          'Nothing to delete.',
          'error'
        )
     }else{
        
      swal({
      title: 'Are you sure?',
      text: "This will delete all students in the classes and unassigned from the classes as well",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete all!',
      showCloseButton:true,
      showLoaderOnConfirm:true,
          
    preConfirm:function(){
          return new Promise(function(resolve){
                 $.post("../includes/delete_class.php",{all:"all"},
              function(data){
                     console.log(data);
                  if(data == 'success'){
                      //call ajax
                          swal({
                              title: '',
                              text: "Classes successfully deleted",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('manage_class.php','_self');
                              }
                            })
                          
                  }else if(data == 'notempty'){
                         //call sweetalert
                    swal(
                      'Ooops..',
                      'Class(es) not empty',
                      'error'
                    )
                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured. please make sure you are connected to the internet.',
                      'error'
                    )
                  }
              })
            }
           )}
    })
     }
}

function add_subject(Class){
    var subject = $('#add_subject_name').val();
    var teacher = $('#sub_teacher').val();
    
    if(subject == "" || teacher == "" || Class=="No Class selected"){
        swal(
              'Ooops..',
              'Nothing to add. Please make sure you select a class or you fill all fileds correctly',
              'error'
            )
    }else{
        $('#add_subject_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
        $('#add_subject_btn').attr('disabled','true');
        
         $.post("../includes/add_subject.php",{subject:subject,classname:Class,teacher:teacher},
              function(data){
                   $('#add_subject_btn').html('Add Subject');
                $('#add_subject_btn').removeAttr('disabled','false')
                    
                    if(data == 'success'){
                    $('#add_subject_name').val('');
                     swal(
                      'Success',
                      subject+' added successfully.',
                      'success'
                    )
                    
                  }else if(data == 'found'){
                     swal(
                      'Sorry..',
                      subject+' already exist.',
                      'error'
                    ) 
                  }else{
                     swal(
                      'Ooops..',
                      'An error occured when adding. please make sure you are connected to the internet.',
                      'error'
                    )  
                  }
        
              })
        
    }
}

function delete_all_subjects(Class){
     var value = $('#result_box').html();
     if(value.length==188){
         swal(
                      'Ooops..',
                      'Nothing to delete.',
                      'error'
                    )
     }else{
        
         swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete all!',
          showCloseButton:true,
          showLoaderOnConfirm:true,

        preConfirm:function(){
          return new Promise(function(resolve){
                   $.post("../includes/delete_subject.php",{all:"all",class:Class},
              function(data){
                    console.log(data);
                  if(data == 'success'){
                      //call ajax
                          swal({
                              title: '',
                              text: "Subjects successfully deleted",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('manage_subject.php?class='+Class,'_self');
                              }
                            })
                          
                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured when posting. please make sure you are connected to the internet.',
                      'error'
                    )
                  }
              })
              })
          }
        })
     }
      
}

function delete_subject(id){
      var Class = $('#class').html();
    
      swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showCloseButton:true,
      showLoaderOnConfirm: true,
          
      preConfirm:function(){
          return new Promise(function(resolve){
               $.post("../includes/delete_subject.php",{id:id},
              function(data){
                  if(data == 'success'){
                      //call ajax
                          swal({
                              title: '',
                              text: "Subject successfully deleted",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('manage_subject.php?class='+Class,'_self');
                              }
                            })
                          
                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured when posting. please make sure you are connected to the internet.',
                      'error'
                    )
                  }
              })
          })
      }
    })
}

function edit_subject(id){
    $.post("../includes/edit_subject.php",{id:id,show:'show'},
              function(data){
                
                   var fields = JSON.parse(data);
                   
                   $('#edit_subject_name').val(fields[1]);
                   $('#edit_subject_btn').attr('name',fields[0]);
                   
              })
}



function edit_subject_action(Class){
    var id = document.getElementById('edit_subject_btn').name;
    var subject = $('#edit_subject_name').val();
    var edit_sub_teacher = $('#edit_sub_teacher').val();
    if(subject == ""){
        swal(
              'Ooops..',
              'Subject name needed.',
              'error'
            )
    }else{
    $('#edit_subject_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
    $('#edit_subject_btn').attr('disabled','true');
    $.post("../includes/edit_subject.php",{id:id,class:Class,subject:subject,teacher:edit_sub_teacher},
              function(data){
                   
                    $('#edit_subject_btn').html('Edit Class');
    $('#edit_subject_btn').removeAttr('disabled','true');
                    if(data == 'success'){
                     window.open('manage_subject.php?class='+Class,'_self');
                    
                  }else if(data == 'found'){
                     swal(
                      'Sorry..',
                      'Teacher already assigned.',
                      'error'
                    ) 
                  }else{
                     swal(
                      'Ooops..',
                      'An error occured when adding. please make sure you are connected to the internet.',
                      'error'
                    )  
                  }
        
              })
    }
}

function upload_student_image_from_explorer(){
    $('#file').change(function() {
                $('#student_image').css('background-image','url()');
                $('#student_image').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> uploading...');
                var fd = new FormData(document.getElementById("form")); 
                
                $.ajax({
                  url: "../cms/upload_student_image_from_explorer.php",
                  type: "POST",
                  data: fd,
                  processData: false,  // tell jQuery not to process the data
                  contentType: false   // tell jQuery not to set contentType
                }).done(function( data ) {
                   console.log(data);
                    if(data == 'error'){
                        $('#student_image').html('');
                        swal(
                          'Ooops..',
                          'An error occured. please make sure you are connected to the internet.',
                          'error'
                        )
                        
                    }else{
                        $('#student_image').html('');
                        $('#student_image').css('background-image','url(../cms/upload/'+data+')');
                    }
                    
                });
                return false;
            });
}

function upload_edit_student_image_from_explorer(){
    $('#file').change(function() {
                $('#student_image').css('background-image','url()');
                $('#student_image').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> uploading...');
                var fd = new FormData(document.getElementById("form")); 
                
                $.ajax({
                  url: "../cms/upload_edit_student_image_from_explorer.php",
                  type: "POST",
                  data: fd,
                  processData: false,  // tell jQuery not to process the data
                  contentType: false   // tell jQuery not to set contentType
                }).done(function( data ) {
                   console.log(data);
                    if(data == 'error'){
                        $('#student_image').html('');
                        swal(
                          'Ooops..',
                          'An error occured. please make sure you are connected to the internet.',
                          'error'
                        )
                        
                    }else{
                        $('#student_image').html('');
                        $('#student_image').css('background-image','url(../cms/upload/'+data+')');
                    }
                    
                });
                return false;
            });
}

function add_new_student(){
    //student personal information
    
    var firstname  = $('#first_name').val();
    var lastname   = $('#last_name').val();
    var date_of_birth = $('#date_of_birth').val();
    
    var hometown = $('#hometown').val();
    var nationality = $('#nationality').val();
    var rgd = $('#rgd').val();
    var former_school = $('#former_school').val();
    var std_class = $('#class').val();
    var gender = $('#gender').val();
    var Class = $('#class').val();
    
    //guardian information
    var guardianname = $('#guardianname').val();
    var guardianaddress = $('#guardianaddress').val();
    var guardianoccupation = $('#guardianoccupation').val();
    var guardiantel = $('#guardiantel').val();
    var guardianrgd = $('#guardianrgd').val();
    var relationship_to_std = $('#relationship').val();
    var disability = $('#disability').val();
    
    //office use
    var fee = $('#fee').val();
    var paid_date = $('#paid_date').val();
    var admission_date = $('#admission_date').val();
    
    var validate = false;
    
    if(isNaN(guardiantel) || guardiantel==""){
        $('#guardiantel').css('border','thin solid red');
        $('#guardiantel').val("");
        $('#guardiantel').attr('placeholder','Telephone number Should be in numbers.');
        
    }
    if(isNaN(fee) || fee==""){
        $('#fee').css('border','thin solid red');
        $('#fee').val("");
        $('#fee').attr('placeholder','Fees number Should be in numbers.');
        
    }
    
    if((isNaN(fee) || fee=="") || (isNaN(guardiantel) || guardiantel=="")){
        validate  = false;
    }else{
        validate = true;
    }
    
    if(validate == true){
        if(firstname == "" || lastname == "" ||  guardianname==""){
            swal(
                  'Ooops..',
                  'Some fields were left blank.',
                  'error'
                )
        }else{
            $('#add_student').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Please wait...');
            $('#add_student').attr('disabled','true');
            $('#choose_pic').attr('disabled','true');
            $('#configure_cam').attr('disabled','true');
            
            $.post("../includes/add_student.php",{firstname:firstname,lastname:lastname,date_of_birth:date_of_birth,hometown:hometown,nationality:nationality,rgd:rgd,guardianname:guardianname,guardianaddress:guardianaddress,guardianoccupation:guardianoccupation,guardianrgd:guardianrgd,relationship_to_std:relationship_to_std,disability:disability,paid_date:paid_date,admission_date:admission_date,former_school:former_school,fee:fee,guardiantel:guardiantel,class:Class,gender:gender},
              function(data){
                    console.log(data);
                    $('#add_student').html('<i class="fa fa-plus"></i> Add Student');
                    $('#add_student').removeAttr('disabled','true');
                    $('#choose_pic').removeAttr('disabled','true');
                    $('#configure_cam').removeAttr('disabled','true');
                    
                    if(data=='year'){
                        swal(
                          'Ooops..',
                          'Academic Year Not set',
                          'error'
                        )
                    }else if(data=="error"){
                        swal(
                          'Ooops..',
                          'An error occured. Please try again later.'+data,
                          'error'
                        )
                    }else{
                        swal(
                          '',
                          'Student Added Successfully','success'
                        )
                       window.open('print_receipt.php?id='+data,'_blank');
                       //setTimeout(open_file,3000);
                       
                    }
              })
        }
    }
    
   
}
function open_file(){
    window.open('add_student.php','_self');
}

function edit_student(){
    //student personal information
    
    var firstname  = $('#first_name').val();
    var lastname   = $('#last_name').val();
    var date_of_birth = $('#date_of_birth').val();
    
    var hometown = $('#hometown').val();
    var nationality = $('#nationality').val();
    var rgd = $('#rgd').val();
    var former_school = $('#former_school').val();
    var std_class = $('#class').val();
    var gender = $('#gender').val();
    var Class = $('#class_edit').val();
    
    //guardian information
    var guardianname = $('#guardianname').val();
    var guardianaddress = $('#guardianaddress').val();
    var guardianoccupation = $('#guardianoccupation').val();
    var guardiantel = $('#guardiantel').val();
    var guardianrgd = $('#guardianrgd').val();
    var relationship_to_std = $('#relationship').val();
    var disability = $('#disability').val();
    
    //office use
    var fee = $('#fee').val();
    var paid_date = $('#paid_date').val();
    var admission_date = $('#admission_date').val();
    
    var validate = false;
    
    if(isNaN(guardiantel) || guardiantel==""){
        $('#guardiantel').css('border','thin solid red');
        $('#guardiantel').val("");
        $('#guardiantel').attr('placeholder','Telephone number Should be in numbers.');
        
    }
    if(isNaN(fee) || fee==""){
        $('#fee').css('border','thin solid red');
        $('#fee').val("");
        $('#fee').attr('placeholder','Fees number Should be in numbers.');
        
    }
    
    if((isNaN(fee) || fee=="") || (isNaN(guardiantel) || guardiantel=="")){
        validate  = false;
    }else{
        validate = true;
    }
    
    if(validate == true){
        if(firstname == "" || lastname == "" || guardianname=="" ){
            swal(
                  'Ooops..',
                  'Some fields were left blank.',
                  'error'
                )
        }else{
            $('#add_student').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Please wait...');
            $('#add_student').attr('disabled','true');
            $('#choose_pic').attr('disabled','true');
            $('#configure_cam').attr('disabled','true');
            
            $.post("../includes/edit_student.php",{firstname:firstname,lastname:lastname,date_of_birth:date_of_birth,hometown:hometown,nationality:nationality,rgd:rgd,guardianname:guardianname,guardianaddress:guardianaddress,guardianoccupation:guardianoccupation,guardianrgd:guardianrgd,relationship_to_std:relationship_to_std,disability:disability,paid_date:paid_date,admission_date:admission_date,former_school:former_school,fee:fee,guardiantel:guardiantel,class:Class,gender:gender},
              function(data){
                    $('#add_student').html('<i class="fa fa-plus"></i> Add Student');
                    $('#add_student').removeAttr('disabled','true');
                    $('#choose_pic').removeAttr('disabled','true');
                    $('#configure_cam').removeAttr('disabled','true');
                    console.log(data);
                    if(data == 'success'){
                        swal({
                              title: '',
                              text: "Success",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('manage_student.php?class='+Class,'_self');
                              }
                            })
                        
                    }else{
                        swal(
                          'Ooops..',
                          'An error occured. Please try again later.',
                          'error'
                        )
                    }
              })
        }
    }
    
   
}

function delete_student(id,Class){
    
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showCloseButton: true,
      showLoaderOnConfirm: true,
        
      preConfirm:function(){
          return new Promise(function(resolve){
              $.post("../includes/delete_student.php",{id:id,class:Class},
              function(data){
                  console.log(data);
                  if(data == 'success'){
                      //call ajax
                          swal({
                              title: '',
                              text: "Student deleted",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('manage_student.php?class='+Class,'_self');
                              }
                            })
                          
                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured when deleting. please make sure you are connected to the internet.',
                      'error'
                    )
                  }
              })
          })
      }
    })
}

function show_student_details(id){
    $('.modal-loader').css('display','block');
    $.post("../includes/show_student_info.php",{id:id,show:'show'},
              function(data){
                   $('.modal-loader').css('display','none');
                   var fields = JSON.parse(data);
                   
                    //student personal information
    
                    var firstname  = $('#first_name').val(fields[0]);
                    var lastname   = $('#last_name').val(fields[1]);
                    var date_of_birth = $('#date_of_birth').val(fields[2]);
                    
                    var hometown = $('#hometown').val(fields[4]);
                    var nationality = $('#nationality').val(fields[5]);
                    var rgd = $('#rgd').val(fields[6]);
                    var former_school = $('#former_school').val(fields[7]);
                    var std_class = $('#class_edit').selectpicker('val',fields[8]);
                    var gender = $('#gender').selectpicker('val',fields[9]);
                    

                    //guardian information
                    var guardianname = $('#guardianname').val(fields[11]);
                    var guardianaddress = $('#guardianaddress').val(fields[12]);
                    var guardianoccupation = $('#guardianoccupation').val(fields[13]);
                    var guardiantel = $('#guardiantel').val(fields[14]);
                    var guardianrgd = $('#guardianrgd').val(fields[15]);
                    var relationship_to_std = $('#relationship').val(fields[16]);
                    var disability = $('#disability').val(fields[17]);

                    //office use
                    var fee = $('#fee').val(fields[18]);
                    var paid_date = $('#paid_date').val(fields[19]);
                    var admission_date = $('#admission_date').val(fields[20]);
                    $('#student_id').val(fields[21]);
                    $('#student_image').css('background-image','url(../cms/upload/'+fields[22]+')');
                    
              })
}

function print_student_info(student_id){
    var search = $('input[type="search"]').val();
    if(search == ""){
        search = "all";
    }
    window.open('print_sudent_fees_info.php?student_id='+student_id+'&search='+search,'_blank');
}

function change_student_class(){
    var all_checked = false;
    var checked = false;                
    var check_boxes = document.getElementsByClassName('checkboxes');
    var ids =[];
    for(var x=0; x < check_boxes.length; x++){
            if(check_boxes[x].checked){
               checked = true;
            }
        }
    
    if(checked == true){
        Class = $('#change_class').val();
        for(var x=0; x < check_boxes.length; x++){
            if(check_boxes[x].checked){
                ids[x]=check_boxes[x].name;
            }
        }
        
        swal({
      title: 'Are you sure?',
      text: "You are about to change this class.",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes,  Make Changes!',
      showLoaderOnConfirm:true,
      showCloseButton:true,
      preConfirm:function(){
          return new Promise(function(resolve){
              $.post("../includes/change_student_class.php",{id:ids,class:Class},
                  function(data){
                      if(data == 'success'){

                          window.open('manage_student.php?class='+Class,'_self');
                      }else{
                           swal(
                              'Ooops..',
                              'An error Occured',
                              'error'
                            )
                      }
                  })
          })
      }      
    })
    }else{
        swal(
              'Ooops..',
              'No Seletion Made',
              'error'
            )
          }
    
      
}

function attendanc_sheet(Class){
    var value = $('#result_box').html();
     if(value.length==188){
         swal(
                      'Ooops..',
                      'No Data Available.',
                      'error'
                    )
     }else{
         window.open('../cms/print_attendance_sheet.php?class='+Class,'_blank');
     }
}
function take_attedance(){
    
    var value = $('#result_box').html();
     if(value.length==188){
         swal(
              'Ooops..',
              'No records found.',
              'error'
            )
     }else{
        var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                }
            }
         
         var sms ="none";
         var teacher  = $('#Teacher_Name').val();
         var date = $('#attendance_date').val();
         var Class = $('#initial_class').val();
         if(teacher == "" || date == ""){
             swal(
                 '',
                 'Ooops..,Date needed',
                 'error'
             )
         }else{
             $('#continue').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
             $('#continue').attr('disabled','true');
             
             if(ids == ""){
                 ids = "none";
             }
             $.post("../includes/take_attedance.php",{id:ids,class:Class,teacher:teacher,date:date,sms:sms},
                  function(data){
                      $('#continue').html('<i class="fa fa-save"></i> Continue');
                    $('#continue').removeAttr('disabled','true');
                      if(data == 'success'){
                          swal({
                              title: 'Done',
                              text: 'Attendance Taken',
                              type: 'success',
                              
                             
                          })
                      }else if(data=='found'){
                          swal(
                              '',
                              'Attendance already taken for '+date,
                              'error'
                            )
                      }else{
                           swal(
                              'Ooops..',
                              'An error Occured'+data,
                              'error'
                            )
                      }
                  })
         }
    
        
     }
    
}

function attendance_report(Class,date){
    
    var value = $('#result_box').html();
    
     if(value.length==184 || value.length==183){
         swal(
              'Ooops..',
              'No records found.',
              'error'
            )
     }else{
        var search = $('input[type="search"]').val();
        if(search == ""){
            search = "all";
        }
        window.open('print_attendance_report.php?class='+Class+'&search='+search+'&date='+date,'_blank');
     }
    
    
}

function fetch_attendace_info(Class,date){
    
    $.post("../includes/fetch_attendance_info.php",{date:date,class:Class},
                  function(data){
                      var fields = [];
                      fields = JSON.parse(data);
                     
                      $('#p_teacher_name').html('Change Techer form '+fields[0]+' to');
                      $('#attendance_date').val(fields[1]);
                      $('#pdate').val(fields[1]);
                  })
}


//update attendace

function update_attedance(){
    
    var value = $('#result_box').html();
     if(value.length==188){
         swal(
              'Ooops..',
              'No records found.',
              'error'
            )
     }else{
        var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                }
            }
         
        
         var teacher  = $('#Teacher_Name').val();
         var date = $('#attendance_date').val();
         var Class = $('#initial_class').val();
         var pdate = $('#pdate').val();
         if(teacher == "" || date == ""){
             swal(
                 '',
                 'Ooops..,Date needed',
                 'error'
             )
         }else{
             $('#continue').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
             $('#continue').attr('disabled','true');
             
             if(ids == ""){
                 ids = "none";
             }
             console.log(ids);
             $.post("../includes/update_attedance.php",{id:ids,class:Class,teacher:teacher,date:date,pdate:pdate},
                  function(data){
                      $('#continue').html('<i class="fa fa-save"></i> Continue');
                    $('#continue').removeAttr('disabled','true');
                      if(data == 'success'){
                          swal({
                              title: '',
                              text: "Attendance Updated",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok'
                            }).then((result) => {
                              if (result.value) {
                                window.open('attendance_history.php?class='+Class+'&attendance_date='+date,'_self');
                              }
                            })
                      }else if(data=='found'){
                          swal(
                              '',
                              'Attendance already taken for '+date,
                              'error'
                            )
                      }else{
                           swal(
                              'Ooops..',
                              'An error Occured',
                              'error'
                            )
                      }
                  })
         }
    
        
     }
    
}

function fetch_student_marks(id,Class){
     $.post("../includes/fetch_student_marks.php",{id:id,class:Class},
                  function(data){
                      $('#modal_results').html(data);
                  })
}

function  update_insert(id,Class1){
    var exam = document.getElementsByName('exam_subjects');
    var Class = document.getElementsByName('class_subjects');
    
    var exam_scores = [];
    var Class_scores = [];
    
    var exam_subjects =[];
    var class_subjects = [];
    
    var insert = true;
    //pick exam details
    for(var x=0; x<exam.length; x++){
        
       
           if((isNaN(exam[x].value))){
            exam[x].style.border = "thin solid red";
            insert = false;
            exam[x].value = '';
            exam[x].placeholder='Numbers required';
           }else{
                exam_scores[x]=exam[x].value; 
                exam_subjects[x]=exam[x].id;
           }
      
       
    }
    
     //pick exam details
    for(var x=0; x<Class.length; x++){
        
       
           if((isNaN(Class[x].value))){
            Class[x].style.border = "thin solid red";
            insert = false;
            Class[x].value = '';
            Class[x].placeholder='Numbers required';
           }else{
               Class_scores[x]=Class[x].value; 
               class_subjects[x]=Class[x].id;
           }
       
        
    }
    
    
    if(insert==true){
    
    $('#savebtn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
    $('#savebtn').attr('disabled','true');
    
    $.post("../includes/update_insert_student_mark.php",{exam_subjects:exam_subjects,exam_scores:exam_scores,class_subjects:class_subjects,class_score:Class_scores,id:id,class:Class1},
          function(data){
        
             $('#savebtn').html('<i class="fa fa-save "></i> Save');
             $('#savebtn').removeAttr('disabled','true'); 
            
            if(data=='success'){
                $('.modal').css('display','none');
                swal(
                    'done',
                    'done',
                    'success'
                )
                console.log('success');
            }else{
                console.log(data);
            }
          })
    }else{
          $('#savebtn').html('Error: resend');
          

    }
}

function  update_insert2(Class1,subject){
    var exam = document.getElementsByName('exam_score');
    var Class = document.getElementsByName('class_score');
  
    
    var exam_scores = [];
    var Class_scores = [];
    
    
    
    var exam_subjects=subject;
    var class_subjects=subject;
    var ids = [];
    
    var insert = true;
    //pick exam details
    for(var x=0; x<exam.length; x++){
        
       
           if((isNaN(exam[x].value))){
            exam[x].style.border = "thin solid red";
            insert = false;
            exam[x].value = '';
            exam[x].placeholder='Numbers required';
           }else{
                exam_scores[x]=exam[x].value; 
                ids[x]=exam[x].id; 
                
           }
      
       
    }
    
     //pick exam details
    for(var x=0; x<Class.length; x++){
        
       
           if((isNaN(Class[x].value))){
            Class[x].style.border = "thin solid red";
            insert = false;
            Class[x].value = '';
            Class[x].placeholder='Numbers required';
           }else{
               Class_scores[x]=Class[x].value; 
               
           }
       
        
    }
    
    
    if(insert==true){
    
    $('#savebtn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
    $('#savebtn').attr('disabled','true');
    
    $.post("../includes/update_insert_student_marks.php",{exam_subjects:exam_subjects,exam_scores:exam_scores,class_subjects:class_subjects,class_score:Class_scores,ids:ids,class:Class1},
          function(data){
        
             $('#savebtn').html('<i class="fa fa-save "></i> Save');
             $('#savebtn').removeAttr('disabled','true'); 
            
            if(data=='success'){
                $('.modal').css('display','none');
                swal(
                    'done',
                    'done',
                    'success'
                )
                console.log('success');
            }else{
                console.log(data);
            }
          })
    }else{
          $('#savebtn').html('Error: resend');
          

    }
}

function bill_fees(Class){
    var value = $('#result_box').html();
    
     if(value.length==188 || value.length == 187){
         swal(
              'Ooops..',
              'No records found.',
              'error'
            )
     }else{
         swal({
          title: 'Please Input Amount',
          input: 'text',
          inputPlaceholder: 'Enter Amount',
          showCancelButton: true,
          inputValidator: (value) => {
            return !value && 'You need to enter amount!'
          }
        }).then((result) => {
          if (result.value) {
                if(swal.getInput().value != ""){
                    if(!(isNaN(swal.getInput().value))){
                        var amount = swal.getInput().value;
                        swal({
                          title: 'Are you sure?',
                          text: "If student has already made part of full parment billing won\'t have any effect on it.",
                          type: 'warning',
                          showCancelButton: false,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Yes,  Bill Fees!',
                          showLoaderOnConfirm:true,
                          showCloseButton:true,
                          preConfirm:function(){
                              return new Promise(function(resolve){
                                    var ids =[];
                                    var check_boxes = document.getElementsByClassName('checkboxes');
                                    for(var x=0; x < check_boxes.length; x++){
                                            if(check_boxes[x].checked){
                                                ids[x]=check_boxes[x].name;
                                            }
                                        }
                                     if(ids == ""){
                                         swal('Fail','No one to be bill','error');
                                     }else{
                                          $.post("../includes/bill_fees_ajax.php",{class:Class,ids:ids,amount:amount},
                                          function(data){
                                             console.log(data);
                                              if(data=='success'){
                                                  swal('success','billed','success');
                                              }else if(data=='payment'){
                                                  swal('Fail','Payment has already been made.','error');
                                              }else if(data=='year'){
                                                  swal('Fail','Academic year not set','error');
                                              }else{
                                                  swal('Fail','An error occured','error');
                                              }
                                          })
                                     }
                                    
                              })
                          }      
                        })
                    }else{
                        swal('Fail','Amount should be in numbers only','error');
                    }
                      
                 }
          }
        })
         
     }
}


function make_payment(){
    var student_id = $('#pstudent_id').val();
    var amount = $('#pamount').val();
    var paidby = $('#ppaidby').val();
    var pdate = $('#pdate').val();
    var pay = true;
    
    
    if(amount == ""){
        $('#pamount').css('border','thin solid red');
        $('#pamount').attr('placeholder','Amount needed');
        pay = false;
    }
    if(amount < 1){
        $('#pamount').css('border','thin solid red');
        $('#pamount').attr('placeholder','Should not be less than 1');
        pay = false;
    }
    if(student_id == ""){
        $('#pstudent_id').css('border','thin solid red');
        $('#pstudent_id').attr('placeholder','Student id needed');
        pay = false;
    }
    
    if(paidby == ""  || !(isNaN(paidby))){
        $('#ppaidby').css('border','thin solid red');
        $('#ppaidby').attr('placeholder','Paid by?');
        pay = false;
    }
    if(isNaN(amount)){
        $('#pamount').css('border','thin solid red');
        $('#pamount').attr('placeholder','Fiqures needed');
        pay = false;
    }
    
    if(pay == true){
        $('#loader1').css('display','block');
        $('#make_payment').attr('disabled','true');
        $.post("../includes/pay_fees.php",{student_id:student_id,amount:amount,paidby:paidby,date:pdate},
              function(data){
            console.log(data);
            $('.loader').css('display','none');
            $('#make_payment').removeAttr('disabled','true');
            
            if(data==1){
               $('#msg_box').html('<div class="alert alert-error" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong>Success!</strong> Student is not owing fees!</div>');
            }else if(data==2){
                console.log('payment done');
                $('#print_btn').css('display','block');
                $('#msg_box').html('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong>Success!</strong> You have successfully paid fees for '+$('#msg_box').html()+' !</div>');
            }else if(data=="error"){
                $('#msg_box').html('<div class="alert alert-error" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong></strong> Oops!! an error occured please try again</div>');
            }else{
                $('#msg_box').html('<div class="alert alert-error" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <strong></strong> Strudent not billed</div>');
            }
            close_popup();
        })
    }
}


function close_popup(){
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1000);
}


function add_teacher(){
    
    var first_name = $('#first_name').val();
    var teacher_class = $("#teacher_class").val();
    var last_name = $('#last_name').val();
    var contact = $('#contact').val();
    var valid = true;
   
    if(isNaN(contact)){
        $('#contact').css('border','thin solid red');
        $('#contact').val("");
        $('#contact').attr('placeholder','contact must be in fiqures');
        valid = false;
    }
    
    if(first_name == "" || last_name == "" || contact == ""){
        swal(
              'Ooops..',
              'All Fields name required.',
              'error'
            )
        valid = false;
    }else{
        console.log(valid);
        if(valid == true){
              $('#add_teacher_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
    $('#add_teacher_btn').attr('disabled','true');
    
    $.post("../includes/add_teacher_ajax.php",{first_name:first_name,last_name:last_name,teacher_class:teacher_class,contact:contact},
              function(data){
                    console.log(data);
                    $('#add_teacher_btn').html('Add Teacher');
                    $('#add_teacher_btn').removeAttr('disabled','false');
                        
                    if(data == 'success'){
                     swal(
                      'Success',
                      'Teacher added successfully.',
                      'success'
                    )
                    
                  }
                    else if(data == 'found'){
                     swal(
                      'Sorry..',
                      'Teacher already exist.',
                      'error'
                    ) 
                  }else{
                     swal(
                      'Ooops..',
                      'An error occured when adding. please make sure you are connected to the internet.'+data,
                      'error'
                    )  
                  }
        
              })
        } 
    }
    
}



function delete_teacher(id){
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showLoaderOnConfirm:true,
    showCloseButton:true,
    preConfirm:function(){
    return new Promise(function(resolve){
            $.post("../includes/delete_teacher.php",{id:id},
              function(data){
                  if(data == 'success'){
                      console.log(data);
                      //call ajax
                          swal({
                              title: '',
                              text: "Teacher successfully deleted",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('manage_teacher.php','_self');
                              }
                            })
                          
                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured when posting. please make sure you are connected to the internet.',
                      'error'
                    )
                  }
              })
            })

        }
    })
}

function delete_all_teachers(){
      swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete all!',
      showLoaderOnConfirm:true,
    showCloseButton:true,
    preConfirm:function(){
    return new Promise(function(resolve){
        $.post("../includes/delete_teacher.php",{all:"all"},
              function(data){
                  if(data == 'success'){
                      console.log(data);
                      //call ajax
                          swal({
                              title: '',
                              text: "Teachers successfully deleted",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('manage_teacher.php','_self');
                              }
                            })
                          
                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured when posting. please make sure you are connected to the internet.',
                      'error'
                    )
                  }
              })
    })
    }  
      })
     
}


function edit_teacher(id){
    $.post("../includes/edit_teacher.php",{id:id,show:'show'},
              function(data){
                console.log(data);
                var fields = JSON.parse(data);
                var first_name = $('#edit_first_name').val(fields[1]);
                var teacher_class = $("#edit_teacher_class").selectpicker('val',fields[4]);
                var last_name = $('#edit_last_name').val(fields[2]);
               
                var contact = $('#edit_contact').val(fields[3]);
               
                $('#hidden_id').val(fields[0]);
              })
}
function edit_teacher_action(){
    
    var first_name = $('#edit_first_name').val();
    var teacher_class = $("#edit_teacher_class").val();
    var last_name = $('#edit_last_name').val();
   
    var contact = $('#edit_contact').val();
  
    var id = $('#hidden_id').val();
  
   var valid = true;
   
    if(isNaN(contact)){
        $('#edit_contact').css('border','thin solid red');
        $('#edit_contact').val("");
        $('#edit_contact').attr('placeholder','contact must be in fiqures');
        valid = false;
    }
    
    if(first_name == "" || last_name == "" || contact == ""){
        swal(
              'Ooops..',
              'All Fields name required.',
              'error'
            )
        valid = false;
    }else{
          $('#edit_teacher_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
    $('#edit_teacher_btn').attr('disabled','true');
    
    $.post("../includes/edit_teacher.php",{first_name:first_name, teacher_class:teacher_class,last_name:last_name, contact:contact,id:id},
              function(data){
        console.log(data);
                    $('#edit_teacher_btn').removeAttr('disabled','false');
        $('#edit_teacher_btn').html('Edit Teacher');
                    if(data == 'success'){
                     window.open('manage_teacher.php','_self');
                    $('#edit_teacher_btn').html('Done');
                    $('#edit_teacher_btn').css('background-color','green');
                  }
                    else if(data == 'found'){
                     swal(
                      'Sorry..',
                      'Teacher already exist.'+data,
                      'error'
                    ) 
                  }else{
                     swal(
                      'Ooops..',
                      'An error occured when adding. please make sure you are connected to the internet.'+data,
                      'error'
                    )  
                  }
        
              })
    }
}

function delete_daily_fee(id,from,to){
         swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showLoaderOnConfirm:true,
    showCloseButton:true,
    preConfirm:function(){
    return new Promise(function(resolve){
        $.post("../includes/delete_payment.php",{id:id},
              function(data){
                console.log(data);
                  if(data == 'success'){
                      
                      //call ajax
                          swal({
                              title: '',
                              text: "Payment successfully deleted",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('daily_fees_records.php?from_date='+from+'&to_date='+to,'_self');
                              }
                            })
                          
                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured',
                      'error'
                    )
                  }
              })
    })
    }  
      })
 
}

function keed_feeding_fee(){
    var student_ids = [];
    var amounts = document.getElementById('amount');
    var pdate = document.getElementById('days');
    var payment_date = document.getElementById('Payment_Date');
    var amount_per_day = document.getElementById('amount_per_day');
   
    var insert = true;
    var check_boxes = document.getElementsByClassName('checkboxes');
   
    for(var x=0; x < check_boxes.length; x++){
            if(check_boxes[x].checked){
                
                student_ids[x]=$('#student_id'+check_boxes[x].name).html();
            }
        }
    console.log(student_ids);
    insert = true;
    if(student_ids==""){
        swal('','no records selected','error');
        insert = false;
    }else{
        if(amounts.value==""){
            amounts.style.border="thin solid red";
            amounts.value="";
            amounts.placeholder="Amount needed";
            insert = false;
            
        }else{
            if(isNaN(amounts.value)){
                amounts.style.border="thin solid red";
                amounts.value="";
                amounts.placeholder="Amount must be in figures";
                insert = false;
            }
            
        }
        
        if(amount_per_day.value==""){
            amount_per_day.style.border="thin solid red";
            amount_per_day.value="";
            amount_per_day.placeholder="Amount per day needed";
            insert = false;
            
        }else{
            if(isNaN(amount_per_day.value)){
                amount_per_day.style.border="thin solid red";
                amount_per_day.value="";
                amount_per_day.placeholder="Amount must be in figures";
                insert = false;
            }
            
        }
        
        
         if(pdate.value==""){
            pdate.style.border="thin solid red";
            pdate.value="";
            pdate.placeholder="Days Needed";
            insert = false;
            
        }else{
            if(isNaN(pdate.value)){
                pdate.style.border="thin solid red";
                pdate.value="";
                pdate.placeholder="Days must be in figures";
                insert = false;
            }else if((pdate.value < 1)){
                pdate.style.border="thin solid red";
                pdate.value="";
                pdate.placeholder="Days must be greater than 0";
                insert = false;
            }
            
        }
    }
   
    if(payment_date.value==""){
        payment_date.style.border="thin solid red";
        payment_date.value="";
       payment_date.placeholder="Payment Date Needed";
        insert = false;
    }
    
    console.log(insert);
    if(insert == true){
        

          swal({
              title: '',
              text: 'You About to insert feeding fee records',
              type: 'warning',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Procced'
            }).then((result) => {
              if (result.value) {
                        
        $('#Continue').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
        $('#Continue').attr('disabled','true');
         $.post("../includes/keep_feeding_fee.php",{student_ids:student_ids,amounts:amounts.value,pday:pdate.value,date:payment_date.value,amount_per_day:amount_per_day.value},
              function(data){
                    $('#Continue').html('Continue');
                    $('#Continue').removeAttr('disabled','true');
                    var print = false;
                    var counter = 0;
             
                    console.log(data);
                   
                    if(data=="success"){
                           var print = true;
                            counter ++;
                            //swal('','done','success');
                        }else if(data=="year"){
                            swal('Fail','Academic Year Not set','error');
                        }else{
                            swal('','fail','error');    
                        }
                    if(print){
                        swal('Done',' Payment(s) made','success');
                        $('#print_btn').css('display','block');
                        
                    }
              })
              }
            })
    
    }
}

function delete_feeding_fee(id,from,to){
    var student_id = $('#f_student_id').val();
    var arreas = $('#f_arreas').val();
    var balance = $('#f_balance').val();
    var days_left = $('#f_days_left').val();
    
   
    if(isNaN(arreas)||isNaN(balance)||isNaN(days_left)){
       swal('','all fields require fiqures','error');
    }else{
        
   
    
           swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showLoaderOnConfirm:true,
    showCloseButton:true,
    preConfirm:function(){
    return new Promise(function(resolve){
        
        $.post("../includes/delete_feeding_history.php",{id:id,student_id:student_id,arreas:arreas,balance:balance,days_left:days_left},
              function(data){
            console.log(data);
                  if(data == 'success'){
                      
                      //call ajax
                          swal({
                              title: '',
                              text: "Payment successfully deleted",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('feeding_fee_history.php?from_date='+from+'&to_date='+to,'_self');
                              }
                            })
                          
                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured when posting. please make sure you are connected to the internet.',
                      'error'
                    )
                  }
              })
    })
    }  
      })
    }
}

function delete_bus_fee(id,from,to){
    var student_id = $('#f_student_id').val();
    var arreas = $('#f_arreas').val();
    var balance = $('#f_balance').val();
    var days_left = $('#f_days_left').val();
    
   
    if(isNaN(arreas)||isNaN(balance)||isNaN(days_left)){
       swal('','all fields require fiqures','error');
    }else{
        
   
    
           swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showLoaderOnConfirm:true,
    showCloseButton:true,
    preConfirm:function(){
    return new Promise(function(resolve){
        
        $.post("../includes/delete_bus_history.php",{id:id,student_id:student_id,arreas:arreas,balance:balance,days_left:days_left},
              function(data){
            console.log(data);
                  if(data == 'success'){
                      
                      //call ajax
                          swal({
                              title: '',
                              text: "Payment successfully deleted",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('bus_payment_histories?from_date='+from+'&to_date='+to,'_self');
                              }
                            })
                          
                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured when posting. please make sure you are connected to the internet.',
                      'error'
                    )
                  }
              })
    })
    }  
      })
    }
}

function revert_feeding(id,from,to,action){
           swal({
      title: 'Are you sure?',
      text: "You are about to revert a record",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showLoaderOnConfirm:true,
    showCloseButton:true,
    preConfirm:function(){
    return new Promise(function(resolve){
        $.post("../includes/revert_feeding_payment.php",{id:id,action:action},
              function(data){
            console.log(data);
                  if(data == 'success'){
                      
                      //call ajax
                          swal({
                              title: '',
                              text: "Done",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('feeding_fee_history.php?from_date='+from+'&to_date='+to,'_self');
                              }
                            })
                          
                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured when posting. please make sure you are connected to the internet.',
                      'error'
                    )
                  }
              })
    })
    }  
      })
}

function print_feeding_history(from,to){
    Class = $('#class').val();
    window.open('print_feeding_history.php?from='+from+'&to='+to+'&class='+Class);
}
function print_bus_fee_history(from,to,group){
    Class = $('#class').val();
    window.open('print_bus_fee_history.php?from='+from+'&to='+to+'&class='+Class+'&group='+group);
}

function close_hint(id){
   $('#loader2').css('display','block');
    
    var iframe = document.getElementById('iframe');
    iframe.src="print_receipt.php";
    iframe.onload=function(){
        $('#loader2').css('display','none');
        $('#print_btn').css('display','none');
         $(id).remove();
    }
}

function save_new_expens(){
    var item = $('#item_name').val();
    var unit_price = $('#unit_price').val();
    var date = $('#date').val();
    var quantity = $('#qty').val();
    var disc = $('#disc').val();
    var blc = $('#blc').val();
    var debt = $('#debt').val();
    
    var insert = true;
    if(isNaN(quantity)){
        $('#qty').val("");
        $('#qty').css('border','thin solid red');
        $('#qty').attr('placeholder','Quantity should be in fiqures');
        insert = false;
    }
    
    if(isNaN(unit_price)){
        $('#unit_price').val("");
        $('#unit_price').css('border','thin solid red');
        $('#unit_price').attr('placeholder','Amount should be in fiqures');
        insert = false;
    }
    
    if( item != "" && unit_price !="" && date != "" && quantity !=""){
       if(insert == true){
            $('#save_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
        $('#save_btn').attr('disabled','true');
        
        $.post("../includes/save_expens.php",{item:item,unit_price:unit_price,quantity:quantity,date:date,action:'',disc:disc,bal:blc,debt:debt},
              function(data){
            console.log(data);
             $('#save_btn').html('<i class="fa fa-save"></i> Save');
        $('#save_btn').removeAttr('disabled','false');
                  if(data == 'success'){
                      
                      //call ajax
                          swal('Done','','success');
                                      $('.swal2-container').css('z-index',8000);

                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured when posting. please make sure you are connected to the internet.',
                      'error'
                    )
                                  $('.swal2-container').css('z-index',8000);

                  }
              })
       }
        
    }else{
        
        console.log('nothin')
        swal('Fail','Some fields are left blank','error');
                    $('.swal2-container').css('z-index',8000);

    }

    
}

function save_expens(){
    swal({
      title: 'Are you sure?',
      text: "You are about to save the record(s)",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, save it!',
      showLoaderOnConfirm:true,
    showCloseButton:true,
    preConfirm:function(){
    return new Promise(function(resolve){
        $.post("../includes/save_expens.php",{item:'',unit_price:'',quantity:'',date:'',disc:'',bal:'',debt:'',action:'save'},
              function(data){
            console.log(data);
            if(data ==='success'){
                swal({
                              title: '',
                              text: "Done",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('expenses.php?','_self');
                              }
                            })
            }else{
                swal('Fail','An error Occured','error');
            }
        })
    })
    }
    })
}

function delete_expens(New,from,to){
    var value = $('#result_box').html();
    
     if(value.length==188 || value.length == 187){
         swal(
              'Ooops..',
              'No records found.',
              'error'
            )
     }else{
         
          var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                }
            }
         if(ids == ""){
            swal('Fail','No record selected','error');      
         }else{
         swal({
      title: 'Are you sure?',
      text: "You are about to save the record(s)",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Continue!',
      showLoaderOnConfirm:true,
    showCloseButton:true,
    preConfirm:function(){
    return new Promise(function(resolve){
       
        
        $.post("../includes/delete_expens.php",{ids:ids},
              function(data){
            console.log(data);
            if(data ==='success'){
                swal({
                              title: '',
                              text: "Done",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('expenses.php?new='+New+'&from='+from+'&to='+to,'_self');
                              }
                            })
            }else{
                swal('Fail','An error Occured','error');
            }
        })
    })
    }
    })}
     }
}

function edit_expense_action(New,from,to){
var item = $('#edit_item_name').val();
    var unit_price = $('#edit_unit_price').val();
    var date = $('#edit_date').val();
    var quantity = $('#edit_qty').val();
    var insert = true;
    var id = $('#expens_id').val();
    var disc = $('#edit_disc').val();
    var blc = $('#edit_blc').val();
    var debt = $('#edit_debt').val();
    if(isNaN(quantity)){
        $('#edit_qty').val("");
        $('#edit_qty').css('border','thin solid red');
        $('#edit_qty').attr('placeholder','Quantity should be in fiqures');
        insert = false;
    }
    
    if(isNaN(unit_price)){
        $('#edit_unit_price').val("");
        $('#edit_unit_price').css('border','thin solid red');
        $('#edit_unit_price').attr('placeholder','Amount should be in fiqures');
        insert = false;
    }
    
    if( item != "" && unit_price !="" && date != "" && quantity !=""){
       if(insert == true){
            $('#editsave_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
        $('#editsave_btn').attr('disabled','true');
        
        $.post("../includes/edit_expense.php",{item:item,unit_price:unit_price,quantity:quantity,date:date,id:id,disc:disc,bal:blc,debt:debt},
              function(data){
            console.log(data);
             $('#editsave_btn').html('<i class="fa fa-save"></i> Save');
        $('#editsave_btn').removeAttr('disabled','false');
                  if(data == 'success'){
                      swal({
                              title: '',
                              text: "Done",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('expenses.php?new='+New+'&from='+from+'&to='+to,'_self');
                              }
                            })
                           $('.swal2-container').css('z-index',8000);

                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured when posting. please make sure you are connected to the internet.',
                      'error'
                    )
                                  $('.swal2-container').css('z-index',8000);

                  }
              })
       }
        
    }else{
        
        console.log('nothin')
        swal('Fail','Some fields are left blank','error');
                    $('.swal2-container').css('z-index',8000);

    }

    
}

function edit_expense(id){
    $.post("../includes/fetch_expense.php",{id:id},
              function(data){
                  var fields = [];
                    fields = JSON.parse(data);
                    var unit_price = $('#edit_item_name').val(fields[0]);
                    var unit_price = $('#edit_unit_price').val(fields[1]);
                    var date = $('#edit_date').val(fields[3]);
                    var quantity = $('#edit_qty').val(fields[2]);
                    $('#expens_id').val(fields[4]);
                    $('#edit_disc').val(fields[5]);
                    $('#edit_blc').val(fields[6]);
                    $('#edit_debt').val(fields[7]);
              })
}

function bill_item(Class){
    var value = $('#result_box').html();
    
     if(value.length==188 || value.length == 187){
         swal(
              'Ooops..',
              'No records found.',
              'error'
            )
        $('.swal2-container').css('z-index',8000);
     }else {
         
        
          var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                }
            }
         if(ids == ""){
            swal('Fail','No record selected','error');
            $('.swal2-container').css('z-index',8000);
         }else{
         var item = $('#item_name').val();
    var unit_price = $('#unit_price').val();
    
    var quantity = $('#qty').val();
    var insert = true;
    if(isNaN(quantity)){
        $('#qty').val("");
        $('#qty').css('border','thin solid red');
        $('#qty').attr('placeholder','Quantity should be in fiqures');
        insert = false;
    }
    
    if(isNaN(unit_price)){
        $('#unit_price').val("");
        $('#unit_price').css('border','thin solid red');
        $('#unit_price').attr('placeholder','Amount should be in fiqures');
        insert = false;
    }
    
    if( item != "" && unit_price !=""  && quantity !=""){
       if(insert == true){
            $('#save_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
        $('#save_btn').attr('disabled','true');
        
        $.post("../includes/bill_item.php",{item:item,unit_price:unit_price,quantity:quantity,class:Class,ids:ids},
              function(data){
            console.log(data);
             $('#save_btn').html('<i class="fa fa-save"></i> Save');
        $('#save_btn').removeAttr('disabled','false');
                  if(data == 'success'){
                      console.log(data);
                      //call ajax
                          swal('Done','','success');
                                      $('.swal2-container').css('z-index',8000);

                  }else if(data == 'year'){
                      swal('fail','Academic year not set','error');
                  }else{
                       //call sweetalert
                    swal(
                      'Ooops..',
                      'An error occured. please make sure you are connected to the internet.',
                      'error'
                    )
                                  $('.swal2-container').css('z-index',8000);

                  }
              })
       }
        
    }else{
        
        console.log('nothin')
        swal('Fail','Some fields are left blank','error');
                    $('.swal2-container').css('z-index',8000);

    }
         }
     }
}


function delete_bill(Class,academic_year,term){
    
        var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                }
            }
         if(ids == ""){
            swal('Fail','No record selected','error');
            $('.swal2-container').css('z-index',8000);
         }else{
                   swal({
      title: 'Are you sure?',
      text: "",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showLoaderOnConfirm:true,
    showCloseButton:true,
    preConfirm:function(){
    return new Promise(function(resolve){
       
        
        $.post("../includes/delete_bill.php",{ids:ids},
              function(data){
            console.log(data);
            if(data ==='success'){
                swal({
                              title: '',
                              text: "Done",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('manage_bills.php?class='+Class+'&academic_year='+academic_year+'&term='+term,'_self');
                              }
                            })
            }else{
                swal('Fail','An error Occured','error');
            }
        })
    })
    }
    })}
         }
function upload_pdf(Class){
    console.log(Class);
                
                var fd = new FormData(document.getElementById("form")); 
                fd.append("Class",Class);
                if(fd !=""){
                    $('#btn_upload').attr('disabled','');
                    $('#btn_upload').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> uploading...');
                    
                    
                $.ajax({
                  url: "../cms/upload_time_table.php",
                  type: "POST",
                  data: fd,
                  processData: false,  // tell jQuery not to process the data
                  contentType: false   // tell jQuery not to set contentType
                }).done(function( data ) {
                   $('#btn_upload').removeAttr('disabled','false');
                $('#btn_upload').html('<i class="fa fa-upload"></i> upload');
                    console.log(data);
                    if(data == 'error'){
                        $('#student_image').html('');
                        swal(
                          'Ooops..',
                          'An error occured. please make sure you are connected to the internet... / Check if you have selected a file...',
                          'error'
                        )
                        
                    }else{
                        window.open('time_table.php?class='+Class,'_self');
                        
                    
                    }
                    
                });
                    
                }else{
                    swal('','Nothing selected','error');
                }
                return false;
}

function generate_reports(Class){
            var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                }
            }
         if(ids == ""){
            swal('Fail','No record selected','error');
            $('.swal2-container').css('z-index',8000);
         }else{
             var term_end = document.getElementById('end_date').value;
             var term_begin = document.getElementById('begin_date').value;
             var promotion = document.getElementById('promotion').checked;
            
             var insert = true;
             if(term_end == "" || end_date==""){
                 swal('','Dates needed','error');
             }else{
            swal({
      title: '',
      text: "This will take some few minutes",
      type: 'warning',
      backdrop: true,
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ok',
     
    allowEscapeKey: 'false',            
      showLoaderOnConfirm:true,
    preConfirm:function(){
    return new Promise(function(resolve){
        $('#generate_btn').attr('disabled','');
        $('#generate_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> generating...');
        
         $.post("../includes/generate_terminal_report.php",{ids:ids,term_end:term_end,term_begin:term_begin,promotion:promotion},
              function(data){
            $('#generate_btn').removeAttr('disabled','');
        $('#generate_btn').html('Generate Report');
        
             console.log(data);
            if(data ==='success'){
                window.open('add_report.php?class='+Class,'_self');
            }else{
                swal('Fail','An error Occured','error');
            }
        })
        
    })}})}
         }
}

function delete_result(id,Class,academic_year,term){
        swal({
      title: '',
      text: "Are you sure?",
      type: 'warning',
      backdrop: true,
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ok',
     
    allowEscapeKey: 'false',            
      showLoaderOnConfirm:true,
    preConfirm:function(){
    return new Promise(function(resolve){
        
        
         $.post("../includes/delete_result.php",{id:id,class:Class,academic_year:academic_year,term:term},
              function(data){
           
             console.log(data);
            if(data ==='success'){
                window.open('manage_report.php?class='+Class+'&academic_year='+academic_year+'&term='+term,'_self');
            }else{
                swal('Fail','An error Occured','error');
            }
        })
        
    })}})
}

function add_event(){
    var event_name = $('#event_name').val();
    var start_date = $('#start').val();
    var end_date = $('#ends').val();
    var event_color = $('#event_color').val();
    
    if(event_name == '' || start_date =='' || end_date == ''){
        swal('','Some Felds are left blank','warning');
    }else{
        $('#add_event_btn').attr('disabled','');
        $('#add_event_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Please wait...');
        
        $.post("../includes/add_event.php",{event_name:event_name,start_date:start_date,end_date:end_date,event_color:event_color},
              function(data){
           $('#add_event_btn').removeAttr('disabled','');
            $('#add_event_btn').html('Add Event');
             console.log(data);
            if(data ==='success'){
                swal('Done','Event Added successfully','success');
            }else{
                swal('Fail','An error Occured','error');
            }
        })
    }
}

function delete_event(){
       var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                }
            }
         if(ids == ""){
            swal('Fail','No record selected','error');
            $('.swal2-container').css('z-index',8000);
         }else{
              swal({
              title: '',
              text: "Are you sure?",
              type: 'warning',
              backdrop: true,
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ok',

            allowEscapeKey: 'false',            
              showLoaderOnConfirm:true,
            preConfirm:function(){
            return new Promise(function(resolve){


                 $.post("../includes/delete_event.php",{ids:ids},
                      function(data){

                     console.log(data);
                    if(data ==='success'){
                        window.open('academic_calendar.php','_self');
                    }else{
                        swal('Fail','An error Occured','error');
                    }
                })

            })}})
         }
}
function add_notice(action){
    var notice_box = $('#notice_box').val();
    if(notice_box==""){
        swal('','Nothing to post','warning');
    }else{
        $('#publish_btn').attr('disabled','');
        $('#publish_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> publishing...');
        
        $.post("../includes/publish_notice.php",{notice:notice_box},
                      function(data){
$('#publish_btn').removeAttr('disabled','');
        $('#publish_btn').html('Publish');
        
                     console.log(data);
                    if(data ==='success'){
                        swal('Done','Notice published','success');
                        if(action == "dashboard"){
                            window.open('admin_dashboard.php','_self');
                        }
                    }else{
                        swal('Fail','An error Occured','error');
                    }
                })
        
    }
}

function edit_notice(id){
    var notice_box = $('#notice_box').val();
    if(notice_box==""){
        swal('','Nothing to post','warning');
    }else{
        $('#publish_btn').attr('disabled','');
        $('#publish_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> publishing...');
        
        $.post("../includes/edit_notice.php",{notice:notice_box,id:id},
                      function(data){
$('#publish_btn').removeAttr('disabled','');
        $('#publish_btn').html('Publish');
        
                     console.log(data);
                    if(data ==='success'){
                        window.open('manage_notice.php','_self');
                    }else{
                        swal('Fail','An error Occured','error');
                    }
                })
        
    }
}
function delete_notice(){
      var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                }
            }
         if(ids == ""){
            swal('Fail','No record selected','error');
            $('.swal2-container').css('z-index',8000);
         }else{
              swal({
              title: '',
              text: "Are you sure?",
              type: 'warning',
              backdrop: true,
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ok',

            allowEscapeKey: 'false',            
              showLoaderOnConfirm:true,
            preConfirm:function(){
            return new Promise(function(resolve){


                 $.post("../includes/delete_notice.php",{ids:ids},
                      function(data){

                     console.log(data);
                    if(data ==='success'){
                        window.open('manage_notice.php','_self');
                    }else{
                        swal('Fail','An error Occured','error');
                    }
                })

            })}})
         }
}

//settings

function upload_edit_school_image_from_explorer() {
    $('#school_file').change(function () {
        $('#school_image').css('background-image', 'url()');
        $('#school_image').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> uploading...');
        var fd = new FormData(document.getElementById("form"));

        $.ajax({
            url: "../cms/upload_edit_school_image_from_explorer.php",
            type: "POST",
            data: fd,
            processData: false, // tell jQuery not to process the data
            contentType: false // tell jQuery not to set contentType
        }).done(function (data) {
            console.log(data);
            if (data == 'error') {
                $('#school_image').html('');
                swal(
                    'Ooops..',
                    'An error occured. please make sure you are connected to the internet.',
                    'error'
                )

            } else {
                window.open('settings.php','_self');
            }

        });
        return false;
    });
}

function update_school_info() {
    var sch_id = $("#sch_id").val();
    var school_code = $("#school_code").val();
    var school_name = $("#school_name").val();
    var school_number = $("#school_number").val();
    var sch_address = $("#sch_address").val();
    var principal_name = $("#principal_name").val();
    var sms_id = $("#sms_id").val();

    if (sch_id == "" || school_code == "" || school_name == "" || school_number == "" || sch_address == "" || principal_name == "" || sms_id == '') {
        swal(
            'Ooops..',
            'Some fields were left blank.',
            'error'
        )
    } else {
        $('#save_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Please wait...');
        $('#save_btn').attr('disabled', 'true');
        $('#select_pic').attr('disabled', 'true');

        $.post("../includes/edit_school.php", {
                sch_id: sch_id,
                school_name: school_name,
                school_number: school_number,
                sch_address: sch_address,
                principal_name: principal_name,
                sms_id: sms_id
            },
            function (data) {
                $('#save_btn').html('<i class="fa fa-plus"></i> Save');
                $('#save_btn').removeAttr('disabled', 'true');
                $('#select_pic').removeAttr('disabled', 'true');
                console.log(data);
                if (data == 'success') {
                    swal({
                        title: '',
                        text: "Success",
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok!'
                    }).then((result) => {
                        if (result.value) {
                            window.open('settings.php', '_self');
                        }
                    })

                } else {
                    swal(
                        'Ooops..',
                        'An error occured. Please try again later.',
                        'error'
                    )
                }
            })
    }


}

function update_admin_info() {

    var admin_id = $("#admin_id").val();
    var admin_name = $("#admin_name").val();
    var phone_number = $("#phone_number").val();
    var email = $("#email").val();

    if (admin_id == "" || admin_name == "" || phone_number == "" || email == "") {
        swal(
            'Ooops..',
            'Some fields were left blank.',
            'error'
        )
    } else {
        $('#update_admin_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Please wait...');
        $('#update_admin_btn').attr('disabled', 'true');

        $.post("../includes/update_admin.php", {
            admin_id: admin_id,
            admin_name: admin_name,
            phone_number: phone_number,
            email: email
        }, function (data) {
            $('#update_admin_btn').html('Save');
            $('#update_admin_btn').removeAttr('disabled', 'true');
            console.log(data);
            if (data == 'success') {
                swal({
                    title: '',
                    text: "Success",
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok!'
                }).then((result) => {
                    if (result.value) {
                        window.open('my_profile.php', '_self');
                    }
                })

            } else {
                swal(
                    'Ooops..',
                    'An error occured. Please try again later.',
                    'error'
                )
            }

        })

    }
}

function change_pwd() {

    var admin_pid = $("#admin_pid").val();
    var old_password = $("#old_password").val();
    var new_password = $("#new_password").val();
    var c_password = $("#c_password").val();

    if (admin_pid == "" || old_password == "" || new_password == "" || c_password == "") {
        swal(
            'Ooops..',
            'Some fields were left blank.',
            'error'
        )
    } else {
        $('#chng_pwd_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Please wait...');
        $('#chng_pwd_btn').attr('disabled', 'true');

        $.post("../includes/update_password.php", {
            admin_pid: admin_pid,
            old_password: old_password,
            new_password: new_password,
            c_password: c_password
        }, function (data) {
            $('#chng_pwd_btn').html('Change Password');
            $('#chng_pwd_btn').removeAttr('disabled', 'true');
            console.log(data);
            if (data == 'success') {
                swal({
                    title: '',
                    text: "Success",
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok!'
                }).then((result) => {
                    if (result.value) {
                        window.open('my_profile.php', '_self');
                    }
                })

            } else if (data == 'not') {

                swal(
                    'Ooops..',
                    'Passwords do not match.',
                    'error'
                )

            } else if (data == 'strong') {
                swal(
                    'Ooops..',
                    'Your password is not strong enough, it must include both small and capital letters and numbers. Also avoid using spaces in passwords.',
                    'warning'
                )
            } else if (data == 'six') {
                swal(
                    'Ooops..',
                    'Sorry password should be more than six characters.',
                    'warning'
                )

            } else if (data == 'incorrect') {
                swal(
                    'Ooops..',
                    'Sorry old password is incorrect.',
                    'error'
                )

            } else {
                swal(
                    'Ooops..',
                    'An error occured. Please try again later.',
                    'error'
                )
            }

        })

    }
}

function add_academic_year(school) {

    var academic = $('#academic').val();
    var term = $('#term').val();

    if (academic != "" && term != "") {

        $('#save_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
        $('#save_btn').attr('disabled', 'true');

        $.post("../includes/add_academic_year.php", {
                academic: academic,
                term: term,
                school: school
            },
            function (data) {
                console.log(data);
                $('#save_btn').html('<i class="fa fa-save"></i> Save');
                $('#save_btn').removeAttr('disabled', 'false');
                if (data == 'success') {
                    console.log(data);
                    //call ajax
                    swal('Done', '', 'success');
                    $('.swal2-container').css('z-index', 8000);

                } else if (data == 'year') {
                    swal('fail', 'Academic year not set', 'error');
                } else {
                    //call sweetalert
                    swal(
                        'Ooops..',
                        'An error occured. Please make sure the academic year does not exist',
                        'error'
                    )
                    $('.swal2-container').css('z-index', 8000);

                }
            })


    } else {

        console.log('nothin')
        swal('Fail', 'Some fields are left blank', 'error');
        $('.swal2-container').css('z-index', 8000);

    }
}

function delete_year(id, sch) {

    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!. This will clear all records for the academic year",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showCloseButton: true,
        showLoaderOnConfirm: true,

        preConfirm: function () {
            return new Promise(function (resolve) {
                $.post("../includes/delete_year.php", {
                        id: id,
                        sch: sch
                    },
                    function (data) {
                        console.log(data);
                        if (data == 'success') {
                            //call ajax
                            swal({
                                title: '',
                                text: "Successfully deleted",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok!'
                            }).then((result) => {
                                if (result.value) {
                                    window.open('manage_academic_year.php', '_self');
                                }
                            })

                        } else {
                            //call sweetalert
                            swal(
                                'Ooops..',
                                'An error occured when deleting. please make sure you are connected to the internet.',
                                'error'
                            )
                        }
                    })
            })
        }
    })
}

function activate_year(id) {


    $.post("../includes/activate_academic_year.php", {
            id: id
        },
        function (data) {
            console.log(data);
            $('#activate_btn').attr('disabled', 'true');
            if (data == 'success') {
                swal({
                    title: '',
                    text: "Successfully Activated",
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok!'
                }).then((result) => {
                    if (result.value) {
                        window.open('manage_academic_year.php', '_self');
                    }
                })
            } else {
                //call sweetalert
                swal(
                    'Ooops..',
                    'An error occured when posting. please make sure you are connected to the internet.',
                    'error'
                )
                $('.swal2-container').css('z-index', 8000);

            }
        })
}

function edit_year(id) {
    $.post("../includes/edit_academic_year.php", {
            id: id
        },
        function (data) {
            var fields = JSON.parse(data);

            $('#academic_year').val(fields[1]);
            $('#term_term').selectpicker('val',fields[2]);
            $('#status').val(fields[3]);
            $('#yr_id').val(fields[4]);

        })

}

function edit_academic_year() {

    var academic_year = $('#academic_year').val();
    var term_term = $('#term_term').val();
    var status = $('#status').val();
    var yr_id = $('#yr_id').val();
    
    $.post("../includes/edit_year.php",{academic_year:academic_year, term_term:term_term, status:status, yr_id:yr_id}, 
           function(data){
        console.log(data);
        if (data == 'success') {
                swal({
                    title: '',
                    text: "Successfully Updated",
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok!'
                }).then((result) => {
                    if (result.value) {
                        window.open('manage_academic_year.php', '_self');
                    }
                })
            $('.swal2-container').css('z-index', 8000);
            } else {
                //call sweetalert
                swal(
                    'Ooops..',
                    'An error occured when posting. please make sure you are connected to the internet.',
                    'error'
                )
                $('.swal2-container').css('z-index', 8000);

            }
    })
}

function delete_shelf(){
      var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                }
            }
         if(ids == ""){
            swal('Fail','No record selected','error');
            $('.swal2-container').css('z-index',8000);
         }else{
              swal({
              title: '',
              text: "Are you sure?",
              type: 'warning',
              backdrop: true,
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ok',

            allowEscapeKey: 'false',            
              showLoaderOnConfirm:true,
            preConfirm:function(){
            return new Promise(function(resolve){


                 $.post("../includes/delete_shelf.php",{ids:ids},
                      function(data){

                     console.log(data);
                    if(data ==='success'){
                        window.open('manage_shelf.php','_self');
                    }else{
                        swal('Fail','An error Occured','error');
                    }
                })

            })}})
         }
}

function add_shelf(){
    
    var categories = $('#categories').val();
    if(categories==""){
        swal('','Nothing to insert','warning');
         $('.swal2-container').css('z-index',8000);
    }else{
        $('#save_btn').attr('disabled','');
        $('#save_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> adding...');
        
        $.post("../includes/add_shelf.php",{categories:categories},
                      function(data){
$('#save_btn').removeAttr('disabled','');
        $('#save_btn').html('Add Shelf');
        
                     console.log(data);
                    if(data ==='success'){
                        swal('Done','Shelf Added','success');
         $('.swal2-container').css('z-index',8000);
                    }else{
                        swal('Fail','An error Occured','error');
         $('.swal2-container').css('z-index',8000);
                    }
                })
        
    }
}

function show_shelf_for_edit(id){
    var cat = $('#cat_'+id).html();
    $('#edit_categories').val(cat);
    edit_shelf(id);
}

function edit_shelf(id){
    $('#edit_btn').on('click',function(){
        var edit_categories = $('#edit_categories').val();
    if(edit_categories==""){
        swal('','Nothing to insert','warning');
                 $('.swal2-container').css('z-index',8000);

    }else{
        $('#edit_btn').attr('disabled','');
        $('#edit_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Saving...');
        
        $.post("../includes/edit_shelf.php",{categories:edit_categories,id:id},
                      function(data){
$('#edit_btn').removeAttr('disabled','');
        $('#edit_btn').html('Save');
        
                     console.log(data);
                    if(data ==='success'){
                        window.open('manage_shelf.php','_self');
                    }else{
                        swal('Fail','An error Occured','error');
                        $('.swal2-container').css('z-index',8000);

                    }
                })
        
    }
    })
    
}



function add_book(){
    var add_shelves = $('#add_shelves').val();
    var cats = $('#cats').val();
    var Publisher = $('#Publisher').val();
    var book_name = $('#book_name').val();
    var qty = $('#qty').val();
    
    var insert = true;
    if(isNaN(qty)){
        insert= false;
         swal('Done','Quantity must be in figures','error');
         $('.swal2-container').css('z-index',8000);
    }else if(parseInt(qty) < 1){
        insert= false;
         swal('Done','Quantity must be greater than 0','error');
         $('.swal2-container').css('z-index',8000);
    }
    if(book_name=="" || cats=="" || Publisher==""){
        swal('','Some fields are blank','warning');
         $('.swal2-container').css('z-index',8000);
    }else{
        if (insert == true){
            
        
        $('#save_btn').attr('disabled','');
        $('#save_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> adding...');
        
        $.post("../includes/add_book.php",{category:cats,book_name:book_name ,Publisher:Publisher,shelf:add_shelves,qty:qty},
                      function(data){
$('#save_btn').removeAttr('disabled','');
        $('#save_btn').html('Add Book');
        
                     console.log(data);
                    if(data ==='success'){
                        swal('Done','Book Added','success');
         $('.swal2-container').css('z-index',8000);
                    }else{
                        swal('Fail','An error Occured','error');
         $('.swal2-container').css('z-index',8000);
                    }
                })
        
    }}
}

function delete_book(shelf){
      var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        var shelfs = [];
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                    shelfs[x]=check_boxes[x].id;
                }
            }
         if(ids == ""){
            swal('Fail','No record selected','error');
            $('.swal2-container').css('z-index',8000);
         }else{
              swal({
              title: '',
              text: "Are you sure?",
              type: 'warning',
              backdrop: true,
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ok',

            allowEscapeKey: 'false',            
              showLoaderOnConfirm:true,
            preConfirm:function(){
            return new Promise(function(resolve){


                 $.post("../includes/delete_book.php",{ids:ids,shelfs:shelfs},
                      function(data){

                     console.log(data);
                    if(data ==='success'){
                        window.open('manage_books.php?shelves='+shelf,'_self');
                    }else{
                        swal('Fail','An error Occured','error');
                    }
                })

            })}})
         }
}

function edit_book_show(id){
    
    $('#edit_book_number').val($('#book_number'+id).html());
    $('#edit_book_name').val($('#cat_'+id).html());
    $('#edit_Publisher').val($('#book_publisher'+id).html());
    $('#edit_cats').selectpicker('val',$('#book_category'+id).html());
    edit_book($('#edit_book_number').val());
}

function edit_book(booknumber){
   
            $('#edit_btn').on('click',function(){
            var add_shelves = $('#edit_shelf').val();
            var cats = $('#edit_cats').val();
            var Publisher = $('#edit_Publisher').val();
            var book_name = $('#edit_book_name').val();

            if(book_name=="" || cats=="" || Publisher==""){
            swal('','Some fields are blank','warning');
             $('.swal2-container').css('z-index',8000);
        }else{
            $('#edit_btn').attr('disabled','');
            $('#edit_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> saving...');

            $.post("../includes/edit_book.php",{category:cats,book_name:book_name ,Publisher:Publisher,shelf:add_shelves,booknumber:booknumber},
                          function(data){
    $('#edit_btn').removeAttr('disabled','');
            $('#edit_btn').html('Save Changes');

                         console.log(data);
                        if(data ==='success'){
                            swal('Done','Changes Saved','success');
             $('.swal2-container').css('z-index',8000);
                        }else{
                            swal('Fail','An error Occured','error');
             $('.swal2-container').css('z-index',8000);
                        }
                    })

        }    
    })
    
}

function return_book(book_number,shelf_number){
     $('#return_btn'+book_number).attr('disabled','');
            $('#return_btn'+book_number).html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> returning...');
     $.post("../includes/return_book.php",{book_number:book_number,shelf_number:shelf_number},
                          function(data){
            $('#return_btn'+book_number).removeAttr('disabled','');
            $('#return_btn'+book_number).html('Action <span class="caret">');

                         console.log(data);
                        if(data ==='success'){
                           window.open('manage_books.php?shelves='+shelf_number,'_self');
                        }else{
                            swal('Fail','An error Occured','error');
             $('.swal2-container').css('z-index',8000);
                        }
                    })
}

//USERS

function add_user() {

    var user_name = $('#user_name').val();
    var gender = $('#gender').val();
    var contact = $('#contact').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var roles = $('#roles').val();

    var valid = true;
    if (isNaN(contact)) {
        $('#contact').css('border', 'thin solid red');
        $('#contact').val("");
        $('#contact').attr('placeholder', 'contact must be in fiqures');
        valid = false;
    }

    if (user_name == "" || gender == "" || contact == "" || email == "" || address == "" || roles == "") {
        swal(
            'Ooops..',
            'All Fields name required.',
            'error'
        )
        valid = false;
    } else {
        console.log(valid);
        if (valid == true) {
            $('#add_user_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
            $('#add_user_btn').attr('disabled', 'true');

            $.post("../includes/add_user.php", {
                    user_name: user_name,
                    gender: gender,
                    contact: contact,
                    email: email,
                    address: address,
                    roles: roles
                },
                function (data) {
                    console.log(data);
                    $('#add_user_btn').html('Add User');
                    $('#add_user_btn').removeAttr('disabled', 'false');

                    if (data == 'success') {
                        swal(
                            'Success',
                            'User added successfully.',
                            'success'
                        )

                    } else if (data == 'found') {
                        swal(
                            'Sorry..',
                            'User email already exist.',
                            'error'
                        )
                    } else {
                        swal(
                            'Ooops..',
                            'An error occured when adding. please make sure you are connected to the internet.' + data,
                            'error'
                        )
                    }

                })
        }
    }

}

function delete_all_users() {
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete all!',
        showLoaderOnConfirm: true,
        showCloseButton: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.post("../includes/delete_users.php", {
                        all: "all"
                    },
                    function (data) {
                    console.log(data);
                        if (data == 'success') {
                            
                            //call ajax
                            swal({
                                title: '',
                                text: "Users successfully deleted",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok!'
                            }).then((result) => {
                                if (result.value) {
                                    window.open('manage_users.php', '_self');
                                }
                            })

                        }else {
                            //call sweetalert
                            swal(
                                'Ooops..',
                                'An error occured when deleting. please make sure you are connected to the internet.',
                                'error'
                            )
                        }
                    })
            })
        }
    })

}

function delete_user(id) {
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        showCloseButton: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.post("../includes/delete_users.php", {
                        id: id
                    },
                    function (data) {
                    console.log(data);
                        if (data == 'success') {
                            //call ajax
                            swal({
                                title: '',
                                text: "User successfully deleted",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok!'
                            }).then((result) => {
                                if (result.value) {
                                    window.open('manage_users.php', '_self');
                                }
                            })

                        } else if(data=='admin'){
                            swal('Fail','Main admin cannot be deleted','error');
                        } else {
                            //call sweetalert
                            swal(
                                'Ooops..',
                                'An error occured when deleting. please make sure you are connected to the internet.',
                                'error'
                            )
                        }
                    })
            })

        }
    })
}

function edit_user(id) {

    
    $.post("../includes/edit_users.php", {
        id: id,
        show: 'show'
    }, function (data) {
        console.log(data);
        if(data=="no"){
            swal('Sorry','Can\'t edit main administrator details','error');
        }else{
             var fields = JSON.parse(data);

            var user_name = $('#e_user_name').val(fields[0]);
            var gender = $('#e_gender').selectpicker('val',fields[1]);
            var contact = $('#e_contact').val(fields[2]);
            var email = $('#e_email').val(fields[3]);
            var address = $('#e_address').val(fields[4]);
            var e_user_id = $('#e_user_id').val(fields[6]);
            var roles = $('#e_roles').selectpicker('val',fields[5]);
            if(fields[5]=="headmistress" || fields[5]=="headmaster"){
            var roles = $('#e_roles').selectpicker('val',"headmaster/headmistress");
            }
        }
       

    })
}

function edit_user_action() {

    var e_user_name = $('#e_user_name').val();
    var e_gender = $("#e_gender").val();
    var e_contact = $('#e_contact').val();
    var e_email = $('#e_email').val();
    var e_address = $('#e_address').val();
    var edit_role = $('#e_roles').val();
    var e_id = $('#e_user_id').val();

    
    var valid = true;
    if (isNaN(e_contact)) {
        $('#e_contact').css('border', 'thin solid red');
        $('#e_contact').val("");
        $('#e_contact').attr('placeholder', 'contact must be in fiqures');
        valid = false;
    }

    if (e_user_name == "" || e_gender == "" || e_contact == "" || e_email == "" || e_address == "" || edit_role == "" || e_id == "") {
        swal(
            'Ooops..',
            'All fields are required.',
            'error'
        )
        valid = false;
    } else {
        $('#e_user_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
        $('#e_user_btn').attr('disabled', 'true');

        $.post("../includes/edit_users.php", {
                e_user_name: e_user_name,
                e_gender: e_gender,
                e_contact: e_contact,
                e_email: e_email,
                e_address: e_address,
                edit_role: edit_role,
                e_id: e_id
            },
            function (data) {
                console.log(data);
                $('#e_user_btn').removeAttr('disabled', 'false');
                $('#e_user_btn').html('Edit User');
                if (data == 'success') {
                    window.open('manage_users.php', '_self');
                    $('#e_user_btn').html('Done');
                    $('#e_user_btn').css('background-color', 'green');
                } else if (data == 'found') {
                    swal(
                        'Sorry..',
                        'User already exist.' + data,
                        'error'
                    )
                } else {
                    swal(
                        'Ooops..',
                        'An error occured when adding. please make sure you are connected to the internet.' + data,
                        'error'
                    )
                }

            })
    }
}

function recover_pwd(id) {

    $.post("../includes/rec_pwd.php", {id:id}, function (data) {
        console.log(data);
        if (data == 'success') {
                            //call ajax
                            swal({
                                title: '',
                                text: "Password Recovered successfully",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok!'
                            }).then((result) => {
                                if (result.value) {
                                    window.open('recover_password.php', '_self');
                                }
                            })

                        } else {
                            //call sweetalert
                            swal(
                                'Ooops..',
                                'An error occured when posting. please make sure you are connected to the internet.',
                                'error'
                            )
                        }
    })
}

function delete_rec_pwd(id){
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        showCloseButton: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.post("../includes/delete_rec_pwd.php", {
                        id: id
                    },
                    function (data) {
                        if (data == 'success') {
                            //call ajax
                            swal({
                                title: '',
                                text: "successfully",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok!'
                            }).then((result) => {
                                if (result.value) {
                                    window.open('recover_password.php', '_self');
                                }
                            })

                        } else {
                            //call sweetalert
                            swal(
                                'Ooops..',
                                'An error occured when posting. please make sure you are connected to the internet.',
                                'error'
                            )
                        }
                    })
            })

        }
    })
    
}

function send_sms(){
    var message = $('#message').val();
    var numbers = [];
    
    var check_boxes = document.getElementsByClassName('checkboxes');
   
    for(var x=0; x < check_boxes.length; x++){
            if(check_boxes[x].checked){
                
                numbers[x]=$('#guardian_num'+check_boxes[x].name).html();
            }
        }
    
  
    check_boxes = document.getElementsByClassName('checkboxes1');
   
    for(var x=0; x < check_boxes.length; x++){
            if(check_boxes[x].checked){
                
                numbers.push($('#teacher_num'+check_boxes[x].name).html());
            }
        }
    
    check_boxes = document.getElementsByClassName('checkboxes2');
   
    for(var x=0; x < check_boxes.length; x++){
            if(check_boxes[x].checked){
                
                numbers.push($('#user_num'+check_boxes[x].name).html());
            }
        }
    
    console.log(numbers);
    var send = true;
    if(message==""){
        swal('Fail','Nothing to send','error');
        send = false;
    }else{
        if(numbers==""){
            swal('Fail','Numbers needed','error');
            send = false;
        }

        if(send == true){
            $('#send_sms_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> sending...');
            $('#send_sms_btn').attr('disabled', 'true');
            $.post("../includes/send_sms.php", {message: message,numbers:numbers},
                    function (data) {
                        $('#send_sms_btn').html('Send');
                        $('#send_sms_btn').removeAttr('disabled', 'true');
                        console.log(data);
                        if(data=='success'){
                            swal('Done','Message Sent','success');
                        }else{
                            
                        }
                    })
        }
    }
    
}

function reset_system(){
    
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this! All records will be cleard from our database.",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        showCloseButton: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $('#reset_btn').html('<i class="fa fa-spin fa-3x fa-gear" style="font-size:18px;"></i> resetting...');
                 $('#reset_btn').attr('disabled', 'true');
                $.post("../includes/reset_system.php", {},
                    function (data) {
                    console.log(data);
                             $('#reset_btn').html('<i class="fa fa-refresh"></i> Reset System');
                            $('#reset_btn').removeAttr('disabled', 'true');
                    
                        if (data == 'success') {
                            
                            //call ajax
                            swal({
                                title: '',
                                text: "Done",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok!'
                            }).then((result) => {
                                if (result.value) {
                                    window.open('settings.php', '_self');
                                }
                            })

                        } else {
                            //call sweetalert
                            swal(
                                'Ooops..',
                                'An error occured when posting. please make sure you are connected to the internet.',
                                'error'
                            )
                        }
                    })
            })

        }
    })
    
    
}

function delete_history(){
       var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                }
            }
         if(ids == ""){
            swal('Fail','No record selected','error');
            $('.swal2-container').css('z-index',8000);
         }else{
                   swal({
      title: 'Are you sure?',
      text: "",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showLoaderOnConfirm:true,
    showCloseButton:true,
    preConfirm:function(){
    return new Promise(function(resolve){
       
        
        $.post("../includes/delete_history.php",{ids:ids},
              function(data){
            console.log(data);
            if(data ==='success'){
                swal({
                              title: '',
                              text: "Done",
                              type: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Ok!'
                            }).then((result) => {
                              if (result.value) {
                                    window.open('histories.php','_self');
                              }
                            })
            }else{
                swal('Fail','An error Occured','error');
            }
        })
    })
    }
    })}
}

function show_result_box(id){
    $('#vcode_btn').on('click',function (){
        var vcode = $('#vcode').val();
        if(vcode == ""){
            swal('Fail','Voucher Code Needed','error');
            $('.swal2-container').css('z-index',8000);
        }else{
            $('#vcode_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> checking...');
            $('#vcode_btn').attr('disabled', 'true');
            
            $.post("../includes/check_result_voucher.php",{voucher_code:vcode,id:id},
              function(data){
                console.log(data);
                 $('#vcode_btn').html('Continue');
                 $('#vcode_btn').removeAttr('disabled', 'true');
                
                 if(data=="success"){
                     window.open('print_terminal_report.php?id='+id,'_blank');
                 }else if(data=="used"){
                     swal('Fail','Voucher Code Used','error');
                     $('.swal2-container').css('z-index',8000);
                 }else if(data=="notfound"){
                     swal('Fail','Voucher Code Not Found.Please note: Either voucher code has been used or not in our database','error');
                     $('.swal2-container').css('z-index',8000);
                 }else{
                     swal('Fail','An Error Occured','error');
                        $('.swal2-container').css('z-index',8000);
                 }
                 console.log(data); 
              })
        }
    })
}

function submit_invoice(operation,invoice_number,id,user){
    var mobile_money_number = $('#mobile_number').val();
    console.log(invoice_number);
    if(mobile_money_number == ""){
        swal('','Mobile money number needed','warning');
    }else{
        if(isNaN(mobile_money_number) || mobile_money_number.length < 10){
            swal('','Mobile number needed','warning');
        }else{
            $('#invoice_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> submitting...');
            $('#invoice_btn').attr('disabled','true');
            console.log('hello');
             $.post("../includes/submit_invoice.php",{number:mobile_money_number,operation:operation,invoice_number:invoice_number},
              function(data){
                 console.log(data);
                 $('#invoice_btn').html('<i class="fa fa-visacard"></i> Submit Invoice');
                $('#invoice_btn').removeAttr('disabled','true');
                 
                 if(data=="success"){
                     swal('','Invoice sumbitted succesfully','success');
                     window.open('sms_payment_invoice.php?id='+id+'&user='+user,'_self');
                 }else{
                     swal('','Oops..An error occured','error');
                 }
             })
        }
    }
}

function delete_invoice(id,page){
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        showCloseButton: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.post("../includes/delete_invoice.php", {
                        id: id
                    },
                    function (data) {
                        if (data == 'success') {
                            //call ajax
                            swal({
                                title: '',
                                text: "successfully",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok!'
                            }).then((result) => {
                                if (result.value) {
                                    if(page =="unsubmitted"){
                                    window.open('unsubmitted_invoices.php', '_self');
                                    }else{
                                    window.open('submitted_invoices.php', '_self');
                                    }
                                }
                            })

                        } else {
                            //call sweetalert
                            swal(
                                'Ooops..',
                                'An error occured',
                                'error'
                            )
                        }
                    })
            })

        }
    })
    
}


//cpanel


function login() {

    var password = $('#password').val();
    var user = $('#user').val();
    //send ajax request
    $("#login_btn").html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>');

    $.post("includes/clogin.php", {
            password: password,
            user: user
        },
        function (data) {
            console.log(data);
            $('#login_btn').html('<i class="fa fa-arrow-right text-muted" style="font-size:18px;"></i>');
            if (data == "success") {
                $('#login_btn').html('<i class="fa fa-check" style="font-size:18px;"></i>');
                $('#login_btn').toggleClass('btn-success');
                window.open('cms/cDashboard.php', '_self');
            } else{
                //$("#login_btn").html('<i class="fa fa-times"></i>');
                swal('Fail','Password not correct','error');
                
            }
        }
    )
}

function activate_sms(id) {
    console.log(id);
    $("#activate_btn_" + id).html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>Activating...');

    $.post("../includes/activate_sms.php", {
            id: id,
            accept: 'accepted'
        },
        function (data) {
            console.log(data);

            if (data == 'success') {
                 $("#activate_btn_" + id).html('<i class="fa fa-check"></i>Activated');
                $("#activate_btn_" + id).css('background-color', 'green');
                swal({
                    title: '',
                    text: "successfully",
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok!'
                }).then((result) => {
                    if (result.value) {
                        window.open('sms_unaccepted.php', '_self');
                    }
                })

            } else {
                //call sweetalert
                swal(
                    'Ooops..',
                    'An error occured when posting. please make sure you are connected to the internet.',
                    'error'
                )
                $("#activate_btn_" + id).html('<i class="fa fa-edit"></i>Activate');
            }

        })
}



function activate_voucher(id) {
    $("#activate_btn_" + id).html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>Activating...');

    $.post("../includes/activate_voucher.php", {
        id: id,
        accept: 'accepted'
    }, function (data) {
        console.log(data);
        if (data == 'success') {
            $("#activate_btn_" + id).html('<i class="fa fa-check"></i>Activated');
            $("#activate_btn_" + id).css('background-color', 'green');
            swal({
                title: '',
                text: 'Successfull',
                type: 'success',
                
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok!'
            }).then((result) => {
                if (result.value) {
                    window.open('voucher_unaccepted.php', '_self');
                }
            })

        } else {
            swal(
                'Ooops...',
                'An error occured when posting. please make sure you are connected to the internet.',
                'error'
            )
            $("#activate_btn_" + id).html('<i class="fa fa-edit"></i>Activate');
        }

    })

}

function delete_voucher(id) {
   swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        showCloseButton: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.post("../includes/delete_voucher.php", {
                        id: id
                    },
                    function (data) {
                    console.log(data);
                        if (data == 'success') {
                            //call ajax
                            swal({
                                title: '',
                                text: "successfully",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok!'
                            }).then((result) => {
                                if (result.value) {
                                    window.open('voucher_accepted.php', '_self');
                                }
                            })
                        }else {
                            //call sweetalert
                            swal(
                                'Ooops..',
                                'An error occured when deleting. please make sure you are connected to the internet.',
                                'error'
                            )
                        }
                    })
            })

        }
    })

}

function return_blance(id,academic_year,term,Class,group){
    $('#proceed').on('click',function(){
        $("#proceed").html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i>Please wait...');
        $("#proceed").attr('disabled','true');
        var receipient = $('#receipient_name').val();
        if(receipient==""){
            swal('','receipient name needed','error');
        }else{
        return new Promise(function (resolve) {
                $.post("../includes/return_blance.php", {id:id,receipient:receipient},
                    function (data) {
                    $("#proceed").html('Proceed');
                    $("#proceed").removeAttr('disabled','true');
                    if(data=="success"){
                        swal('','Balance return','success');
                        $('.swal2-container').css('z-index','8000');
                        window.open('termly_fees_records.php?class='+Class+'&academic_year='+academic_year+'&term='+term+'&group='+group,'_self');
                    }else{
                        swal('','Sorry, an error occured','error');
                        $('.swal2-container').css('z-index','8000');
                    }
                })
        })
        }
    })
}

function delete_blanace(id,from,to) {
   swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        showCloseButton: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.post("../includes/delete_blance.php", {
                        id: id
                    },
                    function (data) {
                    console.log(data);
                        if (data == 'success') {
                            //call ajax
                            swal({
                                title: '',
                                text: "successfully",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok!'
                            }).then((result) => {
                                if (result.value) {
                                    window.open('return_balances.php?from_date='+from+'&to_date='+to, '_self');
                                }
                            })
                        }else {
                            //call sweetalert
                            swal(
                                'Ooops..',
                                'An error occured when deleing. please make sure you are connected to the internet.',
                                'error'
                            )
                        }
                    })
            })

        }
    })

}

function send_terminal_report_sms(Class){
    $('#sms_btn').attr('onclick','');
    $('#sms_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> sending...');
    
      $.post("../includes/send_terminal_report_sms.php", {class:Class},
        function (data) {
          $('#sms_btn').html('send');
            if(data > 0){
                 swal({
                      title: '',
                      text: data+" messages sent.",
                      type: 'success',
                      showCancelButton: false,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Ok!'
                    }).then((result) => {
                      if (result.value) {
                            window.open('add_report.php?class='+Class,'_self');
                      }
                    }) 
            }else{
                swal('Fail','No sms sent.<br/> 1. Please make sure guardian numbers are correct or.<br/>2. Please make sure you are connected to the internet or.<br/>3. Please make sure you have enough sms balance.','error');
                 $('#sms_btn').attr('onclick','send_terminal_report_sms(\''+Class+'\')');
                 $('#sms_btn').html('send');
            }
      })
}

function delete_school(id){
     swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        showCloseButton: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.post("../includes/delete_admin.php", {
                        id: id
                    },
                    function (data) {
                    console.log(data);
                        if (data == 'success') {
                            //call ajax
                            swal({
                                title: '',
                                text: "successfully",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok!'
                            }).then((result) => {
                                if (result.value) {
                                    window.open('main_admins.php', '_self');
                                }
                            })
                        }else {
                            //call sweetalert
                            swal(
                                'Ooops..',
                                'An error occured when deleing. please make sure you are connected to the internet.',
                                'error'
                            )
                        }
                    })
            })

        }
    })
}

function edit_arreas(id){
   
    var previous_arreas = parseFloat($('#fees'+id).html());
    var current_arreas = parseFloat($('#narreas'+id).html());
    var original_arreas = current_arreas - previous_arreas;
    var credit = parseFloat($('#ncredit'+id).html());
    var payment = parseFloat($('#npayment'+id).html());
     console.log(current_arreas);
    $('#fees').val(previous_arreas);
    $('#nterm').val(current_arreas);
    $('#cterm').val(current_arreas);
    $('#ctermp').val(payment);
    $('#ctermc').val(credit);
    
    $('#nterm').on('keyup',function(){
        var n = parseFloat($('#nterm').val());
        new_arreas = original_arreas+n;
        if(isNaN(n)){
            new_arreas = original_arreas;
        }
        $('#cterm').val(new_arreas);
    })
    
    edit_ar (id);
}

function edit_ar(id){
    $('#proceed').on('click',function(){
        var payment =  $('#ctermp').val();
        var arreas = $('#nterm').val();
        var credit = $('#ctermc').val();
        $('#proceed').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> updating...');
        $('#proceed').attr('disabled','true');
         $.post("../includes/edit_arreas.php", {
                id: id,payment:payment,arreas:arreas,credit:credit
            },function(data){
             $('#proceed').html('Proceed');
            $('#proceed').removeAttr('disabled','true');
             $('#msg_box').html(data);
             $ ('#parreas'+id).html(old_arreas)
             $('#narreas'+id).html(new_arreas)
         })
        setTimeout(clear_msg_box,3000);
    })
}

function clear_msg_box(){
    $('#msg_box').html("");
}

function send_sms_easyskul(){
        var numbers =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        var names = [];
        var message = $('#message').val();
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    numbers[x]=$('#contact'+check_boxes[x].name).html();
                    names[x]=$('#name'+check_boxes[x].name).html();
                }
            }
         if(names == ""){
            swal('Fail','No record selected','error');
            $('.swal2-container').css('z-index',8000);
         }else{
             if(message == ""){
                 swal('','Nothing to send','error')
             }else{
               
                $('#send_sms_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> sending...');
                 $('#send_sms_btn').attr('disabled','true'); 
                  $.post("../includes/send_sms_easyskul.php", {
                 numbers: numbers,names:names,message:message
                  },function(data){
                 $('#send_sms_btn').html('Send');
                 $('#send_sms_btn').removeAttr('disabled','true'); 
                    if(data == 'success'){
                        swal('Message(s) sent','','success');
                    }else{
                        swal('Message(s) not sent','','error');
                    }
                  })
         }
}
}

$(document).ready(function(){
  
    $('#example').DataTable({
        "paging": false,
        "ordering":false,
        "info": false
        
    });
    
    $('#example0').DataTable({
        "paging": false,
        "ordering":false,
        "info": false
        
    });
    
    $('#example3').DataTable({
        "paging": false,
        "ordering":false,
        "info": false
        
    });
    
     $('#example4').DataTable({
                "paging": true,
                "ordering":false,
                "info": false

            });
});

function upload_student_data(){
    var columns = [];
    var fields = document.getElementsByClassName('form-control');
    insert = true;
    for(i = 0; i<fields.length; i++){
       var field = fields[i].value;
       var Class = $('#class').val();
       var file = $('#file').val();
        console.log(field);
        if(file == ""){
            swal('','Please select a .csv file','error');
        }
        if(Class == ""){
           $('#class').attr('placeholder','Class column number needed');
           $('#class').css('outline','red thin solid');
           insert = false;
        }
       if((columns.indexOf(field)) < 0 || field==""){
           if(isNaN(field)){
               if(field !=""){
                   fields[i].style.outline="red thin solid";
                   fields[i].value="";
                   fields[i].placeholder="Number needed";
                   insert = false;
               }
               
           }else{
               columns.push(field);
           }
       }else{
           if(field !=""){
               fields[i].style.outline="red thin solid";
               fields[i].value="";
               fields[i].placeholder="Duplicate Column ("+field+")";
               insert = false;
           }
       }
    }
    
    if(columns[1]==""){
        columns[1]=columns[0];
        columns[0]="";
    }
    
    if(insert == true){
        //call ajax
        
        swal({
            title: 'Are you sure?',
            text: "",
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            showLoaderOnConfirm: true,
            showCloseButton: true,
        }).then((result) => {
            if (result.value) {
               
                $('#add_student').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> uploading...');
                $('#add_student').attr('disabled','false');
                var fd = new FormData(document.getElementById("form")); 
                fd.append("columns",columns);
                $.ajax({
                  url: "../cms/upload_student_data.php",
                  type: "POST",
                  data: fd,
                  processData: false,  // tell jQuery not to process the data
                  contentType: false   // tell jQuery not to set contentType
                }).done(function( data ) {
                    $('#add_student').html('<i class="fa fa-upload"></i> upload');
                    $('#add_student').removeAttr('disabled','false');
                   console.log(data);
                   swal(data);
                });
                return false;
            }
        })
    }
}

function send_student_id(){
     $('#sms_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> sending...');
     $('#sms_btn').attr('disabled','false');
     $.post("../includes/send_student_id.php", {
         
     },function(data){
         console.log(data);
         $('#sms_btn').html('send');
         $('#sms_btn').removeAttr('disable','true');
         if(data=="success"){
             swal('','Messages sent','success');
             $('#hint_box').css('display','none');
         }else{
             swal('','Oops an error occured','error');
         }
     })
    
}

function delect_all_students(Class){
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete all!',
        showLoaderOnConfirm: true,
        showCloseButton: true,
        preConfirm: function () {
             $('#delete_all_students').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> deleting...');
            $('#delete_all_students').attr('disabled','false');
            return new Promise(function (resolve) {
                $.post("../includes/delete_all_studets.php", {
                        Class: Class
                    },
                    function (data) {
                    console.log(data);
                          $('#delete_all_students').html('<i class="fa fa-trash"></i> Delete All');
            $('#delete_all_students').removeAttr('disable','false');
              if(data=="success"){
                window.open('manage_student.php?class='+Class,'_self');
              }
                
                })})}})
}

function add_busses(){
    var bus_number = $('#bus_number').val();
    var bus_driver = $('#bus_driver').val();
    var driver_number = $('#driver_number').val();
    var locations = $('#locations').val();
    var status = $('#status').val();
    var last_bus_id = parseInt($('#last_bus_id').val());
    insert = true;
    
    if(isNaN(driver_number)){
        $('#driver_number').val("");
        $('#driver_number').css("outline","thin solid red");
        $('#driver_number').attr("placeholder","Driver number should be in figures");
        insert = false;
    }
    
    if(bus_number=="" || bus_driver=="" || driver_number=="" || locations == ""){
        swal('','Some fields were left blank','warning');
        insert = false;
    }
    
    if(insert == true){
        var locs = '';
        var locs_array = locations.split(',');
        var colors = ["label-primary","label-danger","label-warning","label-info","label-default","label-success"];
        for(var i=0; i<locs_array.length; i++){
            color = colors[Math.floor(Math.random()*colors.length)];
            locs = locs + '<span class="label '+color+'" onclick="find_map(\''+locs_array[i].replace('"','')+'\')" style="cursor:pointer">'+locs_array[i].replace('"','')+'</span> ';
        }
        
        console.log(locs);
         $('#add_bus_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> saving...');
         $('#add_bus_btn').attr('disabled','false');
        
         $.post("../includes/add_bus.php", {
                        bus_number:bus_number,bus_driver:bus_driver,driver_number:driver_number,locations:locations,status:status
                    },
                    function (data) {
             $('#add_bus_btn').html('<i class="fa fa-save"></i> Save');
         $('#add_bus_btn').removeAttr('disabled','false');
             console.log(data);
             if(data == "success"){
                 var header = "success";
                 $('#all_busses').html(parseInt($('#all_busses').html())+1);
                 
                if(status == "ACTIVE"){
                    $('#active_busses').html(parseInt($('#active_busses').html())+1);
                }else{
                    $('#faulty_busses').html(parseInt($('#faulty_busses').html())+1);
                    var header = "warning";
                }
                  id = last_bus_id +1;
                 $('#bus_box').html('<div class="alert alert-success alert-dismissable"> <button type="button"class="close"data-dismiss="alert"aria-hidden="true">&times;</button>Bus Added</div>');
             var bus = '<div class="col-xs-12 col-sm-6 col-md-4"><div class="box box-widget widget-user-2 box-'+header+'" style="box-shadow:0px 0px 4px 1px #ccc;"><div class="header" style="padding:10px;"><img src="../web_images/school_bus.png" class="img img-responsive"/></div><div class="box-footer no-padding"><ul class="nav nav-stacked"><li><a><label>Bus Number</label> <small id="bus_number'+id+'">'+bus_number+'</small></a></li><li><a><label>Driver</label> <small id="bus_driver'+id+'">'+bus_driver+'</small></a></li><li><a><label>Driver Tel</label> <small id="driver_tel'+id+'">'+driver_number+'</small></a></li><li><a><label>Status</label> <small><span class="label label-'+header+'" id="bus_status'+id+'">'+status+'</span></small></a></li><li><a class="loca_btn" onclick="toggle_location_btn(\''+id+'\');" id="locs_btn'+id+'" style="cursor:pointer"><i class="fa fa-location-arrow"></i> Locations  <span style="display:none"  id="locs'+id+'">'+locs+'</span></a></li><li onclick="edit_show_bus(\''+id+'\');" data-toggle="modal" data-target="#edit_bus"><a><i class="fa fa-edit"></i> Edit</a></li><li><a style="background-color:#d9534f; color:white; cursor:pointer" onclick="delete_bus(\''+bus_number+'\')" id="d_bus1"><i class="fa fa-trash"></i> Delete</a></li></a></li></ul></div></div></div><input type="hidden" value="'+locations+'" id="bus_locations'+id+'"/>';
             $('#busses_box').append(bus);
             $('#alert').css('display','none');
            $('#bus_locations').val(locs)
            $('#last_bus_id'+id).val(locations);
             }else{
                 $('#bus_box').html(data);
             }
         })
    }
}
function delete_bus(bus_number){
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        showLoaderOnConfirm: true,
        showCloseButton: true,
        preConfirm: function () {
             
            $('#d_bus1').attr('disabled','false');
            $('#d_bus').attr('disabled','false');
            return new Promise(function (resolve) {
                $.post("../includes/delete_busses.php", {
                        bus_number: bus_number
                    },
                    function (data) {
                    console.log(data);
                          
              if(data=="success"){
                window.open('manage_buses','_self');
              }
                
                })})}})
}

function edit_show_bus(id){
  
    var bus_number = $('#bus_number_edit').val($('#bus_number'+id).html());
    var bus_driver = $('#bus_driver_edit').val($('#bus_driver'+id).html());
    var driver_number = $('#driver_number_edit').val($('#driver_tel'+id).html());
    var locations = $('#locations_edit').val($('#bus_locations'+id).val());
    var status = $('#status_edit').selectpicker('val',$('#bus_status'+id).html());
    eidt_busses(id);
}

function eidt_busses(id){
     $('#add_bus_edit_btn').on('click',function(){
    var bus_number = $('#bus_number_edit').val();
    var bus_driver = $('#bus_driver_edit').val();
    var driver_number = $('#driver_number_edit').val();
    var locations = $('#locations_edit').val();
    var status = $('#status_edit').val();
    
    insert = true;
    
    if(isNaN(driver_number)){
        $('#driver_number_edit').val("");
        $('#driver_number_edit').css("outline","thin solid red");
        $('#driver_number_edit').attr("placeholder","Driver number should be in figures");
        insert = false;
    }
    
    if(bus_number=="" || bus_driver=="" || driver_number=="" || locations == ""){
        swal('','Some fields were left blank','warning');
        insert = false;
    }
    
    if(insert == true){
        var locs = '';
        var locs_array = locations.split(',');
        var colors = ["label-primary","label-danger","label-warning","label-info","label-default","label-success"];
        for(var i=0; i<locs_array.length; i++){
            color = colors[Math.floor(Math.random()*colors.length)];
            locs = locs + '<span class="label '+color+'" onclick="find_map(\''+locs_array[i].replace('"','')+'\')" style="cursor:pointer">'+locs_array[i].replace('"','')+'</span> ';
        }
        
        console.log(locs);
         $('#add_bus_edit_btn').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> saving...');
         $('#add_bus_edit_btn').attr('disabled','false');
        
         $.post("../includes/edit_bus.php", {
                        bus_number:bus_number,bus_driver:bus_driver,driver_number:driver_number,locations:locations,status:status,id:id
                    },
                    function (data) {
             $('#add_bus_edit_btn').html('<i class="fa fa-save"></i> Save');
         $('#add_bus_edit_btn').removeAttr('disabled','false');
             console.log(data);
             if(data == "success"){
                 window.open('manage_buses.php','_self');
             }else{
                 $('#bus_box_edit').html(data);
             }
         })
    }
     })
}

function toggle_location_btn(id){
   
    $('.loca_btn').css('background-color','white').css('color','#1f1f1f');
    $('#locs_btn'+id).css('background-color','#286090').css('color','white');
    $('#bus_locations').html($('#locs'+id).html());
    $('#map_frame').html("");
}
function find_map(location){
    var html = ' <iframe id="map" src="https://maps.google.com/maps?q='+location+'&hl=en&z=14&amp;output=embed" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>';
    
    $('#map_frame').html(html);
}

function fetch_feeding_fee_records(student_id,row_id,from,to){
    $('#modal_results2').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> please wait...');
   
    $.post("../includes/fetch_student_feeding.php", {student_id:student_id,row_id:row_id,from:from,to:to
                    },
                    function (data) {
        $('#modal_results2').html(data);
    })
}

function fetch_bus_fee_records(student_id,row_id,from,to){
    $('#modal_results2').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> please wait...');
   
    $.post("../includes/fetch_student_bus_fee.php", {student_id:student_id,row_id:row_id,from:from,to:to
                    },
                    function (data) {
        $('#modal_results2').html(data);
    })
}

function take_feeding(action,Class){
    
    var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                }
            }
         if(ids == ""){
            swal('Fail','No record selected','error');
            $('.swal2-container').css('z-index',8000);
         }
    else{
        swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        showLoaderOnConfirm: true,
        showCloseButton: true,
        preConfirm: function () {
             
            $('#Continue').html('Please wait...');
            $('#Continue').attr('disabled','false');
            action2 ='';
            if(action == "debitors"){
                action2 = 'TAKE ARREAS';
            }else{
                action2 = 'RETURN BALANCE';
            }
            return new Promise(function (resolve) {
                $.post("../includes/return_take_feeding.php", {
                       ids:ids,action:action
                    },
                    function (data) {
                     $('#Continue').html(action2);
                     $('#Continue').removeAttr('disabled','false');
                    
                    console.log(data);
                          
              if(data=="success"){
                window.open('feeding_fee_debitors_creditors?feeding='+action+'&class='+Class,'_self');
              }
                
                })})}})
    }
     
}

function take_busfee(action,Class){
    
    var ids =[];
        var check_boxes = document.getElementsByClassName('checkboxes');
        for(var x=0; x < check_boxes.length; x++){
                if(check_boxes[x].checked){
                    ids[x]=check_boxes[x].name;
                }
            }
         if(ids == ""){
            swal('Fail','No record selected','error');
            $('.swal2-container').css('z-index',8000);
         }
    else{
        swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        showLoaderOnConfirm: true,
        showCloseButton: true,
        preConfirm: function () {
             
            $('#Continue').html('Please wait...');
            $('#Continue').attr('disabled','false');
            action2 ='';
            if(action == "debitors"){
                action2 = 'TAKE ARREAS';
            }else{
                action2 = 'RETURN BALANCE';
            }
            return new Promise(function (resolve) {
                $.post("../includes/return_take_bus_fee.php", {
                       ids:ids,action:action
                    },
                    function (data) {
                     $('#Continue').html(action2);
                     $('#Continue').removeAttr('disabled','false');
                    
                    console.log(data);
                          
              if(data=="success"){
                window.open('bus_debitors_creditors?feeding='+action+'&class='+Class,'_self');
              }
                
                })})}})
    }
     
}

function keep_bus_fee(){
    var student_ids = [];
    var amounts = document.getElementById('amount');
    var pdate = document.getElementById('days');
    var payment_date = document.getElementById('Payment_Date');
    var amount_per_day = document.getElementById('amount_per_day');
    var location = document.getElementById('location');
    var bus = document.getElementById('bus');
    var cat = document.getElementById('cat');
    
   
    var insert = true;
    var check_boxes = document.getElementsByClassName('checkboxes');
   
    for(var x=0; x < check_boxes.length; x++){
            if(check_boxes[x].checked){
                
                student_ids[x]=$('#student_id'+check_boxes[x].name).html();
            }
        }
    console.log(student_ids);
    insert = true;
    if(student_ids==""){
        swal('','no records selected','error');
        insert = false;
    }else{
        if(amounts.value==""){
            amounts.style.border="thin solid red";
            amounts.value="";
            amounts.placeholder="Amount needed";
            insert = false;
            
        }else{
            if(isNaN(amounts.value)){
                amounts.style.border="thin solid red";
                amounts.value="";
                amounts.placeholder="Amount must be in figures";
                insert = false;
            }
            
        }
        
        if(amount_per_day.value==""){
            amount_per_day.style.border="thin solid red";
            amount_per_day.value="";
            amount_per_day.placeholder="Amount per day needed";
            insert = false;
            
        }else{
            if(isNaN(amount_per_day.value)){
                amount_per_day.style.border="thin solid red";
                amount_per_day.value="";
                amount_per_day.placeholder="Amount must be in figures";
                insert = false;
            }
            
        }
        
        
         if(pdate.value==""){
            pdate.style.border="thin solid red";
            pdate.value="";
            pdate.placeholder="Days Needed";
            insert = false;
            
        }else{
            if(isNaN(pdate.value)){
                pdate.style.border="thin solid red";
                pdate.value="";
                pdate.placeholder="Days must be in figures";
                insert = false;
            }else if((pdate.value < 1)){
                pdate.style.border="thin solid red";
                pdate.value="";
                pdate.placeholder="Days must be greater than 0";
                insert = false;
            }
            
        }
    }
   
    if(payment_date.value==""){
        payment_date.style.border="thin solid red";
        payment_date.value="";
       payment_date.placeholder="Payment Date Needed";
        insert = false;
    }
    
     if(location.value==""){
        location.style.border="thin solid red";
        location.value="";
       location.placeholder="Location Needed";
        insert = false;
    }
    
    console.log(insert);
    if(insert == true){
        

          swal({
              title: '',
              text: 'You About to insert bus fee records',
              type: 'warning',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Procced'
            }).then((result) => {
              if (result.value) {
                        
        $('#Continue').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...');
        $('#Continue').attr('disabled','true');
         $.post("../includes/keep_bus_fee.php",{student_ids:student_ids,amounts:amounts.value,pday:pdate.value,date:payment_date.value,amount_per_day:amount_per_day.value,location:location.value,bus:bus.value,cat:cat.value},
              function(data){
                    $('#Continue').html('Continue');
                    $('#Continue').removeAttr('disabled','true');
                    var print = false;
                    var counter = 0;
             
                    console.log(data);
                   
                    if(data=="success"){
                           var print = true;
                            counter ++;
                            //swal('','done','success');
                        }else if(data=="year"){
                            swal('Fail','Academic Year Not set','error');
                        }else{
                            swal('','fail','error');    
                        }
                    if(print){
                        swal('Done',' Payment(s) made','success');
                        $('#print_btn').css('display','block');
                        
                    }
              })
              }
            })
    
    }
}

function copyToClipboard(element) {
 
  $("#copytext").val($(element).text()).select();
  document.execCommand("copy");
  
  $(".copied").text("Student ID copied").show().fadeOut(1200);
}

function toggle_position(){
    $('#check_btn').html('please wait...');
    $('#check_btn').attr('disabled','true');
    
    $.post("../includes/check_pos.php",{check:"true"},
       function(data){
         $('#check_btn').html(' <i class="fa fa-check"></i> Click to turn on');
         $('#check_btn').removeAttr('disabled','true');
         if(data ==  'success'){
             $('#check_btn').toggleClass(' btn-success');
             $('#check_btn').html(' <i class="fa fa-check"></i> Click to turn off');
         }else{
              $('#check_btn').toggleClass(' btn-default');
         }
    })
}



$('document').ready(function(){
   get_tip("teacher");
   $('.closebtn').on('click',function(){
       $('.hint-cover').remove();
   })
})




function get_tip(tip){
    var tip_lo = localStorage.getItem("tip");
    if(tip_lo!=tip){
        console.log("No hint found.");
        $('.hint-cover').css('display','block');
        $('.modal-box').toggleClass('animate');
        localStorage.setItem("tip",tip);
        
    }else{
        //localStorage.removeItem("tip")
        console.log(tip_lo);
    }
    
    
//    alertify.success('<a href="notifications" style="color:white"><i class="fa fa-bell"></i> You have 5 new notifications</a>');
//    
//    alertify.success('<a href="#" style="color:white"> You are runining out of sms, top up now.</a>');
//    
//    var win = new Audio('../web_images/oppo-message-tone-trickle-oppo-sms-tone_2928.mp3');
//    win.play();
    
}

