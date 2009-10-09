<?php
/** @author NDF, updated 8 October 2009.
 */
$this->load->view('layout/header');
?>

<h1>Welcome to <abbr >MALT</abbr> Wiki!</h1>

<p> The <em>Multimedia Accessibility</em> project will provide a site for the
 community co-creation, editing, storage and delivery of alternative content
 &ndash; <abbr title="also known as sub-titles">captions</abbr> and audio description;
 and software services and components to improve online multimedia players.
</p>
<p> This is an experimental site which provides an 
 <a href="http://oembed.com/" title="oEmbed specification">oEmbed</a> compatible
 <a href="oembed?url=http%3A//youtube.com%2Fwatch%3Fv%3Dgrqt3HoLOIA" title="Javascript Object Notation JSON format" type="application/json">web service</a>
 for a video player with captions where available, and accessible controls.
 It also demonstrates the web service <a href="#oembed-0">in use</a>.
 We are experimenting with player personalization, and browser and software plugins.
</p>
<p>Find out more and join the <a class="cloudworks" href="http://cloudworks.ac.uk/cloudscape/view/1873">discussion on Cloudworks</a></p>


<a rel="embed" href="http://youtube.com/watch?v=grqt3HoLOIA">Learn about Moodle</a>


<?php $this->load->view('blocks/recent_media'); ?>

<?php $this->load->view('layout/footer'); ?>