<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Report extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('userid')){
			redirect (base_url(''));
		}
	}
    
    public function registration(){
		$this->load->view('admin/print/registration');
	}
    
	public function customer_list(){
		$data['title']='Customer List';
		$data['page']='Report / Customer List';
		$data['backend_content']='report/customer';
		$this->load->view('admin/layout',$data);
	}

	public function all_customer_report(){
		if ($this->input->post('action')=='customerlist') {

			$type = $this->input->post('type');

			
			$from_date=trim($this->input->post('form_date'));
			$to_date=trim($this->input->post('to_date'));

			$clause = '';

			if($type == 1) {
				$clause = "and c.type = 'active'";
			}

			if($type == 2) {
				$clause = "and c.type = 'inactive'";
			}

			if($type == 3) {
				$clause = "and c.wifi_is_active = 'active'";
			}

			if($type == 4) {
				$clause = "and c.wifi_is_active = 'inactive'";
			}

			$search_date = array(
				'from_date'  => $from_date,
				'to_date'  => $to_date,
				'customer_type'  => $type
			);
			$this->session->set_userdata($search_date);

		    $query = $this->db->query("
				select 
					c.cust_id,c.cust_name,cust_father_name,entry_date,reconn_date,inactive_date,c.cust_phone,c.quantity,c.wifi_quantity,c.dish_total, c.wifi_total, c.cust_address,a.name 
				from tbl_customer c 
				inner join  tbl_area a on c.area_id=a.id 
		    	where c.status='a' 
				and c.entry_date 
				between ? and ?
				$clause 
				order by cust_id asc
			",[$from_date,$to_date]);
		    $count=$query->num_rows();
		    $output='';
		    if ($count >0) {
		    	
		    	$data=$query->result();
				// print_r($data);
				
				$j=1;
				if (!empty($data)) {
					foreach($data as $value){
						$output.='
							<tr>
								<td>'.$j++.'</td>
								<td>'.$value->cust_id.'</td>
								<td>'.$value->cust_name.'</td>
								<td>'.$value->cust_father_name.'</td>
								<td>'.$value->cust_phone.'</td>
								<td>'.$value->quantity.'</td>
								<td>'.$value->wifi_quantity.'</td>
								<td>'.$value->dish_total.'</td>
								<td>'.$value->wifi_total.'</td>
								<td>'.$value->name.'</td>
								<td width="10%">'.$value->cust_address.'</td>
								<td>'.$value->entry_date.'</td>
								<td>'.$value->reconn_date.'</td>
								<td>'.$value->inactive_date.'</td>
							</tr>
						';
					}

					$output.='
						<tr> 
							<td colspan="9" class="text-right">Total</td>
							<td>'.$count.'</td>
						</tr>
					';
				}
			}
			else{
					$output.='
						<tr>
							<td colspan="10" class="text-center">No Customer Recode</td>
						</tr>
					';
				}
			echo $output;
		}
	}

	public function customer_print(){
		$type = $this->session->userdata('customer_type');
		$from_date=$this->session->userdata('from_date');
		$to_date=$this->session->userdata('to_date');

		$clause = '';

		if($type == 1) {
			$clause = "and c.type = 'active'";
		}

		if($type == 2) {
			$clause = "and c.type = 'inactive'";
		}

		if($type == 3) {
			$clause = "and c.wifi_is_active = 'active'";
		}

		if($type == 4) {
			$clause = "and c.wifi_is_active = 'inactive'";
		}

		$query=$this->db->query("select c.cust_id,c.cust_name,c.cust_phone,c.quantity,c.wifi_quantity,c.dish_total, c.wifi_total,c.cust_address,a.name from tbl_customer c inner join  tbl_area a on c.area_id=a.id 
		    	where c.status='a' and c.entry_date between ? and ? $clause",[$from_date,$to_date]);
		$data['count']=$query->num_rows();
		$data['printcustomer']=$query->result();

		// unset($_SESSION['customer_type']);
		// unset($_SESSION['to_date']);
		// unset($_SESSION['to_date']);
		$this->load->view('admin/print/print_customer',$data);
	}


	//due customer list

	public function coll_due(){
		$data['title']='Collection Due';
		$data['page']='Collection';
		$data['backend_content']='collection/due_customer';
		$this->load->view('admin/layout',$data);
	}


	// customer due report

	public function due_report(){
		$data['title']='Customer Due';
		$data['page']='Report / Customer Due';
		$data['backend_content']='report/due_customer';
		$this->load->view('admin/layout',$data);
	}

	public function cust_due_report(){
		if ($this->input->post('action')=='duereport') {
			$cust_id=$this->input->post('cust_name');
			$form_month=$this->input->post('form_month');
			$to_month=$this->input->post('to_month');

			$search_data = array(
				'cust_id'  => $cust_id,
				'form_month'  =>$form_month,
				'to_month'  =>$to_month			       
			);
			$this->session->set_userdata($search_data);
			
			$data=$this->db->query("select c.id,c.cust_id,c.cust_name,c.cust_phone,sum(coll.dish_bill)as totalDishDue, sum(coll.wifi_bill)as totalWifiDue,'$form_month' as fromM,
				'$to_month' as toM from tbl_collection coll inner join tbl_customer c on c.id=coll.cust_id where coll.cust_id=? and coll.coll_status='p' and coll.coll_month between ? and ? group by coll.cust_id",[$cust_id,$form_month,$to_month])->result();

			$result=array_map(function($obj){
				$obj->due_months=$this->db->query("select m.month_name from tbl_collection coll left join tbl_month m on coll.coll_month=m.id where coll.cust_id=? and coll.coll_status='p' and coll.coll_month between ? and ?",[$obj->id,$obj->fromM,$obj->toM])->result();
				return $obj;
			}, $data);
			// echo '<pre>';
			// print_r($result);
			// exit;
			$output='';
			$output.='
			
				<div style="margin-bottom: 15px"><a href="'. base_url("due-print").'" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
				<table class="table table-bordered" >
					<thead>
						<th>Customer Id</th>
						<th>Customer Name</th>
						<th>Phone Number</th>
						<th>Due Month</th>
						<th>Dish Due</th>
						<th>Wifi Due</th>	
						<th>Total Amount</th>
					</thead>
					<tbody>
			';
		
			if(!empty($result)){

				
				foreach ($result as $value) {
					$months='';
					foreach($value->due_months as $v){
						$months.=' '.$v->month_name.' ,';
					}
					$output.='
					<tr>
						<td>'.$value->cust_id.'</td>
						<td>'.$value->cust_name.'</td>
						<td>'.$value->cust_phone.'</td>
						
						<td>'.rtrim($months,',').'</td>
						<td class="text-right">'.$value->totalDishDue.'</td>
						<td class="text-right">'.$value->totalWifiDue.'</td>
						<td class="text-right">'.($value->totalDishDue + $value->totalWifiDue).'</td>
					</tr>';
					

				}
			
				
			}else{
				$output.='
					<tr>
						<td colspan="7" style="text-align: center;">No Due</td>		
					</tr>
					</tbody>
				</table>
				';
			}
			//print_r($output);
			echo $output;
		}
	}

	public function print_customer_due(){

	
			$cust_id=$this->session->userdata('cust_id');
			$form_month=$this->session->userdata('form_month');
			$to_month=$this->session->userdata('to_month');

			$data=$this->db->query("select c.id,c.cust_id,c.cust_name,c.cust_phone,sum(coll.dish_bill)as totalDishDue, sum(coll.wifi_bill)as totalWifiDue, '$form_month' as fromM,
				'$to_month' as toM from tbl_collection coll inner join tbl_customer c on c.id=coll.cust_id where coll.cust_id=? and coll.coll_status='p' and coll.coll_month between ? and ? group by coll.cust_id",[$cust_id,$form_month,$to_month])->result();

			$data['printdata']=array_map(function($obj){
				$obj->due_months=$this->db->query("select m.month_name from tbl_collection coll left join tbl_month m on coll.coll_month=m.id where coll.cust_id=? and coll.coll_status='p' and coll.coll_month between ? and ?",[$obj->id,$obj->fromM,$obj->toM])->result();
				return $obj;
			}, $data);

			// unset($_SESSION['cust_id']);
			// unset($_SESSION['form_month']);
			// unset($_SESSION['to_month']);
		
		$this->load->view('admin/print/cust_due_print',$data);
	}

	public function coll_due_list(){
		$data['title']='Customer Due List';
		$data['page']='Report / Customer Due List';
		$data['backend_content']='report/due_list';
		$this->load->view('admin/layout',$data);
	}

	public function due_all_cust(){
		if ($this->input->post('action')=='duelist') {
			$form_month=$this->input->post('form_month');
			$to_month=$this->input->post('to_month');
			$sess_data = array(
				'due_form_month'  =>$form_month,
				'due_to_month'  =>$to_month			       
			);
			$this->session->set_userdata($sess_data);
			$result=$this->db->query("
				select  
					c.cust_name,
					c.cust_phone,
					c.id,
					c.cust_address,
					sum(coll.dish_bill) as totalDishDue,
					sum(coll.wifi_bill) as totalWifiDue,
				'$form_month' as fromM,
				'$to_month' as toM
				from tbl_customer as c
				INNER JOIN tbl_collection as coll
				ON c.id = coll.cust_id
				WHERE  coll.coll_status='p' AND coll.coll_month BETWEEN ? AND ?
				GROUP BY coll.cust_id",[$form_month,$to_month])->result();


			$j=1;
			$sum=0;
			$dish=0;
			$wifi=0;
			$output='';

			$result = array_map(function($obj){
				$obj->due_months =  $this->db->query("select m.month_name from tbl_collection coll left join tbl_month m on coll.coll_month=m.id WHERE   coll.coll_status='p' and coll.cust_id=? and coll.coll_month BETWEEN ? AND ?",[$obj->id,$obj->fromM,$obj->toM])->result();
				return $obj;
			}, $result);
				
			if($result){
				foreach ($result as  $value) {

						$months = '';
						foreach($value->due_months as $v){ 
							$months .= ' '.$v->month_name.' ,';
						}
					$sum=$sum + $value->totalDishDue + $value->totalWifiDue;
					$dish = $dish + $value->totalDishDue;
					$wifi = $wifi + $value->totalWifiDue;
					$output.='
						<tr>
							<td>'.$j++.'</td>
							<td>'.$value->cust_name.'</td>
							<td>'.$value->cust_phone.'</td>
							<td>'.$value->cust_address.'</td>
							<td>'.rtrim($months,',').'</td>
							<td class="text-right">'.$value->totalDishDue.'</td>
							<td class="text-right">'.$value->totalWifiDue.'</td>
							<td class="text-right">'.($value->totalDishDue+$value->totalWifiDue).'</td>	
						</tr>
					';
				}
				$output.='
					<tr>
						<td colspan="5" style="text-align: right;">Total Due</td>
						<td class="text-right">'.$dish.'</td>
						<td class="text-right">'.$wifi.'</td>
						<td class="text-right">'.$sum.'</td>
					</tr>
				';
			}else{
				$output.='
					<tr>
						<td colspan="8" class="text-center">No Customer due</td>
					</tr>
				';
			}
			echo $output;	
		}	
	}


	public function print_all_customer_due(){
		$form_month=$this->session->userdata('due_form_month');
		$to_month=$this->session->userdata('due_to_month');

		$result=$this->db->query("
				select 
					c.cust_name,
					c.cust_phone,
					c.id,
					c.cust_address,
					sum(coll.dish_bill) as totalDishDue,
					sum(coll.wifi_bill) as totalWifiDue,
					'$form_month' as fromM,
					'$to_month' as toM
				from tbl_customer as c
				INNER JOIN tbl_collection as coll
				ON c.id = coll.cust_id
				WHERE coll.coll_status='p' AND coll.coll_month BETWEEN ? AND ?
				GROUP BY coll.cust_id",[$form_month,$to_month])->result();

			$data['printdata'] = array_map(function($obj){
				$obj->due_months =  $this->db->query("select m.month_name from tbl_collection coll left join tbl_month m on coll.coll_month=m.id WHERE   coll.coll_status='p' and coll.cust_id=? and coll.coll_month BETWEEN ? AND ?",[$obj->id,$obj->fromM,$obj->toM])->result();
				return $obj;
			}, $result);
			// print_r($data);
			// exit;

		// unset($_SESSION['due_form_month']);
		// unset($_SESSION['due_to_month']);
		
		$this->load->view('admin/print/all_cust_due',$data);

	}

	public function payment_list(){
		$data['title']='Customer Payment List';
		$data['page']='Report / Payment Collection';
		$data['backend_content']='report/payment_list';
		$this->load->view('admin/layout',$data);
	}

	public function payment_all_cust(){
		$data = json_decode($this->input->raw_input_stream);
		$clauses = '';
		$dateClause = '';

		if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
			$dateClause = " and cl.update_date between '$data->dateFrom' and '$data->dateTo'";
		}

		if(isset($data->areaId) && $data->areaId != '') {
			$clauses .= " and c.area_id = $data->areaId";
		}

		if(isset($data->customerId) && $data->customerId != '') {
			$clauses .= " and c.id = $data->customerId ";
		}

		$collections = $this->db->query("
			select * from (
			select
				c.cust_name,
				c.cust_id as cust_code,
				c.cust_phone,
				a.name,
				(
					select 
						ifnull(sum(cl.dish_bill), 0)
					from tbl_collection cl
					where cl.coll_status = 'a'
					and cl.cust_id = c.id
					$dateClause
				) as dish_bill,
				(
					select 
						ifnull(sum(cl.wifi_bill), 0)
					from tbl_collection cl
					where cl.coll_status = 'a'
					and cl.cust_id = c.id
					$dateClause
				) as wifi_bill,
				(
					select 
						ifnull(sum(cl.discount), 0)
					from tbl_collection cl
					where cl.coll_status = 'a'
					and cl.cust_id = c.id
					$dateClause
				) as discount,
				(select (dish_bill + wifi_bill) - discount) as total
			from tbl_customer c
			join tbl_area a on a.id = c.area_id
			where c.status = 'a'
			$clauses
			)as tbl
			where total > 0
		")->result();

		echo json_encode($collections);
	}

	public function pay_customer_print(){
		$form_month=$this->session->userdata('pay_form_month');
		$to_month=$this->session->userdata('pay_to_month');

		$result=$this->db->query("select  c.cust_name,c.cust_phone,c.id,c.cust_address,
				sum(coll.dish_bill) as totalDishPay,
				sum(coll.wifi_bill) as totalWifiPay,
				'$form_month' as fromM,
				'$to_month' as toM
				from tbl_customer as c
				INNER JOIN tbl_collection as coll
				ON c.id = coll.cust_id
				WHERE coll.coll_status='a' AND coll.coll_month BETWEEN ? AND ?
				GROUP BY coll.cust_id",[$form_month,$to_month])->result();

			$data['printdata'] = array_map(function($obj){
				$obj->payMonthCount =  $this->db->query("SELECT count(coll_status) payMonths FROM tbl_collection WHERE   coll_status='a' and cust_id=? and coll_month BETWEEN ? AND ?",[$obj->id,$obj->fromM,$obj->toM])->result();
				return $obj;
			}, $result);
			// print_r($data);
			// exit;

		// unset($_SESSION['pay_form_month']);
		// unset($_SESSION['pay_to_month']);
		
		$this->load->view('admin/print/all_cust_pay',$data);
	}

	public function payment_cust(){
		$data['title']='Customer Payment';
		$data['page']='Payment Report';
		$data['backend_content']='report/payment_cust';
		$this->load->view('admin/layout',$data);
	}

	public function cust_payment_report(){
		if ($this->input->post('action')=='paymentreport') {
			$cust_id=$this->input->post('cust_name');
			$form_month=$this->input->post('form_month');
			$to_month=$this->input->post('to_month');

			$search_data = array(
				'cust_id'  => $cust_id,
				'form_month'  =>$form_month,
				'to_month'  =>$to_month			       
			);
			$this->session->set_userdata($search_data);

			$data=$this->db->query("SELECT * FROM tbl_collection WHERE cust_id=? AND coll_month between ? AND ? AND coll_status ='a'",[$cust_id,$form_month,$to_month])->result();
			//print_r($data);

			$output='';
			$output.='
				<div style="margin-bottom: 15px"><a href="'. base_url("payment-print").'" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
				<table class="table table-bordered" >
					<thead>
						<th>Serial</th>
						<th>Customer Name</th>
						<th>Phone Number</th>
						<th>Payment Month</th>
						<th>Dish Paid</th>	
						<th>Wifi Paid</th>	
						<th>Total Paid</th>	
							
					</thead>
					<tbody>
			';
			$j=1;
			if(!empty($data)){

				$total=0;
				foreach ($data as $value) {
					$cust_id=$value->cust_id;
					$month_id=$value->coll_month;
					$selectData=$this->db->query("select coll.coll_month,coll.dish_bill,coll.wifi_bill,c.*,m.month_name from tbl_collection as coll inner join tbl_customer as c on c.id=coll.cust_id inner join tbl_month as m on m.id=coll.coll_month where coll.cust_id=? and coll.coll_month =?  and coll.coll_status='a'",[$cust_id,$month_id])->row();
					$subTotal = $selectData->dish_bill + $selectData->wifi_bill;
					$output.='
					<tr>
						<td>'.$j++.'</td>
						<td>'.$selectData->cust_name.'</td>
						<td>'.$selectData->cust_phone.'</td>
						
						<td>'.$selectData->month_name.'</td>
						<td class="text-right">'.$selectData->dish_bill.'</td>
						<td class="text-right">'.$selectData->wifi_bill.'</td>
						<td class="text-right">'.$subTotal.'</td>
					</tr>';
					$total += $subTotal;

				}
			
					$output.='
						<tr>
							<td colspan="6" style="text-align: right;">Sub Total</td>
							<td class="text-right">'.$total.'</td>
								
						</tr>

					';
				
			}else{
				$output.='
					<tr>
						<td colspan="7" style="text-align: center;">No Payment Customer</td>		
					</tr>
					</tbody>
				</table>
				';
			}
			//print_r($output);
			echo $output;
		}
	}

	public function print_customer_payment(){

	
			$cust_id=$this->session->userdata('cust_id');
			$form_month=$this->session->userdata('form_month');
			$to_month=$this->session->userdata('to_month');

			$data['printdata']=$this->db->query("SELECT * FROM tbl_collection WHERE cust_id=? AND coll_month between ? AND ? AND coll_status ='a'",[$cust_id,$form_month,$to_month])->result_array();
			//print_r($data);

			// unset($_SESSION['cust_id']);
			// unset($_SESSION['form_month']);
			// unset($_SESSION['to_month']);
		
		$this->load->view('admin/print/print_customer_payment',$data);
	}

	public function customer_due(){
		$data['title']='Customer Due';
		$data['page']='Due Customer';
		$data['backend_content']='report/due_single_customer';
		$this->load->view('admin/layout',$data);
	}


	public function other_payment(){
		$data['title']='Customer Service Payment';
		$data['page']='Report / Service Payment';
		$data['backend_content']='report/service_payment';
		$this->load->view('admin/layout',$data);
	}

	public function service_report(){
		if ($this->input->post('action')=='servicereport') {
			$cust_id=$this->input->post('cust_id');
			$search_data = array(
				'cust_id'  => $cust_id,			       
			);
			$this->session->set_userdata($search_data);
			$data = $this->db->query("
				select 
					cl.*,
					c.cust_id as cust_code
				from tbl_collection cl
				join tbl_customer c on c.id = cl.cust_id
				where cl.cust_id = ? 
				and cl.coll_status = 'a' 
				and cl.coll_note !=''
				", $cust_id)->result();
			//print_r($data);

			$output="";
			$j=1;
			$sum=0;
			$output='
			
			<div style="margin-bottom: 15px"><a href="'. base_url("service-print").'" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
				<table class="table table-bordered">
					<thead>
						<th>Serial</th>
						<th>Transaction Id</th>
						<th>Customer Id</th>
						<th>Customer Name</th>
						<th>Phone</th>
						<th>Decspiption</th>
						<th>Date</th>
						<th>Amount</th>
					</thead>
					<tbody>
			';

			if (!empty($data)) {
				foreach ($data as $value) {
					$cust_id=$value->cust_id;
					$customerdata=$this->db->query("select * from tbl_customer where id='$cust_id'")->row();

					$output.='
						<tr>
							<td>'.$j++.'</td>
							<td>'.$value->coll_code.'</td>
							<td>'.$customerdata->cust_code.'</td>
							<td>'.$customerdata->cust_name.'</td>
							<td>'.$customerdata->cust_phone.'</td>
							<td>'.$value->coll_note.'</td>
							<td>'.$value->coll_date.'</td>
							<td>'.$value->coll_amount.'</td>
						</tr>';
						$sum=$sum+$value->coll_amount;
				}
				$output.='
						<tr>
							<td colspan="7" style="text-align: right;">Sub Total</td>
							<td>'.$sum.'</td>
						</tr>

					';
			}
			else{
				$output.='
					<tr>
						<td colspan="8" style="text-align: center;">Customer no payment</td>		
					</tr>
					</tbody>
				</table>
				';
			}

			echo $output;
		}
	}

	public function service_report_print(){
		$cust_id=$this->session->userdata('cust_id');
			$data['printdata']=$this->db->query("select * from tbl_collection where cust_id='$cust_id' and coll_status='a' and coll_note !=''")->result_array();
			//print_r($data);
			// unset($_SESSION['cust_id']);
		$this->load->view('admin/print/payment_serviec_print',$data);
	}


	public function expense_report(){
		$data['title']='Expense Report';
		$data['page']='Expense Report';
		$data['backend_content']='report/expense_report';
		$this->load->view('admin/layout',$data);
	}

	public function areawise_due(){
		$data['title']='Areawise Due Report';
		$data['page']='Report / Areawise Due';
		$data['backend_content']='report/area_due';
		$this->load->view('admin/layout',$data);
	}

	public function areawise_cust_due(){
		if ($this->input->post('action')=='areawiseduelist') {
			$month_id = $this->input->post('month_id');
			$area_id =$this->input->post('area_id');
			$session_data = array(
				'month_id'  => $month_id,
				'area_id'  =>$area_id	       
			);
			$this->session->set_userdata($session_data);
			$areaWiseCustomers = $this->db->query("select c.*,'$month_id' as month_id from
			tbl_customer c 
			where c.area_id=?",$area_id)->result();
			$getCollAreaWise = array_map(function($customer){
				   $newColl = $this->db->query("
				   	SELECT coll.*,c.cust_name,c.cust_phone,c.cust_address,m.month_name  from tbl_collection coll
						inner join tbl_customer  c on c.id=coll.cust_id
						inner join  tbl_month  m on m.id=coll.coll_month

				    WHERE coll.cust_id=? and coll.coll_month=? AND coll.coll_status=?",[$customer->id,$customer->month_id,'p'])->result();
				   return $newColl;
				},$areaWiseCustomers);


			    $j=1;

			    $output = '';
			    $total=0;
				$dish = 0;
				$wifi = 0;
				foreach ($getCollAreaWise as $sub){
					$ii=0;


					foreach ($sub as $key => $value) {
						$ii++;


                
						if (!empty($value)) {
							$subtotal = $value->dish_bill + $value->wifi_bill;
							$dish += $value->dish_bill; 
							$wifi += $value->wifi_bill; 
					 $output.='
					<tr>
						<td>'.$j++.'</td>
						<td>'.$value->cust_name.'</td>
						<td>'.$value->cust_phone.'</td>
						<td>'.$value->cust_address.'</td>
						<td>'.$value->month_name.'</td>
						<td class="text-right">'.$value->dish_bill.'</td>
						<td class="text-right">'.$value->wifi_bill.'</td>
						<td class="text-right">'.$subtotal.'</td>
					</tr>
					
				';
				$total=$total + $subtotal;
						}
						

					}
			
			}

			$output.='
						<tr>
							<td colspan="5" style="text-align: right;">Sub Total</td>
							<td class="text-right">'.$dish.'</td>	
							<td class="text-right">'.$wifi.'</td>	
							<td class="text-right">'.$total.'</td>	
						</tr>

					';


			
			echo $output;
		}

	}

	public function areawise_due_print(){
		$month_id=$this->session->userdata('month_id');
		$area_id=$this->session->userdata('area_id');
		$areaWiseCustomers = $this->db->query("select c.*,'$month_id' as month_id from
			tbl_customer c 
			where c.area_id=?",$area_id)->result();
			$data['getCollAreaWise'] = array_map(function($customer){
				   $newColl = $this->db->query("
				   	SELECT coll.*,c.cust_name,c.cust_phone,c.cust_address,m.month_name  from tbl_collection coll
						inner join tbl_customer  c on c.id=coll.cust_id
						inner join  tbl_month  m on m.id=coll.coll_month

				    WHERE coll.cust_id=? and coll.coll_month=? AND coll.coll_status=?",[$customer->id,$customer->month_id,'p'])->result();
				   return $newColl;
				},$areaWiseCustomers);


		// unset($_SESSION['month_id']);
		// unset($_SESSION['area_id']);
		$this->load->view('admin/print/areawise_due',$data);
	}

	public function exp_reports(){
		if ($this->input->post('action')=='expreport') {
			$exp_type=$this->input->post('exp_type');
			$form_date=$this->input->post('form_date');
			$to_date=$this->input->post('to_date');
			$search_date = array(
				'exp_type'  => $exp_type,
				'form_date'  =>$form_date,
				'to_date'  =>$to_date			       
			);
			$this->session->set_userdata($search_date);
			$data=$this->db->query("select ex.*,et.expense_name from tbl_expense ex inner join tbl_exp_type et on ex.exp_type=et.id
				where ex.exp_type=? and ex.exp_date between ? and ?",[$exp_type,$form_date,$to_date])->result();
			
			$output='';
			$output.='
				<div style="margin-bottom: 15px"><a href="'. base_url('expense-print').'" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
				<table class="table table-bordered" >
					<thead>
						<th>Serial</th>
						<th>Exp.Name</th>
						<th>Exp.Type</th>
						<th>Exp.Date</th>
						<th>Decspiption</th>	
						<th>Amount</th>	
							
					</thead>
					<tbody>
			';
			$j=1;
			if(!empty($data)){

				$total=0;
				foreach ($data as $value) {
					$output.='
					<tr>
						<td>'.$j++.'</td>
						<td>'.$value->exp_name.'</td>
						<td>'.$value->expense_name.'</td>
						
						<td>'.$value->exp_date.'</td>
						<td>'.$value->exp_desc.'</td>
						<td>'.$value->exp_amount.'</td>
					</tr>';
					$total=$total+$value->exp_amount;

				}
					$output.='
						<tr>
							<td colspan="5" style="text-align: right;">Sub Total</td>
							<td>'.$total.'</td>
								
						</tr>

					';
				
			}else{
				$output.='
					<tr>
						<td colspan="6" style="text-align: center;">No Expense</td>		
					</tr>
					</tbody>
				</table>
				';
			}
			//print_r($output);
			echo $output;
		}
	}

	public function expense_print(){
		$cust_id=$this->session->userdata('cust_id');

			$exp_type=$this->session->userdata('exp_type');
			$form_date=$this->session->userdata('form_date');
			$to_date=$this->session->userdata('to_date');

			$data['printdata']=$this->db->query("select ex.*,et.expense_name from tbl_expense ex inner join tbl_exp_type et on ex.exp_type=et.id
				where ex.exp_type=? and ex.exp_date between ? and ?",[$exp_type,$form_date,$to_date])->result();
			//print_r($data);

			// unset($_SESSION['exp_type']);
			// unset($_SESSION['form_date']);
			// unset($_SESSION['to_date']);
		
		$this->load->view('admin/print/print_expense',$data);
	}


	public function officer_collection(){
		$data['title']='Officer Collection';
		$data['page']='Officer Collection';
		$data['backend_content']='report/officer_collection';
		$this->load->view('admin/layout',$data);
	}

	public function officer_coll_report(){
		if ($this->input->post('action')=='officercollection') {
			$officer_id = $this->input->post('officer_id');
			$dateFrom = $this->input->post('dateFrom');
			$dateTo = $this->input->post('dateTo');

			$data = $this->db->query("
					SELECT
						cl.update_date,
					    e.emp_id,
					    e.emp_name,
					    e.emp_phone,
						ifnull(sum(cl.dish_bill),0)as dishTotal,
						ifnull(sum(cl.wifi_bill),0)as wifiTotal
					FROM tbl_collection as cl
					JOIN tbl_emplyee as e ON cl.officer_id = e.id
					WHERE coll_status ='a' AND update_date BETWEEN ? AND ?
					GROUP BY update_date
				",[$dateFrom,$dateTo])->result();
			// $coll_month=$this->input->post('coll_month');

			$officer_coll=array(
				'officer_id'=> $officer_id,
				'dateFrom'  => $dateFrom,
				'dateTo'    => $dateTo
			);
			$this->session->set_userdata($officer_coll);


			// $data=$this->db->query("select coll.update_date,sum(coll_amount)as total,e.emp_name,e.emp_phone,m.month_name from tbl_collection coll
			// 	inner join tbl_emplyee e on coll.officer_id=e.id
			// 	inner join tbl_month m on coll.coll_month=m.id
			// 	where coll_status='a' and officer_id=? and coll_month=? group by coll.update_date",[$officer_id,$coll_month])->result();

			//print_r($data);
			$output='';
			$output.='
			<div style="margin-bottom: 15px"><a href="'.base_url('officer-print').'" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
			<table class="table table-striped table-bordered">
					<thead>
						<th>Serial</th>
						<th>Officer Id</th>
						<th>Officer Name</th>
						<th>Phone Number</th>
						<th>Collection Date</th>
						<th>Dish Amount</th>
						<th>Wifi Amount</th>
						<th>Sub Total</th>
					</thead>
					<tbody>';
					if (!empty($data)) {
						$dish = 0;
						$wifi = 0;
						$sum = 0;
						$j=1;
						foreach($data as $value){
							$dish += $value->dishTotal;
							$wifi += $value->wifiTotal;
							$subTotal = $value->dishTotal + $value->wifiTotal;
							$sum += $subTotal;
							$output.='
							<tr>
								<td>'.$j++.'</td>
								<td>'.$value->emp_id.'</td>
								<td>'.$value->emp_name.'</td>
								<td>'.$value->emp_phone.'</td>
								<td>'.$value->update_date.'</td>
								<td class="text-right">'.$value->dishTotal.'</td>
								<td class="text-right">'.$value->wifiTotal.'</td>
								<td class="text-right">'.$subTotal.'</td>
							</tr>
							';
						}
						$output.='
							<tr>
								<td colspan="5" class="text-right">Sub Amount</td>
								<td class="text-right">'.$dish.'</td>
								<td class="text-right">'.$wifi.'</td>
								<td class="text-right">'.$sum.'</td>
							</tr>
						';
						
					}
					else{
						$output.='
							<tr>
								<td colspan="6" class ="text-center">This month is no collection</td>
							</tr>
						';
					}
			
				$output.='</tbody>
				</table>';
			echo $output;
		}
	}

	public function officer_print(){
		// $officer_id=$this->session->userdata('officer_id');
		// $coll_month=$this->session->userdata('coll_month');
		// $data['officercollection']=$this->db->query("select coll.update_date,sum(coll_amount)as total,e.emp_name,e.emp_phone,m.month_name from tbl_collection coll
		// 		inner join tbl_emplyee e on coll.officer_id=e.id
		// 		inner join tbl_month m on coll.coll_month=m.id
		// 		where coll_status='a' and officer_id=? and coll_month=? group by coll.update_date",[$officer_id,$coll_month])->result();

		$officer_id = $this->session->userdata('officer_id');
		$dateFrom = $this->session->userdata('dateFrom');
		$dateTo = $this->session->userdata('dateTo');

		$data['officercollection'] = $this->db->query("
				SELECT
					cl.update_date,
				    e.emp_id,
				    e.emp_name,
				    e.emp_phone,
					ifnull(sum(cl.coll_amount),0)as total
				FROM tbl_collection as cl
				JOIN tbl_emplyee as e ON cl.officer_id = e.id
				WHERE coll_status ='a' AND update_date BETWEEN ? AND ?
				GROUP BY update_date
			",[$dateFrom,$dateTo])->result();
		unset($_SESSION['officer_id']);
		unset($_SESSION['dateFrom']);
		unset($_SESSION['dateTo']);
		$this->load->view('admin/print/officer_print',$data);
	}

	public function user_complaint(){
		$data['title']='Complaint Recode';
		$data['page']='Complaint Recode';
		$data['backend_content']='setting/complaint';
		$data['backend_content']='report/complaint';
		$this->load->view('admin/layout',$data);
	}

	public function complaint_report(){

		if ($this->input->post('action')=='complaintreport') {
            $complaintType=trim($this->input->post('complaintType'));
			$form_date=trim($this->input->post('form_date'));
			$to_date=trim($this->input->post('to_date'));
			$complaint_date=array(
				'complaintType'=>$complaintType,
				'form_date'=>$form_date,
				'to_date'=>$to_date
			);
			$this->session->set_userdata($complaint_date);
			$result=$this->db->query("select cp.id,cp.date,cp.complaint,c.cust_name,c.cust_phone,c.cust_address,a.name as area_name,e.emp_name from tbl_complaint cp inner join tbl_customer c on cp.cust_id=c.id inner join tbl_area a on cp.area_id=a.id inner join tbl_emplyee e on cp.officer_id=e.id where cp.date between ? and? and cp.status=? order by cp.id desc",[$form_date,$to_date,$complaintType])->result();

			// print_r($result);
			$output='';
			$j=1;
			if ($result) {
			foreach ($result as $value) {
				$output.='
					<tr>
						<td>'.$j++.'</td>
						<td>'.$value->cust_name.'</td>
						<td>'.$value->cust_phone.'</td>
						<td>'.$value->cust_address.'</td>
						<td>'.$value->area_name.'</td>
						<td>'.$value->emp_name.'</td>
						<td>'.$value->date.'</td>
						<td style="width:27%">'.$value->complaint.'</td>
					</tr>
				';
				}
			}
			else{
				$output.='
					<tr>
						<td colspan="8" class="text-center">No result found</td>
					</tr>
				';
			}
			echo $output;
		}
	}

	public function complaint_print(){
        $type=$this->session->userdata('type');
		$form_date=$this->session->userdata('form_date');
		$to_date=$this->session->userdata('to_date');
		
		$data['complaint_print']=$this->db->query("select cp.id,cp.date,cp.complaint,c.cust_name,c.cust_phone,c.cust_address,a.name as area_name,e.emp_name from tbl_complaint cp inner join tbl_customer c on cp.cust_id=c.id inner join tbl_area a on cp.area_id=a.id inner join tbl_emplyee e on cp.officer_id=e.id where cp.date between ? and ? and cp.status=? order by cp.id desc",[$form_date,$to_date,$type])->result();

		// unset($_SESSION['type']);

		// unset($_SESSION['form_date']);
		// unset($_SESSION['to_date']);
		$this->load->view('admin/print/complaint',$data);
	}

	public function all_transaction_report(){
		$data['title']='Month Recode';
		$data['page']='Month Recode';
		$data['backend_content']='report/profide';
		$this->load->view('admin/layout',$data);
	}

	public function all_report(){

		if ($this->input->post('action') == 'allrecode') {
			$form_date=trim($this->input->post('form_date'));
			$to_date=trim($this->input->post('to_date'));

			// $salary_total=$this->db->query("select  sum(payment_amount) as s_total from tbl_salary where status='a' and payment_date between ? and ?",[$form_date,$to_date])->row();

			// //print_r($salary_result);

		 // 	$expense_total=$this->db->query("select SUM(exp_amount) as exp_total from tbl_expense where exp_date between ? and ?",[$form_date,$to_date])->row();

		 // 	$service_pay_total=$this->db->query("select SUM(coll_amount) as ser_total from  tbl_collection where coll_note !='' and coll_date between ? and ?",[$form_date,$to_date])->row();

		 // 	//print_r($expense_result);
		 // 	$coll_total=$this->db->query("select sum(coll_amount) as coll_total from tbl_collection where coll_date between ? and ?",[$form_date,$to_date])->row();
		 // 	//print_r($collection_total);

		 // 	$coll_due_total=$this->db->query("select sum(coll_amount) as due_total from tbl_collection where coll_status='p' and coll_date between ? and ? ",[$form_date,$to_date])->row();
		 // 	$coll_pay_total=$this->db->query("select sum(coll_amount) as pay_total from tbl_collection where coll_status='a' and coll_date between ? and ? ",[$form_date,$to_date])->row();


		 	$Recode=$this->db->query("
		 		select 
		 		(select  sum(payment_amount) as s_total from tbl_salary where status='a' and payment_date between ? and ?) as s_total,
		 		(select SUM(exp_amount) as exp_total from tbl_expense where exp_date between ? and ?) as exp_total,
		 		(select SUM(coll_amount) as ser_total from  tbl_collection where coll_note !='' and coll_date between ? and ?) as ser_total,
		 		(select sum(coll_amount) as coll_total from tbl_collection where coll_date between ? and ?)as coll_total,
		 		(select sum(coll_amount) as due_total from tbl_collection where coll_status='p' and coll_date between ? and ?)as due_total,
		 		(select sum(coll_amount) as pay_total from tbl_collection where coll_status='a' and coll_date between ? and ?) as pay_total

		 		",[$form_date,$to_date,$form_date,$to_date,$form_date,$to_date,$form_date,$to_date,$form_date,$to_date,$form_date,$to_date])->row();

		 	 $subtotal=($Recode->coll_total + $Recode->ser_total)-($Recode->s_total + $Recode->exp_total);

		 	//print_r($subtotal);
		 		$output='';
			 	$output.='
			 		<tr>
			 			<td>'.$Recode->coll_total.'</td>
			 			<td>'.$Recode->s_total.'</td>
			 			<td>'.$Recode->exp_total.'</td>
			 			<td>'.$Recode->pay_total.'</td>
			 			<td>'.$Recode->ser_total.'</td>
			 			<td>'.$Recode->due_total.'</td>
			 			<td>'.$subtotal.'</td>
			 		</tr>
			 	';
			 	echo $output;
		 	}
	}
	
	public function areawise_customer(){
		$data['title']='Areawise Customer List';
		$data['page']='Report / Areawise Customer';
		$data['backend_content']='report/areawise_customer';
		$this->load->view('admin/layout',$data);
	}

	public function area_cust_list(){
        if ($this->input->post('action')=='areawisecustomer') {
			$type=$this->input->post('type');
			$area_id=$this->input->post('area');
// 			$area=array('area_id'=>$area_id,'type'=>$type);
// 			$this->session->set_userdata($area);
			$data = $this->db->query("select c.id,c.cust_id,c.cust_name,c.cust_phone,c.cust_address,c.quantity,c.wifi_quantity,a.name as area from tbl_customer c inner join tbl_area a on c.area_id=a.id where c.area_id=? and c.status='a'",$area_id)->result();
			$j=1;

			if ($type ==1) {
				$result = array_map(function($obj){
					$getDueAmount = $this->db->query("select sum(dish_bill)as totalDishBill, sum(wifi_bill)as totalWifiBill from tbl_collection where cust_id=? and coll_status='p'",$obj->id)->row();
					$obj->areawiseDishDue= $getDueAmount->totalDishBill;
					$obj->areawiseWifiDue= $getDueAmount->totalWifiBill;
					return $obj;
				}, $data);

				$final_result = array_map(function($para){
					$para->due_months =$this->db->query("select m.month_name from tbl_collection coll left join tbl_month m on coll.coll_month=m.id where coll.cust_id=? and coll.coll_status='p'",$para->id)->result();
					return $para;
				}, $result);

				$output='';
 

				$output.='
					<div class="col-md-12">
					<div style="margin-bottom: 15px"><a href="'. base_url('print-customerlist/').$type.'/'.$area_id.'" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
					<table class="table table-bordered">
						<thead>
							<th>Sl.</th>
							<th>Customer Id</th>
							<th>Customer Name</th>
							<th>Phone</th>
							<th>Area</th>
							<th>Address</th>
							<th>Due Month</th>
							<th>Dish Due</th>
							<th>Wifi Due</th>
							<th>Sub Total</th>
						</thead>
						<tbody>
				'; 

				if (!empty($final_result)) {
					foreach($final_result as $value){
						$months = '';
						foreach($value->due_months as $v){ 
							$months .= ' '.$v->month_name.' ,';
						}
						//print_r($value->due_months);
						$total = ($value->areawiseDishDue + $value->areawiseWifiDue);
						$output.='
							<tr>
								<td>'.$j++.'</td>
								<td>'.$value->cust_id.'</td>
								<td>'.$value->cust_name.'</td>
								<td>'.$value->cust_phone.'</td>
								<td>'.$value->area.'</td>
								<td>'.$value->cust_address.'</td>
								<td>'.rtrim($months,',').'</td>
								<td>'.$value->areawiseDishDue.'</td>
								<td>'.$value->areawiseWifiDue.'</td>
								<td>'.$total.'</td>
							</tr>
						';
					}
					
				}
				else{
					$output.='
					<tr>
						<td class="text-center" colspan="11"> No result found !!</td>
					</tr>
					';
				}
				$output.='</tbody>
					</table>
				</div>';
				echo $output;
			}
			else if ($type ==2) {
				$output='';
				$output.='
					<div class="col-md-12">
					<div style="margin-bottom: 15px"><a href="'.base_url('print-customerlist/').$type.'/'.$area_id.'" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
					<table class="table table-bordered">
						<thead>
							<th>Serial</th>
							<th>Customer Id</th>
							<th>Customer Name</th>
							<th>Phone Number</th>
							<th>Area</th>
							<th>Address</th>
							
						</thead>
						<tbody>
				';
				if (!empty($data)) {
					foreach($data as $value){
						$output.='
							<tr>
								<td>'.$j++.'</td>
								<td>'.$value->cust_id.'</td>
								<td>'.$value->cust_name.'</td>
								<td>'.$value->cust_phone.'</td>
								<td>'.$value->area.'</td>
								<td>'.$value->cust_address.'</td>
							</tr>
						';
					}
					
				}
				else{
					$output.='
					<tr>
						<td class="text-center" colspan="6"> No result found !!</td>
					</tr>
					';
				}
				$output.='</tbody>
					</table>
				</div>';
				echo $output;
			}
		}
	}

	public function print_areawise_customer($type,$area){
		$type=$type;
    	$area_id=$area;
//     $area_id=$this->session->userdata('area_id');
// 		$type=$this->session->userdata('type');
		$res=$this->db->query("select c.id,c.cust_id,c.cust_name,c.cust_phone,c.cust_address,c.quantity,c.wifi_quantity,a.name as area from tbl_customer c inner join tbl_area a on c.area_id=a.id where c.area_id=? and c.status='a'",$area_id)->result();
		if ($type==1) {
			
			$result= array_map(function($obj){
					$getDueAmount = $this->db->query("select sum(dish_bill)as totalDishDue, sum(wifi_bill)as totalWifiDue from tbl_collection where cust_id=? and coll_status='p'",$obj->id)->row();
					$obj->totalDishDue = $getDueAmount->totalDishDue;
					$obj->totalWifiDue = $getDueAmount->totalWifiDue;
					return $obj;
				}, $res);
			$data['withdue'] = array_map(function($para){
					$para->due_months =$this->db->query("select m.month_name from tbl_collection coll left join tbl_month m on coll.coll_month=m.id where coll.cust_id=? and coll.coll_status='p'",$para->id)->result();
					return $para;
				}, $result);
		}
		else if($type==2){
			$data['withoutdue']=$res;
		}
		
// 		unset($_SESSION['area_id']);
// 		unset($_SESSION['type']);
		$this->load->view('admin/print/areawise_customer',$data);
	}

	public function advance_list(){
		$data['title']='Advance Payment';
		$data['page']='Report / Advance Payment List';
		$data['advancelist']=$this->db->query("select c.cust_id,c.cust_name,c.cust_phone,c.cust_address,c.advance_amount,a.name as area_name from tbl_customer c inner join tbl_area a on c.area_id=a.id where c.status='a' and c.advance_amount !=0")->result();
		$data['backend_content']='report/advance';
		$this->load->view('admin/layout',$data);
	}

	public function advance_payment_ist(){
		if ($this->input->post('action') == 'payment') {
			$options = trim($this->input->post('select-option'));
			$phone = trim($this->input->post('phone'));
			$session_data = array(
				'options'  => $options,
				'phone'  => $phone	       
			);
			$this->session->set_userdata($session_data);
			if ($options == 0) {
				$result = $this->db->query("select c.cust_id,c.cust_name,c.cust_phone,c.cust_address,c.advance_amount,a.name as area_name from tbl_customer c inner join tbl_area a on c.area_id=a.id where c.status='a' and c.advance_amount !=0")->result();
			}
			else{
				if (!empty($phone)) {
					if (!preg_match('/^01[3-9]\d{8}$/',$phone)) {
						echo "<script>alert('This phone number is not valid !')</script>";
						return;
					}
					else{

						$query = $this->db->query("select c.cust_id,c.cust_name,c.cust_phone,c.cust_address,c.advance_amount,a.name as area_name from tbl_customer c inner join tbl_area a on c.area_id=a.id where c.status='a' and c.cust_phone =? and c.advance_amount !=0",$phone);

						if ($query->num_rows() >0) {
							$result = $query->result();
						}
					}
				}
				else{
					echo "<script>alert('Plese enter phone number')</script>";
					return;
				}
			}

			$output = "";

			$output .= '
				<div style="margin-bottom: 15px"><a href="'.base_url("advance-print").'" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
				<table class="table table-bordered">
				<thead>
					<th>Serial</th>
					<th>Customer Id</th>
					<th>Customer Name</th>
					<th>Phone</th>
					<th>Area</th>
					<th>Address</th>
					<th>Advance Amount</th>
				</thead>
			';
			$j = 1;
			$sum = 0;

			if (!empty($result)) {
				foreach ($result as $value) {
					$sum=$sum+$value->advance_amount;
					$output.='
						<tbody>
							<tr>
								<td>'.$j++.'</td>
								<td>'.$value->cust_id.'</td>
								<td>'.$value->cust_name.'</td>
								<td>'.$value->cust_phone.'</td>
								<td>'.$value->area_name.'</td>
								<td>'.$value->cust_address.'</td>
								<td class="text-center">'. $value->advance_amount.'</td>
							</tr>
						</tbody>
					';
				}
				$output.='
					<tr>
						<td colspan="6" class="text-right">total</td>
						<td class="text-center">'.$sum.'</td>
					</tr>
				';
			}
			else{
				$output.= '
						<tr>
							<td colspan="7" class="text-center">No Customer Advance</td>
						</tr>
					</table>
				';
			}

			echo $output;

		}
	}

	public function advance_print(){
		
		$option = $this->session->userdata('options');
		$phone = $this->session->userdata('phone');

		if ($option == 0) {
				$data['advancelist'] = $this->db->query("select c.cust_id,c.cust_name,c.cust_phone,c.cust_address,c.advance_amount,a.name as area_name from tbl_customer c inner join tbl_area a on c.area_id=a.id where c.status='a' and c.advance_amount !=0")->result();
			}
			else{
				if (!empty($phone)) {
					$query = $this->db->query("select c.cust_id,c.cust_name,c.cust_phone,c.cust_address,c.advance_amount,a.name as area_name from tbl_customer c inner join tbl_area a on c.area_id=a.id where c.status='a' and c.cust_phone =? and c.advance_amount !=0",$phone);

					if ($query->num_rows() >0) {
						$data['advancelist'] = $query->result();
					}
				}
				
			}

		// unset($_SESSION['options']);
		// unset($_SESSION['phone']);
		$this->load->view('admin/print/advance_print',$data);
	}
	
	//payment invoice
	
	public function payment_invoice($id){
		$result=$this->db->query("select coll.coll_code,coll.cust_id,coll.coll_amount,coll.update_date,coll.discount,m.month_name from tbl_collection as coll inner join tbl_month as m on coll.coll_month =m.id where coll.coll_master_id=?",$id)->result();
		if (isset($result)) {
			$cust_id=$result[0]->cust_id;
		}
		
		$data['customerinfo']=$this->db->query("select c.cust_name,c.cust_phone,c.cust_address,c.cust_email from tbl_customer as c where c.id=?",$cust_id)->row();

		$data['openingBalance'] = $this->db->query("select opening_balance from tbl_collection_master where id=?",$id)->row();
		$data['printdata']=$result;
		$this->load->view('admin/print/payment_invoice',$data);
	}
	
	public function payment_invoices(){
		$data['title']='Payment Invoice';
		$data['page']='Report / Payment Invoice';
		$data['paymentList']=$this->db->query("select * from  tbl_collection_master  order by id desc")->result();
		$data['backend_content']='report/payment_invoices';
		$this->load->view('admin/layout',$data);
	}

	public function invoice_data(){
		if ($this->input->post("action")=='Invoice') {
			$invoice_id = $this->input->post("paymentInvoice");
			$collMaster = $this->db->query("select recipt_book from tbl_collection_master where id=?", $invoice_id)->row();
			$custId = '';

			$result = $this->db->query("
				select 
					coll.coll_code,
					coll.cust_id,
					coll.coll_amount,
					coll.update_date,
					coll.discount,
					m.month_name 
				from tbl_collection as coll 
				inner join tbl_month as m on coll.coll_month = m.id 
				where coll.coll_master_id = ?
				
			",$invoice_id)->result();
			if (isset($result)) {
				$custId = $result[0]->cust_id;
			}

			$customerinfo = $this->db->query("select c.cust_name,c.cust_phone,c.cust_address,c.cust_email from tbl_customer as c where c.id = ?", $custId)->row();
			
			$session_data=array(
				'invoice_id'=> $invoice_id,
				'cust_id'=> $custId
			);
			$this->session->set_userdata($session_data);
			$output='';

			$output.=' 
				<div class="col-md-10 col-md-offset-1" style="margin-bottom: 15px"><a href="'. base_url("print-invoice").'" target="_blank" style="color:#000;font-size: 16px;"><i class="fa fa-print"></i> print</a></div>
				<h2 class="text-center">Customer Information</h2>

				<div class ="col-md-10 col-md-offset-1">
					<h5><strong>Customer Name <span style="padding:0px 10px"> : </span> </strong> '.$customerinfo->cust_name.'</h5>
					<h5><strong>Mobile <span style="padding-left: 68px;padding-right: 10px;"> :</strong> '.$customerinfo->cust_phone.'</h5>
					<h5><strong>Email <span style="padding-left: 77px;padding-right: 10px;"> : </strong> '.$customerinfo->cust_email.'</h5>
					<h5><strong>Address <span style="padding-left: 60px;padding-right: 10px;">: </strong> '.$customerinfo->cust_address.'</h5>
					<h5><strong>Recipt No <span style="padding-left: 50px;padding-right: 10px;">: </strong> '.$collMaster->recipt_book.'</h5>
				</div>
				<div class="col-md-10 col-md-offset-1" style="padding-top:0px">
				<table id="order-print" class="table table-bordered table-striped">
		        <tr>
		           <th style="text-align:center;width: 5%;font-family: times;font-weight: 500">SI</th>
		           <th style="text-align:center;font-family: times;font-weight: 500">Transaction</th>
		           <th style="text-align:center;font-family: times;font-weight: 500">Month</th>
		           <th style="text-align:center;font-family: times;font-weight: 500">Date</th>
		           <th style="text-align:center;font-family: times;font-weight: 500">Amount</th>
		        </tr>
			';
		
        	$sum=0;
        	$discount=0;
          	$subtotal=0;
        	$j=1;
        	
        		foreach ($result as  $value) {
        		$discount_amount=$value->discount;
        		$sum=$sum+$value->coll_amount+$discount_amount;
        		$discount=$discount+$discount_amount;
            	$output.='
            		<tr align="center">
                    <td>'. $j++ .'</td>
                    <td>'. $value->coll_code.'</td>
                    <td>'. $value->month_name.'</td>
                    <td>'. $value->update_date.'</td>
                    <td>'.($value->coll_amount+$discount_amount).'</td>
                </tr>
            	';
        	}
        	$output.='
        		<tr>
		            <td colspan="4" style="border:0px;text-align: right;">Total : </td>
		            <td style="border:0px; text-align: center;padding: 0px !important">'.$sum.' </td>
		        </tr>
		        <tr>
		          <td colspan="4" style="border:0px;text-align: right;">Discount : </td>
		          <td style="border:0px; text-align: center;padding: 0px !important">'.$discount.'</td>
		        </tr>
		        
		        <tr>
		          
		          <td colspan="4" style="border:0px;text-align: right;">Sub Total : </td>
		          <td style="border:0px; text-align: center;padding: 0px !important">'. $subtotal=($sum -$discount).' </td>
		        </tr>
        	';
			$output.='</table></div>';
			echo $output;
		}
	}

	public function print_invoice(){
		$invoice_id=$this->session->userdata('invoice_id');
		$cust_id=$this->session->userdata('cust_id');
		$data['recipt_no'] = $this->db->query("select recipt_book from tbl_collection_master where id=?", $invoice_id)->row();
		$data['result']=$this->db->query("select coll.coll_code,coll.cust_id,coll.coll_amount,coll.update_date,coll.discount,m.month_name from tbl_collection as coll inner join tbl_month as m on coll.coll_month =m.id where coll.coll_master_id=?",$invoice_id)->result();
		$data['customerinfo']=$this->db->query("select c.cust_name,c.cust_phone,c.cust_address,c.cust_email from tbl_customer as c where c.id=?",$cust_id)->row();
		// unset($_SESSION['invoice_id']);
		// unset($_SESSION['cust_id']);
		$this->load->view('admin/print/print_invoice',$data);
	}

	public function print_invoices($mid, $cid){
		$invoice_id = $mid;
		$cust_id= $cid;
		
		$data['result']=$this->db->query("select coll.coll_code,coll.cust_id,coll.coll_amount,coll.update_date,coll.discount,m.month_name from tbl_collection as coll inner join tbl_month as m on coll.coll_month =m.id where coll.coll_master_id=?",$invoice_id)->result();
		$data['customerinfo']=$this->db->query("select c.cust_name,c.cust_phone,c.cust_address,c.cust_email from tbl_customer as c where c.id=?",$cust_id)->row();
		unset($_SESSION['cust_id']);
		$this->load->view('admin/print/print_invoice',$data);
	}

	public function areawise_payment(){
		$data['title']='Areawise Payment Report';
		$data['page']='Report / Areawise Payment';
		$data['backend_content']='report/areawise_payment';
		$this->load->view('admin/layout',$data);
	}

	public function areawise_customer_payment(){
		if ($this->input->post('action')=='areawisepaidlist') {
			$month_id = $this->input->post('month_id');
			$area_id =$this->input->post('area_id');
			$session_data = array(
				'month_id'  => $month_id,
				'area_id'  =>$area_id	       
			);
			$this->session->set_userdata($session_data);
			$areaWiseCustomers = $this->db->query("
				select
					coll.*,
				    c.*,
				    m.month_name
				from tbl_collection as coll 
					left join tbl_customer as c on coll.cust_id = c.id
					left join tbl_month as m on coll.coll_month = m.id
				where c.area_id =? and coll.coll_month =? and coll.coll_status = 'a'
				",[$area_id,$month_id])->result();



			     $j=1;

			     $output = '';
				 $total = 0;
				 $dish = 0;
				 $wifi = 0;

                
				if (!empty($areaWiseCustomers)) {
					foreach ($areaWiseCustomers as $value) {
						$dish += $value->dish_bill;
						$wifi += $value->wifi_bill;
						$subtotal = ($value->dish_bill + $value->wifi_bill);
						$total = $total + ($value->dish_bill + $value->wifi_bill);
						$output.='
							<tr>
								<td>'.$j++.'</td>
								<td>'.$value->cust_name.'</td>
								<td>'.$value->cust_phone.'</td>
								<td>'.$value->cust_address.'</td>
								<td>'.$value->month_name.'</td>
								<td class="text-right">'.$value->dish_bill.'</td>
								<td class="text-right">'.$value->wifi_bill.'</td>
								<td class="text-right">'.$subtotal.'</td>
							</tr>
						';
					}
					$output.='
						<tr>
							<td colspan="5" style="text-align: right;">Sub Total</td>
							<td class="text-right">'.$dish.'</td>	
							<td class="text-right">'.$wifi.'</td>	
							<td class="text-right">'.$total.'</td>	
						</tr>

					';
				}
				else{
					$output.='
						<tr>
							<td colspan="8" style="text-align: center;">This areawisc customer payment is not found !!</td>
						</tr>

					';
				}

			echo $output;
		}
	}

	public function areawise_paid_print() {
		$month_id=$this->session->userdata('month_id');
		$area_id=$this->session->userdata('area_id');
		$data['areaWiseCustomers'] = $this->db->query("
			select
				coll.*,
			    c.*,
			    m.month_name
			from tbl_collection as coll 
				left join tbl_customer as c on coll.cust_id = c.id
				left join tbl_month as m on coll.coll_month = m.id
			where c.area_id =? and coll.coll_month =? and coll.coll_status = 'a'
			",[$area_id,$month_id])->result();
		// unset($_SESSION['month_id']);
		// unset($_SESSION['area_id']);
		$this->load->view('admin/print/areawise_paid',$data);
	}

	public function monthlyReport() {
		$data['title']='Monthly Collection';
		$data['page']='Report / Monthly Collection';
		$data['backend_content']='report/monthly_colleciton';
		$this->load->view('admin/layout',$data);
	}

	public function getMonthlyCollection() {
		$data = json_decode($this->input->raw_input_stream);

		$collection = $this->db->query("
			select 
				ifnull(sum(cl.dish_bill), 0) as dish,
				ifnull(sum(cl.wifi_bill), 0) as wifi
			from tbl_collection cl
			where cl.coll_status = 'a'
			and cl.update_date between ? and ?
		", [$data->dateFrom, $data->dateTo])->row();

		echo json_encode($collection);
	}

	public function customerLedger() {
		$data['title']='Monthly Collection';
		$data['page']='Report / Customer Ledger';
		$data['backend_content']='report/customer_ledger';
		$this->load->view('admin/layout',$data);
	}

	public function getCustomerLedger() {
		$data = json_decode($this->input->raw_input_stream);

		$customers = $this->db->query("
			select 
				'a' as sequence,
				c.coll_date as date,
				concat('Due bill - ', m.month_name) as description,
				c.coll_amount as bill,
				c.coll_amount as due,
				0.00 as paid,
				0.00 as balance
			from tbl_collection c
			join tbl_month m on m.id = c.coll_month
			where c.coll_status = 'p'
			and c.cust_id = $data->customerId
			and c.coll_date between '$data->dateFrom' and '$data->dateTo'

			UNION
			
			select 
				'b' as sequence,
				c.update_date as date,
				concat('Bill payment - ', m.month_name) as description,
				c.coll_amount as bill,
				0.00 as due,
				c.coll_amount as paid,
				0.00 as balance
			from tbl_collection c
			join tbl_month m on m.id = c.coll_month
			where c.coll_status = 'a'
			and c.cust_id = $data->customerId
			and c.update_date between '$data->dateFrom' and '$data->dateTo'
			
			order by date asc
		")->result();

		echo json_encode($customers);
	}
}
?>