<?php
/** Home and about pages, RSS feed, redirects.
 */

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();
        $this->load->library('layout', 'layout_main');
        $this->load->library('Mutil');
        $this->load->helper('url');
	}

	function index()
	{
		$this->layout->view('welcome_message');
	}

    function about() {
        $data['title'] = 'About MALT Wiki';
        #$data['navigation'] = 'about'; 
        $this->layout->view('about/about', $data);
    }
    function notifications() {
        $data['title'] = 'Mailing list';
        $this->layout->view('about/notifications', $data);
    }
    function contact() {
        $data['title'] = 'Contact us';
        $this->layout->view('about/contact', $data);
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