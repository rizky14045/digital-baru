<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dev extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		is_admin();
	}

    public function index() {
    	$this->load->library('uniplay');

    	// $get_saldo = $this->uniplay->inquiry_saldo();
    	// print_r($get_saldo);die;

    	// $get_voucher = $this->uniplay->inquiry_voucher();
    	// print_rr($get_voucher['list_product'][0]);die;

    	// $game_id = $get_voucher['list_product'][1]['id'];
    	// $denom_id = $get_voucher['list_product'][1]['denom'][0]['id'];
    	// $set_payment_voucher = $this->uniplay->inquiry_payment_voucher($game_id, $denom_id);
    	// print_r($set_payment_voucher);

    	$get_dtu = $this->uniplay->inquiry_dtu();
    	// print_rr($get_dtu);

    	$game_id = $get_dtu['list_product'][0]['id'];
    	// $game_id = "NGwralhtNnJWdXd0b0E5bXRVZWRzeWxtbkV3Y2JGeEo3VEtHMFNKVmdoLy8zd1plU0Y1dFR5NGIrVlVwa241SlpTcjVDZG0wT2VaMG1xZXRNNXlkcnc9PQ==";
    	$denom_id = $get_dtu['list_product'][0]['denom'][0]['id'];
    	// $denom_id = "aUk5SHhDSmRUZjNjTmQveGlmUWhYZExEL0tCZVQ2L05jMkFSc3VTUENQUSttK25mR1ROWE5ELzNsMmdJRlBVQmROaWV1aTEzdnRQVXJrSHpqNzMra2c9PQ==";
    	$set_payment_dtu = $this->uniplay->inquiry_payment_dtu($game_id, $denom_id, "test");
		print_r($set_payment_dtu);

		$inquiry_id = $set_payment_dtu->inquiry_id;
		$confirm_payment = $this->uniplay->confirm_payment($inquiry_id);
		print_r($confirm_payment);

		$order_id = $confirm_payment->order_id;
		$check_order = $this->uniplay->check_order($order_id);
		print_r($check_order);

		// trx_resp_voucher_code

    }

	public function inquiry_payment() {
		
	}


}