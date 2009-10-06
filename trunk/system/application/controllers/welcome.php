<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}

	function index()
	{
		$this->load->view('welcome_message');
	}

    function rss_media() {
        $this->load->view('feed/media_rss');
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */