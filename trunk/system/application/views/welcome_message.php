<?php
/** @author N.D.Freear, updated 8 October 2009.
 */
#$this->load->view('layout/header');

if (!malt_is_live()) {
?>
<p class="warning" style="border:1px solid gray; background:#fbb; text-align:center; padding:1em; margin:2em; font-size:1.2em; ">
 The LIVE web site has moved to
 <a rel="bookmark follow" href="http://maltwiki.org/" style="font-weight:bold">Maltwiki.org</a> - please update your bookmarks.
 <br />iet-access.open.ac.uk/malt may be shut down in the near future.
</p>
<?php } ?>


<h1>Welcome to <abbr >MALT</abbr> Wiki!</h1>

<p> The <em>Multimedia Accessibility</em> project will provide a site for the
 community co-creation, editing, storage and delivery of alternative content
 &ndash; <abbr title="also known as sub-titles">captions</abbr> and audio description;
 and software services and components to improve online multimedia players.
</p>
<p> This is an experimental site which provides an 
 <a href="http://oembed.com/" title="oEmbed specification">oEmbed</a> compatible
 <a href="oembed?debug=1&amp;url=<?php echo urlencode(MALT_YOUTUBE_MOODLE) ?>" title="Javascript Object Notation JSON format" type="application/json">web service</a>
 for a video player with captions where available, and accessible controls.
 It also demonstrates the web service <a href="#oembed-0">in use</a>.
 We are experimenting with player personalization, and browser and software plugins.
</p>
<p>Find out more and join the <a class="cloudworks" href="discuss">discussion on Cloudworks</a></p>


<a class="embed" href="<?php echo MALT_YOUTUBE_MOODLE ?>">Learn about Moodle</a>


<?php $this->load->view('blocks/recent_media'); ?>

<?php #$this->load->view('blocks/twitter', array('user'=>'nfreear')); ?>

<?php #$this->load->view('layout/footer'); ?>