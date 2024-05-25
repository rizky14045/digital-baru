<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_uniplay extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		is_admin();
		$this->load->model('product_model', 'product');
	}
	
	public function index() {

		$this->load->library('uniplay');

		$data['title']		= 'Products';

		// error handling jika API uniplay error
		
		$get_saldo = $this->uniplay->inquiry_saldo();
		$get_dtu = $this->uniplay->inquiry_dtu();
		$get_voucher = $this->uniplay->inquiry_voucher();

		if($get_saldo->status == "200") {

			$data['status']		= $get_saldo->status;
			$data['message']	= $get_saldo->message;
			$data['saldo']		= $get_saldo->saldo;
			$product			= array_merge($get_voucher['list_product'], $get_dtu['list_product']);
			$buildarray = [];
			if(count($product) > 0) {
				foreach($product as $key => $val) {
					$buildarray[$key] = $val;
					$product_db = $this->product->getProductUniplayPublish($buildarray[$key]['slug']);
					$buildarray[$key]['product_id'] = $product_db['id'];
					$denom_array = $this->product->getProductDenom($product_db['id']);
					if(count($denom_array) > 0) {
						$total_price = 0;
						foreach ($denom_array as $key_denom => $value_denom) {
							$total_price += $value_denom['price'] != NULL ? $value_denom['price'] : 0;
						}

						if($total_price > 0) {
							$buildarray[$key]['status']	= "Product available to buy";
						} else {
							$buildarray[$key]['status']	= "Please specify the price";
						}
					} else {
						$buildarray[$key]['status']	= "Please specify the price";
					}
					$buildarray[$key]['publish'] = $this->product->CheckProductUniplayPublish($buildarray[$key]['slug']);
				}
			}
			$data['product'] = $buildarray;
			$data['page']		= 'pages/product_uniplay/index';
			$this->load->view('layouts/app', $data);

		} else {

			$data['status']		= $get_saldo->status;
			$data['message']	= $get_saldo->message;
			$data['saldo']		= NULL;
			$data['product']	= array();
			$data['page']		= 'pages/product_uniplay/index';
			$this->load->view('layouts/app', $data);
		}
	}

	public function add() {
		$this->load->library('uniplay');

		$arr_product_uniplay = $this->input->post('chk_game');
		
		$get_dtu 		= $this->uniplay->inquiry_dtu();
		$get_voucher 	= $this->uniplay->inquiry_voucher();
		$product		= array_merge($get_voucher['list_product'], $get_dtu['list_product']);

		if(count($arr_product_uniplay) > 0) {
			$dataInsert = array();
			foreach ($arr_product_uniplay as $key => $value) {
				## Get Uniplay API Where Slug
				$arr_uniplay_product = searchForSlug($value, $product);
				if(count($arr_uniplay_product) > 0) {
					$dataInsert['uniplay_id'] = $arr_uniplay_product['id'];
					$dataInsert['kategori'] = $arr_uniplay_product['kategori_id'];
					$dataInsert['name'] = $arr_uniplay_product['name'];
					$dataInsert['edition'] = $arr_uniplay_product['kategori'];
					$dataInsert['image'] = substr($arr_uniplay_product['image'], strrpos($arr_uniplay_product['image'], '/') + 1);
					file_put_contents('./images/game/'.$dataInsert['image'], file_get_contents($arr_uniplay_product['image']));

					$dataInsert['description'] = $arr_uniplay_product['publisher'] . " Website : " . $arr_uniplay_product['publisher_website'];
					$dataInsert['requirements'] = "";
					$dataInsert['slug_key_uniplay'] = $arr_uniplay_product['slug'];
					if($arr_uniplay_product['slug'] == "mobile-legends" || $arr_uniplay_product['slug'] == "one-punch-man-the-strongest" || $arr_uniplay_product['slug'] == "lifeafter") {
						$dataInsert['flag_server_id'] = 1;
					} else {
						$dataInsert['flag_server_id'] = 0;
					}
					## Insert product ## Get product_id
					$product_id = $this->product->insertProductUniplay($dataInsert);

					## Insert denom
					if(count($arr_uniplay_product['denom']) > 0) {
						foreach ($arr_uniplay_product['denom'] as $key_denom => $value_denom) {
							$dataInsertDenom[$key_denom]['uniplay_id'] = $value_denom['id'];
							$dataInsertDenom[$key_denom]['product_id'] = $product_id;
							$dataInsertDenom[$key_denom]['name'] = $value_denom['package'];
							$dataInsertDenom[$key_denom]['price_reseller'] = $value_denom['price'];
						}
						$product_id = $this->product->insertProductUniplayDenom($dataInsertDenom);
					}
				}
			}
		}
		redirect(base_url('product_uniplay'));
	}

	public function edit($id) {
		$this->form_validation->set_rules('description', 'Description', 'required',[
			'required' => 'Description is required.',
		]);

		$data['product_denom']	= $this->product->getProductDenom($id);
		if(count($data['product_denom']) > 0) {
			foreach ($data['product_denom'] as $key => $value) {
				$this->form_validation->set_rules('price['.$value['id'].']', 'Price', 'required|numeric',[
					'required' => 'Price is required.',
					'numeric'  => 'Price must number.'
				]);
			}
		}

		if($this->form_validation->run() == false) {
			$data['title']		= 'Update Game';
			$data['page']		= 'pages/product_uniplay/edit';
			$data['product']		= $this->product->getProduct($id);
			$this->load->view('layouts/app', $data);
		} else {
			$id = $this->input->post('id');
			$data = [
				'description'	=> $this->input->post('description'),
				'requirements'	=> $this->input->post('requirements'),
			];
			$this->product->updateProduct($id, $data);
			
			if(count($this->input->post('price')) > 0) {
				foreach ($this->input->post('price') as $key => $value) {
					$this->product->updateProductDenom($key, array("price" => $value));
				}
			}
			$this->session->set_flashdata('success', 'Game succesfully updated.');

			redirect(base_url('product_uniplay'));
		}
	}

	public function delete($id) {
		## lakukan pengecekan jika barang sudah ada di cart dan order
		$count_product_cart = $this->product->CheckProductCart(($id));
		if($count_product_cart > 0) {
			$this->session->set_flashdata('error', "The game can't be deleted because it's already in the cart");

			redirect(base_url('product_uniplay'));
		}

		$count_product_order = $this->product->CheckProductOrder(($id));
		if($count_product_order > 0) {
			$this->session->set_flashdata('error', "The game can't be deleted because it's already in the order");

			redirect(base_url('product_uniplay'));
		}
		$produk = $this->product->getProduct(($id));
		unlink('images/game/' . $produk['image']);
		$this->product->deleteProduct($id);
		$this->session->set_flashdata('success', 'Game succesfully deleted.');

		redirect(base_url('product_uniplay'));
	}

}

/* End of file Product.php */
