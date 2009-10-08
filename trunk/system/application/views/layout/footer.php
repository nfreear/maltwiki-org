<?php
/** 15 September 2009
 */

$host = $_SERVER['HTTP_HOST'];
if ('maltwiki.org'!=$host || 'iet-access.open.ac.uk'!=$host) {
  ?>
</body></html>
  <?php
  return;
}
?>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='"+ gaJsHost +"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
 var pageTracker = _gat._getTracker("<?php echo MALT_ANALYTICS_ID ?>");
 pageTracker._trackPageview();
} catch(err) {}</script>

</body></html>
