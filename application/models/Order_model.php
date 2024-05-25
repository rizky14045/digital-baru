<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

	public function getOrders() 
	{
		$this->db->select('*, status_mcpay as status, (SELECT users.name FROM users WHERE users.id = orders.user_id) as user_name');
		$this->db->where('status_mcpay', "");
		$this->db->or_where('status_mcpay', "SUCCESS");
		$this->db->order_by('id', "desc");
		return $this->db->get('orders')->result_array();
	}

	public function getOrderExpireds() 
	{
		$this->db->select('*, status_mcpay as status, (SELECT users.name FROM users WHERE users.id = orders.user_id) as user_name');
		$this->db->where('status_mcpay', "CANCEL");
		$this->db->or_where('status_mcpay', "FAILED");
		$this->db->or_where('status_mcpay', "EXPIRED");
		$this->db->order_by('id', "desc");
		return $this->db->get('orders')->result_array();
	}

	public function getOrdersRequest() {
		$this->db->where('status_mcpay', "");
		$this->db->order_by('id', "desc");
		return $this->db->get('orders')->result_array();
	}

	public function getOrdersSuccess() {
		$this->db->where('status_mcpay', "SUCCESS");
		$this->db->order_by('id', "desc");
		return $this->db->get('orders')->result_array();
	}

	public function getOrderDetailById($id) 
	{
		return $this->db->get_where('orders', ['id' => $id])->row_array();
	}

	public function getOrderDetail($id) 
	{
		$this->db->select('
			orders_detail.*, 
			products.name, 
			products.image, 
			products.price, 
			products.kategori, 
			product_kategories.name as kategori_name
		');
		$this->db->from('orders_detail');
		$this->db->join('products', 'orders_detail.product_id = products.id');
		$this->db->join('product_kategories', 'product_kategories.id = products.kategori');
		$this->db->where('orders_detail.orders_id', $id);
		return $this->db->get()->result_array();
	}

	public function getOrderDetailID($id) {
		$this->db->select('
			orders_detail.*, 
			products.name, 
			products.image, 
			products.price, 
			products.kategori, 
			product_kategories.name as kategori_name
		');
		$this->db->from('orders_detail');
		$this->db->join('products', 'orders_detail.product_id = products.id');
		$this->db->join('product_kategories', 'product_kategories.id = products.kategori');
		$this->db->where('orders_detail.id', $id);
		return $this->db->get()->row_array();
	}

	public function getOrderDetailUniplay($id) 
	{
		$this->db->select('*');
		$this->db->from('orders_detail_uniplay');
		$this->db->where('orders_detail_uniplay.order_detail_id', $id);
		return $this->db->get()->row_array();
	}

	public function getProductUniplayID($id) 
	{
		$this->db->select('uniplay_id');
		$this->db->from('products');
		$this->db->where('products.id', $id);
		return $this->db->get()->row()->uniplay_id;
	}

	public function getDenomUniplayID($id) 
	{
		$this->db->select('uniplay_id');
		$this->db->from('product_denoms');
		$this->db->where('product_denoms.id', $id);
		return $this->db->get()->row()->uniplay_id;
	}

	public function getOrderConfirm($id) 
	{
		return $this->db->get_where('orders_confirm', ['orders_id' => $id])->row_array();
	}

	public function updateStatus($id, $data)
	{
		$this->db->update('orders', $data, ['id' => $id]);
	}

	public function updateStatusMCpay($id, $data)
	{
		$this->db->update('orders', $data, ['id' => $id]);
	}

}

/* End of file Order_model.php */
