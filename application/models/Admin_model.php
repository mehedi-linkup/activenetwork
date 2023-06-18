<?php 
/**
 * 
 */
class Admin_model extends CI_Model
{
	public function user_login($name,$pass){
		$query = $this->db->query("select * from tbl_admin where binary user_name=? and password=? and status='a'",[$name,$pass]);
		if ($query->num_rows() >0) {
			return $query->result_array();
		}
		else{
			return false;
		}
	}

	public function save_data($data){
		$query=$this->db->insert('tbl_admin', $data);
			return $query;
	}

	public function selectOnerow($id){
		$this->db->where('id',$id);
		$query = $this->db->get('tbl_admin');
				
		if ($query->num_rows()>0) {
			return $query->row();
		}
	}

	public function update($id,$data){
		$this->db->where('id',$id);
		$query = $this->db->update('tbl_admin', $data);
		if ($query) {
			return $query;
		}else{
			return false;
		}
	}

	public function administator_delete($id,$data){
		$query=$this->db->where("id",$id)->update("tbl_admin",$data);
		if ($query) {
			return $query;
		}else{
			return false;
		}
	}

	public function profile($id){
		$this->db->where('id',$id);
		$query = $this->db->get('tbl_admin');
				
		if ($query->num_rows()>0) {
			return $query->row();
		}
	}

	public function change_password($id){

		$this->db->where('id',$id);
		$query = $this->db->get('tbl_admin');
				
		if ($query->num_rows()>0) {
			return $query->row();
		}
	}


	public function match_old_pass($id,$old_password){
		$this->db->where('id',$id);
		$this->db->where('password',$old_password);
		$query = $this->db->get('tbl_admin');

		return $query->num_rows();
		// if ($query->num_rows()) {
		// 	return $query->row();
		// }
		// else{
		// 	return false;
		// }
	}

	public function create_new_pass($id,$data){
		$this->db->where('id',$id);
		$query = $this->db->update('tbl_admin', $data);
		if ($query) {
			return $query;
		}else{
			return false;
		}
	}

	public function customer_list(){
		$this->db->where('status',1);
		
		$query = $this->db->get('user_register');
		if ($query->num_rows() >0) {
			return $query->result();
		}
		else{
			return false;
		}
	}

	public function delete($id,$data){
		$query=$this->db->where("id",$id)->update("user_register",$data);
		if ($query) {
			return $query;
		}else{
			return false;
		}
	}


	public function edit_customer($id){
		$this->db->where('id',$id);
		$query = $this->db->get('user_register');
		if ($query->num_rows() >0) {
			return $query->row();
		}
		else{
			return false;
		}
	}


	public function update_customer($id,$data){
		$this->db->where('id',$id);
		$query = $this->db->update('user_register', $data);
		if ($query) {
			return $query;
		}else{
			return false;
		}
	}

	public function user_message(){
		$this->db->where('status',1);
		$query = $this->db->get('contact_user');
		if ($query->num_rows() >0) {
			return $query->result();
		}
		else{
			return false;
		}
	}

	public function delete_contact($id){
		$this->db->where('id',$id);
		$query = $this->db->delete('contact_user');
		if ($query) {
			return $query;
		}else{
			return false;
		}
	}

	public function message_details($id){
		$this->db->where('id',$id);
		$this->db->where('status',1);
		$query = $this->db->get('contact_user');
		if ($query->num_rows() >0) {
			return $query->row();
		}
		else{
			return false;
		}
	}

	public function message_reply($id){
		$this->db->where('id',$id);
		$this->db->where('status',1);
		$query = $this->db->get('contact_user');
		if ($query->num_rows() >0) {
			return $query->row();
		}
		else{
			return false;
		}
	}

	public function messages_reply($id){
		$this->db->where('id',$id);
		$this->db->where('status',0);
		$query = $this->db->get('contact_user');
		if ($query->num_rows() >0) {
			return $query->row();
		}
		else{
			return false;
		}
	}

	public function inbox_row(){
		$this->db->where('status',1);
		$query = $this->db->get('contact_user');
		return $query->num_rows();
	}

	public function seen_all_msg(){
		$this->db->where('status',0);
		$query = $this->db->get('contact_user');
		if ($query->num_rows() >0) {
			return $query->result();
		}
		else{
			return false;
		}
	}

	public function seen_messages($id,$data){
		$this->db->where('id',$id);
		$query = $this->db->update('contact_user',$data);
		if ($query) {
			return $query;
		}else{
			return false;
		}
	}

	public function user_product_order(){
		
// 		$this->db->where('status','p');
		$this->db->order_by('id','desc');
		$query= $this->db->get('tbl_orders_master');
		if ($query->num_rows()>0) {
			return $query->result();
		}
		else{
			return false;
		}
	}

	public function contact(){
		$this->db->where('status','a');
		$this->db->order_by('id','desc');
		$query= $this->db->get('tbl_contact');
		if ($query->num_rows()>0) {
			return $query->result();
		}
		else{
			return false;
		}
	}

	public function cusotmer_msg(){
		$this->db->where ('status','a');
		$query=$this->db->get('tbl_message');
		if ($query->num_rows()>0) {
			return $query->result();
		}
		else{
			return false;
		}
	}


	public function admin_profile_info($id){
		
		$query = $this->db->query("select * from tbl_admin where id=?",$id);
		if ($query->num_rows() >0) {
			return $query->row();
		}
		else{
			return false;
		}
	}

	public function delete_message($id,$data){
		$query=$this->db->where("id",$id)->update("tbl_contact",$data);
		if ($query) {
			return $query;
		}else{
			return false;
		}
	}
}

 ?>