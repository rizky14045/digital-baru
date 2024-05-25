<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

	public function getAllHome()
	{
		$this->db->select('
			*,
			(
				IFNULL((SELECT COUNT(od.id) FROM orders_detail od WHERE od.product_id = products.id),0)
				+
				IFNULL((SELECT COUNT(cart.id) FROM cart WHERE cart.product_id = products.id),0)
			) as count_selling,
			(SELECT pk.name FROM product_kategories pk WHERE pk.id = products.kategori LIMIT 1) as kategori_name
		');
		$this->db->order_by('count_selling','desc');
		$this->db->limit((16*3));
		$result = $this->db->get('products')->result_array();
		$group_by_kategori = grouping_array_by_value($result, "kategori_name");

		return ($group_by_kategori);

	}

	public function getAllHomeLast()
	{
		$this->db->select('
			*,
			(
				IFNULL((SELECT COUNT(od.id) FROM orders_detail od WHERE od.product_id = products.id),0)
				+
				IFNULL((SELECT COUNT(cart.id) FROM cart WHERE cart.product_id = products.id),0)
			) as count_selling,
			(SELECT pk.name FROM product_kategories pk WHERE pk.id = products.kategori LIMIT 1) as kategori_name
		');
		$this->db->order_by('id','desc');
		$this->db->limit(4);
		$result = $this->db->get('products')->result_array();

		return ($result);

	}

	public function getAllGame()
	{
		$this->db->select('
			*,
			(SELECT pk.name FROM product_kategories pk WHERE pk.id = products.kategori LIMIT 1) as kategori_name
		');
		$this->db->order_by('name','asc');
		return $this->db->get('products')->result_array();
	}

	public function getGameKageori($kategori_name)
	{
		$this->db->select('
			*,
			(SELECT pk.name FROM product_kategories pk WHERE pk.id = products.kategori LIMIT 1) as kategori_name
		');
		$this->db->join('product_kategories', 'product_kategories.id = products.kategori', 'LEFT');
		$this->db->where('product_kategories.name',$kategori_name);
		$this->db->order_by('products.id','desc');
		return $this->db->get('products')->result_array();
	}

	public function getAllBanner()
	{
		return $this->db->get('banners')->result_array();
	}

	public function getGameById($id)
	{
		$this->db->select('
			*,
			(SELECT pk.name FROM product_kategories pk WHERE pk.id = products.kategori LIMIT 1) as kategori_name
		');
		$result = $this->db->get_where('products', ['id' => $id])->row_array();
		$result['denom'] = $this->db->order_by('price_reseller', 'ASC')->get_where('product_denoms', ['product_id' => $result['id'], 'price >' => 0])->result_array();
		return $result;
	}

}

/* End of file Home_model.php */
