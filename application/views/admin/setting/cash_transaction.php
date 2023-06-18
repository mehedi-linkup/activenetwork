<div class="container">
	<div class="row">
		<div class="well" style="min-height: 500px">
			<?php 
				$collectionReceive = $this->db->query("
					SELECT 
						(dish_total + wifi_total + service_payment)as total
					FROM (
						SELECT 
							ifnull(sum(dish_bill),0)as dish_total,
							ifnull(sum(wifi_bill),0)as wifi_total,
							ifnull(sum(coll_amount),0)as service_payment
						FROM tbl_collection where coll_status ='a'
						)as tbl
				")->row();
				$connectionFeeReceive = $this->db->query("SELECT ifnull(sum(connection_fee),0)as connection_total FROM tbl_customer ")->row();
				$salaryPaid = $this->db->query("SELECT ifnull(sum(payment_amount),0)as salary_total FROM tbl_salary WHERE status='a'")->row();
				$cashRecive = $this->db->query("SELECT ifnull(sum(tr_amount),0)as receive_total FROM tbl_transaction WHERE tr_type =1")->row();
				$cashPaid = $this->db->query("SELECT ifnull(sum(tr_amount),0)as paid_total FROM tbl_transaction WHERE tr_type =2")->row();
				$puchasePayment = $this->db->query("SELECT ifnull(sum(paid),0)as purchase_paid from tbl_purchase where status='a'")->row();
				$supplierPayment = $this->db->query("SELECT ifnull(sum(payment_amount),0)as supplier_paid from tbl_supplier_payments where status='a'")->row();
				// $data=$this->db->query("select (select sum(coll_amount)as pay_total from tbl_collection where coll_status='a') as payment,
				// (select sum(coll_amount)as due_total from tbl_collection where coll_status='p')as due,
				// (select sum(payment_amount)as total_salary from tbl_salary where status='a')as total_salary,
				// (select sum(exp_amount)as total_amount from  tbl_expense)as total_expense,
				// (select sum(tr_amount)as receive_total from tbl_transaction)as cash_recive,
				// (select sum(tr_amount)as payment_total from tbl_transaction where tr_type=2)as cash_payment")->row();
			//print_r($data);
			

			$payment_receive = ($collectionReceive->total + $cashRecive->receive_total + $connectionFeeReceive->connection_total);
			$cash_payment = ($salaryPaid->salary_total + $cashPaid->paid_total + $puchasePayment->purchase_paid + $supplierPayment->supplier_paid);
			$cash_in_hand = ($payment_receive - $cash_payment);
			?>
			<div class="row">
				<div class="col-md-4">
					<div class="view-transaction">
						<div class="fa fa-money fa-3x"></div>
						<h2 style="margin:0px">Payment Receive</h2>
						
						<h3>tk. <?php echo $payment_receive  ?></h3>
					</div>
				</div>
				

				<div class="col-md-4">
					<div class="view-transaction">
						<div class="fa fa-dollar fa-3x"></div>
						<h2 style="margin:0px">Cash Payment</h2>
						
						<h3>tk. <?php echo $cash_payment  ?> </h3>
					</div>
				</div>
				<div class="col-md-4">
					<div class="view-transaction">
						<div class="fa fa-money fa-3x"></div>
						<h2 style="margin:0px">Cash In Hand</h2>
						
						<h3>tk. <?php echo $cash_in_hand ?></h3>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	// $(document).ready(function(){
	// 	$(document).on('submit','#cashviewForm',function(e){
	// 		e.preventDefault();
	// 		var from_date=$('#from_date','#cashviewForm').val();
	// 		var to_date=$('#to_date','#cashviewForm').val();
	// 		var action=$('#action','#cashviewForm').val();
	// 		//alert(`${from_date} --- ${to_date}`);

	// 		if (from_date=='') {
	// 			alert('Please search form date !');
	// 		}
	// 		else if(to_date==''){
	// 			alert('Please search to date !');
	// 		}
	// 		else{
	// 			$.ajax({
	// 				url:'<?php //echo base_url("cash-transaction") ?>',
	// 				method:'post',
	// 				data:{action:action,from_date:from_date,to_date:to_date},
	// 	        	success:function(data){
	// 	        		$('#showcashview').html(data);
	// 	        	}
	// 			});
	// 		}
	// 	})
	// })
</script>