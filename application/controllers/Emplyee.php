<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Emplyee extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('userid')){
			redirect ();
		}
		
		// $this->load->model('Admin_model','admin_m');
	}
	public function image_upload($file_name_get){
	   $file_name = $file_name_get['name'];
	   $file_temp = $file_name_get['tmp_name'];

	   $div = explode('.', $file_name);
	   $get_last_e = end($div);
	   $new_name =  rand().'.'.$get_last_e;
	   move_uploaded_file($file_temp,'assets/backend/images/'.$new_name);
	   return $new_name;
	}
	public function add_emplyee(){
		
		
		$data['title']='Add Employee';
		$data['page']='Administration / Add Employee';
        $data['emp_list']= $this->db->query("select * from tbl_emplyee where status='a' order by id desc")->result();
		$data['backend_content']='emplyee/emplyee';
		$this->load->view('admin/layout',$data);
	}

	public function save(){
		if ($this->input->post('action') == 'create') {
			$phone=trim($this->input->post('emp_phone'));
			$email=trim($this->input->post('emp_email'));

			if ($email != '' && !preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/',$email)) {
				echo "This email is not valid !";
			}

			if (!preg_match('/^01[3-9]\d{8}$/',$phone)) {
				
				echo "This phone number is not valid !";
			}
			else{


				$data=array(
					'emp_id'=>trim($this->input->post('emp_id')),
					'emp_name'=>trim($this->input->post('emp_name')),
					'emp_phone'=>$phone,
					'emp_email'=>$email,
					'designation'=>trim($this->input->post('designation')),
					'date_of_birth'=>trim($this->input->post('date_of_birth')),
					'salary_range'=>trim($this->input->post('salary_range')),
					'father_name'=>trim($this->input->post('father_name')),
					'mother_name'=>trim($this->input->post('mother_name')),
					'present_address'=>trim($this->input->post('present_address')),
					'permanent_address'=>trim($this->input->post('permanent_address')),
					'gender'=>trim($this->input->post('gender')),
					'emp_entry_date'=>trim($this->input->post('emp_entry_date')),
					'designation'=>trim($this->input->post('designation')),
					'area_id'=>trim($this->input->post('area_id')),
					'image'=>$this->image_upload($_FILES['picture']),
					'status'=>'a'
				);
				// echo '<pre>';
				// print_r($data);
	
				$result= $this->db->insert('tbl_emplyee',$data);
				if ($result) {
					echo "success";
				}
				else{
					return false;
				}
			}
		}	
	

		if ($this->input->post('action')=='Update') {
			$email=trim($this->input->post('emp_email'));
			$phone=trim($this->input->post('emp_phone'));
			
				$image="";
				if ($_FILES['picture']['name'] != "") { 
					$image=$this->image_upload($_FILES['picture']);
					$img_unlink='assets/backend/images/'.$this->input->post("old_image");
					unlink($img_unlink);
				}else{
				 $image=$this->input->post("old_image");
				}

				if ($email != '' && !preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/',$email)) {
						echo "This email is not valid !";
				}

				if (!preg_match('/^01[3-9]\d{8}$/',$phone)) {
					
					echo "This phone number is not valid !";
				}
				else{
					$id=$this->input->post('action_id');
					$data=array(
						'emp_id'=>trim($this->input->post('emp_id')),
						'emp_name'=>trim($this->input->post('emp_name')),
						'emp_phone'=>$phone,
						'emp_email'=>$email,
						'designation'=>trim($this->input->post('designation')),
						'date_of_birth'=>trim($this->input->post('date_of_birth')),
						'salary_range'=>trim($this->input->post('salary_range')),
						'father_name'=>trim($this->input->post('father_name')),
						'mother_name'=>trim($this->input->post('mother_name')),
						'present_address'=>trim($this->input->post('present_address')),
						'permanent_address'=>trim($this->input->post('permanent_address')),
						'gender'=>trim($this->input->post('gender')),
						'emp_entry_date'=>trim($this->input->post('emp_entry_date')),
						'designation'=>trim($this->input->post('designation')),
						'area_id'=>trim($this->input->post('area_id')),
						'image'=>$image
					);
					
					$this->db->where('id',$id);
			       $result=$this->db->update('tbl_emplyee',$data);
					if ($result) {
						echo "update";
					}
					else{
						return false;
					}
				}
			
		}
	}

	public function edit_emp(){
		$id=$this->input->post('id');
		$data=$this->db->query("select * from tbl_emplyee where status ='a' and id=?",$id)->result();

		$subArray=array();
		foreach ($data as $key => $value) {
			$subArray['emp_id']=$value->emp_id;
			$subArray['emp_name']=$value->emp_name;
			$subArray['emp_phone']=$value->emp_phone;
			$subArray['emp_email']=$value->emp_email;
			$subArray['designation']=$value->designation;
			$subArray['salary_range']=$value->salary_range;
			$subArray['present_address']=$value->present_address;
			$subArray['permanent_address']=$value->permanent_address;
			$subArray['father_name']=$value->father_name;
			$subArray['mother_name']=$value->mother_name;
			$subArray['gender']=$value->gender;
			$subArray['date_of_birth']=$value->date_of_birth;
			$subArray['image']=$value->image;
			$subArray['emp_entry_date']=$value->emp_entry_date;
			$subArray['area_id']=$value->area_id;
		}
		echo json_encode($subArray);
	}

	public function delete(){
		$id=$this->input->post('id');
		$data=array('status'=>'d');
		$this->db->where('id',$id);
		$result=$this->db->update('tbl_emplyee',$data);
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

	public function get_employees() {
		$data = json_decode($this->input->raw_input_stream);
		$clause = '';
		if(isset($data->areaId) && $data->areaId != '') {
			$clause .= " and area_id = $data->areaId";
		}

		$employees = $this->db->query("select *, concat(emp_id, ' - ', emp_name)as display_text from tbl_emplyee where status ='a' $clause")->result();
		echo json_encode($employees);
	}
}
?>