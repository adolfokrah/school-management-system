<?php
    include 'school_ini_user_id.php';
    
    
    if(isset($_REQUEST['id']) && isset($_REQUEST['class'])){
        $class = $_REQUEST['class'];
        $student_id = $_REQUEST['id'];
        $academic_year = '';
        $term = '';

        $query_select_academic = mysqli_query($conn,"select * from `academic_years` where `SCHOOL`='$initials' and `STATUS`='ACTIVE'");
        if($fetch_year = mysqli_fetch_assoc($query_select_academic)){
            $academic_year = $fetch_year['ACADEMIC YEAR'];
            $term = $fetch_year['TERM'];
        }
        
        $student_name = '';
        $query_pick_student_name = mysqli_query($conn,"select * from admitted_students where SCHOOL='$initials' and `ADMISSION NO / ID`='$student_id'");
        if($fetch_name = mysqli_fetch_assoc($query_pick_student_name)){
            $student_name = $fetch_name['STUDENT LAST NAME'].' '.$fetch_name['STUDENT  FIRST NAME'];
        }
        
        //SELECT SUBJECTS
        $class_subjects = '';
        $exam_subjects = '';
        
        
        $query_pick_subject = mysqli_query($conn,"select * from subjects where `SCHOOL`='$initials' and `CLASS`='$class' order by `SUBJECT NAME` asc");
        while($fetch = mysqli_fetch_assoc($query_pick_subject)){
            $subject = $fetch['SUBJECT NAME'];
            $class_subjects .= '
            <div class="form-group" id="markbox">
                <label>'.$subject.'</label><br/>
                <input type="text" placeholder="Marks" class="form-control"';
          //student student subject markbox
            $query_select_mark = mysqli_query($conn,"select * from marksheet where `SCHOOL`='".$initials."' and `CLASS`='$class' and `STUDENT ID`='$student_id' and `TERM`='$term' and `ACADEMIC YEAR`='$academic_year' and `SUBJECT`='$subject' and `MARKSHEET`='CLASS SCORE'");
            
            echo mysqli_connect_error();
            if($fetch_mark = mysqli_fetch_assoc($query_select_mark)){
                $class_subjects .='value = "'.$fetch_mark['MARKS'].'"';
            }
             $class_subjects .=' name = "class_subjects" id="'.$subject.'"/></div>';
            
            
            $exam_subjects .= '
            <div class="form-group" id="markbox">
                <label>'.$subject.'</label><br/>
                <input type="text" placeholder="Marks" class="form-control"';
          //student student subject markbox
            $query_select_mark = mysqli_query($conn,"select * from marksheet where `SCHOOL`='".$initials."' and `CLASS`='$class' and `STUDENT ID`='$student_id' and `TERM`='$term' and `ACADEMIC YEAR`='$academic_year' and `SUBJECT`='$subject' and `MARKSHEET`='EXAM SCORE'");
            
            echo mysqli_connect_error();
            if($fetch_mark = mysqli_fetch_assoc($query_select_mark)){
                $exam_subjects .='value = "'.$fetch_mark['MARKS'].'"';
            }
             $exam_subjects .=' name = "exam_subjects" id="'.$subject.'"/></div>';
        }
        //select student class and exam score
        $query = mysqli_query($conn,"select * from marksheet where `SCHOOL`='$initials' and `STUDENT ID`='$student_id' and `CLASS`='$class' and `ACADEMIC YEAR`='$academic_year' and `TERM`='$term'");
        
        echo '<div class="col-sm-12">
                                <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                   <strong>'.$student_name.' - '.$student_id.'</strong>
                                </div>
                            </div>
                        
                            </div>
                        </div>
                         
                         <form class="form">
                             
                             
                             <div class="form-group" id="capture_image">
                                 <div class="tabbable tabs-left">
                                        <ul class="nav nav-tabs " style="font-size:16px;" id="nav_tabs">
                                          <li class="active"><a href="#guardian" data-toggle="tab">Class Marks</a></li>
                                          <li><a href="#school_fees" data-toggle="tab">Exam Marks</a></li>
                                          
                                        </ul>
                                        <div class="tab-content">
                                         <div class="tab-pane active" id="guardian" style="padding-top:10px;">
                                             '.$class_subjects.'
                                        </div>
                                        <div class="tab-pane" id="school_fees" style="padding-top:10px;">
                                            '.$exam_subjects.'
                                        </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 
                                 <button class="btn btn-primary btn-block" type="button" id="savebtn" onclick="update_insert(\''.$student_id.'\',\''.$class.'\');"><i class="fa fa-save" ></i> Save </button>
                                 
                             </div>
                         </form>';
    }
?>