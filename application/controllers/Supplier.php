<?php
    defined('BASEPATH') OR exit('No direct script access allowed'); 

    class Supplier extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            if (!$this->session->userdata('userid')){
                redirect (base_url());
            }
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

        public function index() {
            $data['title']='Add Supplier';
            $data['page']='Administration / Supplier';
            $data['suppliers']= $this->db->query("select * from tbl_supplier where status = 'a' order by id desc")->result();
            $data['backend_content']='store/supplier';
            $this->load->view('admin/layout',$data);
        }

        public function save_supplier() {
            if($this->input->post('action') == 'create') {
                $mobile = trim($this->input->post('mobile'));
                if (!preg_match('/^01[3-9]\d{8}$/',$mobile)) {
					
                    echo "This phone number is not valid !";
                }
                else{
                    $data = array(
                        'code' => trim($this->input->post('code')),
                        'name' => trim($this->input->post('name')),
                        'mobile' => $mobile,
                        'email' => trim($this->input->post('email')),
                        'owner_name' => trim($this->input->post('owner_name')),
                        'address' => trim($this->input->post('address')),
                        'previous_due' => trim($this->input->post('address')),
                        'image' => $this->image_upload($_FILES['image']),
                        'added_by' => $this->session->userdata('userid'),
                        'added_date' => date("Y-m-d H:i:s"),
                        'status' => 'a'
                    );
                    // print_r($data);
                    $result = $this->db->insert('tbl_supplier', $data);
                    if ($result) {
                        echo 'insert';
                    } else {
                        return false;
                    }
                }
            }

            if($this->input->post('action') == 'update') {
                $mobile = trim($this->input->post('mobile'));
                $image="";
				if ($_FILES['image']['name'] != "") { 
					$image=$this->image_upload($_FILES['image']);
					$img_unlink='assets/backend/images/'.$this->input->post("old_image");
					unlink($img_unlink);
				}else{
				 $image=$this->input->post("old_image");
                }
                
                if (!preg_match('/^01[3-9]\d{8}$/',$mobile)) {
					
                    echo "This phone number is not valid !";
                }
                else {
                    $data = array(
                        'code' => trim($this->input->post('code')),
                        'name' => trim($this->input->post('name')),
                        'mobile' => $mobile,
                        'email' => trim($this->input->post('email')),
                        'owner_name' => trim($this->input->post('owner_name')),
                        'address' => trim($this->input->post('address')),
                        'previous_due' => trim($this->input->post('previous_due')),
                        'image' => $image,
                        'updated_by' => $this->session->userdata('userid'),
                        'update_date' => date("Y-m-d H:i:s")
                    );
                    // print_r($data);
                    
                    $id = $this->input->post('action_id');
                    $result = $this->db->where('id', $id)->update('tbl_supplier', $data);
                    if($result) {
                        echo 'update';
                    } else {
                        return false;
                    }
                }
            }
        }

        public function edit_supplier() {
            if($this->input->post('id')) {
                $id = $this->input->post('id');
                $result = $this->db->query("select * from tbl_supplier where status='a' and id=?", $id)->result();
                $subArray = [];
                foreach($result as $key => $value) {
                    $subArray['code'] = $value->code;
                    $subArray['name'] = $value->name;
                    $subArray['mobile'] = $value->mobile;
                    $subArray['email'] = $value->email;
                    $subArray['owner_name'] = $value->owner_name;
                    $subArray['address'] = $value->address;
                    $subArray['previous_due'] = $value->previous_due;
                    $subArray['image'] = $value->image;
                }
                echo json_encode($subArray);
            }
        }

        public function delete_supplier() {
            if($this->input->post('id')) {
                $id = $this->input->post('id');

                $data = array('status' => 'd');
                $result = $this->db->where('id', $id)->update('tbl_supplier', $data);
                if($result) {
                    echo 'delete';
                }
                else {
                    return false;
                }
            }
        }

        public function get_suppliers() {
            $result = $this->db->query("select *, concat(code , ' - ', name)as display_text from tbl_supplier where status ='a'")->result();
            echo json_encode($result);
        }

        public function supplier_payment() {
            $data['title']='Supplier Payment';
            $data['page']='Store / Supplier Payment';
            $data['supplierPayments']= $this->db->query("select * from tbl_supplier_payments where status = 'a' order by id desc")->result();
            $data['backend_content']='store/supplier_payment';
            $this->load->view('admin/layout',$data);
        }

        public function save_supplier_payment() {
            $res = new stdClass();
            try {
                $paymentObj = json_decode($this->input->raw_input_stream);
                if($paymentObj->payment_amount != 0) {
                    $data = array(
                        'supplier_id' => $paymentObj->supplier_id,
                        'payment_date' => $paymentObj->payment_date,
                        'payment_amount' => $paymentObj->payment_amount,
                        'payment_note' => $paymentObj->payment_note,
                        'added_by' => $this->session->userdata('userid'),
                        'added_date' => date("Y-m-d H:i:s"),
                        'status' => 'a'
                    ); 

                    $result = $this->db->insert('tbl_supplier_payments', $data);

                    if($result) {
                        $res->message = 'Supplier payment successfully !';
                        $res->success = true;
                    }
                }
                else {
                    $res->message = 'Supplier payment is not empty';
                    $res->success = true;
                }
            } catch (Exception $e) {
                $res->message = 'Supplier payment faild !'. $e->getMessage();
                $res->success = false;
            }

            echo json_encode($res);
        }

        public function update_supplier_payment() {
            $res = new stdClass();
            try {
                $paymentObj = json_decode($this->input->raw_input_stream);
                // print_r($paymentObj);
                if($paymentObj->payment_amount != 0) {
                    $data = array(
                        'supplier_id' => $paymentObj->supplier_id,
                        'payment_date' => $paymentObj->payment_date,
                        'payment_amount' => $paymentObj->payment_amount,
                        'payment_note' => $paymentObj->payment_note,
                        'update_by' => $this->session->userdata('userid'),
                        'update_date' => date("Y-m-d H:i:s"),
                    ); 

                    $result = $this->db->where('id', $paymentObj->id)->update('tbl_supplier_payments', $data);

                    if($result) {
                        $res->message = 'Update successfully !';
                        $res->success = true;
                    }
                }
                else {
                    $res->message = 'Supplier payment is not empty';
                    $res->success = true;
                }
            } catch (Exception $e) {
                $res->message = 'Update faild !'. $e->getMessage();
                $res->success = false;
            }

            echo json_encode($res);
        }

        public function get_supplier_payment() {
            $result = $this->db->query("
                SELECT
                    sp.*,
                    s.code,
                    s.name
                FROM tbl_supplier_payments as sp 
                JOIN tbl_supplier as s ON sp.supplier_id = s.id
                WHERE sp.status='a'
            ")->result();
            echo json_encode($result);
        }

        public function delete_supplier_payment() {
            $res = new stdClass();
            $obj = json_decode($this->input->raw_input_stream);
            $data = array('status' => 'd');
            $result = $this->db->where('id', $obj->id)->update('tbl_supplier_payments', $data);
            if($result) {
                $res->message = "Supplier payment deleted !";
                $res->success = true;
            }

            echo json_encode($res);
        }

        public function supplier_due() {
            $obj = json_decode($this->input->raw_input_stream);
            $clause = '';
            if(isset($obj->supplierId) && $obj->supplierId != '') {
                $clause.= " and s.id = $obj->supplierId";
            }
            $result = $this->db->query("
                SELECT
                    s.*,
                    (select ifnull(sum(p.due),0) from tbl_purchase p  where s.id = p.supplier_id ) as purchaseDue,
                    (select ifnull(sum(sp.payment_amount),0) from tbl_supplier_payments sp WHERE sp.status = 'a' and sp.supplier_id = s.id) as paymentTotal,
                    (SELECT purchaseDue - paymentTotal)as due
                FROM
                tbl_supplier as s
                where 1 = 1
                $clause
            ")->result();

            echo json_encode($result);
        }
    }
?>