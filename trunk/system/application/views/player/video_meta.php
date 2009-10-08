<?php
/**
 * A quick mockup of the panel below the video player, containing 'contribute' links,
 * meta-data including copyright/license terms, and personalization options.
 * @author N.D.Freear, 7 October 2009.
 *
 * @todo: Show/ hide Javascript, styling, wrapper-div, contributor links etc,  language strings.
 */
if (!isset($_REQUEST['demo'])) return;

$this->load->library('Mutil');

function contribs($contributors) {
  $out='';
  foreach ($contributors as $role => $name) {
    $out .= ucfirst($role)." - $name, ";
  }
  return $out;
}

$f_langs = array('en' =>'English', 'fr'=>'Francais', 'cmn-Hans'=>'Chinese, Simplified', );
$f_themes= array('riz'=>'Standard', 'easy'=>'Easy', 'text'=>'Text only', '.'=>' &hellip; ', );
$f_alt   = array('cc' =>'Captions', 'tr'=>'A transcript', 'ad'=>'Audio description');
#var_dump($media);
?>
<div class="malt-vmeta" lang="en">
  <button class="showhide" onclick="alert('Not yet operational!');">Show/ hide panel</button>
<h2>About <em><?php echo $media->title ?></em></h2>
<dl class="info">
<dt>Contribute</dt><dd><a href="#give-feedback" title="Let our contributors know what you think of the captions/audio description">Give feedback</a>
&bull; <a href="#create" >Create/edit alternative content</a>
&bull; <a href="#request" title="Vote, to help drive our next contributions">Request alternatives</a>
&bull; <a href="#view-comments">View comments</a>
<img title="Useful? 3 out of 5" alt="Useful? 3 out of 5 stars" src="http://upload.wikimedia.org/wikipedia/commons/8/8c/3of5.png" /> </dd>
<dt>Contributors</dt> <dd><?php echo isset($media->contributor) ? contribs($media->contributor) :''; ?> Captions - J.Bloggs&hellip;</dd>
<dt>Copyright</dt> <dd>Video - &copy; 2009 John Doe. Some rights reserved.</dd>
<dt>Terms</dt> <dd><?php echo isset($media->license_url) ? license_parse($media->license_url, $xml=FALSE) :''; ?>
 <em>[ Disclaimer: The Open University is not responsible for video, captions&hellip; except where attributed. ]</em></dd>
<dt>Video language</dt> <dd><?php echo $media->lang ?></dd>
<dt><abbr title="Captions/audio description language">Alt</abbr> language</dt> <dd>English.</dd>
<dt>Duration</dt> <dd><?php echo $media->duration ?></dd>
<dt>Description&hellip;</dt>
</dl>

<h3>Personalize</h3>
<form>
<input type="hidden" name="url" value="<?php echo $media->url ?>" />
<input type="hidden" name="demo" value="1" />
<ul class="personal">

<li class="f-alt"><fieldset><legend>I prefer </legend>
<?php $out=''; foreach ($f_alt as $key => $name) {
  $checked = 'cc'==$key ? 'checked="checked"' :'';
  $out .=<<<EOF
  <label for="f-alt-$key" class="$key"><input type="checkbox" id="f-alt-$key" name="alt" value="$key" $checked /> $name</label>
EOF;
  }
  echo $out;
?>
</fieldset></li>

<li><label for="f-theme">Theme (controls) </label>
<select id="f-theme" name="theme">
<?php foreach ($f_themes as $code => $name): ?>
  <option value="<?php echo $code ?>"><?php echo $name ?></option>
<?php endforeach; ?>
</select></li>

<li><label for="f-lang">Preferred language </label>
<select id="f-lang" name="lang">
<?php foreach ($f_langs as $code => $name): ?>
  <option value="<?php echo $code ?>"><?php echo $name ?></option>
<?php endforeach; ?>
</select></li>

</ul>
  <button type="submit" onclick="alert('Partially operational!');">Personalize</button>
</form>
<div class="clear"></div>
</div>