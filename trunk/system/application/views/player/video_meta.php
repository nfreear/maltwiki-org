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
$lang_ui = $this->config->item('_lang_pack');

$f_langs = $this->lang->select_names();
$f_themes= array('riz'=>'Standard', 'easy'=>'Easy', 'text'=>'Text only', '.'=>' &hellip; ', );
$f_alt   = array('cc'=>$this->lang->line('malt_captions'), 'tr'=>$this->lang->line('malt_transcript'),
    'ad'=>$this->lang->line('malt_audio_desc'), 'an'=>$this->lang->line('malt_annotations'));
?>
<div class="malt-vmeta" lang="en">
  <button class="showhide" onclick="alert('Not yet operational!');">Show/ hide panel</button>
  <?php #echo $this->lang->line('malt_help') ?>
<h2><?php echo $this->lang->span('malt_about_video', $media->title, $media->lang) ?></h2>
<dl class="info">
<dt><?php echo $this->lang->span('malt_contribute') ?></dt><dd><a href="#give-feedback"
 title="Let our contributors know what you think of the captions/audio description"><?php echo $this->lang->span('malt_give_feedback') ?></a>
&bull; <a href="#create" >Create/edit alternative content</a>
&bull; <a href="#request" title="Vote, to help drive our next contributions">Request alternatives</a>
&bull; <a href="#view-comments">View comments</a>
<img title="Useful? 3 out of 5" alt="Useful? 3 out of 5 stars" src="http://upload.wikimedia.org/wikipedia/commons/8/8c/3of5.png" /> </dd>
<dt>Contributors</dt> <dd><?php echo contributors($media); ?></dd>
<dt>Copyright</dt> <dd>Video - &copy; 2009 John Doe. Some rights reserved.</dd>
<dt>Terms</dt> <dd><?php echo isset($media->license_url) ? license_parse($media->license_url, $xml=FALSE) :''; ?>
 <em>[ Disclaimer: The Open University is not responsible for video, captions&hellip; except where attributed. ]</em></dd>
<dt>Video language</dt> <dd><?php echo $media->lang ?></dd>
<dt><abbr title="Captions/audio description language">Alt</abbr> language</dt> <dd>English.</dd>
<dt>Duration</dt> <dd><?php echo $media->duration ?></dd>
<dt>Description&hellip;</dt>
</dl>

<form lang="<?php echo $lang_ui ?>">
<h3><?php echo $this->lang->line('malt_personalize') ?></h3>

<input type="hidden" name="url" value="<?php echo $media->url ?>" />
<input type="hidden" name="demo" value="1" />
<ul class="personal">

<li class="f-alt"><fieldset><legend><?php echo $this->lang->line('malt_i_prefer') ?></legend>
<?php $out=''; foreach ($f_alt as $key => $name) {
  $checked = 'cc'==$key ? 'checked="checked"' :'';
  $out .=<<<EOF
  <label for="f-alt-$key" class="$key"><input type="checkbox" id="f-alt-$key" name="alt" value="$key" $checked /> $name</label>
EOF;
  }
  echo $out;
?>
</fieldset></li>

<li><label for="f-theme"><?php echo $this->lang->line('malt_theme') #(controls) ?> </label>
<select id="f-theme" name="theme">
<?php foreach ($f_themes as $code => $name): ?>
  <option value="<?php echo $code ?>"><?php echo $name ?></option>
<?php endforeach; ?>
</select></li>

<li><label for="f-lang"><?php echo $this->lang->line('malt_prefer_lang') ?> </label>
<select id="f-lang" name="lang">
<?php foreach ($f_langs as $key => $name):
  $checked = $lang_ui==$key ? 'selected="selected"' :''; ?>
  <option value="<?php echo $key.'" '.$checked ?>><?php echo $name ?></option>
<?php endforeach; ?>
</select></li>

</ul>
  <button type="submit"><?php echo $this->lang->line('malt_personalize') #onclick="alert('Partially operational!');"
   ?></button>
</form>
<div class="clear"></div>
</div>