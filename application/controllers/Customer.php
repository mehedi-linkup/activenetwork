<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Customer extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('userid')){
			redirect (base_url());
		}
		
		// $this->load->model('Admin_model','admin_m');
	}

	public function image_upload($file_name_get){
		$file_name = $file_name_get['name'];
		$file_temp = $file_name_get['tmp_name'];
 
		$div = explode('.', $file_name);
		$get_last_e = end($div);
		$new_name =  rand().'.'.$get_last_e;
		move_uploaded_file($file_temp,'assets/backend/images/customer/'.$new_name);
		return $new_name;
	}

	public function get_customers() {
		$customer = json_decode($this->input->raw_input_stream);

		$clause = '';
		if(isset($customer->id) && $customer->id != 0){
			$clause .= "and c.id = $customer->id"; 
		}
		$result = $this->db->query("
		select
			c.*,
			concat(c.cust_id, ' - ', c.cust_name, ' - ', c.cust_phone)as display_text,
			e.id as e_id,
			e.emp_name,
			a.id as area_id,
			a.name as area_name
		from tbl_customer c 
		inner join tbl_emplyee e on e.id=c.officer_id 
		inner join tbl_area a on a.id=c.area_id 
		where c.status='a'
		$clause
		")->result();
		echo json_encode($result);
	}

	public function add_customer(){
		$data['title']='Add Customer';
		$data['page']='Administration / Add Customer';
		
        $data['cust_list']= $this->db->query("select * from tbl_customer order by id desc")->result();
		$data['backend_content']='customer/customer';
		$this->load->view('admin/layout',$data);
	}

	public function save(){	
		if ($this->input->post('action')=='create') {
			$custId = trim($this->input->post('cust_id'));
			$cust_name=trim($this->input->post('cust_name'));
			$cust_phone=trim($this->input->post('cust_phone'));
			$cust_email=trim($this->input->post('cust_email'));
			$cust_address=trim($this->input->post('cust_address'));
			$officer_id=trim($this->input->post('officer_id'));
			$area=trim($this->input->post('area_id'));
			$entry_date=trim($this->input->post('entry_date'));
			$reconn_date=trim($this->input->post('reconn_date'));
			$inactive_date=trim($this->input->post('inactive_date'));
			$speed_id=$this->input->post('speed_id');
			$previous_due=trim($this->input->post('previous_due'));
			$quantity=trim($this->input->post('quantity'));
			
			$dublicateCode = $this->db->query("select * from tbl_customer where cust_id=?", $custId);
			$dublicatePhone = $this->db->query("select * from tbl_customer where cust_phone=?",$cust_phone);

			if ($cust_name=='') {
				echo "Customer name field is not empty !!";
			}
			else if($custId == '') {
				echo "Customer id field is not empty !!";
			}
			else if($dublicateCode->num_rows() > 0) {
				echo "Custoemr id already exists";
			}
			else if($cust_phone==''){
				echo "Phone number field is not empty !!";
			}
			else if($dublicatePhone->num_rows() > 0){
				echo "Phone number already exists";
			}
			else if($cust_address==''){
				echo "Address field is not empty !!";
			}
			else if($officer_id==0){
				echo "Officer field is not empty !!";
			}
			else if($area==0){
				echo "Area field is not empty !!";
			}
		
			else if($entry_date==''){
				echo "Customer entry field is not empty !!";
			}
			
			else{

				if (!preg_match('/^01[3-9]\d{8}$/',$cust_phone)) {
					echo "This phone number is not valid !";
				}				
				else{
					$totalDishAmount = $this->input->post('dish_amount');
					$totalWifiAmount = $this->input->post('wifi_amount');				
					$data=array(
					    'cust_id'=> $custId,
					    'nid'=> trim($this->input->post('nid')),
						'cust_name'=> $cust_name,
						'cust_father_name'=> trim($this->input->post('cust_father_name')),
						'cust_phone'=> $cust_phone,
						'cust_email'=> $cust_email,
						'cust_address'=> $cust_address,
						'officer_id'=> $officer_id,
						'area_id'=> $area,
						'entry_date'=> $entry_date,
						'type'=> trim($this->input->post('type')),
						'wifi_is_active'=> $this->input->post('wifi_is_active'),
						'dish_amount'=> $this->input->post('dish_amount'),
						'wifi_amount'=> $this->input->post('wifi_amount'),
						'reconn_date'=> $reconn_date,
						'inactive_date'=> $inactive_date,
						'speed_id'=> $speed_id,
						'dish_total'=> $totalDishAmount,
						'wifi_total'=> $totalWifiAmount,
						'connection_fee'=> $this->input->post('connection_fee'),
						'status'=> 'a'
					);

					// print_r($data);
					$result=$this->db->insert('tbl_customer',$data);
					if ($result) {
						echo "success";
					}
					else{
						echo 'false';
					}
				}
			}

		}

		if ($this->input->post('action')=='Update') {
			$id=$this->input->post('action_id');
			$custId = trim($this->input->post('cust_id'));
			$cust_name=$this->input->post('cust_name');
			$cust_phone=$this->input->post('cust_phone');
			$cust_email=$this->input->post('cust_email');
			$cust_address=$this->input->post('cust_address');
			$officer_id=$this->input->post('officer_id');

			$reconn_date=$this->input->post('reconn_date');
			$inactive_date=$this->input->post('inactive_date');
			$speed_id=$this->input->post('speed_id');

			$area=$this->input->post('area_id');
			$entry_date=$this->input->post('entry_date');

			$dublicateCode = $this->db->query("select * from tbl_customer where id != ? and cust_id=?", [$id, $custId]);

			if ($cust_name=='') {
				echo "Customer name field is not empty !!";
			}
			else if($dublicateCode->num_rows() > 0) {
				echo "Custoemr id already exists";
			}
			else if($cust_phone==''){
				echo "Phone number field is not empty !!";
			}
			
			else if($cust_address==''){
				echo "Address field is not empty !!";
			}
			else if($officer_id==0){
				echo "Officer field is not empty !!";
			}
			else if($area==0){
				echo "Area field is not empty !!";
			}
			
			else{

				if (!preg_match('/^01[3-9]\d{8}$/',$cust_phone)) {
					
					echo "This phone number is not valid !";
				}
				
				else{
					$totalDishAmount = $this->input->post('dish_amount');
					$totalWifiAmount = $this->input->post('wifi_amount');
					$data=array(
						'cust_id'=> $custId,
					    'nid'=> trim($this->input->post('nid')),
						'cust_name'=> $cust_name,
						'cust_father_name'=> trim($this->input->post('cust_father_name')),
						'cust_phone'=> $cust_phone,
						'cust_email'=> $cust_email,
						'cust_address'=> $cust_address,
						'officer_id'=> $officer_id,
						'area_id'=> $area,
						'entry_date'=> $entry_date,
						'type'=> trim($this->input->post('type')),
						'wifi_is_active'=> $this->input->post('wifi_is_active'),
						'dish_amount'=> $this->input->post('dish_amount'),
						'wifi_amount'=> $this->input->post('wifi_amount'),
						'reconn_date'=> $reconn_date,
						'inactive_date'=> $inactive_date,
						'speed_id'=> $speed_id,
						'dish_total'=> $totalDishAmount,
						'wifi_total'=> $totalWifiAmount,
						'connection_fee'=> $this->input->post('connection_fee'),
						'status'=> 'a'
					);
					// print_r($data);
					
					$this->db->where('id',$id);
					$resutl=$this->db->update('tbl_customer',$data);
					if ($resutl) {
						echo "updated";
					}
					else{
						return false;
					}
				}
			}	
		}
	}

	public function edit(){
		$id=$this->input->post('id');

		//print_r($id);
		$data=$this->db->query("select c.*,e.id as e_id,a.id from tbl_customer c 
		inner join tbl_emplyee e on e.id=c.officer_id inner join tbl_area a on a.id=c.area_id where c.status='a' and c.id=?",$id)->result();
		//print_r($data);

		$subArray=array();
		foreach ($data as $key => $value) {
		    $subArray['cust_id']=$value->cust_id;
		    $subArray['nid']=$value->nid;
			$subArray['cust_name']=$value->cust_name;
			$subArray['cust_father_name']=$value->cust_father_name;
			$subArray['cust_phone']=$value->cust_phone;
			$subArray['cust_email']=$value->cust_email;
			$subArray['cust_address']=$value->cust_address;
			$subArray['officer_id']=$value->e_id;
			$subArray['area_id']=$value->id;
			$subArray['entry_date']=$value->entry_date;
			$subArray['type']=$value->type;
			$subArray['wifi_is_active']=$value->wifi_is_active;
			$subArray['dish_amount']=$value->dish_amount;
			$subArray['wifi_amount']=$value->wifi_amount;
			$subArray['reconn_date']=$value->reconn_date;
			$subArray['inactive_date']=$value->inactive_date;
			$subArray['speed_id']=$value->speed_id;
			$subArray['dish_total']=$value->dish_total;
			$subArray['wifi_total']=$value->wifi_total;
			$subArray['connection_fee']=$value->connection_fee;
		}
		echo json_encode($subArray);
	}

	public function delete(){
		$id=$this->input->post('id');
		$data=array('status'=>'i', 'type' => 'Inactive');
		$this->db->where('id',$id);
		$result=$this->db->update('tbl_customer',$data);
		if ($result) {
			echo "deleted";
		}else{
			echo "faild";
		}
	}

	public function add_single_report(){

		$data['title']='Customer Report';
		$data['page']='Customer Report';
		$data['backend_content']='customer/single_cust_report';
		$this->load->view('admin/layout',$data);
	}

	public function change_type(){
		$id=$this->input->post('id');
		$selectStatus=$this->db->query("select * from tbl_customer where id=?",$id)->row();
		$status='';
		$type='';

		if ($selectStatus->status == 'a') {
			$status='i';
			$type='Inactive';
		}else if($selectStatus->status=='i'){
			$status='a';
			$type='active';
		}

		$data=array('status'=>$status, 'type' => $type);
		$this->db->where('id',$id);
		$result=$this->db->update('tbl_customer',$data);
		if ($result) {
			echo "update";
		}else{
			echo "faild";
		}
	}

	public function registration(){
		$data['formSlNo'] = $this->db->get("tbl_registration")->num_rows()+1;

		$data['title']='Registration Form';
		$data['page']='Registration';
		$data['backend_content']='customer/registration';
		$this->load->view('admin/layout',$data);

	}
	public function editRegistration($id){
		$data['customer'] = $this->db->where('id', $id)->get("tbl_registration")->row();

		$data['title']='Registration Form';
		$data['page']='Registration';
		$data['backend_content']='customer/edit_registration';
		$this->load->view('admin/layout',$data);

	}
	public function storeRegistration(){
		extract($_POST);
		$code='C';
		$Id = $code.'00001';
		$lastCode = $this->db->query("select id from tbl_customer order by id desc limit 1");
		
		if (!empty($lastCode)) {
			$lastCode = $lastCode->row()->id + 1;
			$zeros = array('0', '00', '000', '0000');
			$Id = "$code" . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
		}
		// $this->image_upload($_FILES['image']);
		$data = array(
			'name' => $name,
			'phone' => $phone,
			'nid' => $nid,
			'father_name'=> $father_name,
			'holding_no'=> $holding_no,
			'house_no'=> $house_no,
			'house_name'=> $house_name,
			'present_address'=> $present_address,
			'pre_post'=> $pre_post,
			'pre_thana'=> $pre_thana,
			'pre_district'=> $pre_district,
			'parament_address'=> $parament_address,
			'par_post'=> $par_post,
			'par_thana'=> $par_thana,
			'par_district'=> $par_district,
			'connection_date'=> $connection_date,
			'connection_fee'=> $connection_fee,
			'image'=> $this->image_upload($_FILES['image'])
		);
		$total = ($cust_bill * $quantity);
		$customer = array(
			'cust_id'=>$Id,
			'cust_name'=>$name,
			'cust_father_name'=>$father_name,
			'cust_phone'=>$phone,
			'cust_address'=>$present_address,
			'officer_id'=>$officer_id,
			'area_id'=>$area_id,
			'cust_bill'=>$cust_bill,
			'entry_date'=>$connection_date,
			'type'=> 'active',
			'quantity'=>$quantity,
			'total_amount'=>$total,
			'status'=>'a'
		);
		// echo '<pre>';
		// print_r($customer);
		$result = $this->db->insert('tbl_customer', $customer);

		$store = $this->db->insert('tbl_registration', $data);
		$id = $this->db->insert_id();
		if($store){
			redirect('print_registration_form/'.$id);
		}else{
            redirect(base_url('registration'));
		}
	}
	public function updateRegistration(){
		extract($_POST);

		$image="";
		if ($_FILES['image']['name'] != "") { 
			$image=$this->image_upload($_FILES['image']);
			$img_unlink='assets/backend/images/customer/'.$this->input->post("old_image");
			unlink($img_unlink);
		}else{
			$image=$this->input->post("old_image");
		}

		$data = array(
			'name' => $name,
			'phone' => $phone,
			'nid' => $nid,
			'father_name'=> $father_name,
			'holding_no'=> $holding_no,
			'house_no'=> $house_no,
			'house_name'=> $house_name,
			'present_address'=> $present_address,
			'pre_post'=> $pre_post,
			'pre_thana'=> $pre_thana,
			'pre_district'=> $pre_district,
			'parament_address'=> $parament_address,
			'par_post'=> $par_post,
			'par_thana'=> $par_thana,
			'par_district'=> $par_district,
			'connection_date'=> $connection_date,
			'connection_fee'=> $connection_fee,
			'image' => $image
		);

		$store = $this->db->where('id', $id)->update('tbl_registration', $data);
		if($store){
			redirect('registration_record');
		}
	}
	public function printRegistrationForm($id){
		$this->load->view('admin/print/registration', $id);
	}
	public function registrationRecord(){
			$this->load->library('pagination');

			$config = array();
        	$config["base_url"] = base_url() . "registration_record";
			$config["total_rows"] = $this->db->where('status', 'a')->get("tbl_registration")->num_rows();
			$config["per_page"] = 10;
			$config["uri_segment"] = 2;

			$config['base_url'] = base_url() . "registration_record";
			$config['total_rows'] = $this->db->where('status', 'a')->get("tbl_registration")->num_rows();
			$config['per_page'] = 10;
			$config["uri_segment"] = 2;

			$config['full_tag_open'] = '<ul class="pagination">';        

			$config['full_tag_close'] = '</ul>';        
	
			$config['first_link'] = 'First';        
	
			$config['last_link'] = 'Last';        
	
			$config['first_tag_open'] = '<li>';        
	
			$config['first_tag_close'] = '</li>';        
	
			$config['prev_link'] = '&laquo';        
	
			$config['prev_tag_open'] = '<li class="prev">';        
	
			$config['prev_tag_close'] = '</li>';        
	
			$config['next_link'] = '&raquo';        
	
			$config['next_tag_open'] = '<li>';        
	
			$config['next_tag_close'] = '</li>';        
	
			$config['last_tag_open'] = '<li>';        
	
			$config['last_tag_close'] = '</li>';        
	
			$config['cur_tag_open'] = '<li class="active"><a href="#">';        
	
			$config['cur_tag_close'] = '</a></li>';        
	
			$config['num_tag_open'] = '<li>';        
	
			$config['num_tag_close'] = '</li>';

			$this->pagination->initialize($config);
			$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			$data['customers'] = $this->db->where('status', 'a')
				->order_by('id', 'DESC')
				->limit($config['per_page'], $page)
				->get("tbl_registration")
				->result();

			$data['links'] = $this->pagination->create_links();


		$data['title']='Registration  Record';
		$data['page']='Registration Record';
		$data['backend_content']='customer/registration_record';
		$this->load->view('admin/layout',$data);
	}

	public function deleteRegistration($id){
		$update = $this->db->where('id', $id)->update("tbl_registration", ['status' => 'd']);
		if($update){
			$this->session->set_flashdata('success', 'Registration was deleted');
			redirect('/registration_record');
		}
	}

	public function change_wifi_type() {
		if($this->input->post('id')) {
			$id=$this->input->post('id');
			$selectWifiType=$this->db->query("select * from tbl_customer where id=?",$id)->row();
			$wifiType = '';

			if ($selectWifiType->wifi_is_active == 'active') {
				$wifiType = 'Inactive';
			}else if($selectWifiType->wifi_is_active == 'Inactive'){
				$wifiType = 'active';
			}

			$data=array('wifi_is_active' => $wifiType);
			$this->db->where('id',$id);
			$result=$this->db->update('tbl_customer',$data);
			if ($result) {
				echo "update";
			}else{
				echo "faild";
			}

		}
	}

}
?>