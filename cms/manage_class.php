<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Manage Classes</title>
        <link href="../web_images/logo2.png" rel="icon"/>
         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="../css/font-awesome.css">
         <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../css/sidebar.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="style.css">
        
        <!--add the tables css-->
        <link rel="stylesheet" type="text/css" href="datatables/dataTables.bootstrap.css"/>
        <script src="../js/jQuery-v2.1.3.js"></script>
        <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
        <script src="../js/cms.js"></script>
<script src="//code.tidio.co/4x7il8hkflx6xialwkq6m0d8xeaujgcw.js"></script>
    </head>
    <body>



        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php 
            $users = array("Administrator","Data Entry");
            include '../includes/cms_sidebar.php';
        ?>

            <!-- Page Content Holder -->
            <div id="content">
<?php include '../includes/cms_header.php';
                ?>                                       
                <div id="box">
                 
                    <div class="content" style="padding:20px; padding-top:0px;">
                        <div class="col-sm-12">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">Administrator CMS / Class /</span> <span style="color:#3c8dbc">Manage Class</span>
                                </div>
                            </div>
                        </div>
                            
                            <div class="row" style="padding-bottom:20px;">
                            <div class="content">
                                <div class="col-xs-12">
                                    <button class="btn btn-danger" type="button" onclick="delete_all_classes();"><i class="fa fa-trash"></i> Delete All</button>
                                   
                                        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_class" type="button"><i class="fa fa-plus"></i> Add Class</button>

                                </div>
                            </div>
                                
                        </div>
                        <div class="row">
                            <div class="content">
                                <div class="col-sm-12">
                                    
            
            <!-- /.box-header -->
             <div class="panel-group">
                <div class="panel panel-primary">
                                                 
                      <div class="panel-heading">
                          All Classes
                      </div>
                      <div class="panel-body" style="overflow-x:auto">
                          <table id="example" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Class Name</th>
                          <th>Operation</th>

                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                            <?php $counter = 0;
    $query = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials' order by `CLASS` asc");
    if(mysqli_num_rows($query) == null){
        echo 'No class found.';
    }
    while($fetch = mysqli_fetch_assoc($query)){
        $teachers = '';
        $class = htmlentities($fetch['CLASS']);
        //pick teachers in that classs
        $pick_teachers = mysqli_query($conn,"select * from admitted_students where `PRESENT CLASS`='$class' and `SCHOOL`='$initials'");
        
        $teachers .='Total students : '.mysqli_num_rows($pick_teachers).'';
        $counter ++;
        $id = $fetch['ID'];
        echo '<tr data-toggle="tooltip" data-placement="top" title="'.$teachers.'">
              <td>'.$counter.'</td>
              <td><a href="manage_student.php?class='.htmlentities($class).'">'.htmlentities($class).'</a>
              </td>
              <td style="width:30%;"><button class=" btn btn-danger" onclick=delete_class(\''.$id.'\'); ></i> Delete</button> <button class=" btn btn-default" onclick=edit_class(\''.$id.'\'); data-toggle="modal" data-target="#edit_class"><i class="fa fa-edit"></i> Edit</button>
              </td>

            </tr>';
    }?>
                        </tbody>
                        <tfoot>
                        <tr>
                           <th>#</th>
                          <th>Class Name</th>
                          <th>Operation</th>
                        </tr>
                        </tfoot>
                      </table>
                      </div>
                </div>
            </div>
               
            
           
                                </div>
                            </div>
                        </div>
                    </div>
                       
                </div>  
                     
                    </div>  
                
                
             
            </div>
        

        </div>

<?php 
        
        $query_check2 = mysqli_query($conn,"select * from classes where `SCHOOL`='$initials'");
        if(mysqli_num_rows($query_check2)==null){
            echo "<script>swal('','Please add Classes Before you can continue','warning');</script>";
        }
        ?>
<!--modl boxes-->
         <div class="modal fade" id="add_class">
             <div class="modal-dialog" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Add New Class</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form">
                             <div class="form-group">
                                 <label>Class Name</label>
                                 <input type="text" class="form-control" id="add_class_name"/>
                             </div>
                             <div class="form-group">
                                 
                                 <button class="btn btn-primary" type="button" onclick="add_class()" id="add_class_btn">Add Class</button>
                                 <button class="btn btn-danger" onclick="window.open('manage_class.php','_self');" data-toggle="tooltip" data-placement="top" title="Click here to see added classes after you have added your classes.">Done</button>
                             </div>
                         </form>
                     </div>
                       
                 </div>
             </div>
         </div>
        
        
        <div class="modal fade" id="edit_class">
             <div class="modal-dialog" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Edit Class</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form" id="edit_form">
                             <i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> Loading...
                         </form>
                     </div>
                       
                 </div>
             </div>
         </div>
        
        
        <!-- jQuery CDN -->
         
         <!-- Bootstrap Js CDN -->
         <script src="../js/boostrap.min.js"></script>
        
        <!--add the table js-->
        <script src="datatables/jquery.dataTables.min.js" id="script1"></script>
        <script src="datatables/dataTables.bootstrap.min.js" id="script2"></script>
        <script src="../js/table.js" id="script3"></script>
         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                     
                     
                     
                 });
                 
                 $('.list-unstyled li:nth-child(4) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(4) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(4) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(4) a').toggleClass('');
                 $('.list-unstyled li:nth-child(4) ul li:first-child').toggleClass('active');
             });
            
            $(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });

            $('document').ready(function(){
                $('#file').change(function() {
                        
                        $('#upload').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:18px;"></i> uploading...');
                        var fd = new FormData(document.getElementById("form")); 

                        $.ajax({
                          url: "upload_class_csv.php",
                          type: "POST",
                          data: fd,
                          processData: false,  // tell jQuery not to process the data
                          contentType: false   // tell jQuery not to set contentType
                        }).done(function( data ) {
                             window.open('manage_class.php','_self');
                        });
                        return false;
                    });
            })
         </script>
        
        
    </body>
</html>
