<div class="container">

	<div class="row">
		<div class="well" style="min-height: 400px">
			<?php
				$id=$this->session->userdata('userid');
				$type=$this->session->userdata('type');
				$data=$this->db->query("select menuaccess from tbl_admin where id=?",$id)->row(); 
				// $menu=$data->menuaccess;
				// echo $menu;
				$ac = explode(',', $data->menuaccess);
				if(in_array('create-admin', $ac) || $type==2){
			?>
         
			<div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <!-- gogradient-bg -->
            <div class="info-box blgradient-bg">
              <i class="">&#2547;</i>
              <div class="count">
                <?php 
                  	$totalCollection = $this->db->query("
						SELECT
						ifnull(sum(dish_bill),0)as dish_total,
						ifnull(sum(wifi_bill),0)as wifi_total
						FROM tbl_collection
						WHERE update_date = CURRENT_DATE()")->row();
                  	$connectionFee = $this->db->query("
						SELECT
							ifnull(sum(connection_fee),0)as total
						FROM tbl_customer
						WHERE entry_date = CURRENT_DATE()
                  	")->row();
                 	$serviceTotal = $this->db->query("
						SELECT
						ifnull(sum(coll_amount),0)as service_paid
						FROM tbl_collection 
						WHERE coll_status='a' and coll_note !='' and coll_date = CURRENT_DATE()
                  	")->row();

                  	$cashReceived = $this->db->query("
						SELECT 
						ifnull (sum(tr_amount), 0)as total  
						FROM tbl_transaction 
						WHERE tr_type=1
						AND tr_status ='a'
						AND create_date = CURRENT_DATE()
                 	")->row();

                  	$todayTotal = ($totalCollection->dish_total + $totalCollection->wifi_total + $connectionFee->total + $serviceTotal->service_paid + $cashReceived->total);
                    echo $todayTotal;
                 ?>
              </div>
              <div class="title">Today's Collection</div>
            </div>
          </div> 
          <!-- gogradient-bg -->

			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="info-box rpgradient-bg">
					<i class="fa fa-user"></i>
					<div class="count">
						<?php 
						$count=$this->db->query("select * from tbl_customer where  wifi_is_active = 'active'")->num_rows();
						echo $count;
					?>
					</div>
					<div class="title">Wifi Active Customer</div>
				</div>
            <!--/.info-box-->
          	</div>
          	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="info-box rpgradient-bg">
					<i class="fa fa-user"></i>
					<div class="count">
						<?php 
						$count=$this->db->query("select * from tbl_customer where  wifi_is_active = 'Inactive'")->num_rows();
						echo $count;
					?>
					</div>
					<div class="title">Wifi Inactive Customer</div>
				</div>
				<!--/.info-box-->
          	</div>

          	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="info-box rpgradient-bg">
					<i class="fa fa-user"></i>
					<div class="count">
						<?php 
							$wifiActive=$this->db->query("select * from tbl_customer where  wifi_is_active = 'active'")->num_rows();
							$wifiInactive=$this->db->query("select * from tbl_customer where  wifi_is_active = 'Inactive'")->num_rows();
							$totalWifiUser = $wifiActive + $wifiInactive;
							echo $totalWifiUser;
						?>
					</div>
					<div class="title">Wifi Total Customer</div>
				</div>
            <!--/.info-box-->
          	</div>

			  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="info-box blgradient-bg">
					<i class="">&#2547;</i>
					<div class="count">
						<?php 
							$monthlyCollection = $this->db->query("
								SELECT
								ifnull(sum(dish_bill),0)as dish_total,
								ifnull(sum(wifi_bill),0)as wifi_total
								FROM tbl_collection
								WHERE update_date > now() - interval 1 month")->row();
							$connectionFee = $this->db->query("
								SELECT
								ifnull(sum(connection_fee),0)as total
								FROM tbl_customer 
								WHERE entry_date > now() - interval 1 month
							")->row();
							$serviceTotal = $this->db->query("
								SELECT
								ifnull(sum(coll_amount),0)as service_paid
								FROM tbl_collection 
								WHERE coll_status='a' and coll_note !='' and coll_date > now() - interval 1 month
							")->row();

							$monthlyReceive= $this->db->query("
								SELECT 
								ifnull (sum(tr_amount), 0)as total  
								FROM tbl_transaction 
								WHERE tr_type=1
								AND tr_status ='a'
								AND create_date > now() - interval 1 month
							")->row();
							
							$monthlyTotal = ($monthlyCollection->dish_total + $monthlyCollection->wifi_total + $connectionFee->total + $serviceTotal->service_paid + $monthlyReceive->total);
							echo $monthlyTotal;
						?>
					</div>
					<div class="title">Monthly Collection</div>
				</div>
          	</div>

			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="info-box glgradient-bg">
					<i class="fa fa-user"></i>
					<div class="count">
						<?php 
						$count = $this->db->query("select * from tbl_customer where type='active'")->num_rows();
						echo $count;
						?>
					</div>
					<div class="title">Dish Active Customer</div>
				</div>
            <!--/.info-box-->
          	</div>
          <!--/.col-->
          	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="info-box glgradient-bg">
					<i  class="fa fa-user"></i>
					<div class="count">
						<?php 
						$activeCustomer = $this->db->query("select * from tbl_customer where status ='i'");

						echo $activeCustomer->num_rows();
						?>
					</div>
					<div class="title">Dish Inactive Customer</div>
				</div>
          	</div> 
          	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="info-box glgradient-bg">
					<i  class="fa fa-user"></i>
					<div class="count">
						<?php 
							$activeCust = $this->db->query("select * from tbl_customer where type='active'")->num_rows();
							$inactiveCust = $this->db->query("select * from tbl_customer where status ='i'")->num_rows();
							$totalCustomer = $activeCust + $inactiveCust;
							echo $totalCustomer;
						?>
					</div>
					<div class="title">Dish Total Customer</div>
				</div>
         	 </div> 
          	
          <!--/.col-->
          	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="info-box blgradient-bg">
					<i class="fa fa-calendar-o"></i>
					<div class="count">
						<?php 
							$complaint=$this->db->query("select count(complaint)as total_complains from  tbl_complaint where status='p'")->row();
							$comp=0;
							if($complaint->total_complains){
								$comp=$complaint->total_complains;
							}
							echo $comp;

						?>
					</div>
					<div class="title">User Complains</div>
				</div>
				<!--/.info-box-->
          	</div>
          	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="info-box rpgradient-bg">
					<i class="">&#2547;</i>
					<div class="count">
						<?php 
							$count_due=$this->db->query("
								SELECT 
									(dish_total + wifi_total)as total
								FROM (
									SELECT 
										ifnull(sum(dish_bill),0)as dish_total,
										ifnull(sum(wifi_bill),0)as wifi_total
									FROM tbl_collection where coll_status ='p'
									)as tbl
								")->row();
							
							echo $count_due->total;

						?>
					</div>
					<div class="title">Due Amount</div>
				</div>
            <!--/.info-box-->
         	 </div>
          <!--/.col-->

           	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            	<div class="info-box gogradient-bg">
					<i class="">&#2547;</i>
					<div class="count">
						<?php 
							$count_pay=$this->db->query("
							SELECT 
								(dish_total + wifi_total + service_payment)as total
							FROM (
								SELECT 
								ifnull(sum(dish_bill),0)as dish_total,
								ifnull(sum(wifi_bill),0)as wifi_total,
								ifnull(sum(coll_amount),0)as service_payment
								FROM tbl_collection where coll_status ='a'
								)as tbl"
							)->row();
						
						echo $count_pay->total;

						?>
					</div>
					<div class="title">Pay Amount</div>
				</div>
          	</div> 
          <!--/.col-->
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="info-box gogradient-bg">
					<i class="">&#2547;</i>
					<div class="count">
						<?php 
							$advance_pay=$this->db->query("select sum(advance_amount)total from tbl_customer where status='a'")->row();
							$payment=0;
						if($advance_pay->total !=0){
							$payment=$advance_pay->total;
						}
						echo $payment;

						?>
					</div>
				<div class="title">Advance Amount</div>
				</div>
			</div> 
        </div>
      <?php } else{ ?>
        <h1 style="color: #0A9331; text-align: center;padding-top: 10px"><strong>Welcome</strong> to <br> Active Network Dashboard</h1>
      <?php } ?>
			<!--  -->
		</div>
	</div>

</div>