<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Privasi extends CI_Controller {

    public function index(){
        $data['title'] 	= 'Privasi';
		$data['privasi']	= $this->getPrivasi();
		$data['page'] 		= 'pages/privasi/index';
		$this->load->view('layouts/app', $data);
    }
    public function kebijakanprivasi(){
        $data['title'] 	= 'Banner';
		$data['privasi']	= $this->getPrivasi();
		$data['page'] 		= 'pages/privasi/kebijakan';
		$this->load->view('layouts/app', $data);
      
      
    }
    public function add()
    {
        $this->form_validation->set_rules('description', 'Description', 'required',[
			'required' => 'Description is required.',
		]);
        if($this->form_validation->run() == false) {
			$data['title']		= 'Add Privasi';
			$data['page']		= 'pages/privasi/add';
			$this->load->view('layouts/app', $data);
		}else {

            $data =[
            'description' =>$this->input->post('description'),
            ];
        
            $this->insertPrivasi($data);
            $this->session->set_flashdata('success', 'Privasi succesfully added.');
			redirect(base_url('privasi'));
     }
    }
    public function edit($id)
    {
        $this->form_validation->set_rules('description', 'Description', 'required',[
			'required' => 'Description is required.',
		]);
        if($this->form_validation->run() == false) {
			$data['title']		= 'Edit Privasi';
			$data['privasi']		= $this->getprivasi();
			$data['page']		= 'pages/privasi/edit';
			$this->load->view('layouts/app', $data);
		}else {
            $data =[

                'description' =>$this->input->post('description'),
            ];
            $this->updatePrivasi($id,$data);
            $this->session->set_flashdata('success', 'Privasi succesfully updated.');
			redirect(base_url('privasi'));
        } 
    }
    public function delete($id)
    {
        $this->deletePrivasi($id);
        $this->session->set_flashdata('success', 'Privasi succesfully deleted.');
        redirect(base_url('privasi'));
    }
    protected function getPrivasi(){
        return $this->db->get('privasi')->row_array();
    }
    protected function insertPrivasi($data){
        $this->db->insert('privasi', $data);
    }
    protected function updatePrivasi($id, $data){
        $this->db->update('privasi', $data, ['id' => $id]);
    }
    protected function deletePrivasi($id){
        $this->db->delete('privasi', ['id' => $id]);
    }

   
}