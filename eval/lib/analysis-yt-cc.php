<?php
/**
 YouTube caption analysis
 @author N.D.Freear, 18 June 2009.
*/
error_reporting(E_ALL|E_STRICT);
date_default_timezone_set('Europe/London');
set_time_limit(300);  #ini_set('max_execution_time',300); #30.
header('Content-Type: text/plain; charset=utf-8');
turn_off_buffer();
$seconds = 5;


$words_EN_2 = array(
  #'apple','ball','car','dog','egg','flower','grapes','hat','icecream','jug','king','lemon','milk',
  'nut','owl','piano','queen','ring','star','telephone','umbrella','van','watch','x','yo-yo','zebra',
);
$queries = array('a', 'xy', 'z', 'dante',); #'moodle', 'open',);
$queries = array_merge($queries, $words_EN_2);
$time=date('c');


$milli_pauses = range(3500, 5500, 11); #mt_rand(11,13)); #223/154, OK.
shuffle($milli_pauses);

$csv = "YouTube caption analysis,,".PHP_EOL."N.D.Freear,,$time,,analysis-yt-cc.php,,".PHP_EOL;
$csv.= ",,".PHP_EOL;
$csv.= "Query,URL,Caption count,'All' count *,Proportion,(Pause 1 ms),(Pause 2),Example title *,Durations s*,,".PHP_EOL;
echo $csv;
$count=0;
foreach ($queries as $q) {
  $with= youtube_search($q, true);
  $p1  = $milli_pauses[$count++];
  usleep($p1 *1000);
  $wo  = youtube_search($q);
  $p2  = $milli_pauses[$count++];
  usleep($p2 *1000);
  #sleep($seconds);
  $prop= $with->total / $wo->total;
  $durations = implode(',', $wo->durations);

  echo "{$with->q},{$with->url},{$with->total},{$wo->total},{$prop},$p1,$p2,\"{$wo->a_title}\",$durations,,".PHP_EOL;
}
$csv = ",,".PHP_EOL;
$csv .= "* NOTE: example title and durations taken from Atom feeds - 'All' count,,".PHP_EOL;
$csv .= date('c').',,'.PHP_EOL;
echo $csv;



function youtube_search($query, $captions=false, $category=null) {
  $count = null;
  $max   = 10;
  $url = "http://gdata.youtube.com/feeds/api/videos?v=2&start-index=1&max-results=$max&q=";
  if ($captions) {
    $url = 'http://www.youtube.com/results?search_type=videos&closed_captions=1&search_query='; #&page=2&search_category=27; Education
  }
  $url .= urlencode($query);
  $categories = array('education'=>27, ); #@todo.

  $result = (object)array('q'=>$query, 'url'=>$url, 'cc'=>$captions);

  $data = http_get($url);
  $xmlo = @simplexml_load_string($data); #@simplexml_load_file($url);

  if ($captions) { #Screen-scrape.
    #if (!$xmlo) echo "<p>Error, SimpleXML/HTML: $url</p>".PHP_EOL;

    if (preg_match('#class="search-query">.+?<strong.+?<strong>(.{1,9})<\/strong#ms', $data, $matches)) {
      $count = $matches[1]; #8: millions, 924,100.
      if ('millions'==$count) $count = 1000000;
      $count = str_replace(',','', $count);

    } else {
      die('Error, regular expression/HTML: '.$url);
    }

  } else { #Atom-OpenSearch.
    $xmlo = @simplexml_load_string($data);
    if (!$xmlo) die('Error, SimpleXML/ Atom: '.$url);

    $xmlo->registerXPathNamespace('os', 'http://a9.com/-/spec/opensearch/1.1/');
    $xmlo->registerXPathNamespace('yt', 'http://gdata.youtube.com/schemas/2007');
    $xmlo->registerXPathNamespace('me', 'http://search.yahoo.com/mrss/');
    $count = $xmlo->xpath("//os:totalResults");
    $count = (string)$count[0];
    $durations= $xmlo->xpath("//yt:duration/@seconds");
    $titles = $xmlo->xpath("//me:title");
    $a_title= (string)$titles[mt_rand(0, count($titles)-1)];

    $result->a_title = $a_title;
    $result->durations = $durations;
  }
  $result->total = $count;
  #$result = (object)array('q'=>$query, 'url'=>$url, 'cc'=>$captions, 'total'=>$count);
  $result->url = str_replace('www.','', $result->url);
  return $result;
}


function http_get($url) {
  putenv('http_proxy=wwwcache.open.ac.uk:80'); #PHP_PEAR_HTTP_PROXY.
  putenv('NO_PROXY=localhost,127.0.0.1');

  // create a new cURL resource
  $ch = curl_init($url);

  // set URL and other appropriate options
  #curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_REFERER, 'http://www.youtube.com/');
  curl_setopt($ch, CURLOPT_USERAGENT,
'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11 (.NET CLR 3.5.30729)');

  // grab URL and pass it to the browser
  $data = curl_exec($ch);
  #echo $data;

  echo curl_error($ch);

  // close cURL resource, and free up system resources
  curl_close($ch);
  return $data;
}


function turn_off_buffer() {
  @apache_setenv('no-gzip', 1);
  @ini_set('zlib.output_compression', 0);
  @ini_set('implicit_flush', 1);
  for ($i = 0; $i < ob_get_level(); $i++) { ob_end_flush(); }
  ob_implicit_flush(1);
}


/* HTML - Line-breaks removed.

<div id="search-section-header"> 
		<div id="search-adv-header">
...
		</div>

	<div class="name">
			<span class="search-query">“ice”</span> video results

inEducation 

<strong>1 - 20</strong> of about <strong>66</strong>

	</div>
*/

/* <?xml version='1.0' encoding='UTF-8'?>
<feed
 xmlns='http://www.w3.org/2005/Atom'
 xmlns:media='http://search.yahoo.com/mrss/'
 xmlns:openSearch='http://a9.com/-/spec/opensearch/1.1/'
 xmlns:gd='http://schemas.google.com/g/2005'
 xmlns:yt='http://gdata.youtube.com/schemas/2007'
 gd:etag='W/&quot;A0QEQH88fSp7ImA9WxJWE08.&quot;'>

<id>tag:youtube.com,2008:videos</id>
<updated>2009-06-18T16:04:10.055Z</updated>
<category scheme='http://schemas.google.com/g/2005#kind' term='http://gdata.youtube.com/schemas/2007#video'/>
<title>YouTube Videos matching query: a</title>

<link rel='self' type='application/atom+xml' href=
 'http://gdata.youtube.com/feeds/api/videos?q=a&amp;start-index=1&amp;max-results=1&amp;v=2'/>
  ...

<openSearch:totalResults>1000000</openSearch:totalResults>
<openSearch:startIndex>1</openSearch:startIndex>
<openSearch:itemsPerPage>1</openSearch:itemsPerPage>

  <entry gd:etag='W/&quot;DkQNQ347eCp7ImA9WxJWEk4.&quot;'>
    <id>tag:youtube.com,2008:video:LU8DDYz68kM</id>
    ...
  </entry>
</feed> */
?>