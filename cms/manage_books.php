<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Easyskul - CMS::Manage Books</title>
        <link href="../web_images/logo2.png" rel="icon"/>
         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="../css/font-awesome.css">
        <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../css/sidebar.css">
        <link rel="stylesheet" href="../css/cms_style.css">
        
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="../css/cms_style.css">
        <link rel="stylesheet" href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/boostrap-select.min.css">
        <!--add the tables css-->
        <link rel="stylesheet" type="text/css" href="datatables/dataTables.bootstrap.css"/>
        <script src="../js/jQuery-v2.1.3.js"></script>
        <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
        <script src="../js/bootstrap-select.min.js"></script>
        <script src="../js/cms.js"></script>
        <script src="//code.tidio.co/oc6tcjthxgtesxrtpwutqwmcbl4txaih.js"></script>

    </head>
    
    
    <body>



        <div class="wrapper">
            <!-- Sidebar Holder -->
            <?php 
            $users = array("Administrator","Libarian","School Head");
            include '../includes/cms_sidebar.php';
        ?>

            <!-- Page Content Holder -->
            <div id="content">
<?php include '../includes/cms_header.php';
                    include '../includes/redirect_admin.php';
                
                      $query_check2 = mysqli_query($conn,"select * from shelves where `SCHOOL`='$initials' and `SHELF NUMBER`!=''");
        if(mysqli_num_rows($query_check2)==null){
            echo "<script>window.open('manage_shelf.php','_self');</script>";
            die();
        }
                ?>                                       
                <div id="box">
                 
                    <div class="content" style="padding:20px; padding-top:0px;">
                        <div class="content"><form class="form-inline" method="get" action="manage_books.php">
                     <label><small>Filter by shelf </small></label><br/>
                           <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="class" name="shelves">
                            <?php
                                   
                                    $qeuery_pick_classes = mysqli_query($conn,"select * from shelves where `SCHOOL`='$initials' and `SHELF NUMBER`!='' order by `SHELF NUMBER` asc");
                                    while($fetch = mysqli_fetch_assoc($qeuery_pick_classes)){
                                        echo '<option value="'.htmlentities($fetch['SHELF NUMBER']).'" >'.htmlentities($fetch['SHELF NUMBER']).'</option>';
                                    }
                                    
                                
                               ?>

                          </select>
                           <button type="submit" class="btn btn-default">Search</button>
                 </form></div><br/>
                        <div class="content">
                            <div class="col-sm-12">
                                <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="col-sm-12 col-md-6">
                                        <span style="color:#6b6b6b">CMS / Manage 
                                    Books</span> <br/>
                                    <?php 
                                    $shelf = '';        
                                    $qurey_pick_shelf='';
                                    $total_books =0;
                                    $total_books_given=0;
                                    $total_books_lef=0;
                                    if(isset($_GET['shelves']) && !empty($_GET['shelves'])){
                                        $shelf = $_GET['shelves'];
                                        $qurey_pick_shelf = mysqli_query($conn,"select * from shelves where `SCHOOL`='$initials' and `SHELF NUMBER`='$shelf' order by `SHELF NUMBER` asc");
                                        
                                    }else{
                                            $initial_class = '';
                                            $qurey_pick_shelf = mysqli_query($conn,"select * from shelves where `SCHOOL`='$initials' and `SHELF NUMBER` !='' order by `SHELF NUMBER` asc");
                                            
                                            }
                                    if($fetch = mysqli_fetch_assoc($qurey_pick_shelf)){
                                            $shelf = $fetch['SHELF NUMBER'];
                                            echo '<strong><h2>'.$fetch['SHELF NUMBER'].'</h2></strong><br/>';
                                            echo 'TOTAL BOOKS IN THIS SHELF: <strong>'.$total_books = number_format($fetch['TOTAL BOOKS']).'</strong><br/>';
                                            echo 'TOTAL BOOKS GIVEN OUT FORM THIS SHELF: <strong>'.$total_books_given = number_format($fetch['BOOKS GIVEN']).'</strong><br/>';
                                            echo 'TOTAL BOOKS LEFT IN THIS SHELF: <strong>'.$total_books_left = number_format($fetch['BOOKS LEFT']).'</strong><br/>';
                                        }
                                    ?>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <?php 
                                            $query = mysqli_query($conn,"select * from shelves where `SCHOOL`='$initials' and `SHELF NUMBER`!=''");
                                            $total_books_in_lib = 0;
                                            $total_books_given_out_lib =0;
                                            $total_shelves= mysqli_num_rows($query);
                                            $total_books_taken_lib = 0;
                                        
                                            while($fetch_shelves = mysqli_fetch_assoc($query)){
                                                $total_books_in_lib = number_format($fetch_shelves['TOTAL BOOKS']+$total_books_in_lib);
                                                $total_books_given_out_lib = number_format($fetch_shelves['BOOKS GIVEN']+$total_books_given_out_lib);
                                                $total_books_taken_lib = number_format($fetch_shelves['BOOKS LEFT']+$total_books_taken_lib);
                                            }
                                        
                                           echo 'TOTAL SHELVES: <strong>'.number_format($total_shelves).'</strong><br/>';
                                            echo 'TOTAL BOOKS IN LIBRARY: <strong>'.$total_books_in_lib.'</strong><br/>';
                                            echo 'TOTAL BOOKS GIVEN OUT: <strong>'.$total_books_given_out_lib.'</strong><br/>';
                                            echo 'TOTAL BOOKS LEFT IN SHELVES: <strong>'.$total_books_taken_lib.'</strong><br/>';
                                        ?>
                                    </div>
                                    
                                </div>
                            </div>
                        
                            </div>
                        </div>
                        </div>
                        <div class="content">
                          
                            <div <?php echo $btn_style ?>>
                            <button type="button"  data-toggle="modal" data-target="#add_shelf" class="btn btn-primary pull-left" onclick=""><i class="fa fa-plus"></i> Add Book</button>
                            <button type="button"  data-toggle="modal" data-target="#_shelf" class="btn btn-danger pull-right" onclick="delete_book('<?php echo $shelf;?>');"><i class="fa fa-trash"></i> Delete</button>
                            </div></div>
                        </div>
                        
                        <div class="content">
                         <div class="col-sm-12" style="padding-top:20px;">
                            <div class="panel-group">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                       Shelves
                                    </div>
                                    <div class="panel-body" style="overflow-x:auto">
                                        
                                       <table id="example" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>
                              <form class="form">
                                  <label>
                                      <input type="checkbox" id="check_all">
                                      All <i class="fa fa-check"></i>
                                  </label>
                              </form>
                          </th>
                         <th>#</th>
                          <th>SHELF NUMBER</th>
                          <th>BOOK NUMBER</th>
                           <th>BOOK NAME</th>
                          <th>PUBLISHER</th>
                          <th>CATEGORY</th>
                          <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody id="result_box">
                            
                            <?php $counter = 0;
    
    $query1 = mysqli_query($conn,"select * from library_books where `SCHOOL`='$initials' and `SHELF NUMBER`='$shelf' order by `ID` asc");
    $counter = 0;
    while($fetch1 = mysqli_fetch_assoc($query1)){
        $shelf_number = htmlentities($fetch1['SHELF NUMBER']);
        $book_number = htmlentities($fetch1['BOOK NUMBER']);
        $book_name = htmlentities($fetch1['BOOK NAME']);
        $publisher = htmlentities($fetch1['PUBLISHER']);
        $category = htmlentities($fetch1['CATEGORY']);
        $status = htmlentities($fetch1['STATUS']);
        
        $id = $fetch1['ID'];
        $btn = '';
       
        if($status =='STORED'){
                     $btn='  <a href="give_book.php?id='.$book_number.'&shelf_number='.$shelf_number.'"><li><i class="fa fa-book"></i> Give out </li></a>';
        }else{
                     $btn='  <a id="activate_btn" onclick="return_book(\''.$book_number.'\',\''.$shelf_number.'\')"><li><i class="fa fa-book"></i> Return </li></a>';
        }
        $counter ++;
        $id = $fetch1['ID'];
        echo '<tr id="row'.$id.'">
              <td><label>
                  <input type="checkbox" id="'.$shelf_number.'" name="'.$id.'" class="checkboxes">  <i class="fa fa-check"></i>
              </label> </td>
              <td>'.$counter.'</td>
              <td id="shelf_number'.$id.'">'.$shelf_number.'</td>
              
              <td id="book_number'.$id.'">'.$book_number.'</td>
              <td id="cat_'.$id.'">'.$book_name.'</td>
              <td id="book_publisher'.$id.'">'.$publisher.'</td>
              <td id="book_category'.$id.'">'.$category.'</td>
              <td>'.$status.'</td>
              <td>
                  
              <div class="dropdown" '.$btn_style.'>    
                <button class="btn btn-default"  data-toggle="dropdown"  id="return_btn'.$book_number.'">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu" id="dropdown" class="dropdown">
                    <li data-toggle="modal" data-target="#edit_book" onclick="edit_book_show(\''.$id.'\');" ><i class="fa fa-edit"></i> Edit</li>
                        '.$btn.'
                    </ul>
              </div>
                   </td>
              

            </tr>';
    }?>
                        </tbody>
                        <tfoot>
                        <tr>
                        <th></th>
                         <th>#</th>
                          <th>SHELF NUMBER</th>
                          <th>BOOK NUMBER</th>
                           <th>BOOK NAME</th>
                          <th>PUBLISHER</th>
                          <th>CATEGORY</th>
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
        

        

