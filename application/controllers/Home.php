<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model', 'home');
	}
	
	public function index()
	{
		$data['title'] 	= 'Home';
		$data['games']		= $this->home->getAllHome();
		$data['games_last']	= $this->home->getAllHomeLast();
		$data['banners']	= $this->home->getAllBanner();
		$data['page']		= 'pages/home/index';
		$this->load->view('layouts/app', $data);
	}

	public function allGames()
	{
		$data['title'] 	= 'All Games';
		$data['games']		= $this->home->getAllGame();
		$data['banners']	= $this->home->getAllBanner();
		$data['page']		= 'pages/home/allgames';
		$this->load->view('layouts/app', $data);
	}

	public function allGamesKategori($title = "")
	{
		$data['title'] 		= urldecode($title);
		$data['games']		= $this->home->getGameKageori(urldecode($title));
		$data['page']		= 'pages/home/kategorigames';
		$this->load->view('layouts/app', $data);
	}

	public function detail($id)
	{
		$data['title'] = 'Detail Game';
		$data['game']	= $this->home->getGameById($id);
		$data['page']	= 'pages/home/detail';
		$this->load->view('layouts/app', $data);
	}

}

/* End of file Home.php */
