<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uniplay {

	private $api_key = "5JLNKF9GXN90WYKKFHIYWH3VWZUDVREC5VWDS5";
	private $timestamp = "";
	private $upl_signature = "";
	private $access_token = "";
	private $pincode = "292929";

	public function __construct($rules = array()) {
		$this->ci =& get_instance();

		date_default_timezone_set("Asia/Bangkok");

		$this->timestamp		= date("Y-m-d H:i:s");
		
		$config = array(
			'ssl_verify_peer'   => false,
			'ssl_verif_host'    => false,
			'request_timeout'   => 30,
			'response_timeout'  => 90,
			'accept_cookies'    => false
		);

		$this->ci->load->library('Http', $config);

	}

	private function _object_to_array_product($obj_array = array(), $kategori = '', $kategori_id = 0) {
		// build array
		$build_array = array();
		foreach (json_decode($obj_array) as $key => $value) {
			if(is_array($value)) {
				foreach ($value as $key_detail => $value_detail) {
					$build_array['list_product'][$key_detail] = (array) $value_detail;
					$build_array['list_product'][$key_detail]['kategori'] = $kategori;
					$build_array['list_product'][$key_detail]['kategori_id'] = $kategori_id;
					$build_array['list_product'][$key_detail]['slug'] = createSlug($value_detail->name);
					foreach ($value_detail->denom as $key_denom => $value_denom) {
						$build_array['list_product'][$key_detail]['denom'][$key_denom] = (array) $value_denom;
					}
				}
			} else {
				$build_array[$key] = $value;
			}
		}
		return $build_array;
	}

	private function get_signature($json_string) {
		$hmac_key 		= $this->api_key.'|'.$json_string;
		$upl_signature	= hash_hmac('sha512', $json_string, $hmac_key);
		return $upl_signature;
	}

	private function get_access_token() {
		$url			= 'https://api-reseller.uniplay.id/v1/access-token';
		$json_string 	= json_encode(array(
			"api_key" => $this->api_key, 
			"timestamp" => $this->timestamp
		));
		$headers		= array('UPL-SIGNATURE' => $this->get_signature($json_string));
		$response		= $this->ci->http->post($url, $json_string, $headers);
		return 			json_decode($response)->access_token;
	}

	public function inquiry_saldo()	{
		$url			= 'https://api-reseller.uniplay.id/v1/inquiry-saldo';
		$json_string 	= json_encode(array(
			"api_key" => $this->api_key, 
			"timestamp" => $this->timestamp
		));
		$headers		= array('UPL-ACCESS-TOKEN' => $this->get_access_token(), 'UPL-SIGNATURE' => $this->get_signature($json_string));
		$response		= $this->ci->http->post($url, $json_string, $headers);
		return			json_decode($response);
	}

	public function inquiry_dtu() {
		
		$url			= 'https://api-reseller.uniplay.id/v1/inquiry-dtu';
		$json_string 	= json_encode(array(
			"api_key" => $this->api_key, 
			"timestamp" => $this->timestamp
		));
		$headers		= array('UPL-ACCESS-TOKEN' => $this->get_access_token(), 'UPL-SIGNATURE' => $this->get_signature($json_string));
		$response		= $this->ci->http->post($url, $json_string, $headers);
		$data			= $this->_object_to_array_product($response, "Top Up Game", 2);
		return $data;
	}

	public function inquiry_voucher() {

		$url        = 'https://api-reseller.uniplay.id/v1/inquiry-voucher';
		$json_string 	= json_encode(array(
			"api_key" => $this->api_key, 
			"timestamp" => $this->timestamp
		));
		$headers 	= array('UPL-ACCESS-TOKEN' => $this->get_access_token(), 'UPL-SIGNATURE' => $this->get_signature($json_string), 'Content-Type' => 'application/json');
		$response = $this->ci->http->post($url, $json_string, $headers);

		$data = $this->_object_to_array_product($response, "Voucher", 3);
		return $data;
	}

	public function inquiry_payment_voucher($entitas_id = '', $denom_id = '') {
		// pemesanan produk voucher
		// voucher game_id, denom_id

		if($entitas_id == '') {
			return json_decode(json_encode(array("status" => "400", "message" => "Game ID Required")));
		} 

		if($denom_id == '') {
			return json_decode(json_encode(array("status" => "400", "message" => "Denom ID Required")));
		} 

		$url		= 'https://api-reseller.uniplay.id/v1/inquiry-payment';
		$json_string 		= json_encode(array(
			"api_key" => $this->api_key, 
			"timestamp" => $this->timestamp,
			"entitas_id" => $entitas_id,
			"denom_id" => $denom_id,
			// "user_id" => NULL,
			// "server_id" => NULL,
		));
		$headers 	= array('UPL-ACCESS-TOKEN' => $this->get_access_token(), 'UPL-SIGNATURE' => $this->get_signature($json_string));
		$response = $this->ci->http->post($url, $json_string, $headers);
		return json_decode($response);
	}

	public function inquiry_payment_dtu($entitas_id = '', $denom_id = '', $player_id = '', $server_id = '') {
		// pemesanan produk voucher
		// voucher game_id, denom_id

		if($entitas_id == '') {
			return json_decode(json_encode(array("status" => "400", "message" => "Game ID Required")));
		} 

		if($denom_id == '') {
			return json_decode(json_encode(array("status" => "400", "message" => "Denom ID Required")));
		} 

		if($player_id == '') {
			return json_decode(json_encode(array("status" => "400", "message" => "Player ID Required")));
		} 

		$url		= 'https://api-reseller.uniplay.id/v1/inquiry-payment';
		$json_string 		= json_encode(array(
			"api_key" => $this->api_key, 
			"timestamp" => $this->timestamp,
			"entitas_id" => $entitas_id,
			"denom_id" => $denom_id,
			"user_id" => $player_id,
			"server_id" => $server_id,
		));
		$headers 	= array('UPL-ACCESS-TOKEN' => $this->get_access_token(), 'UPL-SIGNATURE' => $this->get_signature($json_string));
		$response = $this->ci->http->post($url, $json_string, $headers);
		return json_decode($response);
	}

	public function confirm_payment($inquiry_id='') {
		// check order berdasarkan order id

		if($inquiry_id == '') {
			return json_decode(json_encode(array("status" => "400", "message" => "Inquiry ID Required")));
		} 
		
		$url			= 'https://api-reseller.uniplay.id/v1/confirm-payment';
		$json_string	= json_encode(array(
			"api_key" => $this->api_key, 
			"timestamp" => $this->timestamp, 
			"inquiry_id" => $inquiry_id, 
			"pincode" => $this->pincode
		));
		$headers 		= array('UPL-ACCESS-TOKEN' => $this->get_access_token(), 'UPL-SIGNATURE' => $this->get_signature($json_string));
		$response = $this->ci->http->post($url, $json_string, $headers);
		return json_decode($response);
	}

	public function check_order($order_id='') {
		// check order berdasarkan order id

		if($order_id == '') {
			return json_decode(json_encode(array("status" => "400", "message" => "Order ID Required")));
		} 
		
		$url			= 'https://api-reseller.uniplay.id/v1/check-order';
		echo $json_string	= json_encode(array(
			"api_key" => $this->api_key, 
			"timestamp" => $this->timestamp, 
			"order_id" => $order_id
		));
		$headers 		= array('UPL-ACCESS-TOKEN' => $this->get_access_token(), 'UPL-SIGNATURE' => $this->get_signature($json_string));
		$response = $this->ci->http->post($url, $json_string, $headers);
		return json_decode($response);
	}


    public function get_inqury_payment_uniplay_voucher($order_detail_id, $product_id, $denom_id) {
    	$this->ci->load->model('order_model', 'order');

    	$get_produk_uniplay_id = $this->ci->order->getProductUniplayID($product_id);
    	$get_denom_uniplay_id = $this->ci->order->getDenomUniplayID($denom_id);
		$set_payment_inquiry = $this->inquiry_payment_voucher($get_produk_uniplay_id, $get_denom_uniplay_id);

		if($set_payment_inquiry->status == "200") { 
			$this->ci->db->insert('orders_detail_uniplay', array(
				"order_detail_id" => $order_detail_id, 
				"inquiry_id" => $set_payment_inquiry->inquiry_id,
				"code_status_uniplay_inquiry" => $set_payment_inquiry->status,
				"text_status_uniplay_inquiry" => $set_payment_inquiry->message
			));
			$insert_id = $this->ci->db->insert_id();
			$data['inquiry_id'] = $set_payment_inquiry->inquiry_id;
			$data['insert_id'] 	= $insert_id;
			return $data;
		} else {
			return NULL;
		}
    }

    public function get_inqury_payment_uniplay_dtu($order_detail_id, $product_id, $denom_id, $player_id, $server_id) {
    	$this->ci->load->model('order_model', 'order');

    	$get_produk_uniplay_id = $this->ci->order->getProductUniplayID($product_id);
    	$get_denom_uniplay_id = $this->ci->order->getDenomUniplayID($denom_id);
    	$set_payment_inquiry = $this->inquiry_payment_dtu($get_produk_uniplay_id, $get_denom_uniplay_id, $player_id, $server_id);

    	if($set_payment_inquiry->status == "200") { 
			$this->ci->db->insert('orders_detail_uniplay', array(
				"order_detail_id" => $order_detail_id, 
				"inquiry_id" => $set_payment_inquiry->inquiry_id,
				"code_status_uniplay_inquiry" => $set_payment_inquiry->status,
				"text_status_uniplay_inquiry" => $set_payment_inquiry->message
			));
			$insert_id = $this->ci->db->insert_id();
			$data['inquiry_id'] = $set_payment_inquiry->inquiry_id;
			$data['insert_id'] 	= $insert_id;
			return $data;
		} else {
			return NULL;
		}
    }

    public function trigger_confirm_payment($inquiry_id, $insert_id) {

    	$confirm_payment = $this->confirm_payment($inquiry_id);
    	if($confirm_payment->status == "200") {
	    	$voucher_code = "";
	    	if(isset($confirm_payment->trx_resp_voucher_code)) {
	    		$voucher_code = $confirm_payment->trx_resp_voucher_code;
	    	}
	    	$this->ci->db->update('orders_detail_uniplay', array(
	    			"order_id" => $confirm_payment->order_id, 
	    			"trx_date" => $confirm_payment->order_info->trx_date_order,
	    			"trx_number" => $confirm_payment->order_info->trx_number,
	    			"trx_item" => $confirm_payment->order_info->trx_item,
	    			"trx_price" => $confirm_payment->order_info->trx_price,
	    			"status_uniplay" => $confirm_payment->order_info->trx_status,
	    			"code_voucher" => $voucher_code,
					"code_status_uniplay_payment" => $confirm_payment->status,
					"text_status_uniplay_payment" => $confirm_payment->message
	    		), ['id' => $insert_id]
	    	);
	    	return $confirm_payment->order_info->trx_number;
	    } else {
	    	$this->ci->db->update('orders_detail_uniplay', array(
					"code_status_uniplay_payment" => $confirm_payment->status,
					"text_status_uniplay_payment" => $confirm_payment->message
	    		), ['id' => $insert_id]
	    	);
	    	return FALSE;
	    }
    }

}