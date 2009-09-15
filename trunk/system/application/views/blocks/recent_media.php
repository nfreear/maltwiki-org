<?php /* 15 September 2009 */ ?>

<h2>Recent multimedia</h2>
<ul id="recent_media">
  <?php #@todo: Back to front! Limit.
  require APPPATH.'controllers/maltapi.php';
  $api = new MaltApi();
  $metas = $api->load_data();
  foreach ($metas as $media) {
    $p=parse_url($media['url']);
    if ($p['host']!='youtube.com') continue; #false!==strpos($media['url'], '__'))
    ?>
  <li><a href="frame?url=<?php echo urlencode($media['url']) ?>"><img alt=""
   src="<?php echo $media['image']; #hqdefault? ?>" /> <span><?php echo $media['title'] ?></span></a></li>
  <?php } ?>
</ul>
