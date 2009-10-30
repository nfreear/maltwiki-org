<?php
/**
 * A showcase videos block - will be 'recent videos/activity'.
 * @author 15 September 2009
 * @todo: meta-data, RSS link.
 */
$this->load->library('Mutil');
$this->load->library('malt_data');
?>

<h2>Showcase videos</h2>
<p>With captions or transcripts (sample audio description coming soon!)</p>
<ul id="recent_media">
  <?php #@todo: Woops, controller - back to front! + Limit.
  $media_data = Malt_data::load();
  foreach ($media_data as $media):
    $p=parse_url($media['url']);
    if ($p['host']!='youtube.com') continue; #&&$p['host']!='localhost' | false!==strpos($media['url'], '__'))
    $img=NULL;
    if (isset($media['image'])) {
      $img = "<img class='thumb' alt='' src='{$media['image']}' />";
    }
    $license = ''; #isset($media['license_url']) ? license_parse($media['license_url'], $xml=FALSE) :'';
    ?>
  <li><a href="frame?url=<?php echo urlencode($media['url']) ?>"><?php echo $img ?>
    <span><?php echo $media['title'] ?></span></a>
    <?php echo $license ?>
  </li>
  <?php endforeach; ?>
</ul>
<div class="clear"></div>
