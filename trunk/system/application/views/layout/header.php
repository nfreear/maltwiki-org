<?php
/**
 * @author N.D.Freear, 15 September 2009.
 * <title>..(alpha)?
 */
if (!isset($title)) {
  $title = 'Co-creating accessible video and multimedia';
}

?>
<!DOCTYPE html><html lang="en"><head><meta charset=utf-8 />
<title>MALT Wiki &ndash; <?php echo $title ?></title>

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<meta name="dc:Title" content="MALT Wiki" />
<meta name="description" content=
"This project will provide a site for the community co-creation, editing, storage and delivery of captions and audio description.
 We already provide software services to improve Flash video and multimedia players." />
<meta name="copyright" content="&copy; 2009 The Open University" />

<?php if (!malt_is_live()) { ?>
  <meta name="robots" content="noindex,follow" />
<?php } ?>

<link rel="made" href="mailto:<?php echo MALT_EMAIL ?>?subject=MALT-Wiki" />
<link rel="alternate" href="<?php echo MALT_CLOUDWORKS_FEED ?>"
 type="application/rss+xml" title="Related acessibility clouds on Cloudworks" />
<link rel="alternate" href="media/rss"
 type="application/rss+xml" title="Recent contributions to MALT Wiki" />

<link rel="stylesheet" href="<?php echo base_url() ?>assets/site/maltwiki.css" type="text/css" />
<link rel="shortcut icon" href="<?php echo base_url().MALT_FAVICON ?>" type="image/png" />

</head>
<body>
<div id="header">
  <div id="text"><abbr title="Multimedia alternatives">MALT</abbr> Wiki<small> alpha</small></div>
  <span id="strap">Co-creating accessible<br /> video and multimedia</span>
</div>


<div id="nav">
<h2 class="accesshide">Site navigation</h2>
<ul>
<li><a href="<?php echo base_url() ?>">Home</a></li>
<li><a href="<?php echo base_url() ?>about">About</a></li>
<li><a href="<?php echo base_url() ?>about/notifications">Mailing list</a></li>
<li><a href="<?php echo base_url() ?>about/contact">Contact us</a></li>
</ul>
</div>

<?php
/*<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>*/

#$favicon = MALT_FAVICON;
?>