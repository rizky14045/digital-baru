<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	protected $apiKey = '7WxeugecFL2wgn2H2OuA';
	protected $mrcId = 'digi220201';	

	public function __construct()
	{
		parent::__construct();
		is_login();
		$this->load->model('order_model', 'order');
	}
	
	public function index() {

    	$this->load->library('uniplay');

		$data['title']	= 'Orders';
		$data['page']	= 'pages/order/index';
		$data['saldo_uniplay']	= $this->uniplay->inquiry_saldo();
		$data['invoice']= $this->order->getOrders();
		$data['orders'] = [];
		foreach($data['invoice'] as $order){
			$status = $this->detailOrder($order['transaction_id']);
			$status = json_decode($status,true);
			$order['status'] = $status['status'];

			// if($order['status_mcpay'] != "SUCCESS") {
			// 	$status = $this->detailOrder($order['transaction_id']);
			// 	$status = json_decode($status,true);
			// 	$order['status'] = $status['status'];

			// 	if($status['status'] != 'REQUEST') { 
			// 		$statusmcpay['status_mcpay'] = $status['status'];
			// 		$this->order->updateStatusMCpay($order['id'], $statusmcpay);
			// 	}
			// } else {
			// 	$order['status'] = $order['status_mcpay'];
			// }

			$order['order_detail'] 	= $this->order->getOrderDetail($order['id']);
			array_push($data['orders'],$order);
		}
	
		$this->load->view('layouts/app', $data);
	}
	
	public function expired()
	{

    	$this->load->library('uniplay');
		$data['title']	= 'Orders';
		$data['page']	= 'pages/order/index';
		$data['saldo_uniplay']	= $this->uniplay->inquiry_saldo();
		$data['invoice']= $this->order->getOrderExpireds();
		$data['orders'] = [];
		foreach($data['invoice'] as $order){
			$order['status'] = $order['status_mcpay'];
			$order['order_detail'] 	= $this->order->getOrderDetail($order['id']);
			array_push($data['orders'],$order);
		}
	
		$this->load->view('layouts/app', $data);
	}

	public function detail($id)
	{
		$data['title']				= 'Order Detail';
		$data['page']				= 'pages/order/detail';
		$data['order'] 			= $this->order->getOrderDetailById($id);
		$data['order_detail'] 	= $this->order->getOrderDetail($id);
		$data['detailTransaksi'] = json_decode($this->detailOrder($data['order']['transaction_id']),true);
		$this->load->view('layouts/app', $data);
	}

	public function update($id)
	{
		$data['status'] = $this->input->post('status');
		$this->order->updateStatus($id, $data);
		$this->session->set_flashdata('success', 'Data updated successfully.');

		redirect(base_url("order/detail/$id"));
	}

	public function repeat_order($order_detail_id) {
		$this->load->library('uniplay');

		// delete uniplay order detail
		$this->db->delete('orders_detail_uniplay', ['order_detail_id' => $order_detail_id]);
		
		// insert inquiry baru
		$value_detail = $this->order->getOrderDetailID($order_detail_id);
		if($value_detail['kategori'] == 2) {
			$set_payment_inquiry = $this->uniplay->get_inqury_payment_uniplay_dtu($order_detail_id, $value_detail['product_id'], $value_detail['denom_id'], $value_detail['player_id'], $value_detail['server_id']);
		} elseif($value_detail['kategori'] == 3) {
			$set_payment_inquiry = $this->uniplay->get_inqury_payment_uniplay_voucher($order_detail_id, $value_detail['product_id'], $value_detail['denom_id']);
		}

		// get new payment
		if($set_payment_inquiry != NULL) {
			$trx_number = $this->uniplay->trigger_confirm_payment($set_payment_inquiry['inquiry_id'], $set_payment_inquiry['insert_id']);
			if($trx_number == TRUE) {
				$this->session->set_flashdata('success', 'Transaction successful transaction number ' . $trx_number);
				redirect(base_url("order"));
			} else {
				$this->session->set_flashdata('error', 'Transaction failed.');
				redirect(base_url("order"));
			}
		}
	}

	protected function detailOrder($id)
	{
		$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.mcpayment.id/va/transactions/'.$id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'x-api-key:'.$this->apiKey
			),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;
	}

}

/* End of file Order.php */
