<?php /* 15 September 2009 */ ?>

<h2>Recent multimedia</h2>
<ul id="recent_media">
  <?php #@todo: Woops, controller - back to front! + Limit.
  /*require APPPATH.'controllers/maltapi.php';
  $api = new MaltApi();
  $metas = $api->load_data();*/
  $this->load->library('malt_data');
  $media_data = Malt_data::load();
  foreach ($media_data as $media):
    $p=parse_url($media['url']);
    if ($p['host']!='youtube.com') continue; #&&$p['host']!='localhost' | false!==strpos($media['url'], '__'))
    $img=NULL;
    if (isset($media['image'])) {
      $img = "<img alt='' src='{$media['image']}' />";
    }
    ?>
  <li><a href="frame?url=<?php echo urlencode($media['url']) ?>"><?php echo $img ?> <span><?php echo $media['title'] ?></span></a></li>
  <?php endforeach; ?>
</ul>
