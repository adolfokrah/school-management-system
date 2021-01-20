<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Easyskul - CMS::Uaccepted Vouchers</title>
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
</head>

<body>



    <div class="wrapper">
        <!-- Sidebar Holder -->
        <?php include '../includes/c_sidebar.php'?>

        <!-- Page Content Holder -->
        <div id="content">
            <?php include '../includes/c_header.php'?>


            <div id="box">

                <div class="content" style="padding:20px; padding-top:0px;">
                    <div class="col-sm-12">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <span style="color:#6b6b6b">Administrator CMS / Voucher /</span> <span style="color:#3c8dbc">Unaccepted</span>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="padding-bottom:20px;">
                            <div class="content">
                              
                            </div>

                        </div>
                        <div class="row">
                            <div class="content">
                                <div class="col-sm-12">
                                    <!-- /.box-header -->
                                    <div class="panel-group">
                                        <div class="panel panel-primary">

                                            <div class="panel-heading">
                                               VOUCHER
                                            </div>
                                            <div class="panel-body" style="overflow-x:scroll">
                                                <table id="example" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>SCHOOL</th>
                                                                    <th>USER ID</th>
                                                                    <th>INVOICE NUMBER</th>
                                                                    <th>MOBILE MONEY  NUMBER</th>
                                                                    <th>OPERATION</th>
                                                                    <th>UNIT PRICE</th>
                                                                    <th>DATE</th>
                                                                    <th>STATUS</th>
                                                                    <th>ACTION</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody id="result_box">
                                                                <?php $counter = 0;
        $operations = 'VOUCHER';
        $state = 'SUBMITTED';
    $query = mysqli_query($conn,"select * from `payment_invoices` where `OPERATION`='$operations' and `status`='$state' order by `ID` asc");
    
    if(mysqli_num_rows($query) == null){
        echo 'No results found.';
    }
    while($fetch = mysqli_fetch_assoc($query)){       
        $school = htmlentities($fetch['SCHOOL']);
        $user_id = htmlentities($fetch['USER ID']);
        $invoice_number = htmlentities($fetch['INVOICE NUMBER']);
        $operation = htmlentities($fetch['OPERATION']);
        $unit_price = htmlentities($fetch['UNIT PRICE']);
        $quantity = htmlentities($fetch['QUANTITY']);
        $status= htmlentities($fetch['STATUS']);
        $date = htmlentities($fetch['DATE']);
        $id = htmlentities($fetch['ID']);
        $number = htmlentities($fetch['MOBILE MONEY NUMBER']);
        $counter ++;
        echo '<tr>
              <td>'.$counter.'</td>
              <td>'.$school.'</td>
              <td>'.$user_id.'</td>
              <td>'.$invoice_number.'</td>
              <td>'.$number.'</td>
              <td>'.$operation.'</td>
              <td>'.$unit_price.'</td>
              <td>'.$date.'</td>
              <td>'.$status.'</td>';
            
        ?>
            <td style="width:30%;">
                <button class=" btn btn-primary" data-toggle="tooltip" data-placement="top" title="Click to accept" id="activate_btn_<?php echo $fetch['ID']; ?>" onclick="activate_voucher(<?php echo $fetch['ID']; ?>);"><i class="fa fa-edit"></i> Activate</button>
            </td>
            
            <?php
        echo '</tr>';
    }
                                               
?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>SCHOOL</th>
                                                                    <th>USER ID</th>
                                                                    <th>INVOICE NUMBER</th>
                                                                    <th>MOBILE MONEY  NUMBER</th>
                                                                    <th>OPERATION</th>
                                                                    <th>UNIT PRICE</th>
                                                                    <th>DATE</th>
                                                                    <th>STATUS</th>
                                                                    <th>ACTION</th>

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
