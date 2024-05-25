<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		is_admin();
	}
    public function index(){
        
        $data['title'] 	= 'Banner';
		$data['bank']	= $this->getBank();
		$data['page'] 		= 'pages/bank/index';
		$this->load->view('layouts/app', $data);
    }

    public function add()
    {
        $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'required',[
			'required' => 'Nama Bank is required.',
		]);
		$this->form_validation->set_rules('payment_channel', 'Payment Channel', 'required',[
			'required' => 'Payment Channel is required.',
		]);
		$this->form_validation->set_rules('secret_key', 'Secret Key', 'required',[
			'required' => 'Secret Key is required.',
		]);

        if($this->form_validation->run() == false) {
			$data['title']		= 'Add Bank';
			$data['page']		= 'pages/bank/add';
			$this->load->view('layouts/app', $data);
		}else {

            $data =[
            'nama_bank' =>$this->input->post('nama_bank'),
            'payment_channel' =>$this->input->post('payment_channel'),
            'secret_key' =>$this->input->post('secret_key'),
            ];
        
            $this->insertBank($data);
            $this->session->set_flashdata('success', 'Bank succesfully added.');

			redirect(base_url('bank'));
     }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'required',[
			'required' => 'Nama Bank is required.',
		]);
		$this->form_validation->set_rules('payment_channel', 'Payment Channel', 'required',[
			'required' => 'Payment Channel is required.',
		]);
		$this->form_validation->set_rules('secret_key', 'Secret Key', 'required',[
			'required' => 'Secret Key is required.',
		]);
        if($this->form_validation->run() == false) {
			$data['title']		= 'Add Bank';
			$data['bank']		= $this->getBankDetail($id);
			$data['page']		= 'pages/bank/edit';
			$this->load->view('layouts/app', $data);
		}else {
            $data =[
            'nama_bank' =>$this->input->post('nama_bank'),
            'payment_channel' =>$this->input->post('payment_channel'),
            'secret_key' =>$this->input->post('secret_key'),
            ];
            $this->updateBank($id,$data);
            $this->session->set_flashdata('success', 'Bank succesfully updated.');
			redirect(base_url('bank'));
        } 
    }
    public function delete($id)
    {
        $this->deleteBank($id);
        $this->session->set_flashdata('success', 'Bank succesfully deleted.');
        redirect(base_url('bank'));
    }
    protected function getBank()
    {
        return $this->db->get('va_bank')->result_array();
    }
    protected function getBankDetail($id)
    {
        return $this->db->get_where('va_bank', ['id' => $id])->row_array();
    }

    protected function insertBank($data)
    {
        $this->db->insert('va_bank', $data);
    }
    public function updateBank($id, $data) 
	{
		$this->db->update('va_bank', $data, ['id' => $id]);
	}

	public function deleteBank($id)
	{
		$this->db->delete('va_bank', ['id' => $id]);
	}

}