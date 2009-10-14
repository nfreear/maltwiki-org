<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();
        $this->load->helper('url');
        $this->load->library('Mutil');	
	}

	function index()
	{
		$this->load->view('welcome_message');
	}

    function embedtest() {
        $this->load->view('embedtestview');
    }

    function media_feed() {
        $this->load->view('feed/media_rss');
    }

    function discuss() {
        redirect(MALT_CLOUDWORKS_WEB);
    }

    function developer() { #@todo A cloud!
        redirect(MALT_CLOUDWORKS_WEB);
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */