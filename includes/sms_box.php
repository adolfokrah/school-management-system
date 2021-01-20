<!--modl boxes-->
         <div class="modal fade" id="sms_box" style="z-index:5000;">
             <div class="modal-dialog" style="z-index:5000;">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                         <h5>Purchase SMS</h5>
                     </div>
                     <div class="modal-body">
                         <form class="form" for="form" style="padding:10px;">
                             <?php 
                                include 'mysql_connect.php';
                                
                                //pick sms
                                $unit_price =0;
                                $query = mysqli_query($conn,"SELECT * FROM `sms_cost`");
                                if($fetch = mysqli_fetch_assoc($query)){
                                    $unit_price = $fetch['UNIT PRICE'];
                                }
                             ?>
                             
                             
                                 <div class="form-group">
                                     <label>Quantity</label><br/>
                                     <input type="tel" class="form-control" placeholder="Quantity" id="qty" value="1"/>
                                 </div>
                                 
                                 <div class="form-group">
                                     <label>Unit Price (GHS)</label><br/>
                                     <input type="text" class="form-control" placeholder="Unit price" readonly value="<?php echo ' '.sprintf('%0.2f',$unit_price); ?>" id="unit_price"/>
                                 </div>
                                 <div class="form-group">
                                     <label>Total Amount (GHS)</label><br/>
                                     <input type="text" class="form-control" placeholder="Amount" readonly value="<?php echo ' '.sprintf('%0.2f',$unit_price); ?>" id="amount"/>
                                 </div>
                                
                                <div class="form-group">
                                    <button type="button" class="btn btn-warning btn-block" id="proceed_btn">Proceed</button>
                                </div>
                         </form>
                     </div>
                       
                 </div>
             </div>
         </div>

<script>
    $('document').ready(function(){
        $('#qty').on('keyup',function(){
            var qty = $('#qty').val();
            var unit_price = $('#unit_price').val();
            var amount = $('#amount').val();
            if(qty > 0){
                amount = qty * unit_price;
                $('#amount').val(amount);
            }
        })
        
        $('#proceed_btn').on('click',function(){
            var qty = $('#qty').val();
            var unit_price = $('#unit_price').val();
            var amount = $('#amount').val();
            if(qty > 0){
                window.open('sms_payment_invoice.php?qty='+qty+'&amount='+amount+'&unit_price='+unit_price,'_blank');
            }else{
                swal('','Quantity should be more than 0','warning');
                $('.swal2-container').css('z-index',8000);
            }
        })
        
    })
</script>