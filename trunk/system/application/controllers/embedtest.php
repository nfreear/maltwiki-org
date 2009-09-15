<?php
class EmbedTest extends Controller {

	function index()
	{
		$this->load->view('embedtestview');
	}

  function test($a, $b)
	{
		echo 'An embed test [embed:http://youtube.com/watch?v=grqt3HoLOIA] '.$a;
	}
}
?>