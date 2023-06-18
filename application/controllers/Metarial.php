<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Metarial extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('userid')){
			redirect (base_url());
		}
    }
    
    public function cateogry() {
        $data['title']='Add Category';
		$data['page']='Setting / Category Entry';
        $data['categories']= $this->db->query("select * from tbl_category where status = 'a' order by id desc")->result();
		$data['backend_content']='store/category';
		$this->load->view('admin/layout',$data);
    }

    public function get_categories() {
        $result = $this->db->query("select * from tbl_category where status ='a' order by id desc")->result();
        echo json_encode($result);
    }

    public function save_category() {
        if($this->input->post('action') == 'create') {
            $data  = array(
                'category_name' => trim($this->input->post('category_name')), 
                'description' => trim($this->input->post('description')),
                'status' => 'a',
            );

            // print_r($data);
            $result = $this->db->insert('tbl_category', $data);
            if ($result) {
                echo 'success';
            } else {
                return false;
            }
            
        }

        if($this->input->post('action') == 'update') {
            $data = array(
                'category_name' => trim($this->input->post('category_name')), 
                'description' => trim($this->input->post('description'))
            );

            $id = $this->input->post('action_id');

            // print_r($data);
            $result = $this->db->where('id', $id)->update('tbl_category', $data);

            if($result) {
                echo 'update';
            }
            else{
                return false;
            }
        }
    }

    public function category_edit() {
        if($this->input->post('id')) {
            $id  = $this->input->post('id');

            $result = $this->db->query("select * from tbl_category where id=? and status ='a'", $id)->result();

            $subArray = array();

            foreach($result as  $key => $value) {
                $subArray['category_name'] = $value->category_name;
                $subArray['description'] = $value->description;
            }
            echo json_encode($subArray);
        }

    }

    public function category_delete() {
        if($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array('status' => 'd');

            $result = $this->db->where('id', $id)->update('tbl_category', $data);

            if($result) {
                echo 'delete';
            }
            else {
                return false;
            }
        }
    }

    public function unit() {
        $data['title']='Add Unit';
		$data['page']='Setting / Unit Entry';
        $data['units']= $this->db->query("select * from tbl_unit where status = 'a' order by id desc")->result();
		$data['backend_content']='store/unit';
		$this->load->view('admin/layout',$data);
    }

    public function save_unit() {
        if($this->input->post('action') == 'create') {
            $data  = array(
                'unit_name' => trim($this->input->post('unit_name')), 
                'status' => 'a',
            );

            // print_r($data);
            $result = $this->db->insert('tbl_unit', $data);
            if ($result) {
                echo 'success';
            } else {
                return false;
            }
            
        }

        if($this->input->post('action') == 'update') {
            $data = array(
                'unit_name' => trim($this->input->post('unit_name')), 
            );

            $id = $this->input->post('action_id');

            // print_r($data);
            $result = $this->db->where('id', $id)->update('tbl_unit', $data);

            if($result) {
                echo 'update';
            }
            else{
                return false;
            }
        }
    }

    public function unit_edit() {
        if($this->input->post('id')) {
            $id  = $this->input->post('id');

            $result = $this->db->query("select * from tbl_unit where id=? and status ='a'", $id)->result();

            $subArray = array();

            foreach($result as  $key => $value) {
                $subArray['unit_name'] = $value->unit_name;
            }
            echo json_encode($subArray);
        }
    }

    public function unit_delete() {
        if($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array('status' => 'd');

            $result = $this->db->where('id', $id)->update('tbl_unit', $data);

            if($result) {
                echo 'delete';
            }
            else {
                return false;
            }
        }
    }

    public function get_products() {
        $products = $this->db->query("
            SELECT 
                p.*,
                concat(p.code , ' - ', product_name) as display_text,
                c.category_name,
                u.unit_name
            FROM tbl_product as p
                JOIN tbl_category as c ON p.category_id = c.id
                JOIN tbl_unit as u ON p.unit_id = u.id
            WHERE p.status ='a'
            ORDER BY p.id DESC
        ")->result();
        echo json_encode($products);
    }

    public function product() {
        $data['title']='Add Metarial';
		$data['page']='Setting / Metarial Entry';
		
        $data['products']= $this->db->query("
            SELECT 
                p.*,
                c.category_name,
                u.unit_name
            FROM tbl_product as p
                JOIN tbl_category as c ON p.category_id = c.id
                JOIN tbl_unit as u ON p.unit_id = u.id
            WHERE p.status ='a'
            ORDER BY p.id DESC
            ")->result();
		$data['backend_content']='store/product';
		$this->load->view('admin/layout',$data);
    }

    public function save_product() {
        if($this->input->post('action') == 'create') {
            $data = array(
                'code' => trim($this->input->post('code')),
                'product_name' => trim($this->input->post('product_name')),
                'category_id' => trim($this->input->post('category_id')),
                'unit_id' => trim($this->input->post('unit_id')),
                'vat' => trim($this->input->post('vat')),
                'order_level' => trim($this->input->post('order_level')),
                'purchase_rate' => trim($this->input->post('purchase_rate')),
                'added_by' => $this->session->userdata('userid'),
                'added_date' => date("Y-m-d H:i:s"),
                'status' => 'a'
            );

            // print_r($data);

            $result = $this->db->insert('tbl_product', $data);
            if($result) {
                echo 'insert';
            }
            else {
                return false;
            }
        }

        if($this->input->post('action') == 'update') {
            $data = array(
                'code' => trim($this->input->post('code')),
                'product_name' => trim($this->input->post('product_name')),
                'category_id' => trim($this->input->post('category_id')),
                'unit_id' => trim($this->input->post('unit_id')),
                'vat' => trim($this->input->post('vat')),
                'order_level' => trim($this->input->post('order_level')),
                'purchase_rate' => trim($this->input->post('purchase_rate')),
                'update_by' => $this->session->userdata('userid'),
                'update_date' => date("Y-m-d H:i:s")
            );

            // print_r($data);
            $id = $this->input->post('action_id');

            $result = $this->db->where('id', $id)->update('tbl_product', $data);
            if($result) {
                echo 'update';
            }
            else {
                return false;
            }
        }
    }

    public function product_edit() {
        if($this->input->post('id')) {
            $id = $this->input->post('id');
            $result = $this->db->query("
                select * from tbl_product where id=? and status='a'
            ",$id)->result();

            $subArray = array();
            foreach($result as $key => $value) {
                $subArray['code'] = $value->code;
                $subArray['product_name'] = $value->product_name;
                $subArray['category_id'] = $value->category_id;
                $subArray['unit_id'] = $value->unit_id;
                $subArray['vat'] = $value->vat;
                $subArray['order_level'] = $value->order_level;
                $subArray['purchase_rate'] = $value->purchase_rate;
            }

            echo json_encode($subArray);
        }
    }

    public function product_delete() {
        if($this->input->post('id')) {
            $id = $this->input->post('id');
            $data = array('status' => 'd');

            $result = $this->db->where('id', $id)->update('tbl_product', $data);

            if($result) {
                echo 'delete';
            }
            else {
                return false;
            }
        }
    }

}
?>