<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *  
 */
class Setting extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('userid')){
			redirect ();
		}
		
		// $this->load->model('Admin_model','admin_m');
	}

	public function add_month(){
		$data['title']='Add Month';
		$data['page']='Setting / Month';
        $data['month']= $this->db->query("select * from tbl_month where status='a' or status='i' order by id desc")->result();
		$data['backend_content']='setting/month';
		$this->load->view('admin/layout',$data);
	}

	public function getMonth() {
		$month = $this->db->query("select * from tbl_month where status = 'a' order by id desc")->result();
		echo json_encode($month);
	}

	public function save_month(){
		if ($this->input->post('action')=='create') {
			$month_name=trim($this->input->post('month_name'));
			$count=$this->db->query("select * from tbl_month where status='a' and month_name=?",$month_name)->num_rows();
			if ($month_name=='') {
				echo "Name field is not empty !!";
			}
			else if($count>0){
				echo "This month already added";
			}
			else{

				$data=array(
					'month_name'=>$month_name,
					'status'=>'a'
				);

				$resutl=$this->db->insert('tbl_month',$data);
				if ($resutl) {
					echo "success";
				}
				else{
					return false;
				}
			}
		}	
	

		if ($this->input->post('action')=='Update') {
			$month_name=trim($this->input->post('month_name'));
			$id=$this->input->post('action_id');
			if ($month_name=='') {
				echo "Name field is not empty !!";
			}
			
			else{

				$data=array(
					'month_name'=>$month_name,
				);
					$this->db->where('id',$id);
				$resutl=$this->db->update('tbl_month',$data);
				if ($resutl) {
					echo "updated";
				}
				else{
					return false;
				}
			}
		}
	}

	public function edit_month(){
		$id=$this->input->post('id');
		$data=$this->db->query("select * from tbl_month where status ='a' and id=?",$id)->result();
		$subArray=array();
		foreach ($data as $key => $value) {
			$subArray['month_name']=$value->month_name;
		}
		echo json_encode($subArray);
	}

	public function delete_month(){
		$id=$this->input->post('id');
		$data=array('status'=>'d');
		$this->db->where('id',$id);
		$result=$this->db->update('tbl_month',$data);
		if ($result) {
			echo "deleted";
		}else{
			echo "faild";
		}
	}

	public function month_status(){
		$id=$this->input->post('id');
		$selectStatus=$this->db->query("select * from tbl_month where id=?",$id)->row();
		$status='';

		if ($selectStatus->status == 'a') {
			$status='i';
		}else if($selectStatus->status=='i'){
			$status='a';
		}

		//print_r($status);
		$data=array('status'=>$status);
		$this->db->where('id',$id);
		$result=$this->db->update('tbl_month',$data);

	}
	
	public function getArea()
	{
		$areas = $this->db->query("select * from tbl_area where status ='a'")->result();
		echo json_encode($areas);
	}

	public function getOfficerwiseArea() {
		$officerId = $this->input->post('officerId');
		$officer = $this->db->query("select * from tbl_emplyee where status = 'a' and id = ?", $officerId)->row();
		$areaId = $officer->area_id;
		$areas = $this->db->query("
			select 
				a.*
			from tbl_area a
			join tbl_emplyee e on e.area_id = a.id
			where a.status = 'a'
			and a.id = ?
		", $areaId)->result();

		echo json_encode($areas);
	}
	public function add_area(){
		$data['title']='Add Area';
		$data['page']='Setting / Area';
        $data['area_list']= $this->db->query("select * from tbl_area where status='a' order by id desc ")->result();
		$data['backend_content']='setting/area';
		$this->load->view('admin/layout',$data);
	}

	public function save_area(){
		if ($this->input->post('action')=='create') {
			$name=trim($this->input->post('name'));
			$code=trim($this->input->post('area_code'));
			if ($name=='') {
				echo "Area name field is not empty !!";
			}
			else if ($code=='') {
				echo "Area code field is not empty !!";
			}
			else{
				$data=array(
					'area_code'=>$code,
					'name'=>$name,
					'status'=>'a'
				);

				$resutl=$this->db->insert('tbl_area',$data);
				if ($resutl) {
					echo "success";
				}
				else{
					return false;
				}
			}	
		}

		if ($this->input->post('action')=='Update') {
			$name=trim($this->input->post('name'));
			$code=trim($this->input->post('area_code'));

			if ($name=='') {
				echo "Name field is not empty !!";
			}
			
			else{

					$id=$this->input->post('action_id');
					$data=array(
						'area_code'=>$code,
						'name'=>$name,
					);

					$this->db->where('id',$id);
			       $result=$this->db->update('tbl_area',$data);
					if ($result) {
						echo "update";
					}
					else{
						return false;
					}
				
			}	
		}
	}

	public function edit_area(){
		$id=$this->input->post('id');
		$result=$this->db->query("select * from tbl_area where status ='a' and id='$id'")->result();
		$subArray=array();
		foreach ($result as $key => $value) {
			$subArray['area_code']=$value->area_code;
			$subArray['name']=$value->name;
		}
		echo json_encode($subArray);
	}

	public function delete_area(){
		$id=$this->input->post('id');
		$data=array('status'=>'d');
		$this->db->where('id',$id);
		$result=$this->db->update('tbl_area',$data);
		if ($result) {
			echo "deleted";
		}else{
			echo "faild";
		}
	}


	//add expense type

	public function add_expense_type(){
		$data['title']='Add Expense Type';
		$data['page']='Expense Type';
		$data['expenselist']=$this->db->query("select * from tbl_exp_type where status='a'")->result();
		$data['backend_content']='setting/add_exp_type';
		$this->load->view('admin/layout',$data);
	}

	public function save_expense_type(){
		if ($this->input->post('action')=='create') {
			$data=array(
				'expense_name'=>trim($this->input->post('expense_name')),
				'status'=>'a'
			);
			// print_r($data);
			$result=$this->db->insert('tbl_exp_type',$data);
			if ($result) {
				echo "success";
			}
			else{
				return false;
			}
		}

		if ($this->input->post('action')=='Update') {
			$data=array(
				'expense_name'=>trim($this->input->post('expense_name')),
				'status'=>'a'
			);
			$id=$this->input->post('action_id');
			$result=$this->db->where('id',$id)->update('tbl_exp_type',$data);
			if ($result) {
				echo 'update';
			}
			else{
				return false;
			}
		}
	}

	public function edit_expense_type(){
		$id=$this->input->post('id');
		$data=$this->db->query("select * from tbl_exp_type where id=?",$id)->result();
		$subArray=array();
		foreach ($data as $key => $value) {
			$subArray['expense_name']=$value->expense_name;
		}
		echo json_encode($subArray);
	}

	public function delete_expense_type(){
		$id=$this->input->post('id');
		$data=array('status'=>'d');
		$result=$this->db->where('id',$id)->update('tbl_exp_type',$data);
		if ($result) {
			echo "deleted";
		}else{
			echo "faild";
		}
	}

	//bill collection

	public function add_collection(){
		$data['title']='Add Bill Collection';
		$data['page']='Bill Collection';
        
		$data['backend_content']='bill/add_bill';
		$this->load->view('admin/layout',$data);
	}



	//view customer

	public function viewCustomer(){
		if ($this->input->post('action')=='view') {
			$selectCustomer=$this->db->query("select c.cust_id,c.cust_name,c.cust_phone,c.cust_address,c.cust_bill,a.area_code,a.name from tbl_customer as c left join tbl_area as a on c.area_id = a.id where c.status = 'a'")->result();

			$output='';
			$j=1;
			foreach ($selectCustomer as $value) {
				$output.='
					<tr>
						<td>'.$j++.'</td>
						<td>'.$value->cust_id.'</td>
						<td>'.$value->cust_name.'</td>
						<td>'.$value->name.'</td>
						<td>'.$value->area_code.'</td>
						<td width="20%">'.$value->cust_address.'</td>
						<td>'.$value->cust_phone.'</td>
						<td>'.date("d m Y").'</td>
						<td>'.$value->cust_bill.'</td>
					</tr>
				';
			}
			echo $output;
		}
	}

	

	public function collection_save(){
		$res = new stdClass;
		try {
			$data = json_decode($this->input->raw_input_stream);
			$count = $this->db->query("select * from tbl_collection where coll_month = ?", $data->monthId);
			if ($count->num_rows() > 0) {
				$res->success = false;
				$res->message = 'This Month already exists !';
				echo json_encode($res);
				exit;
			}

			// all customer
			$customers = $this->db->query("select * from tbl_customer where status = 'a'")->result();

			$newArray = array();
			$lastCode = $this->generateTransactionId();
		
			foreach ($customers as $value) {
				$lastCode += 1;
				$zeros = array('0', '00', '000', '0000');
				$code = "T" . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
				//  code generate end
			
				$bill = [
					'coll_code' => $code,
					'cust_id' => $value->id,
					'cust_name' => $value->cust_name,
					'wifi_bill' => $value->wifi_total,
					'dish_bill' => $value->dish_total,
					'coll_amount' => $value->dish_total + $value->wifi_total,
					'coll_month' => $data->monthId,
					'coll_date' => $data->date,
					'coll_setting_date' => date('Y-m-d H:i:s'),
					'save_by' => $this->session->userdata('name'),
					'save_date' => date('Y-m-d H:i:s'),
					'genarted_by' => $this->session->userdata('userid'),
					'coll_status' => 'p'
				];
				
				array_push($newArray, $bill);
			}

			$this->db->insert_batch('tbl_collection',$newArray);
			$res->success = true;
			$res->message = 'Customer bill generate successfully';

		} catch (\Exception $e) {
			echo 'fail'. $e->getMessage();
		}
		echo json_encode($res);
	}

	public function generateTransactionId(){
		$code = 0;
		$lastCode = $this->db->query("select coll_id from tbl_collection order by coll_id desc limit 1");
		if($lastCode->num_rows() > 0)
			$code = $lastCode->row()->coll_id;
		return $code;
	}

	public function month_recoed(){
		if ($this->input->post('action')=='viewdata') {
			$month=$this->input->post('month');
			$selectMonthdata=$this->db->query("select * from tbl_collection where coll_month=?",$month)->result();
			$j=1;
			$output="";

			foreach ($selectMonthdata as $value) {
				$cust_id=$value->cust_id;
				$selectCustomer=$this->db->query("select c.cust_id,c.cust_name,c.cust_phone,c.cust_address,c.cust_bill,a.area_code,a.name from tbl_customer as c left join tbl_area as a on c.area_id = a.id where c.id=?",$cust_id)->row();
				$output.='
					<tr>
						<td>'.$j++.'</td>
						<td>'.$selectCustomer->cust_id.'</td>
						<td>'.$selectCustomer->cust_name.'</td>
						<td>'.$selectCustomer->name.'</td>
						<td>'.$selectCustomer->area_code.'</td>
						<td width="20%">'.$selectCustomer->cust_address.'</td>
						<td>'.$selectCustomer->cust_phone.'</td>
						<td>'.$value->coll_date.'</td>
						<td>'.$value->coll_amount.'</td>
					</tr>
				';
			}
			echo $output;
		}
	}

	public function single_bill_generate(){
		$data['title']='Add Bill Collection';
		$data['page']='Collection / New Customer Bill';
        
		$data['backend_content']='setting/single_cust_bill';
		$this->load->view('admin/layout',$data);
	}

	public function single_bill_save(){
		$res = new stdClass;
		try {
			$data = json_decode($this->input->raw_input_stream);

			$count = $this->db->query("select * from tbl_collection where cust_id = ? and coll_month = ?", [$data->customerId, $data->monthId]);
	
			if ($count->num_rows() > 0) {
				$res->success = false;
				$res->message = 'This Month already bill generate !';
				echo json_encode($res);
				exit;
			}

			$selectCustomer = $this->db->query("select * from tbl_customer where id = ?", $data->customerId)->row();

			$Id = 'T00001';
			$lastCode = $this->db->query("select coll_id from tbl_collection order by coll_id desc limit 1");
			
			if (isset($lastCode)) {
				$lastCode = $lastCode->row()->coll_id + 1;
				$zeros = array('0', '00', '000', '0000');
				$Id = "T" . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
			}

			$data = array(
				'coll_code' => $Id,
				'cust_id' => $selectCustomer->id,
				'cust_name' => $selectCustomer->cust_name,
				'coll_amount' => ($selectCustomer->dish_total + $selectCustomer->wifi_total),
				'coll_month' => $data->monthId,
				'coll_date' => date('Y-m-d'),
				'coll_setting_date' => date('Y-m-d H:i:s'),
				'save_by' => $this->session->userdata('name'),
				'save_date' => date('Y-m-d H:i:s'),
				'genarted_by' => $this->session->userdata('userid'),
				'coll_status' => 'p',
				'dish_bill' => $selectCustomer->dish_total,
				'wifi_bill' => $selectCustomer->wifi_total,
			);

			$this->db->insert('tbl_collection',$data);

			$res->success = true;
			$res->message = 'Bill generate successfully';

		} catch (\Exception $e) {
			$res->success = false;
			$res->message = 'fail '. $e->getMessage();
		}

		echo json_encode($res);

	}

	//customer payment
	public function customer_service_payment(){
		$data['title'] = 'Customer Service Payment';
		$data['page'] = 'Service Payment';
		$data['backend_content'] = 'setting/customer_payment';
		$this->load->view('admin/layout',$data);
	}

	public function pay_customer(){
		if ($this->input->post('action')=='payment') {
			$transaction_id=$this->input->post('transaction_id');
			
			$customer_id=$this->input->post('customer_name');
			$payment_date=$this->input->post('payment_date');
			$description=$this->input->post('description');
			$amount=$this->input->post('amount');

			$data=array(
				'coll_code'=>$transaction_id,
				'cust_id'=>$customer_id,
				'coll_date'=>$payment_date,
				'coll_note'=>$description,
				'coll_amount'=>$amount,
				'coll_status'=>'a'
			);

			//print_r($data);

			$result=$this->db->insert('tbl_collection',$data);
			if ($result) {
				echo "payment";
			}else{
				return false;
			}
			
		}
	}

	public function add_expense(){
		$data['title']='Add Expense';
		$data['page']='Expense';
		$data['expenses']=$this->db->query("select ex.*,et.expense_name from tbl_expense ex inner join  tbl_exp_type et on ex.exp_type=et.id where ex.status='a' order by ex.id desc")->result();
		$data['backend_content']='setting/expense';
		$this->load->view('admin/layout',$data);
	}

	public function save_exp(){
		if ($this->input->post('action')=='expense') {
			$exp_name=$this->input->post('exp_name');
			$exp_type=$this->input->post('exp_type');
			$exp_date=$this->input->post('exp_date');
			$exp_desc=$this->input->post('exp_desc');
			$exp_amount=$this->input->post('exp_amount');

			$data=array(
				'exp_name'=>$exp_name,
				'exp_type'=>$exp_type,
				'exp_amount'=>$exp_amount,
				'exp_date'=>$exp_date,
				'exp_desc'=>$exp_desc,
				'status'=>'a'
			);
			//print_r($data);
			$result=$this->db->insert('tbl_expense',$data);
			if ($result) {
				echo "success";
			}
			else{
				return false;
			}
		}
		if ($this->input->post('action')=='Update') {
			$exp_name=$this->input->post('exp_name');
			$exp_type=$this->input->post('exp_type');
			$exp_date=$this->input->post('exp_date');
			$exp_desc=$this->input->post('exp_desc');
			$exp_amount=$this->input->post('exp_amount');

			$data=array(
				'exp_name'=>$exp_name,
				'exp_type'=>$exp_type,
				'exp_amount'=>$exp_amount,
				'exp_date'=>$exp_date,
				'exp_desc'=>$exp_desc
				
			);
			//print_r($data);
			$id=$this->input->post('action_id');
			$this->db->where('id',$id);
			$result=$this->db->update('tbl_expense',$data);
			if ($result) {
				echo "update";
			}
			else{
				return false;
			}
		}
	}

	public function edit_exp(){
		if ($this->input->post('id')) {
			$id=$this->input->post('id');
			$select=$this->db->query("select * from tbl_expense where id=?",$id)->result();
			$subArray=array();
			foreach ($select as $key => $value) {
				$subArray['exp_name']=$value->exp_name;
				$subArray['exp_type']=$value->exp_type;
				$subArray['exp_date']=$value->exp_date;
				$subArray['exp_desc']=$value->exp_desc;
				$subArray['exp_amount']=$value->exp_amount;
			}
			echo json_encode($subArray);
		}
	}

	public function delete_exp(){
		if ($this->input->post('id')) {
			$id=$this->input->post('id');
			$data=array('status'=>'d');
			$this->db->where('id',$id);
			$result=$this->db->update('tbl_expense',$data);
			if ($result) {
				echo "delete";
			}
			else {
				return false;
			}
		}
	}


	public function add_salary(){
		$data['title']='Add Salary';
		$data['page']='Salary';
		$data['salarylist']=$this->db->query("select s.*,e.emp_name,m.month_name from tbl_salary s inner join tbl_month m on s.month_id=m.id inner join tbl_emplyee e on s.emp_id=e.id where s.status='a'")->result();
		$data['backend_content']='setting/salary';
		$this->load->view('admin/layout',$data);
	}

	public function save_salary(){
		if ($this->input->post('action')=='create') {
			$emp_id=$this->input->post('emp_id');
			$month=$this->input->post('month_id');

			$count=$this->db->query("select * from tbl_salary where emp_id=? and month_id=?",[$emp_id,$month])->num_rows();
			if ($count >0) {
				echo 'already salary  added';
			}
			else{
				$data=array(
					'emp_id'=>$emp_id,
					'month_id'=>$month,
					'payment_amount'=> trim($this->input->post('payment_amount')),
					'payment_date'=>trim($this->input->post('payment_date')),
					'payment_note'=>trim($this->input->post('payment_note')),
					'status'=>'a'
				);
				//print_r($data);

				$result=$this->db->insert('tbl_salary',$data);
				if ($result) {
					echo "inserted";
				}
				else {
					return false;
				}
			}
		}

		if ($this->input->post('action')=='Update') {
			$emp_id=$this->input->post('emp_id');
			$month=$this->input->post('month_id');
			$id=$this->input->post('action_id');
			$data=array(
				'emp_id'=>$emp_id,
				'month_id'=>$month,
				'payment_amount'=> trim($this->input->post('payment_amount')),
				'payment_date'=>trim($this->input->post('payment_date')),
				'payment_note'=>trim($this->input->post('payment_note'))
				
			);
			//print_r($data);

			$result=$this->db->where('id',$id)->update('tbl_salary',$data);
			if ($result) {
				echo "updated";
			}
			else {
				return false;
			}
			
		}
	}

	public function edit_salary(){
		if ($this->input->post('id')) {
			$id=$this->input->post('id');
			$result=$this->db->query("select * from tbl_salary where id=? and status='a'",$id)->result();
			$subArray=array();
			// print_r($result);
			foreach ($result as $key => $value) {
				$subArray['emp_id']=$value->emp_id;
				$subArray['month_id']=$value->month_id;
				$subArray['payment_amount']=$value->payment_amount;
				$subArray['payment_date']=$value->payment_date;
				$subArray['payment_note']=$value->payment_note;
			}
			echo json_encode($subArray);
		}
	}

	public function delete_salary(){
		if ($this->input->post('id')) {
			$id=$this->input->post('id');
			$data=array('status'=>'d');
			
			$result=$this->db->where('id',$id)->update('tbl_salary',$data);
			if ($result) {
				echo "delete";
			}
			else {
				return false;
			}
		}
	}

	public function add_complaint(){
		$data['title']='Add Complains';
		$data['page']='Complains';
		$data['complaintlist']=$this->db->query("select cp.id,cp.date,cp.complaint,c.cust_name,c.cust_phone,c.cust_address,cp.status,a.name as area_name,e.emp_name from tbl_complaint cp inner join tbl_customer c on cp.cust_id=c.id inner join tbl_area a on cp.area_id=a.id inner join tbl_emplyee e on cp.officer_id=e.id where cp.status='p' or cp.status='c'  order by cp.id desc")->result();
		$data['backend_content']='setting/complaint';
		$this->load->view('admin/layout',$data);
	}

	public function save_complaint(){
		if ($this->input->post('action')=='complaint') {
			$data=array(
				'cust_id'=>trim($this->input->post('cust_id')),
				'area_id'=>trim($this->input->post('area_id')),
				'officer_id'=>trim($this->input->post('officer_id')),
				'date'=>trim($this->input->post('date')),
				'complaint'=>trim($this->input->post('complaint')),
				'status'=>'p'
			);

			// print_r($data);
			$result=$this->db->insert('tbl_complaint',$data);
			if ($result) {
				echo "success";
			}
			else{
				return false;
			}
		}

		if ($this->input->post('action')=='Update') {
			$id=$this->input->post('action_id');
			$data=array(
				'cust_id'=>trim($this->input->post('cust_id')),
				'area_id'=>trim($this->input->post('area_id')),
				'officer_id'=>trim($this->input->post('officer_id')),
				'date'=>trim($this->input->post('date')),
				'complaint'=>trim($this->input->post('complaint'))
			);
			//print_r($data);
			$result=$this->db->where('id',$id)->update('tbl_complaint',$data);
			if ($result) {
				echo 'update';
			}
		}
	}	

	public function edit_complaint(){
		if ($this->input->post('id')) {
			$id=$this->input->post('id');
			$data=$this->db->query("select * from tbl_complaint where id=?",$id)->result();
			$subArray=array();
			foreach ($data as $key => $value) {
				$subArray['cust_id']=$value->cust_id;
				$subArray['area_id']=$value->area_id;
				$subArray['officer_id']=$value->officer_id;
				$subArray['complaint']=$value->complaint;
				$subArray['date']=$value->date;
			}
			echo json_encode($subArray);
		}
	}

	public function delete_complaint(){
		if ($this->input->post('id')) {
			$id=$this->input->post('id');
			$data=array('status'=>'d');
			
			$result=$this->db->where('id',$id)->update('tbl_complaint',$data);
			if ($result) {
				echo "delete";
			}
			else {
				return false;
			}
		}
	}
	
	public function change_status(){
		if ($this->input->post('id')) {
			$id=$this->input->post('id');
			$result=$this->db->query("update tbl_complaint set status='c' where id=?",$id);
			if ($result) {
				echo 'change';
			}
			else{
				return false;
			}
		}
	}

	public function add_account(){
		$data['title']='Add Account';
		$data['page']='Setting / Account';
		$data['accountlist']=$this->db->query("select * from tbl_account where status='a'")->result();
		$data['backend_content']='setting/account';
		$this->load->view('admin/layout',$data);
	}

	public function save_account(){
		if ($this->input->post("action")=='create') {
			$data=array(
				'account_name'=>trim($this->input->post('account_name')),
				'account_desc'=>trim($this->input->post('account_desc')),
				'save_date'=>date('Y-m-d'),
				'status'=>'a'
			);
			// print_r($data);
			$result=$this->db->insert('tbl_account',$data);
			if ($result) {
				echo 'success';
			}
			else{
				return false;
			}
		}

		if ($this->input->post('action')=='Update') {
			$id=$this->input->post('action_id');
			$data=array(
				'account_name'=>trim($this->input->post('account_name')),
				'account_desc'=>trim($this->input->post('account_desc')),
				'updata_date'=>date('Y-m-d')
			);
			$result=$this->db->where('id',$id)->update('tbl_account',$data);
			if ($result) {
				echo 'update';
			}
			else{
				return false;
			}
		}

	}

	public function edit_account(){
		$id=$this->input->post('id');
		$data=$this->db->query("select * from tbl_account where id=?",$id)->result();
		$subArray=array();
		foreach ($data as $key => $value) {
			$subArray['account_name']=$value->account_name;
			$subArray['account_desc']=$value->account_desc;
		}
		echo json_encode($subArray);
	}

	public function delete_account(){
		if ($this->input->post('id')) {
			$id=$this->input->post('id');
			$data=array('status'=>'d');
			
			$result=$this->db->where('id',$id)->update('tbl_account',$data);
			if ($result) {
				echo "delete";
			}
			else {
				return false;
			}
		}
	}

	public function add_transaction(){
		$data['title']='Add Transaction';
		$data['page']='Transaction / Cash Transaction';
		$data['transactionlist']=$this->db->query("select t.*,a.account_name from tbl_transaction t inner join tbl_account a on t.account_id=a.id where t.tr_status='a' order by t.id desc")->result();
		$data['backend_content']='setting/transaction';
		$this->load->view('admin/layout',$data);
	}

	public function save_transaction(){
		if ($this->input->post('action')=='create') {
			$data=array(
				'tr_id'=>trim($this->input->post('tr_id')),
				'tr_type'=>trim($this->input->post('tr_type')),
				'voucher_no'=>trim($this->input->post('voucher_no')),
				'account_id'=>trim($this->input->post('account_id')),
				'tr_date'=>trim($this->input->post('tr_date')),
				'tr_desc'=>trim($this->input->post('tr_desc')),
				'tr_amount'=>trim($this->input->post('tr_amount')),
				'tr_status'=>'a',
				'create_by'=>$this->session->userdata('userid'),
				'create_date'=>date('Y-m-d')
			);
			//print_r($data);
			$result=$this->db->insert('tbl_transaction',$data);
			if ($result) {
				echo 'success';
			}
			else{
				return false;
			}
		}
		if ($this->input->post('action')=='Update') {
			$data=array(
				'tr_id'=>trim($this->input->post('tr_id')),
				'tr_type'=>trim($this->input->post('tr_type')),
				'voucher_no'=>trim($this->input->post('voucher_no')),
				'account_id'=>trim($this->input->post('account_id')),
				'tr_date'=>trim($this->input->post('tr_date')),
				'tr_desc'=>trim($this->input->post('tr_desc')),
				'tr_amount'=>trim($this->input->post('tr_amount')),
				'update_by'=>$this->session->userdata('userid'),
				'update_date'=>date('Y-m-d')
			);
			//print_r($data);
			$id=$this->input->post('action_id');
			$result=$this->db->where('id',$id)->update('tbl_transaction',$data);
			if ($result) {
				echo 'update';
			}
			else{
				return false;
			}
		}
	}

	public function edit_transaction(){
		$id=$this->input->post('id');
		$data=$this->db->query("select * from tbl_transaction where id=? order by id desc",$id)->result();
		$subArray=array();
		foreach ($data as $value) {
			$subArray['tr_id']=$value->tr_id;
			$subArray['tr_type']=$value->tr_type;
			$subArray['account_id']=$value->account_id;
			$subArray['tr_date']=$value->tr_date;
			$subArray['tr_desc']=$value->tr_desc;
			$subArray['tr_amount']=$value->tr_amount;
			$subArray['voucher_no']=$value->voucher_no;
		}
		echo json_encode($subArray);
	}

	public function delete_transaction(){
		if ($this->input->post('id')) {
			$id=$this->input->post('id');
			$data=array('tr_status'=>'d');
			
			$result=$this->db->where('id',$id)->update('tbl_transaction',$data);
			if ($result) {
				echo "delete";
			}
			else {
				return false;
			}
		}
	}

	public function cash_view(){
		$data['title']='Add Transaction';
		$data['page']='Transaction / Cash View';
		$data['backend_content']='setting/cash_transaction';
		$this->load->view('admin/layout',$data);
	}
	
	public function cash_transaction(){
		if ($this->input->post('action')=='viewcash') {
			$form_date=trim($this->input->post('from_date'));
			$to_date=trim($this->input->post('to_date'));
			$data=$this->db->query("select (select sum(coll_amount)as pay_total from tbl_collection where coll_status='a' and update_date between ? and ?) as payment,
				(select sum(coll_amount)as due_total from tbl_collection where coll_status='p')as due,
				(select sum(exp_amount)as total_amount from  tbl_expense where  exp_date between ? and ?)as total_expense,
				(select sum(tr_amount)as receive_total from tbl_transaction where tr_type=1 and tr_date between ? and ?)as cash_recive,
				(select sum(tr_amount)as payment_total from tbl_transaction where tr_type=2 and tr_date between ? and ?)as cash_payment",[$form_date,$to_date,$form_date,$to_date,$form_date,$to_date,$form_date,$to_date])->row();
			//print_r($data);

			$payment_receive=0;
			$cash_recive=0;
			$cash_payment=0;
			$expense=0;
			
			$cash_in_hand=0;
			if ($data->payment!=0) {
				$payment_receive=$data->payment;
			}
			
			if ($data->total_expense !=0) {
				$expense=$data->total_expense;
			}
			if ($data->cash_recive !=0) {
				$cash_recive=$data->cash_recive;
			}
			if ($data->cash_payment !=0) {
				$cash_payment=$data->cash_payment;
			}

			$cash_in_hand=(($payment_receive + $cash_recive)-($cash_payment+$expense));
			// $customer_payment=$this->db->query("select sum(coll_amount)as payment from tbl_collection where coll_status='a' and update_date between ? and ?",[$form_date,$to_date])->row();
			// $customer_due=$this->db->query("select sum(coll_amount)as due from tbl_collection where coll_status='p' and update_date between ? and ?",[$form_date,$to_date])->row();

			// $cashrecive=$this->db->query("select sum(tr_amount)as receive_total from tbl_transaction where tr_type=2 and tr_date between ? and ?",[$form_date,$to_date])->row();

			// $cashpayment=$this->db->query("select sum(tr_amount)as cash_pay from tbl_transaction where tr_type=2 and tr_date between ? and ?",[$form_date,$to_date])->row();

			// //$total_coll=$cust_payment+$cust_due;
			// $expense=$this->db->query("select sum(exp_amount)as total_amount from  tbl_expense where  exp_date between ? and ?",[$form_date,$to_date])->row();

			// $cash_in_hand=(($cashrecive->receive_total+$customer_payment->payment)-($cashpayment->cash_pay+$expense->total_amount));

			$output='
				<div class="col-md-6">
					<div class="view-transaction">
						<div class="fa fa-money fa-3x"></div>
						<h2 style="margin:0px">Payment Receive</h2>
						
						<h3>tk. '.($payment_receive +$cash_recive).'</h3>
					</div>
				</div>
				

				<div class="col-md-6">
					<div class="view-transaction">
						<div class="fa fa-dollar fa-3x"></div>
						<h2 style="margin:0px">Cash Payment</h2>
						
						<h3>tk. '.($cash_payment + $expense).' </h3>
					</div>
				</div>
				<div class="col-md-6">
					<div class="view-transaction">
						<div class="fa fa-money fa-3x"></div>
						<h2 style="margin:0px">Cash In Hand</h2>
						
						<h3>tk. '.$cash_in_hand.'</h3>
					</div>
				</div>

				<div class="col-md-6">
					<div class="view-transaction">
						<div class="fa fa-money fa-3x"></div>
						<h2 style="margin:0px">Customer Due</h2>
						<h3>tk. '.$data->due.'</h3>
					</div>
				</div>
			';
			echo $output;
		}
	}

	public function speed() {
		$data['title']='Add Speed';
		$data['page']='Setting / Speed';
		$data['speed_list']= $this->db->query("select * from tbl_speed where status = 'a'")->result();

		$data['backend_content']='setting/speed';
		$this->load->view('admin/layout',$data);
	}

	public function saveSpeed() {
		try {
			if ($this->input->post('action')=='create') {
				$name=trim($this->input->post('name'));
				$amount=trim($this->input->post('amount'));
				$duplicateName = $this->db->query("select name from tbl_speed where name = ? and status = 'a'", $name)->num_rows();
				if ($name=='') {
					echo "Speed name field is not empty !!";
				}
				else if ($amount=='') {
					echo "Amount field is not empty !!";
				}
				else if ($duplicateName > 0) {
					echo "This $name already exists !!";
				}
				else{
					$data=array(
						'name'=> $name,
						'amount'=> $amount,
						'status'=> 'a',
						'save_date' => date('Y-m-d')
					);
	
					$resutl=$this->db->insert('tbl_speed',$data);
					if ($resutl) {
						echo "success";
					}
					else{
						return false;
					}
				}	
			}
	
			if ($this->input->post('action')=='Update') {
				$name=trim($this->input->post('name'));
				$amount=trim($this->input->post('amount'));
	
				if ($name=='') {
					echo "Name field is not empty !!";
				} else if ($amount=='') {
					echo "Amount field is not empty !!";
				} else{
					$id=$this->input->post('action_id');
					$data=array(
						'name'=> $name,
						'amount'=> $amount,
						'update_date' => date('Y-m-d')
					);

					$this->db->where('id',$id);
					$result=$this->db->update('tbl_speed',$data);
					if ($result) {
						echo "update";
					} else{
						return false;
					}
					
				}	
			}
		} catch (\Exception $e) {
			//throw $th;
		}
	}

	public function editSpeed(){
		$id=$this->input->post('id');
		$result=$this->db->query("select * from tbl_speed where status ='a' and id='$id'")->result();
		$subArray=array();
		foreach ($result as $key => $value) {
			$subArray['name']=$value->name;
			$subArray['amount']=$value->amount;
		}
		echo json_encode($subArray);
	}

	public function deleteSpeed(){
		$id=$this->input->post('id');
		$data=array('status'=>'d');
		$this->db->where('id',$id);
		$result=$this->db->update('tbl_speed',$data);
		if ($result) {
			echo "deleted";
		}else{
			echo "faild";
		}
	}
}
?>