<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *  
 */
class Collection extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('userid')){
			redirect (base_url(''));
		}
		
		// $this->load->model('Admin_model','admin_m');
	}

	public function add_collection(){
		$data['title']='Add Collection';
		$data['page']='Collection / Collection Entry';
		$data['backend_content']='collection/collection_entry';
		$this->load->view('admin/layout',$data);
	}

	
	public function add_bill_collection(){
		$data['title']='Add Bill Collection';
		$data['page']='Collection Entry';
		$data['backend_content']='collection/bill_collection';
		$this->load->view('admin/layout',$data);
	}
	public function customer_choose(){
		$customer = json_decode($this->input->raw_input_stream);

		if (isset($customer->id) && $customer->id != 0) {
			$cus_id= $customer->id;
			$data = array();
			$result = $this->db->query("
				SELECT 
					coll.*,
					c.cust_id,
					c.cust_name,
					c.cust_phone,
					m.*
				FROM tbl_collection as coll
				JOIN tbl_customer as c ON 
				coll.cust_id = c.id 
				JOIN tbl_month as m ON coll.coll_month = m.id
				WHERE coll.cust_id = ? and coll.coll_status ='p'

				",$cus_id)->result();

			if (!empty($result)) {
				$data = $result; 
			}
			else{
				$data = $this->db->query("select cust_name from tbl_customer where id=?",$cus_id)->row();
			}
			echo json_encode($data);
		}
	}

	public function save_collection(){
		$res = new stdClass();
		try {
			// $this->db->trans_begin();
			$obj = json_decode($this->input->raw_input_stream);
			$update_date = $obj->update_date;
			$officer_id = $obj->officer_id;
			$recipt_book = $obj->recipt_book;
			$note = $obj->note;
			$carts = $obj->cart;
			$advanceAmount = $this->db->query("select advance_amount from tbl_customer where id = ?", $obj->customer_id)->row()->advance_amount;

			$masterData = array(
				'coll_invoice' => $this->collection_code(),
				'added_by'    => $this->session->userdata('userid'),
				'added_date'  => date("Y-m-d H:i:s"),
				'recipt_book' => $recipt_book,
				'note' => $note,
			);

			$this->db->insert('tbl_collection_master', $masterData);

			$collectionMasterId =  $this->db->insert_id();
			$total = 0;

			foreach($carts as $cart) {
				if($cart->isChecked == true) {
					$collectionId = $cart->coll_id;
					$total += ($cart->dish_bill + $cart->wifi_bill) - $cart->discount;
					$data = array(
						'coll_month' => $cart->coll_month,
						'dish_bill' => $cart->dish_bill,
						'wifi_bill' => $cart->wifi_bill,
						'discount' => $cart->discount,
						'coll_status' => 'a',
						'update_by' => $this->session->userdata('userid'),
						'update_date' => $update_date,
						'officer_id' => $officer_id,
						'coll_master_id' => $collectionMasterId,
					);
					$this->db->where('coll_id', $collectionId)->update('tbl_collection', $data);
				}
			}
			if($advanceAmount >= $total) {
				$this->db->query("
					update tbl_customer set 
					advance_amount = advance_amount - $total 
					where id =?
				", $obj->customer_id);

			}

			// if ($this->db->trans_status() === FALSE) {
			// 	$this->db->trans_rollback();
			// } else {
			// 	$this->db->trans_commit();
			// }
			$res->message = 'Collection save successfully';
			$res->success = true;

		} catch (Exception $e) {
			// $this->db->trans_rollback();
			$res->message = "Collection fail".$e->getMessage();
			$res->success = false;
		}

		echo json_encode($res);
	}

	public function collection_code() {
		$code= date('ym');
		$Id = $code.'00001';
		$lastCode = $this->db->query("select id from tbl_collection_master order by id desc limit 1");
		
		if (!empty($lastCode)) {
			$lastCode = $lastCode->row()->id + 1;
			$zeros = array('0', '00', '000', '0000');
			$Id = "$code" . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
		}

		return $Id;
	}

	public function collection_setting(){
		$data['title']='Collection setting';
		$data['page']='Collection / Bill Generate';
		$data['backend_content']='collection/collection_setting';
		$this->load->view('admin/layout',$data);
	}

	public function collection_recoed(){
		$data['title']='Collection Recoed';
		$data['page']='Collection';
		$data['backend_content']='collection/collection_recoed';
		$this->load->view('admin/layout',$data);
	}

	public function getCollection() {
		$data = json_decode($this->input->raw_input_stream);

		$clauses = "";
		if(isset($data->monthId) && $data->monthId != '') {
			$clauses .= " and cl.coll_month = $data->monthId";
		}

		if(isset($data->customerId) && $data->customerId != '') {
			$clauses .= " and cl.cust_id = $data->customerId";
		}

		$bill = $this->db->query("
			select 
				cl.*,
				c.cust_id,
				c.cust_phone,
				m.month_name
			from tbl_collection cl
			join tbl_customer c on c.id = cl.cust_id
			join tbl_month m on m.id = cl.coll_month
			where 1 = 1
			$clauses
		")->result();
		echo json_encode($bill);
	}

	// advance system
	public function customer_advance(){
		$data['title']='Advance Payment';
		$data['page']='Collection / Advance';
		$data['backend_content']='collection/advance';
		$this->load->view('admin/layout',$data);
	}
	public function payment_save(){
		if ($this->input->post('action')=='create'){
			$cust_id=$this->input->post('cust_id');
			//print_r($cust_id);
			$total_amount=$this->db->query("select sum(advance_amount)as adv_total from tbl_customer where status='a' and id=?",$cust_id)->row();
			$oldamount=$total_amount->adv_total;
			//print_r($oldamount);

			$newamount=$this->input->post('amount');
			$sum=0;
			if (!empty($newamount)) {
				$sum=$oldamount+$newamount;
			}

			$data=array(
				'advance_amount'=>$sum,
				'advance_date'=>trim($this->input->post('create_date'))
			);
			 // print_r($data);
			$result=$this->db->where('id',$cust_id)->update('tbl_customer',$data);
			if ($result) {
				echo "success";
			}
			else{
				return false;
			}
		}
	}

	public function advance_payment(){
		if ($this->input->post('c_id')) {
			$cust_id=$this->input->post('c_id');
			$data=$this->db->query("select advance_amount from tbl_customer where status='a' and id=?",$cust_id)->row();
			$total=0;
			if ($data->advance_amount >0) {
				$total=$data->advance_amount;
			}
			echo $total;
		}
	}

	public function previous_due(){
		if ($this->input->post('cust_id')) {
			$id=$this->input->post('cust_id');
			$data=$this->db->query("select previous_due,prev_due_collection from tbl_customer where id=?",$id)->row();
			$prev_due=($data->previous_due-$data->prev_due_collection);
			
			echo $prev_due;
		}
	}

	public function collection_record(){
		$data['title']='Collection Record';
		$data['page']='Collection Record';
		$data['backend_content']='collection/collection_record';
		$this->load->view('admin/layout',$data);
	}

	public function collection_records() {
		$cust_id = $this->input->post('cust_id');
		$dateFrom = $this->input->post('dateFrom');
		$dateTo = $this->input->post('dateTo');

		$query = '';

		if($cust_id != 0) {
			$query = $this->db->query("
				SELECT
					coll.*,
				    m.month_name,
				    e.emp_name
				from tbl_collection as coll
				JOIN tbl_month as m ON coll.coll_month = m.id
				JOIN tbl_emplyee as e ON coll.officer_id = e.id
				WHERE coll.cust_id = ? AND coll.update_date BETWEEN ? AND ?
			", [$cust_id, $dateFrom, $dateTo]);
		}
		else{
			$query = $this->db->query("
				SELECT
					coll.*,
				    m.month_name,
				    e.emp_name
				from tbl_collection as coll
				JOIN tbl_month as m ON coll.coll_month = m.id
				JOIN tbl_emplyee as e ON coll.officer_id = e.id
				WHERE coll.update_date BETWEEN ? AND ?
			", [$dateFrom, $dateTo]);
		}

		$result = $query->result();



		$output = '';
		$j = 1;
		if ($result) {
			foreach ($result as $value) {
				$output .= '
					<tr>
						<td>'.$j++.'</td>
						<td>'.$value->coll_code.'</td>
						<td>'.$value->cust_name.'</td>
						<td>'.$value->update_date.'</td>
						<td>'.$value->month_name.'</td>
						<td>'.$value->emp_name.'</td>
						<td>'.$value->coll_amount.'</td>
						<td class="text-center">
						<a href="'.base_url('print-invoice/').$value->coll_master_id.'/'.$value->cust_id.'" target="_blank" class=""><i class="fa fa-print" aria-hidden="true"></i></a>
						<a href="'.base_url('edit-collection/').$value->coll_master_id.'" target="_blank" id="edit-area" data-id="" class=""><i class="fa fa-pencil-square-o text-success" aria-hidden="true"></i></a>
						</td>
					</tr>
				';
			}
		}

		else{
			$output .= '<tr><td colspan="8" class="text-center">Date not found !</td></tr>';
		}

		echo $output;
	}

	public function edit_colltection() {
		$data['title']='Edit Collection';
		$data['page']='Edit Collection';
		$data['backend_content']='collection/edit_colltection';
		$this->load->view('admin/layout',$data);
	}
	
	public function cashCollection() {
		$data['title']='Cash Collection';
		$data['page']='Cash Collection';
		$data['backend_content']='collection/cash_colltection';
		$this->load->view('admin/layout',$data);
	}

	public function getCashStatement() {
		$res = new stdClass;
		$data = json_decode($this->input->raw_input_stream);

		$res->customerReceive = $this->db->query("
			select 
				c.cust_name,
				cl.update_date,
				cl.coll_amount,
				cl.coll_code
			from tbl_collection cl
			join tbl_customer c on c.id = cl.cust_id
			where cl.coll_status = 'a'
			and cl.update_date between '$data->dateFrom' and '$data->dateTo'
		")->result();

		$res->cashReceived = $this->db->query("
			select 
				tr.tr_id,
				tr.voucher_no,
				tr.tr_date,
				tr.tr_amount
			from tbl_transaction tr
			where tr.tr_status = 'a'
			and tr.tr_type = 1
			and tr.tr_date between '$data->dateFrom' and '$data->dateTo'
		")->result();

		$res->cashPaid = $this->db->query("
			select 
				tr.tr_id,
				tr.voucher_no,
				tr.tr_date,
				tr.tr_amount
			from tbl_transaction tr
			where tr.tr_status = 'a'
			and tr.tr_type = 2
			and tr.tr_date between '$data->dateFrom' and '$data->dateTo'
		")->result();

		$res->servicePayment = $this->db->query("
			select 
				cl.coll_code,
				cl.coll_date,
				cl.coll_amount,
				c.cust_name
			from tbl_collection cl 
			join tbl_customer c on c.id = cl.cust_id
			where cl.coll_status = 'a'
			and cl.coll_date between '$data->dateFrom' and '$data->dateTo'
		")->result();

		$res->purchases = $this->db->query("
			select 
				p.invoice_id,
				p.purchase_date,
				p.paid,
				s.name
			from tbl_purchase p 
			join tbl_supplier s on s.id = p.supplier_id
			where p.status = 'a'
			and p.purchase_date between '$data->dateFrom' and '$data->dateTo'
		")->result();

		$res->supplierPayment = $this->db->query("
			select 
				sp.payment_date,
				sp.payment_amount,
				s.name
			from tbl_supplier_payments sp 
			join tbl_supplier s on s.id = sp.supplier_id
			and sp.status = 'a'
			and sp.payment_date between '$data->dateFrom' and '$data->dateTo'
		")->result();

		$res->salaryPayment = $this->db->query("
			select 
				s.payment_date,
				s.payment_amount,
				e.emp_name
			from tbl_salary s 
			join tbl_emplyee e on e.id = s.emp_id
			where s.status = 'a'
			and s.payment_date between '$data->dateFrom' and '$data->dateTo'
		")->result();

		echo json_encode($res);
	}
}
?>