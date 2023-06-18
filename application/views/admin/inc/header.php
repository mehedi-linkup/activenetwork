<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="United Cable Network">
		<meta name="author" content="">
		<meta name="keyword" content="United Cable Network">
		<!--   <link rel="shortcut icon" href="img/favicon.png"> -->

		<title><?php echo $title ?></title>

		<!-- Bootstrap CSS -->
		<link href="<?php echo base_url().'assets/backend/' ?>css/bootstrap.min.css" rel="stylesheet">
		<!-- bootstrap theme -->
		<link href="<?php echo base_url().'assets/backend/' ?>css/bootstrap-theme.css" rel="stylesheet">
		<!--external css-->
		<link href="<?php echo base_url().'assets/backend/' ?>css/font-awesome.min.css" rel="stylesheet" />
		<link href="<?php echo base_url().'assets/backend/' ?>css/elegant-icons-style.css" rel="stylesheet" />
		<!-- Custom styles -->
		<link href="<?php echo base_url().'assets/backend/' ?>css/style.css" rel="stylesheet">
		<link href="<?php echo base_url().'assets/backend/' ?>css/style-responsive.css" rel="stylesheet" />
		<link href="<?php echo base_url().'assets/backend/' ?>css/datatable.css" rel="stylesheet" />
		<link href="<?php echo base_url().'assets/backend/' ?>css/select2.css" rel="stylesheet" />
		<script src="<?php echo base_url().'assets/backend/' ?>js/jquery.js"></script>
		<script src="<?php echo base_url().'assets/backend/' ?>js/select2.js"></script>
	</head>
	<body>
  	<!-- container section start -->
  	<section id="container" class="">

	<?php
		$id=$this->session->userdata('userid');
		$type=$this->session->userdata('type');
		
		$data=$this->db->query("select menuaccess from tbl_admin where id = ?", $id)->row(); 
		// $menu=$data->menuaccess;
		// echo $menu;
		$ac=explode(',', $data->menuaccess);
    ?>
    <header class="header dark-bg">
		<div class="toggle-nav">
			<div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
		</div>

      	<!--logo start-->
      	<a href="<?php echo base_url('dashboard') ?>" class="logo">Active Network </a>
      	<!--logo end-->

		<div class="nav search-row" id="top_menu">
			<!--  search form start -->
			
			<!--  search form end -->
		</div>

      	<div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
			<ul class="nav pull-right top-menu">
				<li class="hidden-xs">
					<a href="" style="color: #fff"><i class="ace-icon fa fa-clock-o"></i> <?php echo date("l jS \of F Y") ?> &nbsp;<span id="MyClockDisplay" onload="showTime()"></span></a>
			</li>

			<li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#">
					<span class="profile-ava">
					<img alt="" src="<?php echo base_url().'assets/backend/images/'.$this->session->userdata('image') ?>" class="img-responsive" alt="Image"> 
					</span>
					<span class="username"><?php echo $this->session->userdata('username'); ?></span>
					<b class="caret"></b>
				</a>
				<ul class="dropdown-menu extended logout">
					<div class="log-arrow-up"></div>
					<li class="eborder-top">
						<a href="<?php echo base_url().'administator/'.$this->session->userdata('userid'); ?>"><i class="icon_profile"></i> My Profile</a>
					</li>
					<li>
						<a href="<?php echo base_url('logout') ?>"><i class="icon_key_alt"></i> Log Out</a>
					</li>
				</ul>
			</li>
			<!-- user login dropdown end -->
			</ul>
        <!-- notificatoin dropdown end-->
      	</div>
    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>

      	<?php
			function dropdownShow($access, $db_access) {
			$type = $_SESSION['type'];
			if ($type == 2) return true;
			
			$count = 0;
			foreach ($access as $_access) {
				if (in_array($_access, $db_access)) {
				$count++;
				}
			}
			return $count > 0 ? true : false;
			}
      	?>

      <div id="sidebar" class="nav-collapse ">


        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          	<li class="active">
            	<a class="" href="<?php echo base_url('dashboard') ?>">
                	<i class="icon_house_alt"></i>
                  	<span>Dashboard</span>
                </a>
         	</li>
          	<?php if (dropdownShow(['create-admin', 'employee', 'company-profile', 'customer'], $ac)) : ?>
          	<li class="sub-menu">
				<a href="javascript:void(0)" class="">
					<i class="fa fa-users"></i>
					<span>Administration</span>
					<span class="menu-arrow arrow_carrot-right"></span>
				</a>
				<ul class="sub">
					<?php if(in_array('customer', $ac) OR $type == 2){?>
					<li><a class="" href="<?php echo base_url('customer'); ?>">Customer Entry</a></li>
					<?php } ?>
					<?php if(in_array('employee', $ac) OR $type == 2){?>
					<li><a class="" href="<?php echo base_url('employee'); ?>">Employee Entry</a></li>
					<?php } ?>
					<?php if(in_array('company-profile', $ac) OR $type == 2){?>
					<li><a class="" href="<?php echo base_url('company-profile'); ?>">Company Profile</a></li>
					<?php } ?>
					<?php if(in_array('supplier', $ac) OR $type == 2){?>
					<li><a class="" href="<?php echo base_url('supplier'); ?>">Supplier Entry</a></li> 
					<?php }?>
					<?php if(in_array('create-admin', $ac) OR $type == 2){?>
						<li><a class="" href="<?php echo base_url('create-admin'); ?>">Create User</a></li>
					<?php } ?>
				</ul>
           	</li>
          	<?php endif ?>
          	<?php if (dropdownShow(['area', 'month', 'expense-type', 'account', 'speed', 'product', 'category', 'unit'], $ac)) : ?>
         	<li class="sub-menu">
				<a href="javascript:void(0)" class="">
					<i class="fa fa-cogs"></i>
					<span>Settings</span>
					<span class="menu-arrow arrow_carrot-right"></span>
				</a>
				<ul class="sub">
				<?php if(in_array('area', $ac) OR $type == 2){?>
					<li><a class="" href="<?php echo base_url('area'); ?>">Add Area</a></li>
					<?php } ?>
					<?php if(in_array('month', $ac) OR $type == 2){?>
						<li><a class="" href="<?php echo base_url('month'); ?>">Add Month</a></li>
					<?php } ?>
					<!-- <?php //if(in_array('expense-type', $ac) OR $type == 2){?>
					<li><a class="" href="<?php //echo base_url('expense-type'); ?>">Add Expense Type</a></li>
					<?php //}?>  -->
					<?php if(in_array('account', $ac) OR $type == 2){?>
					<li><a href="<?php echo base_url('account') ?>">Add Account</a></li>
					<?php }?> 
					<?php if(in_array('product', $ac) OR $type == 2){?>
					<li><a class="" href="<?php echo base_url('product'); ?>">Metarial Entry</a></li>
					<?php }?>
					<?php if(in_array('category', $ac) OR $type == 2){?>
					<li><a class="" href="<?php echo base_url('category'); ?>">Categories</a></li>
					<?php }?>
					<?php if(in_array('unit', $ac) OR $type == 2){?>
					<li><a class="" href="<?php echo base_url('unit'); ?>">Unit</a></li>
					<?php }?>
					<?php if(in_array('speed', $ac) OR $type == 2){?>
					<li><a class="" href="<?php echo base_url('speed'); ?>">Add Speed</a></li>
					<?php }?>
				</ul>
          	</li>
          	<?php endif ?>
          	<?php if (dropdownShow(['collection-setting', 'collection-entry', 'bill-generate', 'advance-payment'], $ac)) : ?>
          	<li class="sub-menu"> 
            	<a href="javascript:void(0)" class="">
              		<i class="fa fa-cog"></i>
                    <span>Collection</span>
                	<span class="menu-arrow arrow_carrot-right"></span>
                </a>
				<ul class="sub">
				
				<?php if(in_array('collection-entry', $ac) OR $type == 2){?>
				<li><a class="" href="<?php echo base_url('collection-entry'); ?>">Collection entry</a></li>
				<?php } ?>
				
				<?php if(in_array('advance-payment', $ac) OR $type == 2){?>
				<li><a href="<?php echo base_url('advance-payment') ?>">Advance Payment</a></li>
				<?php } ?>
				<?php if(in_array('collection-setting', $ac) OR $type == 2){?>
				<li><a class="" href="<?php echo base_url('collection-setting'); ?>">Bill Generate</a></li>
				<?php } ?>
				<?php if(in_array('bill-generate', $ac) OR $type == 2){?>
				<li><a class="" href="<?php echo base_url('bill-generate'); ?>">New Customer Bill</a></li> 
				<?php } ?>
				</ul>
          	</li>
          	<?php endif ?>
			<?php if (dropdownShow(['purchase', 'consumption', 'stock', 'purchase-record', 'consumption-record', 'supplier-payment'], $ac)) : ?>
         	 <!-- store module -->
          	<li class="sub-menu">
            	<a href="javascript:void(0)" class="">
              		<i class="fa fa-shopping-cart"></i>
					<span>Store Module</span>
					<span class="menu-arrow arrow_carrot-right"></span>
                </a>
                <ul class="sub">
					<?php if(in_array('purchase', $ac) OR $type == 2){?>
						<li><a class="" href="<?php echo base_url('purchase'); ?>">Purchase Entry</a></li>
					<?php }?>
					<?php if(in_array('consumption', $ac) OR $type == 2){?>
						<li><a class="" href="<?php echo base_url('consumption'); ?>">Consumption Entry</a></li>
					<?php }?>
					<?php if(in_array('stock', $ac) OR $type == 2){?>
						<li><a class="" href="<?php echo base_url('stock'); ?>">Stock Report</a></li>
					<?php }?>
					<?php if(in_array('purchase-record', $ac) OR $type == 2){?>
						<li><a class="" href="<?php echo base_url('purchase-record'); ?>">Purchase Record</a></li>
					<?php }?>
					<?php if(in_array('consumption-record', $ac) OR $type == 2){?>
						<li><a class="" href="<?php echo base_url('consumption-record'); ?>">Consumption Record</a></li>
					<?php }?>
					<?php if(in_array('supplier-payment', $ac) OR $type == 2){?>
						<li><a class="" href="<?php echo base_url('supplier-payment'); ?>">Supplier Payment</a></li>
					<?php }?>
            	</ul>
          	</li>
			<?php endif ?>
          	<!-- store module -->

          <?php if (dropdownShow(['customer-payment'], $ac)) : ?>
          	<li class="sub-menu">
				<a href="javascript:void(0)" class="">
					<i class="fa fa-flask"></i>
					<span>Services</span>
                    <span class="menu-arrow arrow_carrot-right"></span>
                </a>
             	<ul class="sub">
              		<?php if(in_array('customer-payment', $ac) OR $type == 2){?>
              		<li><a class="" href="<?php echo base_url('customer-payment'); ?>">Service Payment</a></li>
            		<?php } ?>
            	</ul>
          	</li>
          <?php endif ?>
			<?php if (dropdownShow(['salary', 'expense'], $ac)) : ?>
			<li class="sub-menu">
				<a href="javascript:void(0)" class="">
				<!-- <i class="fa fa-file"></i> -->
					<i class="fa fa-dollar fa-3x"></i>
					<span>Expense</span>
					<span class="menu-arrow arrow_carrot-right"></span>
				</a>
				<ul class="sub">
					<?php if(in_array('salary', $ac) OR $type == 2){?>
					<li><a class="" href="<?php echo base_url('salary'); ?>">Add Salary</a></li>
					<?php } ?>
					<!-- <?php //if(in_array('expense', $ac) OR $type == 2){?>
					<li><a class="" href="<?php //echo base_url('expense'); ?>">Add Expense</a></li>
					<?php // } ?> -->
				</ul>  
			</li>
			<?php endif ?>
			<?php if (dropdownShow(['transaction', 'cash-view'], $ac)) : ?>
			<li class="sub-menu">
				<a href="javascript:void(0)" class="">
				<!-- <i class="fa fa-file"></i> -->
				<i class="fa fa-medkit"></i>
					<span>Transaction</span>
					<span class="menu-arrow arrow_carrot-right"></span>
				</a>
				<ul class="sub">
					<?php if(in_array('transaction', $ac) OR $type == 2){?>
					<li><a class="" href="<?php echo base_url('transaction'); ?>">Cash Transaction</a></li>
					<?php }?>
					<?php if(in_array('cash-view', $ac) OR $type == 2){?>
					<li><a href="<?php echo base_url('cash-view') ?>">Cash View</a></li>
					<?php } ?>
				</ul>  
			</li>
			<?php endif ?>
          <?php if (dropdownShow(['complaint'], $ac)) : ?>
          <li class="sub-menu">
            <a href="javascript:void(0)" class="">
              <!-- <i class="fa fa-file"></i> -->
              <i class="fa fa-file-o"></i>
                          <span>User Complains</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
               <?php if(in_array('complaint', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('complaint'); ?>">Add Complains</a></li>
            <?php } ?>
            </ul> 
          </li>
          <?php endif ?>
          <?php if (dropdownShow(['registration', 'registration_record', 'payment-invoices', 'customer-report','areawise-customer','due-list',
          'due-bill', 'areawise-due', 'payment-list', 'advance-list', 'payment-bill', 'service-payment', 'expense-report', 'user-complaint', 'officer-collection', 'all-transaction-report'
        ], $ac)) : ?>
          <li class="sub-menu">
            <a href="javascript:void(0)" class="">
              <i class="fa fa-calendar-o"></i>
                          <span>Report</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <?php if(in_array('monthly-collection', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('monthly-collection'); ?>">Monthly Collection</a></li>
              <?php } ?>
              <?php if(in_array('payment-invoices', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('payment-invoices'); ?>">Collection Invoice</a></li>
              <?php } ?>
              <?php if(in_array('cash-collection', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('cash-collection'); ?>">Cash Collection</a></li>
              <?php } ?>
              <?php if(in_array('customer-report', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('customer-report'); ?>">Customer List</a></li>
              <?php } ?>
              <?php if(in_array('customer-ledger', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('customer-ledger'); ?>">Customer Ledger</a></li>
              <?php } ?>
              <?php if(in_array('areawise-customer', $ac) OR $type == 2){?>
              <li><a href="<?php echo base_url('areawise-customer') ?>">Areawise Customer</a></li>
              <?php }?>
              <?php if(in_array('due-list', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('due-list'); ?>">Due Customer List</a></li>
              <?php } ?>
              <?php if(in_array('due-bill', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('due-bill'); ?>">Single Customer Due</a></li>
              <?php } ?>
              <?php if(in_array('areawise-due', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('areawise-due'); ?>">Areawise Due</a></li>
              <?php } ?>
              <?php if(in_array('payment-list', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('payment-list'); ?>">Payment List</a></li>
              <?php } ?>
              <?php if(in_array('areawise-payment', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('areawise-payment'); ?>">Areawise Payment</a></li>
              <?php } ?>
              <?php if(in_array('advance-list', $ac) OR $type == 2){?>
              <li><a href="<?php echo base_url('advance-list') ?>">Advance Payment</a></li>
              <?php } ?>
              <!-- <?php //if(in_array('payment-bill', $ac) OR $type == 2){?>
              <li><a class="" href="<?php //echo base_url('payment-bill'); ?>">Customer Payment</a></li>
              <?php //} ?> -->
              <?php if(in_array('service-payment', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('service-payment'); ?>">Service Payment</a></li>
              <?php } ?>
              <!-- <?php // if(in_array('expense-report', $ac) OR $type == 2){?>
              <li><a class="" href="<?php //echo base_url('expense-report'); ?>">Expense Statement</a></li>
              <?php // } ?> -->
              <?php if(in_array('user-complaint', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('user-complaint'); ?>">User Complaint</a></li>
              <?php } ?>
              <?php if(in_array('officer-collection', $ac) OR $type == 2){?>
              <li><a class="" href="<?php echo base_url('officer-collection'); ?>">Officer Collection</a></li>
              <?php } ?>
              <!-- <?php // if(in_array('all-transaction-report', $ac) OR $type == 2){?>
                <li><a class="" href="<?php //echo base_url('all-transaction-report'); ?>">Month Record</a></li>
              <?php //} ?> -->
            </ul>
          </li>
          <?php endif ?>
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      	<section class="wrapper">

         	<div class="row">
          		<div class="col-lg-12">
					<!-- <h3 class="page-header"><?php //echo $title; ?></h3> -->
					<ol class="breadcrumb">
						<li>Dashboard </li>
						<li><?php echo $page; ?></li> 
					</ol>
         		</div>
        	</div>
<script type="text/javascript">
  	function showTime(){
		var date = new Date();
		var h = date.getHours(); // 0 - 23
		var m = date.getMinutes(); // 0 - 59
		var s = date.getSeconds(); // 0 - 59
		var session = "AM";
		
		if(h == 0){
			h = 12;
		}
		
		if(h > 12){
			h = h - 12;
			session = "PM";
		}
		
		h = (h < 10) ? "0" + h : h;
		m = (m < 10) ? "0" + m : m;
		s = (s < 10) ? "0" + s : s;
		
		var time = h + ":" + m + ":" + s + " " + session;
		document.getElementById("MyClockDisplay").innerText = time;
		document.getElementById("MyClockDisplay").textContent = time;
		
		setTimeout(showTime, 1000);
    
	}

	showTime();
</script>