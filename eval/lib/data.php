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
  'captions'=>'http://localhost/upload/corrie.xml',
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
  'captions'=>'http://localhost/upload/car.dfxp.xml',
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
$metas['yt-susan'] = array( #http://kej.tw/flvretriever/
  'url'   =>'http://youtube.com/watch?v=HsXo4-dE9pA',
  'file'  =>'http://youtube.com/get_video?video_id=HsXo4-dE9pA&t=OEgsToPDskInduWgbWT6uO2yZyeEmnY5',
  #'image' =>null,
  'lang'  =>'en',
  'title' =>'Susan Baxter, Open University, YouTube',
  'description'=>'Susan Baxter, Open University student tells her story',
  'duration'=>'02:52',
  'provider_name'=>'YouTube',
  'provider_url' =>'http://www.youtube.com/',
  'author_name'  =>'The Open University',
);
$metas['yt-dream'] = array(
  'url'   =>'http://youtube.com/watch?v=PbUtL_0vAJk',
  'file'  =>'http://youtube.com/get_video?video_id=PbUtL_0vAJk&t=  ',
  'alt_transcript'=>'http://www.americanrhetoric.com/speeches/mlkihaveadream.htm',
  'lang'  =>'en-US',
  'title' =>'Martin Luther King "I have a dream"',
  'description'=>'delivered 28 August 1963, at the Lincoln Memorial, Washington D.C.',
  'duration'=>'17:28',
  'provider_name'=>'YouTube',
  'provider_url' =>'http://www.youtube.com/',
);

$metas['dot-blogs'] = array(
  'url'   =>'http://dotsub.com/view/dc75c2e2-ef81-4851-8353-a877aac9fe3c#videoTranscription',
  'file'  =>'http://dotsub.com/media/dc75c2e2-ef81-4851-8353-a877aac9fe3c/em/flv/en',
  'image' =>'http://dotsub.com/media/dc75c2e2-ef81-4851-8353-a877aac9fe3c/p',
  'captions_ALT' =>'http://dotsub.com/media/dc75c2e2-ef81-4851-8353-a877aac9fe3c/c/eng/tt',
  'captions' =>'http://localhost/upload/dot_dc75c2e2-ef81-4851-8353-a877aac9fe3c_c_eng_tt.xml',
  'alt_url'=>'http://youtube.com/watch?v=NN2I1pWXjXI',
  'license'=>'http://creativecommons.org/licenses/by-nc/2.5/',
  'lang'  =>'en-US',
  'title' =>'Blogs in Plain English: Commoncraft',
  'description'=>
'Commoncraft *Posted by: leelefever *17 months ago *Views 46,102 *Translations 22 | A video for people who wonder why blogs are such a big deal. ... (More) | English, United States, Instructional',
  'duration'=>'2:59',
  'provider_name'=>'dotSUB',
  'provider_url' =>'http://dotsub.com/',
  'height'=> '347',
  'width' => '420',
);
$metas['yt-crotchet'] = array(
  'url'   =>'http://www.youtube.com/watch?v=FIH0ntfwzCk',
  'title' =>'How-to Crochet a Hat, Threadbanger', #Annotations ?
  'desc'=>'This week, Rob and Corinne give the viewers what they want and ...',
  'height'=>425,
  'width' =>344,
);

/*<embed src="http://www.sign-tube.com/player.swf" width="360" height="270" 
allowscriptaccess="always" allowfullscreen="true" 
flashvars="width=360&height=270&file=http://www.sign-tube.com/flvideo/851.flvℑ=http://www.sign-tube.com/thumb/1_851.jpg&displayheight=270&link=http://www.sign-tube.com/video/851/SignTube-going-to-Deaflympics-2009&searchbar=false&linkfromdisplay=true&recommendations=http://www.sign-tube.com/feed_embed.php?v=8261f10d052e6e2c1123" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" />
*/
$metas['st-deaflympics'] = array(
  'url'   =>'http://www.sign-tube.com/video/851/SignTube-going-to-Deaflympics-2009',
  'file'  =>'http://www.sign-tube.com/flvideo/851.flv',
  'title' =>'SignTube going to Deaflympics 2009!',
  'desc'  =>'It\'s official Signtube team will visit Taipei to cover Deaflympics 2009 both sports and community events! So if you see the team, ask them to film you and be sign-tubed!',
  'lang'  =>'en, sgn',
  'duration'=>'0:23',
  'provider_name'=>'Sign-tube',
  'height'=>270,
  'width' =>360,
);