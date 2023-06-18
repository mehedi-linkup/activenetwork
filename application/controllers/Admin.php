<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Admin extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		// if (isset(!$_SESSION['userid'])){
		// 	redirect ('admin');
		// }
		
		$this->load->model('Admin_model','admin_m');
	}

	public function login(){
		
		if (isset($_SESSION['userid'])){
			redirect (base_url().'dashboard');
		}
		$data['title']='Admin Login Page';
		$this->load->view('admin/index',$data);
	}
  
	public function login_in(){

        if ($this->input->post('action')=='login')
        {
           $user_name=$this->input->post('user_name');
           $pass=$this->input->post('password');
        //   $password=md5($pass);
           $new_pass=md5($pass); 
          
           if (empty($user_name)) {
           		echo 'This Username field is not empty';
           }
           else if(empty($pass)){
           	 echo 'This Password field is not empty';
           }
           else{
           		$result=$this->admin_m->user_login($user_name,$new_pass);
          
	           if ($result) {
	           	
	           		$data = array(
					        'userid'  => $result[0]['id'],
					        'username'  =>$result[0]['user_name'],
					        'name'  =>$result[0]['full_name'],
					        'email'     =>$result[0]['email'],
					        'image'     =>$result[0]['image'],
					        'type'     =>$result[0]['type'],
					        'logged_in' => TRUE
					);

					$this->session->set_userdata($data);
					echo 'success';

	           }
	           else
	           {
	           		
	           		echo "User Name or Password not match";
	           }
           }
           
    	}
        
	}

	public function dashboard(){
		if (!$_SESSION['userid']){
			redirect (base_url());
		 }
		$data['title']='Dashboard';
		$data['page']='Home';
		$data['backend_content']='administator/home';
		$this->load->view('admin/layout',$data);
	}

	public function logout(){
		unset($_SESSION['userid']);
		unset($_SESSION['username']);
		unset($_SESSION['email']);
		session_destroy();
		redirect (base_url());
	}
	

	//create admin

	public function image_upload($file_name_get){
	   $file_name = $file_name_get['name'];
	   $file_temp = $file_name_get['tmp_name'];

	   $div = explode('.', $file_name);
	   $get_last_e = end($div);
	   $new_name =  rand().'.'.$get_last_e;
	   move_uploaded_file($file_temp,'assets/backend/images/'.$new_name);
	   return $new_name;
	}

	


	public function company_profile(){
		$data['title']='Compnay Profile';
		$data['page']='Administration / Company Profile';
		$data['cominfo'] = $this->db->query("select * from tbl_profile limit 1 ")->row();
		$data['backend_content']='administator/company';
		$this->load->view('admin/layout',$data);
	}

	public function update_profile(){
		if ($this->input->post('action')=='update') {

			$image="";
			if ($_FILES['picture']['name'] != "") { 
				$image=$this->image_upload($_FILES['picture']);
				$img_unlink='assets/backend/images/'.$this->input->post("old_image");
				unlink($img_unlink);
			}else{
			 	$image=$this->input->post("old_image");
			}

			$data=array(
				'com_name'=>trim($this->input->post('com_name')),
				'com_email'=>trim($this->input->post('com_email')),
				'com_phone'=>trim($this->input->post('com_phone')),
				'com_address'=>trim($this->input->post('com_address')),
				'website'=>trim($this->input->post('website')),
				'com_logo'=>$image
			);
			//print_r($data);
			$id = $this->input->post('id');
			$result = $this->db->where('id',$id)->update('tbl_profile',$data);
			if ($result) {
				echo "update";
			}
			else{
				return false;
			}
		}
		
	}

	 public function create_admin(){
		if (!$this->session->userdata('userid')){
			redirect (base_url());
		}
	 	$data['title']='Create User';
		$data['page']='Administration / Create User';
		$data['userlist']=$this->db->query("select * from tbl_admin where status='a' ")->result();
		$data['backend_content']='administator/admin';
		$this->load->view('admin/layout',$data);
	 }

	 public function save_admin(){
		if ($this->input->post('action')=='create') {
			$email = trim($this->input->post('email'));
			$phone = trim($this->input->post('phone'));
			$user_name = trim($this->input->post('user_name'));
			$password = trim($this->input->post('password'));
			$cpassword = trim($this->input->post('cpassword'));
			$employee = trim($this->input->post('employee_id'));
// 			$passmd5=md5($password);
			$pass=md5($password);

			if (!empty($email) && !preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/',$email)) {
				echo "This email is not valid !";
			}

			if (!preg_match('/^01[3-9]\d{8}$/',$phone)) {
				
				echo "This phone number is not valid !";
			}
			// else if(strlen($password) <=5 ){
			// 	echo"This Password must be more then 5 characters";
			// }
			else{
				if($password == $cpassword){
					
					$data=array(
						'full_name'=>$this->input->post('full_name'),
						'email'=>$email,
						'phone'=>$phone,
						'designation'=>$this->input->post('designation'),
						'user_name'=>$user_name,
						'password'=>$pass,
						'type'=>$this->input->post('type'),
						'employee_id'=> $employee,
						'image'=>$this->image_upload($_FILES['picture']),
						'status'=>'a'
					);
					 //print_r($data);
					$result=$this->db->insert('tbl_admin',$data);
					if ($result) {
						echo "created";
					}
					else{
						return false;
					}
				}

				else{
					echo "Password and Re-type password not match";
				}
			}	
		} 
	}

	public function profile($id){

		$data['admin_info']=$this->admin_m->admin_profile_info($id);
		$data['title']="Admin Profile";
		$data['page']="Edit Profile";
		$data['backend_content']='administator/profile';
		$this->load->view('admin/layout',$data);
	}


	public function update_admin(){
		if ($this->input->post('action')=='updateadmin') {
			$email=trim($this->input->post('email'));
			$phone=trim($this->input->post('phone'));
			if (!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/',$email)) {
				echo "This email is not valid !";
			}
			else if (!preg_match('/^01[3-9]\d{8}$/',$phone)) {
				
				echo "This phone number is not valid !";
			}
			else{

				$image="";
				if ($_FILES['picture']['name'] != "") { 
					$image=$this->image_upload($_FILES['picture']);
					$img_unlink='assets/backend/images/'.$this->input->post("old_image");
					unlink($img_unlink);
				}else{
				 $image=$this->input->post("old_image");
				}
				$data=array(
					'full_name'=>trim($this->input->post('full_name')),
					'designation'=>trim($this->input->post('designation')),
					'email'=>$email,
					'phone'=>$phone,
					'user_name'=>trim($this->input->post('user_name')),
					'image'=>$image
				);
				$id=$this->input->post('id');
				$result=$this->db->where('id',$id)->update('tbl_admin',$data);
				// print_r($data);
				if ($result) {
					echo 'update';
				}
				else{
					return false;
				}
			}
		}
	}


	public function change_pass(){

		if ($this->input->post('action')=='updatepass') {
			$id = trim($this->input->post('id'));
		    $old_pass = trim($this->input->post('old_password'));
		    $old = md5($old_pass);
		    $result = $this->db->query("select * from tbl_admin where id = ? and password = ?",[$id,$old])->num_rows();

		    if ($result > 0) {
				$new_password=trim($this->input->post('new_password'));
				// $new_pass=md5($new_password);
				$create_pass = md5($new_password);

				$retype_pass=trim($this->input->post('retype_pass'));

				if(strlen($new_password) <=5 ){
					echo"This Password must be more then 5 characters";
				}
				else if ($new_password == $retype_pass) {
					
					$data = array('password'=>$create_pass);
					
					$result = $this->db->where('id',$id)->update('tbl_admin',$data);
					if($result){

						echo "update";

					}else{
						return false;
					}
			

				}else{
					echo 'Password or Re-Password not match';
				}
		   	}
		   	else{
				echo 'Old Password  not match';
		   	}
		}
	}


	public function menu_access($id){
		$data['admin_id']=$id;
		$data['title']="Menu Access";
		$data['page']="User Access";
		$data['checkdata']=$this->db->query("select menuaccess from tbl_admin where id=?",$id)->row();
		$data['backend_content']='administator/menu_access';
		$this->load->view('admin/layout',$data);
	}

	public function user_access(){
		if ($this->input->post('action')=='menuaccess') {
			$menuaccess=$this->input->post('menuaccess');
			$user_id=$this->input->post('user_id');
			$accessString = implode(',', $menuaccess);

			$smg = $this->db->query("UPDATE tbl_admin SET menuaccess=? WHERE id=?",[$accessString,$user_id]);
			if ($smg) {
				echo 'update';
			}
		}
	}

	public function user_delete(){
		$id=$this->input->post('id');
		$data=array('status'=>'d');
		$this->db->where('id',$id);
		$result=$this->db->update('tbl_admin',$data);
		if ($result) {
			echo "deleted";
		}else{
			echo "faild";
		}
	}
	
}
?>