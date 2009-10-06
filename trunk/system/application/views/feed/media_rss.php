<?php
/**
 @author NDF, 16 Sep 2009.

 http://openlearn.open.ac.uk/rss/file.php/stdfeed/2805/formats/S250_3_rss.xml
 http://wiki.creativecommons.org/CcLearn_Search_Metadata | http://wiki.creativecommons.org/Syndication

 xmlns:dc="http://purl.org/dc/elements/1.1/"
 xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
 xmlns:admin="http://webns.net/mvcb/"
 xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
 xmlns:content="http://purl.org/rss/1.0/modules/content/"
 <admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />
*/
#@todo: Woops, controller - back to front! + Limit.

  $this->load->library('malt_data');
  $media_data = Malt_data::load();

  $feed_name= 'Accessible media';
  $feed_url = $this->config->site_url().'media/rss';
  $page_language=$this->config->item('_lang');
  $page_description=NULL;
  $creator_email='N.D.Freear@open.ac.uk';
  $base_path = $this->config->site_url().'frame?url='; #@todo.

/**
 * http://creativecommons.org/licenses/by/2.0/uk/
 * http://i.creativecommons.org/l/by/2.0/uk/80x15.png
 */
function license_parse($url, $xml=TRUE) {
  if (!$url) return NULL;

  $p = parse_url($url);
  if ('creativecommons.org'!=$p['host']) return NULL;

  if (preg_match('#licenses\/([\w-]+)\/([\d\.]+)#', $p['path'], $matches)) { #(\/(\w*))?
    $terms  = $matches[1];
    $version= $matches[2];
    $text = 'Creative Commons';
    #$jurisdiction = $matches[4];
    if (false!==strpos($terms, 'by')) {
      $text .=' Attribution';
    }
    if (false!==strpos($terms, 'nc')) {
      $text .=' Non commercial';
    }
    if (false!==strpos($terms, 'nd')) {
      $text .=' No derivatives';
    }
    if (false!==strpos($terms, 'sa')) {
      $text .=' Share alike';
    }
    $text.=" $version License";
    $rdf = "http://creativecommons.org/licenses/$terms/$version/rdf";
    $img = "http://i.creativecommons.org/l/$terms/$version/80x15.png"; #88x31.

    if (!$xml) {#HTML.
      $html =<<<EOF
  <a rel="license" href="$url"><img alt="$text" title="$text" src="$img" /></a>
EOF;
      return $html;
    }
    $xmlns = 'xmlns:atom="http://www.w3.org/2005/Atom"';
    $xml =<<<EOF
<atom:link rel="license" href="$url" title="$text" />
<atom:link rel="license" type="application/rdf+xml" href="$rdf" />

EOF;
    return $xml;
  }  
}

#header('Content-Type: application/xml; charset=UTF-8'); #??
echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL; ?>
<rss version="2.0"
  xmlns:atom="http://www.w3.org/2005/Atom"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
  <channel>
    <title><?php echo /*xml_convert(*/$feed_name; ?></title>
    <link><?php echo $this->config->site_url(); ?></link>
    <description><?php echo /*xml_convert(*/$page_description; ?></description>
    <language><?php echo $page_language; ?></language>
    <dc:creator><?php echo $creator_email; ?></dc:creator>   
    <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>

  <?php foreach ($media_data as $entry):
      $p=parse_url($entry['url']);
      if ($p['host']!='youtube.com') continue;
      $body = '<img alt="" src="'.$entry['image'].'" width="120" height="90" /> ';
      $body .= isset($entry['description']) ? '<p>'.$entry['description'].'</p>' :'';
      $license = isset($entry['license_url']) ? license_parse($entry['license_url']) :'';
      $body .= isset($entry['license_url']) ? license_parse($entry['license_url'], $xml=FALSE) :'';
  ?>
    <item>
      <title><?php echo /*xml_convert(*/$entry['title']; ?></title>
      <link><?php echo $base_path . urlencode($entry['url']); ?></link>
      <guid><?php $base_path . urlencode($entry['url']); ?></guid>
      <description><![CDATA[<?php echo $body ?>]]></description>
      <pubDate><?php echo isset($entry['date'])? date('r', strtotime($entry['date'])) :''; ?></pubDate>
      <?php echo $license ?>
    </item>   
  <?php endforeach; ?>
  </channel>
</rss>