<?php
/**
 * @author N.D.Freear, 15 September 2009.
 * <title>..(alpha)?
 */
?>
<!DOCTYPE html><html lang="en"><head><meta charset=utf-8 />
<title>MALT Wiki &ndash; Co-creating accessible video and multimedia</title>

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

<link rel="alternate" href="<?php echo MALT_CLOUDWORKS_FEED ?>"
 type="application/rss+xml" title="Related acessibility clouds on Cloudworks" />
<link rel="alternate" href="media/rss"
 type="application/rss+xml" title="Recent contributions to MALT Wiki" />

<link rel="stylesheet" href="assets/site/maltwiki.css" type="text/css" />
<link rel="shortcut icon" href="<?php echo MALT_FAVICON ?>" type="image/png" />
</head>
<body>
<div id="header">
  <div id="text"><abbr title="Multimedia alternatives">MALT</abbr> Wiki<small> alpha</small></div>
  <span id="strap">Co-creating accessible<br /> video and multimedia</span>
</div>

