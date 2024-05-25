<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Myorder extends CI_Controller {

	private $id;
	protected $apiKey = '7WxeugecFL2wgn2H2OuA';
	protected $mrcId = 'digi220201';	
	public function __construct()
	{
		parent::__construct();
		is_login();
		$this->load->model('myorder_model', 'myorder');
	}
	
	public function index() {
		$data['title']	= 'My Order';
		$data['page']	= 'pages/myorder/index';
		$data['invoice']= $this->myorder->getMyOrders($this->session->userdata('id'));
		$data['orders'] = [];
		foreach($data['invoice'] as $order){

			$status = $this->detailOrder($order['transaction_id']);
			$status = json_decode($status, true);
			$order['status'] = $status['status'];
			array_push($data['orders'],$order);
		}
		$this->load->view('layouts/app', $data);
	}

	public function detail($invoice) {
		$data['title']				= 'My Order';
		$data['page']				= 'pages/myorder/detail';
		$data['order']				= $this->myorder->getMyOrderDetail($this->session->userdata('id'), $invoice);
		$data['order_detail'] 		= $this->myorder->getOrderDetail($invoice);
		$data['detailTransaksi'] = $this->detailOrder($data['order']['transaction_id']);
		
		$data['detail'] = json_decode($data['detailTransaksi'],true);
		$data['bank'] = $this->detailBank($data['detail']['payment_channel']);
		$this->load->view('layouts/app', $data);
	}

	public function confirm($invoice) {
		$this->form_validation->set_rules('account_name', 'Acoount name', 'required',[
			'required' => 'Acoount name is required.',
		]);
		$this->form_validation->set_rules('account_number', 'Account number', 'required|numeric',[
			'required' => 'Account number is required.',
			'numerin'	=> 'Account number must number.'
		]);
		$this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric',[
			'required' => 'Nominal is required.',
			'numeric'	=> 'Nominal must number.'
		]);

		// Jika sudah ada data terkirim
		if($this->input->post(null)){
			// Jika data salah
			if($this->form_validation->run() == false){
				$data['title']	= 'Payment Confirm';
				$data['page']	= 'pages/myorder/confirm';
				$data['order'] = $this->myorder->getMyOrderDetail($this->session->userdata('id'), $invoice);
				$this->load->view('layouts/app', $data);

			// Jika validasi benar
			}else{
				$data = [
					'orders_id'			=> $this->input->post('orders_id'),
					'account_name'		=> $this->input->post('account_name'),
					'account_number'	=> $this->input->post('account_number'),
					'nominal'			=> $this->input->post('nominal'),
					'note'				=> $this->input->post('note'),
				];
	
				if(!empty($_FILES['image']['name'])){
					$upload = $this->myorder->uploadProofPayment();	
					$data['image'] = $upload;
				}
	
				$this->myorder->insertPaymentConfirm($data);
				$this->myorder->updateStatus($data['orders_id']);
				$this->session->set_flashdata('success', 'Data saved successfully !.');
	
				redirect(base_url('myorder'));
			}
		// Jika belum ada data terkirim / pertama kali halaman di load
		}else {
			$data['title']	= 'Payment Confirm';
			$data['page']	= 'pages/myorder/confirm';
			$data['order'] = $this->myorder->getMyOrderDetail($this->session->userdata('id'), $invoice);
			$this->load->view('layouts/app', $data);
		}
	}

	public function cancel($id) {

		$transactionid = $this->detailTransaksi($id);

		$cancel = $this->cancelVa($transactionid['transaction_id']);
		$cancel = json_decode($cancel,true);
		if($cancel['status_code'] == 200 || $cancel['status_code'] == 201){
			$this->session->set_flashdata('success', 'Transaksi Berhasil di batalkan.');
			redirect('myorder');
		}
		elseif ($cancel['status_code'] == 400 || $cancel['status_code'] ==401) {
			$this->session->set_flashdata('error', 'Transaksi sudah expired');
			redirect('myorder');
		}
		dd($cancel);
	}

	protected function detailOrder($id) {
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

	protected function detailBank($va){
		$this->db->select('nama_bank');
		return $this->db->get_where('va_bank', ['payment_channel' => $va])->row_array();
	}

	protected function detailTransaksi($id) {
		return $this->db->get_where('orders', ['id' => $id])->row_array();
	}

	protected function cancelVa($id) {
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.mcpayment.id/va/transactions/'.$id,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'DELETE',
		CURLOPT_HTTPHEADER => array(
			'x-api-key:'.$this->apiKey
		),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}
}

/* End of file Myorder.php */
