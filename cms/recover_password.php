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
            <?php include '../includes/cms_header.php'?>


            <div id="box">

                <div class="content" style="padding:20px; padding-top:0px;">
                    <div class="col-sm-12">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">CMS / Users /</span> <span style="color:#3c8dbc">Rocover Password</span>
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
                                                            <th>FORGOTTEN PASSWORD</th>
                                                            <th>USER ID</th>
                                                            <th>CONTACT</th>
                                                            <th>POSITION</th>
                                                            <th>OPERATION</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="result_box">
                                                        <?php $counter = 0;
    $query = mysqli_query($conn,"select * from `users` where `SCHOOL`='$initials' and `POSITION` !='' order by `NO` asc");
    
    if(mysqli_num_rows($query) == null){
        echo $initials;
        //echo 'No class found.';
    }
    while($fetch = mysqli_fetch_assoc($query)){       
        $name = htmlentities($fetch['USER NAME']);
        $rec_pwd = htmlentities($fetch['PASSWORD RECOVERY']);
        $u_Id = htmlentities($fetch['USER ID']);
        $contact = htmlentities($fetch['CONTACT']);
        $email = htmlentities($fetch['EMAIL']);
        $position = htmlentities($fetch['POSITION']);
        $counter ++;
        $id = $fetch['NO'];
        $btn = '';
        echo '<tr>
              <td>'.$counter.'</td>
              <td>'.$rec_pwd.'</td>
              <td>'.$u_Id.'</td>
              <td>'.$contact.'</td>
              <td>'.$position.'</td>';
        if($rec_pwd == 'YES'){
            $btn = '';
        }else{
            $btn = 'disabled';
        }
        
        echo '<td><button class=" btn btn-default" onclick="recover_pwd(\''.$id.'\');" '.$btn.'><i class="fa fa-edit"></i> Recover </button></td>
            </tr>';
    }?>
                                                    </tbody>
                                                    <tfoot>
                                                         <tr>
                                                            <th>#</th>
                                                            <th>FORGOTTEN PASSWORD</th>
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
                 $('.list-unstyled li:nth-child(20) ul li:nth-child(2)').toggleClass('active');
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