<!--modl boxes-->
         <div class="modal fade" id="add_shelf" style="z-index:5000;">
             <div class="modal-dialog modal-md" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title"><i class="fa fa-book"></i> Add Book</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Book Name" id="book_name" name="book_name"/>
                             </div>
                             <div class="form-group">
                                <input type="text" class="form-control" placeholder="Publisher" id="Publisher" name="Publisher"/>
                             </div>
                             <div class="form-group">
                             <div class="form-group">
                                <input type="text" class="form-control" placeholder="Shelf Number" id="add_shelves" name="Publisher" value="<?php echo $shelf;?>" readonly/>
                             </div>
                                 
                             </div>
                             <div class="form-group" id="shelf_cat">
                             <label>Book Category</label><br/>
                             <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="cats" name="">
                                <?php 
                                    include '../includes/pick_shelf_cats.php';
                                    foreach($categories as $category){
                                        echo '<option value="'.$category.'">'.$category.'</option>';
                                    }
                                 ?>
                          </select>
                                 
                             </div>
                             <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Qauntity" id="qty" name="qty"/>
                                 </div>
                             <div class="form-group">
                                 
                                 <button class="btn btn-primary" type="button" onclick="add_book();" id="save_btn"><i class="fa fa-save" ></i>   Save</button>
                                 <a href="manage_books.php?shelves=<?php echo $shelf ?>"><button class="btn btn-success" type="button" ><i class="fa fa-thumbs-up" ></i> Done</button></a>
                                 
                             </div>
                         </form>

                     </div>
                       
                 </div>
             </div>
         </div>
        
        
        <div class="modal fade" id="edit_book" style="z-index:5000;">
             <div class="modal-dialog modal-md" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">Edit Book</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form">
                             <div class="form-group">
                                <input type="text" class="form-control" placeholder="Book Name" id="edit_book_number" name="book_name" value="" readonly/>
                             </div>
                             
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Book Name" id="edit_book_name" name="book_name"/>
                             </div>
                             <div class="form-group">
                                <input type="text" class="form-control" placeholder="Publisher" id="edit_Publisher" name="Publisher"/>
                             </div>
                           
                             <div class="form-group">
                             <div class="form-group">
                                <input type="text" class="form-control" placeholder="Publisher" id="edit_shelf" name="edit_shelf" value="<?php echo $shelf;?>" readonly/>
                             </div>
                                 
                             </div>
                             <div class="form-group" id="shelf_cat">
                             <label>Book Category</label><br/>
                             <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="edit_cats" name="">
                                <?php 
                                    include '../includes/pick_shelf_cats.php';
                                    foreach($categories as $category){
                                        echo '<option value="'.$category.'">'.$category.'</option>';
                                    }
                                 ?>
                          </select>
                                 
                             </div>
                             <div class="form-group">
                                 
                                 <button class="btn btn-primary" type="button"  id="edit_btn"><i class="fa fa-save" ></i>   Save Changes</button>
                                 <a href="manage_books.php?shelves=<?php echo $shelf ?>"><button class="btn btn-success" type="button" ><i class="fa fa-thumbs-up" ></i> Done</button></a>
                                 
                             </div>
                         </form>

                     </div>
                       
                 </div>
             </div>
         </div>
        
        <?php
        
    
        
        ?>
        
        <div class="modal fade" id="edit_academic" style="z-index:5000;">
             <div class="modal-dialog modal-md" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h2 class="modal-title">ADD ACADEMIC YEAR</h2>
                     </div>
                     <div class="modal-body">
                         <form class="form form-inline">
                             <div class="form-group">
                                <input type="text" class="form-control" placeholder="eg. 1990-1992" id="academic_year" name="academic_year"/>
                             </div>
                             <div class="form-group">
                             <select class="selectpicker" data-show-subtext="true" data-live-search="true" style="width:100%;" id="term_term" name="term_term">
                                <option value="TERM 1" >TERM 1</option>
                               <option value="TERM 2" >TERM 2</option>
                               <option value="TERM 3" >TERM 3</option>
                               
                          </select>
                             </div><br><br>
                             <input type="hidden" id="status">
                             <input type="hidden" id="yr_id">
                             
                             <div class="form-group">
                                 
                                 <button class="btn btn-primary" type="button" onclick="edit_academic_year();" id="save_btn"><i class="fa fa-save" ></i>   Save</button>
                                 <a href="manage_academic_year.php"><button class="btn btn-success" type="button" ><i class="fa fa-thumbs-up" ></i> Done</button></a>
                                 
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
        <script src="webcam/webcamjs/webcam.min.js"></script>
        <script src="../js/webcam_config.js"></script>
         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
                 
                  $('.list-unstyled li:nth-child(19) ul').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(19) a').attr('aria-expanded','true');
                 $('.list-unstyled li:nth-child(19) ul').toggleClass('collapse in');
                 $('.list-unstyled li:nth-child(19) a').toggleClass('');
                 $('.list-unstyled li:nth-child(19) ul li:nth-child(2)').toggleClass('active');
             });
            
            $(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
            
             
             $('.form_date').datetimepicker({
                language:  'en',
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0
            });
             
             $('input[type="checkbox"]').on('click',function(){
                if(this.checked){
                    $('#row'+this.name).css('background-color','#2e89ab');
                    $('#row'+this.name).css('color','#fff');
                    $('.dropdown').css('color',"#3b3b3b");
                    var all_checked = false;
                    
                    var check_boxes = document.getElementsByClassName('checkboxes');
                    
                    for(var x=0; x < check_boxes.length; x++){
                        if(check_boxes[x].checked){
                            all_checked = true;
                        }else{
                            all_checked = false;
                            break;
                        }
                    }
                    var all_check_box = document.getElementById('check_all');
                    if(all_checked==true){
                        all_check_box.checked = true;
                    }
                    
                    
                }else{
                    $('#row'+this.name).css('background-color','');
                    $('#row'+this.name).css('color','#000');
                    
                    var all_check_box = document.getElementById('check_all');
                    
                    if(all_check_box.checked){
                        all_check_box.checked = false;
                    }
                } 
             });
             
             $('#check_all').on('click',function(){
                 
                 if(this.checked){
                    var check_boxes = document.getElementsByClassName('checkboxes');
                    
                    for(var x=0; x < check_boxes.length; x++){
                        check_boxes[x].checked = true;
                        var checkbox_id = check_boxes[x].name;
                        $('#row'+checkbox_id).css('background-color','#2e89ab');
                        $('#row'+checkbox_id).css('color','#fff');
                        $('.dropdown').css('color',"#3b3b3b");
                    }
                }else{
                    var check_boxes = document.getElementsByClassName('checkboxes');
                    
                    for(var x=0; x < check_boxes.length; x++){
                        check_boxes[x].checked = false;
                        var checkbox_id = check_boxes[x].name;
                        $('#row'+checkbox_id).css('background-color','');
                        $('#row'+checkbox_id).css('color','#000');
                    }
                }
             })
              
            $('document').ready(function(){
                $('input[type="search"]').on('keyup',function(){
                
                var value = $('input[type="search"]').val();
               // console.log(value.length);
                if(value.length < 1){
                    $('#check_all').removeAttr('disabled','false');
                }else{
                    $('#check_all').attr('disabled','true');
                }
            });
            });
         </script>
        
        
    </body>
</html>
