<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob extends CI_Controller {

	//@todo : action pada saat gagal bayar uniplay
	protected $apiKey = '7WxeugecFL2wgn2H2OuA';
	protected $mrcId = 'digi220201';	

    public function __construct()
	{
		parent::__construct();
		$this->load->model('order_model', 'order');
	}

    public function YWPQMRJENTDS() {
		$this->load->library('uniplay');

		// pengecekan ganti status mcpayment dari menunggu pembayaran, ke success atau expired, atau cancel dll
		$invoice = $this->order->getOrdersRequest();
		if(count($invoice) > 0) {
			foreach($invoice as $order) {
				$status = $this->detailOrder($order['transaction_id']);
				$status = json_decode($status,true);
				$order['status'] = $status['status'];
				if($status['status'] != 'REQUEST') {
					$statusmcpay['status_mcpay'] = $status['status'];
					$this->order->updateStatusMCpay($order['id'], $statusmcpay);
					echo "Order invoice number " . $order['invoice'] . " are ".$statusmcpay['status_mcpay']." from mcpayment \n ";
				}
			}
		}

		// jika pembayaran mc payment success maka jalankan perintah pemesanan ke uniplay
		$invoice_success = $this->order->getOrdersSuccess();
		if(count($invoice_success) > 0) {
			foreach ($invoice_success as $key => $value) {
				$order_detail = $this->order->getOrderDetail($value['id']);
				if(count($order_detail) > 0) {
					foreach ($order_detail as $key_detail => $value_detail) {
						if($value_detail['kategori'] != 1) {
							$order_detail_id = $value_detail['id'];
							$get_detail_status_uniplay = $this->order->getOrderDetailUniplay($order_detail_id);
							
							// jalankan pemesanan jika belum ada order_detail_uniplaynya
							if($get_detail_status_uniplay == NULL) {

								if($value_detail['kategori'] == 2) {
									$set_payment_inquiry = $this->uniplay->get_inqury_payment_uniplay_dtu($order_detail_id, $value_detail['product_id'], $value_detail['denom_id'], $value_detail['player_id'], $value_detail['server_id']);
								} elseif($value_detail['kategori'] == 3) {
									$set_payment_inquiry = $this->uniplay->get_inqury_payment_uniplay_voucher($order_detail_id, $value_detail['product_id'], $value_detail['denom_id']);
								}

								if($set_payment_inquiry != NULL) {
									$trx_number = $this->uniplay->trigger_confirm_payment($set_payment_inquiry['inquiry_id'], $set_payment_inquiry['insert_id']);
									if($trx_number == TRUE) {
										echo "Pembayaran Berhasil No Transaksi " . $trx_number . "\n";
									} else {
										echo "Pembayaran gagal \n";
									}
								} else {
									echo "Pemesanan gagal \n";
								}
							}
							// jalankan jika pemesanan sudah ada di order_detail_uniplaynya tapi pembayarannya gagal atau tidak 200
						}
					}
				}
			}
		}
		// error handling status
    }

	public function test() {
		$trx_voucher_code = "Code=1ueak2udsndi;SN=34234325234";
		echo $trx_voucher_code;

		$explode = explode(";", $trx_voucher_code);
		print_rr($explode);

		echo $explode[0];
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