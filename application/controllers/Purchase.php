<?php
    defined('BASEPATH') OR exit('No direct script access allowed'); 

    class Purchase extends CI_Controller {
        function __construct()
        {
            parent::__construct();
            if (!$this->session->userdata('userid')){
                redirect (base_url());
            }
        }

        public function index() {
            $data['title']='Add Purchase';
            $data['page']='Store / Purchase';
            $data['backend_content']='store/purchase';
            $this->load->view('admin/layout',$data);
        }

        public function save_purchase() {
            $res = new stdClass;

            try {
                $this->db->trans_start();

                $purchaseObj = json_decode($this->input->raw_input_stream);
                $carts = $purchaseObj->cart;

                $invoice_id = $this->invoice_code();
                $this->db->query("
                    INSERT INTO tbl_purchase
                    (supplier_id,employee_id,invoice_id,purchase_date,sub_total,vat,discount,others,due,paid,total,previous_due,note,added_by,added_date,status)
                    VALUES(
                        ".$purchaseObj->supplier_id.",
                        ".$purchaseObj->employee_id.",
                        '".$invoice_id."',
                        '".$purchaseObj->purchase_date."',
                        '".$purchaseObj->sub_total."',
                        '".$purchaseObj->vat."',
                        '".$purchaseObj->discount."',
                        '".$purchaseObj->others."',
                        '".$purchaseObj->total."',
                        '".$purchaseObj->paid."',
                        '".$purchaseObj->due."',
                        '".$purchaseObj->previous_due."',
                        '".$purchaseObj->note."',
                        '".$this->session->userdata('userid')."',
                        '".date("Y-m-d H:i:s")."',
                        'a'
                    )
                ");
                
                $purchase_id = $this->db->insert_id();
                foreach($carts as $product) {
                    $this->db->query("
                        INSERT INTO tbl_purchase_details (purchase_id,product_id,quantity,purchase_rate,purchase_total,added_by,added_date)
                        VALUES(
                            ".$purchase_id.",
                            ".$product->product_id.",
                            ".$product->quantity.",
                            ".$product->purchase_rate.",
                            ".$product->total.",
                            ".$this->session->userdata('userid').",
                            '".date("Y-m-d H:i:s")."'
                        )
                    ");
                }

                // $res = ['success'=>true, 'message'=>'Purchase added successfully'];
                $res->message = "Purchase added successfully";
                $res->status = 201;
                $res->success = true;
                $res->purchaseId = $purchase_id;
                
                $this->db->trans_complete();
            } catch (\Exception $e) {
                
                $res->message = "Purchase added fail. ".$e->getMessage();
                $res->status = 422;
                $res->success = false;
            }

            echo json_encode($res);
        }

        public function invoice_code() {
            $code= date('ym');
            $Id = $code.'00001';
            $lastCode = $this->db->query("select id from tbl_purchase order by id desc limit 1");
            
            if (!empty($lastCode)) {
                $lastCode = $lastCode->row()->id + 1;
                $zeros = array('0', '00', '000', '0000');
                $Id = "$code" . (strlen($lastCode) > count($zeros) ? $lastCode : $zeros[count($zeros) - strlen($lastCode)] . $lastCode);
            }

            return $Id;
        }

        public function get_product_stock() {
            $product = json_decode($this->input->raw_input_stream);

            $clause = '';

            if(isset($product->id) && $product->id !=0) {
                $clause .= "WHERE pd.product_id =?"; 
            }

            $stock = $this->db->query("
                SELECT 
                    *,
                    (total_purchase_qty - total_conj) as stock
                FROM (
                    SELECT 
                        pd.product_id,
                        ifnull(SUM(pd.quantity),0) as total_purchase_qty,
                            ifnull((SELECT SUM(cd.quantity) FROM tbl_consumption_details as cd WHERE cd.product_id = pd.product_id),0) as total_conj
                
                    FROM tbl_purchase_details as pd
                    $clause
                    GROUP BY pd.product_id
                ) as tbl
            ",$product->id)->result();
            echo json_encode($stock);
        }

        public function purchase_record() {
            $data['title']='Add Purchase';
            $data['page']='Store / Purchase Record';
            $data['backend_content']='store/purchase_record';
            $this->load->view('admin/layout',$data);
        }

        public function purchase_report() {
            $obj = json_decode($this->input->raw_input_stream);

            $clause = "";

            if(isset($obj->supplier_id)) {
                $supplier_id = $obj->supplier_id;
                $clause = "AND p.supplier_id = $supplier_id";
            }

            if(isset($obj->employee_id)) {
                $employee_id = $obj->employee_id;
                $clause = "AND p.employee_id = $employee_id";
            }

            $result = $this->db->query("
                SELECT
                    p.*,
                    s.name
                FROM tbl_purchase as p
                JOIN tbl_supplier as s ON p.supplier_id = s.id 
                WHERE p.status= 'a'
                $clause
                AND p.purchase_date BETWEEN ? AND ?
            ", [$obj->dateFrom, $obj->dateTo])->result();
            echo json_encode($result);
        }

        public function stock() {
            $data['title']='Add Stock';
            $data['page']='Store / Stock';
            $data['backend_content']='store/stock';
            $this->load->view('admin/layout',$data);
        }

        public function stock_record() {
            $obj = json_decode($this->input->raw_input_stream);

            $clause = '';
            if(isset($obj->product_id)) {
                $productId = $obj->product_id;
                $clause .= " AND p.id= $productId";
            }

            if(isset($obj->category_id)) {
                $categoryId = $obj->category_id;
                $clause .= " AND p.category_id = $categoryId";
            }

            $result = $this->db->query("
                SELECT
                    p.*,
                    c.category_name as category,
                    u.unit_name as unit,
                    (ifnull(sum(pd.quantity), 0) - ifnull(sum(cd.quantity), 0))as stockQunatity,
                    pd.purchase_rate
                FROM tbl_product as p 
                JOIN tbl_category as c ON p.category_id = c.id
                JOIN tbl_unit as u ON p.unit_id = u.id
                LEFT JOIN  tbl_purchase_details as pd ON p.id = pd.product_id
                LEFT JOIN tbl_consumption_details as cd ON p.id = cd.product_id
                WHERE p.status != 'd'
                $clause
                GROUP BY p.id
            ")->result();

            echo json_encode($result);
        }

        public function purchase_invoice($id) {
            $purchase = $this->db->query("
                SELECT 
                    p.*,
                    s.code,
                    s.name,
                    s.mobile,
                    s.email,
                    s.address,
                    u.full_name
                FROM tbl_purchase as p
                JOIN tbl_supplier as s ON p.supplier_id = s.id 
                JOIN tbl_admin as u ON p.added_by = u.id
                WHERE p.id = ? AND p.status = 'a'
            ", $id)->row();
            $data['purchase'] = $purchase;
            $data['products'] = $this->db->query("
                SELECT 
                    pd.*,
                    p.code,
                    p.product_name
                FROM tbl_purchase_details as pd
                JOIN tbl_product as p ON pd.product_id = p.id
                WHERE pd.purchase_id = ?
            ", $purchase->id)->result();

            $data['title']='Purchase invoice';
            $data['page']='Store / Purchase Invoice';
            $data['backend_content']='store/purchase_invoice';
            $this->load->view('admin/layout',$data);
        }
    }
?>