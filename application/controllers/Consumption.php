<?php
    defined('BASEPATH') OR exit('No direct script access allowed'); 

    class Consumption extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            if (!$this->session->userdata('userid')){
                redirect (base_url());
            }
        }

        public function index() {
            $data['title']='Add Consumption';
            $data['page']='Store / Consumption';
            $data['backend_content']='store/consumption';
            $this->load->view('admin/layout',$data);
        }

        public function save_consumption() {
            $res = new stdClass;

            try {
                $this->db->trans_start();

                $consupmtion = json_decode($this->input->raw_input_stream);
                $carts = $consupmtion->cart;

                $invoice_id = $this->invoice_id();
                $this->db->query("
                    INSERT INTO tbl_consumption
                    (invoice_id,employee_id,area_id,assign_date,note,added_by,added_date,status)
                    VALUES(
                        '".$invoice_id."',
                        ".$consupmtion->employee_id.",
                        ".$consupmtion->area_id.",
                        '".$consupmtion->assign_date."',
                        '".$consupmtion->note."',
                        '".$this->session->userdata('userid')."',
                        '".date("Y-m-d H:i:s")."',
                        'a'
                    )
                ");
                
                $consupmtion_id = $this->db->insert_id();
                foreach($carts as $product) {
                    $this->db->query("
                        INSERT INTO tbl_consumption_details (consumption_id,product_id,quantity,added_by,added_date)
                        VALUES(
                            ".$consupmtion_id.",
                            ".$product->product_id.",
                            ".$product->quantity.",
                            ".$this->session->userdata('userid').",
                            '".date("Y-m-d H:i:s")."'
                        )
                    ");
                }

                // $res = ['success'=>true, 'message'=>'Purchase added successfully'];
                $res->message = "Consumption added successfully";
                $res->status = 201;
                $res->success = true;
                $res->consumptionId = $consupmtion_id;
                
                $this->db->trans_complete();
            } catch (\Exception $e) {
                
                $res->message = "Consumption added fail. ".$e->getMessage();
                $res->status = 422;
                $res->success = false;
            }

            echo json_encode($res);
        }

        public function invoice_code() {
            $code= date('ym');
            $Id = $code.'00001';
            $lastCode = $this->db->query("select id from tbl_consumption order by id desc limit 1");
            
            if (!empty($lastCode)) {
                $lastCode = $lastCode->row()->id + 1;
                $zeros = array('0', '00', '000', '0000');
                $Id = "$code" . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
            }

            echo json_encode($Id);
        }
        
        public function invoice_id() {
            $code= date('ym');
            $Id = $code.'00001';
            $lastCode = $this->db->query("select id from tbl_consumption order by id desc limit 1");
            
            if (!empty($lastCode)) {
                $lastCode = $lastCode->row()->id + 1;
                $zeros = array('0', '00', '000', '0000');
                $Id = "$code" . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
            }

            return $Id;
        }

        public function consumption_record() {
            $data['title']='Comsumption Record';
            $data['page']='Store / Comsumption Record';
            $data['backend_content']='store/consumption_record';
            $this->load->view('admin/layout',$data);
        }

        public function consumption_report() {
            $obj = json_decode($this->input->raw_input_stream);
            $clause = "";
            if(isset($obj->employee_id)) {
                $employee_id = $obj->employee_id;
                $clause = " AND c.employee_id = $employee_id";
            }

            $result = $this->db->query("
                SELECT
                    c.*,
                    e.emp_name,
                    u.full_name
                FROM tbl_consumption as c
                JOIN tbl_emplyee as e ON c.employee_id =e.id
                JOIN tbl_admin as u ON c.added_by = u.id
                WHERE c.status='a'
                $clause
                AND c.assign_date BETWEEN ? AND ?
            ", [$obj->dateFrom, $obj->dateTo])->result();
            echo json_encode($result);
        }

        public function consumption_invoice($id) {
            $employee = $this->db->query("
                SELECT
                    c.*,
                    e.emp_id,
                    e.emp_name,
                    e.emp_phone,
                    e.present_address,
                    a.name,
                    u.full_name
                FROM tbl_consumption as c 
                JOIN tbl_emplyee as e ON c.employee_id = e.id
                left JOIN tbl_area as a ON a.id = c.area_id
                JOIN tbl_admin as u ON c.added_by = u.id
                WHERE c.id = ? AND c.status = 'a'
            ", $id)->row();
            $data['employee'] = $employee;
            $data['products'] = $this->db->query("
                SELECT 
                    cd.*,
                    p.code,
                    p.product_name
                FROM tbl_consumption_details as cd
                JOIN tbl_product as p ON cd.product_id = p.id
                WHERE cd.consumption_id = ?
            ", $employee->id)->result();

            $data['title']='Consumption invoice';
            $data['page']='Store / Consumption Invoice';
            $data['backend_content']='store/consumption_invoice';
            $this->load->view('admin/layout',$data);
        }
    }
?>