<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Myorder_model extends CI_Model {

	public function getMyOrders($id) 
	{
		$this->db->order_by('id','desc');
		return $this->db->get_where('orders', ['user_id' => $id])->result_array();
	}

	public function getMyOrderDetail($id, $invoice) 
	{
		$this->db->where('user_id', $id);
		$this->db->where('invoice', $invoice);
		return $this->db->get('orders')->row_array();
	}

	public function uploadProofPayment() {
		$config = [
			'upload_path'     => './images/payments',
			'encrypt_name'    => TRUE,
			'allowed_types'   => 'jpg|jpeg|png|JPG|PNG|JPEG',
			'max_size'        => 3000,
			'max_width'       => 0,
			'max_height'      => 0,
			'overwrite'       => TRUE,
			'file_ext_tolower'=> TRUE
		];

		$this->load->library('upload', $config);
		
		if($this->upload->do_upload('image')){
			return $this->upload->data('file_name');
		}else{
			$this->session->set_flashdata('image_error', 'Uploaded file types are not permitted or the file is too large.');
			return false;
		}
	}
	
	public function insertPaymentConfirm($data) {
		$this->db->insert('orders_confirm', $data);
	}

	public function updateStatus($id){
		$this->db->update('orders', ['status' => 'paid'], ['id' => $id]);
	}

	public function getOrderDetail($id) 
	{
		$this->db->select('orders_detail.id, orders_detail.orders_id, orders_detail.product_id, orders_detail.subtotal, products.name, products.image, products.price, products.kategori, product_kategories.name as kategori_name');
		$this->db->from('orders_detail');
		$this->db->join('orders', 'orders.id = orders_detail.orders_id');
		$this->db->join('products', 'orders_detail.product_id = products.id');
		$this->db->join('product_kategories', 'product_kategories.id = products.kategori');
		$this->db->where('orders.invoice', $id);
		return $this->db->get()->result_array();
	}
	
	// public function insertBuktiTransfer($data, $invoice) {
	// 	$this->db->update('pemesanan', $data, ['invoice' => $invoice]);
	// }

	public function getOrderDetailUniplay($id) 
	{
		$this->db->select('*');
		$this->db->from('orders_detail_uniplay');
		$this->db->where('orders_detail_uniplay.order_detail_id', $id);
		return $this->db->get()->row_array();
	}


}

/* End of file Myorder_model.php */
