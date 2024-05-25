<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

	protected $apiKey = '7WxeugecFL2wgn2H2OuA';
	protected $mrcId = 'digi220201';	
	public function __construct()
	{
		parent::__construct();
		is_login();
		$this->load->model('checkout_model', 'checkout');
	}
	
	public function index()
	{
		$id 					= $this->session->userdata('id');   
		$data['title']		= 'Checkout';
		$data['page']		= 'pages/checkout/index';
		$data['bank']		= $this->getBank();
		$data['cart']		= $this->checkout->getCart($id);
		$this->load->view('layouts/app',$data);
	}

	public function create() {
		$this->form_validation->set_rules('name', 'Name', 'required',[
			'required' => 'Name is requried.',
		]);
		$this->form_validation->set_rules('address', 'Address', 'required',[
			'required' => 'Address is requried.',
		]);
		$this->form_validation->set_rules('phone', 'Phone', 'required|numeric',[
			'required' => 'Phone is requried.',
			'numeric'  => 'Phone must number.'
		]);
		$this->form_validation->set_rules('payment_channel', 'Bank', 'required',[
			'required' => 'Metode Pembayaran is requried.',
		]);

		if($this->form_validation->run() != false) {
			$total = $this->checkout->total($this->session->userdata('id'));

			$data = [
				'user_id'	=> $this->session->userdata('id'),
				'date'		=> date('Y-m-d'),
				'invoice'	=> $this->session->userdata('id') . date('YmdHis'),
				'total'		=> intval($total),
				'name'		=> $this->input->post('name'),
				'address'	=> $this->input->post('address'),
				'phone'		=> $this->input->post('phone'),
			];

			$detailbank = $this->getDetailBank($this->input->post('payment_channel'));

			$paymentcode = substr($data['phone'], 0, $detailbank['digit']);
			
			$order = [
				'mrc_id' => $this->mrcId,
				'amount' => $data['total'],
				'customer_info' => 'DigitalBaru',
				'payment_info' => 'Pembayaran Game',
				'order_id'=> $data['invoice'],
				'payment_code' => $paymentcode,
				'signature'=> hash('sha256',$detailbank['secret_key'].$this->mrcId.$total.'DigitalBaru'.'Pembayaran Game'.$data['invoice']),
				'expired_time' =>''

			];
			$payment = $this->gateway($order,$detailbank['payment_channel']);
			$payment = json_decode($payment,true);			
			if($payment['status_code'] ==201 || $payment['status_code'] ==200) {
				$data['transaction_id'] = $payment['transaction_id'];
				$data['payment_code'] = $payment['payment_code'];
				$data['bank_id'] = $detailbank['payment_channel'];
				$data['expired_time'] = $payment['expired_time'];

				// Masukkan data ke table orders
				if($order = $this->checkout->insertOrder($data)) {
					$cart = $this->checkout->getCartByIdUser($this->session->userdata('id'));
					foreach($cart as $c) {
						$c['orders_id'] = $order;
						unset($c['id'], $c['user_id']);
						$this->checkout->insertOrdersDetail($c);
					}

					// Hapus data pada keranjang
					$this->checkout->deleteCart($this->session->userdata('id'));
					$this->session->set_flashdata('success', 'Data saved successfully.');
					$data['title'] 	= 'Checkout Success';
					$data['content']	= $data;
					$data['page']		= 'pages/checkout/success';
					$this->load->view('layouts/app', $data);
				}

			} elseif($payment['status_code'] ==400 || $payment['status_code'] ==401){
				$data['title']		= 'Checkout';
				$data['page']		= 'pages/checkout/error';
				$data['content']		= $payment;
				$this->load->view('layouts/app',$data);
			}
			
		}else{
			$data['title']		= 'Checkout';
			$data['page']		= 'pages/checkout/index';
			$data['bank']		= $this->getBank();
			$data['cart']		= $this->checkout->getCart($this->session->userdata('id'));
			$this->load->view('layouts/app',$data);
		}
	}

	public function gateway($data,$channel) {
		$curl = curl_init();

		$order = json_encode($data);
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.mcpayment.id/va/transactions?payment='.$channel,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>$order,
			CURLOPT_HTTPHEADER => array(
				'x-api-key:'.$this->apiKey,
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}

	protected function getBank() {
		return $this->db->get('va_bank')->result_array();
	}

	protected function getDetailBank($va) {
		return $this->db->get_where('va_bank', ['payment_channel' => $va])->row_array();
	}

}

/* End of file Checkout.php */
