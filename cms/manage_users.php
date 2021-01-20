<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Easyskul - CMS::Manage Users</title>
    <link href="../web_images/logo2.png" rel="icon" />
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">

    <!--add the tables css-->
    <link rel="stylesheet" type="text/css" href="datatables/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../bootstrap-3.3.7-dist/css/boostrap-select.min.css" />
    <script src="../js/jQuery-v2.1.3.js"></script>
    <script src="../js/bootstrap-select.min.js"></script>
    <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
    <script src="../js/cms.js"></script>
    <script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>

</head>

<body>



    <div class="wrapper">
        <!-- Sidebar Holder -->
        <?php 
            $users = array("Administrator");
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
                                    <span style="color:#6b6b6b">CMS / Users /</span> <span style="color:#3c8dbc">Manage Users</span>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="padding-bottom:20px;">
                            <div class="content">
                                <div class="col-xs-12">
                                    <button class="btn btn-danger" type="button" onclick="delete_all_users();"><i class="fa fa-trash"></i> Delete All</button>
                                    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add New User</button>
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
                                                All Users
                                            </div>
                                            <div class="panel-body" style="overflow-x:scroll">
                                                <table id="example" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>USER NAME</th>
                                                            <th>GENDER</th>
                                                            <th>USER ID</th>
                                                            <th>CONTACT</th>
                                                            <th>POSITION</th>
                                                            <th>OPERATION</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="result_box">
                                                        <?php $counter = 0;
    $query = mysqli_query($conn,"select * from `users` where `SCHOOL`='$initials' and `POSITION` !=''  order by `NO` asc");
    
    if(mysqli_num_rows($query) == null){
        //echo $initials;
        //echo 'No class found.';
    }
    while($fetch = mysqli_fetch_assoc($query)){       
        $name = htmlentities($fetch['USER NAME']);
        $gender = htmlentities($fetch['GENDER']);
        $u_Id = htmlentities($fetch['USER ID']);
        
        $contact = htmlentities($fetch['CONTACT']);
        $position = htmlentities($fetch['POSITION']);
        
        $btn='';
        $id = $fetch['NO'];
        if(strpos($u_Id,'-TCH') || $position=="MAIN ADMIN"){
            $btn = 'disabled';
        }
        if(strpos($u_Id,'-STD')||strpos($u_Id,'-PT')){
          
        }else{
            $counter ++;
            echo '<tr>
              <td>'.$counter.'</td>
              <td>'.$name.'</td>
              <td>'.$gender.'</td>
              <td>'.$u_Id.'</td>
              <td>'.$contact.'</td>
              <td>'.$position.'</td>
              <td ><button class=" btn btn-danger" onclick=delete_user(\''.$id.'\'); '.$btn.'></i> Delete</button> <button class=" btn btn-default" onclick=edit_user(\''.$id.'\'); data-toggle="modal" data-target="#edit_user" '.$btn.'><i class="fa fa-edit" ></i> Edit</button></td>
            </tr>';
        }
        
    }?>
                                                    </tbody>
                                                    <tfoot>
                                                         <tr>
                                                            <th>#</th>
                                                            <th>USER NAME</th>
                                                            <th>GENDER</th>
                                                            <th>USER ID</th>
                                                            <th>CONTACT</th>
                                                            <th>POSITION</th>
                                                            <th>OPERATION</th>

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


    <!--modl boxes-->
    <div class="modal fade" id="add_user">
        <div class="modal-dialog modal-lg" style="z-index:5000;">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <h2 class="modal-title">Add New User</h2>
                </div>
                <div class="modal-body">


                    <form class="form" method="POST">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input type="text" class="form-control" placeholder="User Name" name="user_name" id="user_name" />
                                    </div><br>
                                    <div class="form-group" style="margin-top:-20px;">
                                        <label>Gender</label><br>
                                        <select class="selectpicker" data-show-subtext="true" data-live-search="false" style="width:100%;" id="gender">
                                    <option value="male"> Male </option>
                                    <option value="female"> Female </option>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Contact</label>
                                        <input type="text" placeholder="Contact" class="form-control" id="contact" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                     <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Email" id="email" />
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" placeholder="Address" id="address" />
                                    </div>
                                    <div class="form-group">
                                    <label>Roles</label><br>
                                    <select class="selectpicker" data-show-subtext="true" data-live-search="false" style="width:100%;" id="roles">
                                    <option value="accountant"> Accountant </option>
                                    <option value="data entry"> Data Entry </option>
                                    <option value="librarian"> Librarian </option>
                                    <option value="headmaster/headmistress"> Headmaster/Headmistress </option>
                                    <option value="administrator"> Administrator </option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="margin-left:30px">

                                <button class="btn btn-primary" type="button" onclick="add_user()" id="add_user_btn">Add User</button>
                                <button class="btn btn-danger" onclick="window.open('manage_users.php','_self');" data-toggle="tooltip" data-placement="top" title="Click here to see added Users after you have adding your Users.">Done</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="edit_user">
        <div class="modal-dialog modal-lg" style="z-index:5000;">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <h2 class="modal-title">Edit User</h2>
                </div>
                <div class="modal-body">
                    <form class="form" method="POST">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-xs-12 col-md-6">
                                    <input type="hidden" id="e_user_id">
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input type="text" class="form-control" placeholder="User Name" name="e_user_name" id="e_user_name" />
                                    </div><br>
                                    <div class="form-group" style="margin-top:-20px;">
                                        <label id="ed_gender">Gender</label><br>
                                        <select class="selectpicker" data-show-subtext="true" data-live-search="false" style="width:100%;" id="e_gender">
                                    <option value="male"> Male </option>
                                    <option value="female"> Female </option>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Contact</label>
                                        <input type="text" placeholder="Contact" class="form-control" id="e_contact" />
                                    </div>
                                   
                                </div>
                                <div class="col-xs-12 col-md-6">
                                     <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Email" id="e_email" />
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" placeholder="Address" id="e_address" />
                                    </div>
                                    <div class="form-group">
                                    <label id="edit_role">Roles</label><br>
                                    <select class="selectpicker" data-show-subtext="true" data-live-search="false" style="width:100%;" id="e_roles">
                                    <option value="accountant"> Accountant </option>
                                    <option value="data entry"> Data Entry </option>
                                    <option value="librarian"> Librarian </option>
                                    <option value="headmaster/headmistress"> Headmaster/Headmistress </option>
                                    <option value="administrator"> Administrator </option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="margin-left:30px">

                                <button class="btn btn-primary" type="button" onclick="edit_user_action()" id="e_user_btn">Update User</button>
                            </div>
                        </div>
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
    <script src="bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script src="bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            readProducts();
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
            
             $('.list-unstyled li:nth-child(20) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(20) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(20) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(20) a').toggleClass('');
                 $('.list-unstyled li:nth-child(20) ul li:nth-child(1)').toggleClass('active');
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });


        $('.form_date').datetimepicker({
            language: 'en',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });

        function readProducts() {
            $('#edit_form').load('magecon.php');
        }

    </script>
</body>
</html>
