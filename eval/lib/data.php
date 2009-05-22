<?php
/**
 Copyright 2009-02-05 N.D.Freear, Open University.
*/

$metas['xmoodle'] = array(
#height=350&width=500&searchbar=false&autostart=false
  'url'  =>'http://xtranormal.com/watch?e=20090124001058490',
  'file' =>'http://video.xtranormal.com/highres/aacd0182-e274-11dd-9b38-001b210ae39a_7.flv', #video.
  'image'=>'http://video.xtranormal.com/highres/aacd0182-e274-11dd-9b38-001b210ae39a_7_0.jpg',
  'captions'=>'http://localhost/upload/xmoodle.dfxp.xml',
  #'audio'   =>null,
  'lang' =>'en',
  'title'=>'Learn about Moodle, Xtranormal',
  'description'  =>'An elevator pitch for the online learning environment, Moodle.',
  'duration'     =>'00:51',
  'provider_name'=>'Xtranormal',
  'provider_url' =>'http://xtranormal.com/',
  'author_name'  =>'nickfreear',
);
$metas['corrie'] = array(
  'url'   =>'http://localhost/corrie',
  'file'  =>'http://localhost/upload/corrie.flv',
  'alt_media'=>'http://localhost/upload/corrie.mp4',
  'image' =>'http://localhost/upload/corrie.jpg',
  'captions'=>'http://localhost/upload/corrie.xml', #corrie_2.xml
  'audio' =>'http://localhost/upload/corrie.mp3',
  'lang'  =>'en',
  'title' =>'Coronation Street, audio description',
  'description'  =>'A small excerpt from ITV\'s Coronation Street',
  'duration'     =>'00:45',
  'provider_name'=>'localhost', #RNIB/ Longtailvideo.com (jw).
);
$metas['car'] = array(
  'url'   =>'http://localhost/car',
  'file'  =>'http://localhost/upload/car.flv',
  #'captions'=>'http://localhost/upload/car-dfxp-xml.php',
  'captions'=>'http://localhost/upload/car.dfxp.xml', #car_2.dfxp.xml
  'lang'  =>'en | es | de',
  'title' =>'Accelerating car',
  'description'=>'Someone watching a car accelerate toward light speed...',
  'provider_name'=>'localhost', #NCAM.wgbh.com
);
$metas['podcast-t206'] = array( #'oupod'
  'url' =>'http://podcast.open.ac.uk/oulearn/environment-development-and-international-studies/podcast-t206-energy',
  'file'  =>'http://podcast.open.ac.uk/feeds/t206-energy/t206-hospitals-hospitals-generate-traffic.m4v', #7 MB.
  'image' =>'http://podcast.open.ac.uk/feeds/t206-energy/T206_00142.jpg',
  'alt_transcript'=>'http://media-podcast.open.ac.uk/feeds/t206-energy/transcript/t206-hospitals-hospitals-generate-traffic.pdf',
  'rss'   =>'http://podcast.open.ac.uk/feeds/t206-energy/rss2.xml',
  'rss_transcript'=>'http://podcast.open.ac.uk/feeds/t206-energy/transcript/rss2.xml',  
  'lang'  =>'en',
  'title' =>'Hospitals: major contributors to traffic, OU pod',
  'description'  =>'First podcast in the series, Energy for a sustainable future. Speaker: Carey Newson',
  'duration'     =>'00:00',
  'provider_name'=>'The Open University/iTunesU',
  'provider_url' =>'http://podcast.open.ac.uk/',
);
