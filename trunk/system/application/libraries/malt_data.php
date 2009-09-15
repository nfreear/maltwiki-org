<?php
/**
  Multimedia accessibility - data.
  @copyright 2009 The Open University.
  @author N.D.Freear@open.ac.uk, 5 February 2009.
  @package Maltwiki
*/

class Malt_Data {

  public static function load() {

$metas['xmoodle'] = array(
#height=350&width=500&searchbar=false&autostart=false
  'url'  =>'http://youtube.com/watch?v=grqt3HoLOIA',
  'url_alt'  =>'http://dotsub.com/view/e475f673-9ba7-4013-b896-2e3884694445',
  'url_ALT_2'=>'http://xtranormal.com/watch?e=20090124001058490',
  'file' =>'http://dotsub.com/media/e475f673-9ba7-4013-b896-2e3884694445/em/flv/en',
  'file_ALT' =>'http://video.xtranormal.com/highres/aacd0182-e274-11dd-9b38-001b210ae39a_7.flv', #video.
  'image'=>'http://video.xtranormal.com/highres/aacd0182-e274-11dd-9b38-001b210ae39a_7_0.jpg',
  'captions'=>'http://localhost/upload/xmoodle.dfxp.xml',
  'captions_ALT'=>'http://dotsub.com/media/e475f673-9ba7-4013-b896-2e3884694445/c/eng/tt',
  'lang' =>'en',
  'title'=>'Learn about Moodle',
  'description'  =>'An elevator pitch for the online learning environment, Moodle.',
  'duration'     =>'01:40',  #'00:51',
  'provider_name'=>'dotSUB', #'Xtranormal',
  'provider_url' =>'http://dotsub.com/', #'http://xtranormal.com/',
  'author_name'  =>'nickfreear',
  'height'=> '347',
  'width' => '420',
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
  'title' =>'Hospitals: major contributors to traffic, OU',
  'description'  =>'First podcast in the series, Energy for a sustainable future. Speaker: Carey Newson',
  'duration'     =>'00:00',
  'provider_name'=>'The Open University/iTunesU',
  'provider_url' =>'http://podcast.open.ac.uk/',
);
$metas['yt-ou-susan'] = array( #http://kej.tw/flvretriever/
  'url'   =>'http://youtube.com/watch?v=HsXo4-dE9pA',
  #'file'  =>'http://youtube.com/get_video?video_id=HsXo4-dE9pA&t=OEgsToPDskInduWgbWT6uO2yZyeEmnY5',
  'image' =>'http://i1.ytimg.com/vi/HsXo4-dE9pA/default.jpg',
  'lang'  =>'en',
  'title' =>'Susan Baxter, Open University',
  'description'=>'Susan Baxter, Open University student tells her story',
  'duration'=>'02:52',
  'provider_name'=>'YouTube',
  'provider_url' =>'http://www.youtube.com/',
  'author_name'  =>'TheOpenUniversity',
);
$metas['yt-ou-susan']['transcript'] = <<<EOT
<p>My name is Susan Baxter, and I've done 2 open university courses. first one is studying mammals 
  and the second is The human genome, and they're both for 10 point courses. I suffer with 2 conditions,
  one is dyslexia, and one is dystonia (sp?)
</p><p>...</p>
EOT;

$metas['yt-ou-AA100'] = array(
  'url'   => 'http://youtube.com/watch?v=eIupVqDWoFM',
  #<!--Views: 1931-->
  'image' => 'http://i2.ytimg.com/vi/eIupVqDWoFM/default.jpg',
  'lang'  => 'en',
  'title' => 'The Arts Past &amp; Present (AA100)', #- A brief introduction',
  'duration'   => '05:58',
  'author_name'=>'TheOpenUniversity',
 /* <contributor>Dr Clare Spencer, Course Tutor</contributor>
  <author><name>TheOpenUniversity</name></author>
  <category term="Education"/>
  <itunes:duration>5:58</itunes:duration>*/
);
$metas['yt-ou-AA100']['transcript'] = <<<EOT
<p>The Arts Past and Present - AA100 - is a broad ranging course which is designed to appeal to anyone
  who's interested in the Arts, especially people who haven't studied at the university level before. 
</p><p>
  It covers the full range of subjects we teach in the Arts Faculty ...

  including English, history, religious studies, music and classical studies.
  For example, you'd learn to read between the lines of a historical document.
  you'd learn how to interpret a work of art, understand the symbolism in it,
  you'd learn how to describe pieces of music to other people in a shared language.
</p><p>
  You'll never be bored with this course is our hope because it's not one thing
  right the way through, there's a lot of variety.
</p><p>
  When you're studying this course you'll find that you're never left alone.
  Your tutor will be there as a source of support for you throughout the course.
  it'll be the same person there in the background that you can turn to when you need help.
</p><p>
  The course is divided into four books. The first book 'Reputations' focuses on issues of fame in the Arts
  <!--1:23-->
  ...</p>
EOT;

$metas['yt-mlk-dream'] = array(
  'url'   =>'http://youtube.com/watch?v=PbUtL_0vAJk',
  #'file'  =>'http://youtube.com/get_video?video_id=PbUtL_0vAJk',
  'transcript_ALT'   =>'http://www.americanrhetoric.com/speeches/mlkihaveadream.htm',
  'transcript_rights'=>'Copyright status: Text, Audio = Restricted, seek permission. Images & Video = Uncertain. &#169; Estate of Dr. Martin Luther King, Jr; Intellectual Properties Management; One Freedom Plaza; 449 Auburn Avenue NE; Atlanta, GA 30312',
  'audio_url' =>'http://174.132.193.190/~eiden/mp3clips/politicalspeeches/mlkingihaveadream1234xx.mp3',
  'image' =>'http://i4.ytimg.com/vi/gZLvSnr6s50/default.jpg',
  'lang'  =>'en-US',
  'title' =>'Martin Luther King "I have a dream"',
  'description'=>'Delivered 28 August 1963, at the Lincoln Memorial, Washington D.C.',
  'duration'=>'17:28',
  'provider_name'=>'YouTube',
  'provider_url' =>'http://www.youtube.com/',
);
  $metas['yt-mlk-dream']['transcript'] = <<<EOT
<p>I am happy to join with you today in what will go down in history as the greatest demonstration for freedom in the history of our nation.
</p><p>Five score years ago, a great American, in whose symbolic shadow we stand today, signed the Emancipation Proclamation. This momentous decree came as a great beacon light of hope to millions of Negro slaves who had been seared in the flames of withering injustice. It came as a joyous daybreak to end the long night of their captivity.
</p><p>But one hundred years later, the Negro still is not free. One hundred years later, the life of the Negro is still sadly crippled by the manacles of segregation and the chains of discrimination. One hundred years later, the Negro lives on a lonely island of poverty in the midst of a vast ocean of material prosperity. One hundred years later, the Negro is still languished in the corners of American society and finds himself an exile in his own land. And so we've come here today to dramatize a shameful condition.
</p><p>In a sense we've come to our nation's capital to cash a check. When the architects of our republic wrote the magnificent words of the Constitution and the Declaration of Independence, they were signing a promissory note to which every American was to fall heir. This note was a promise that all men, yes, black men as well as white men, would be guaranteed the "unalienable Rights" of "Life, Liberty and the pursuit of Happiness." It is obvious today that America has defaulted on this promissory note, insofar as her citizens of color are concerned. Instead of honoring this sacred obligation, America has given the Negro people a bad check, a check which has come back marked "insufficient funds."
</p><p>...</p>
<p><cite>&#169; Estate of Dr. Martin Luther King.
Source: <a href="http://www.americanrhetoric.com/speeches/mlkihaveadream.htm">American Rhetoric</a>.
</cite></p>
EOT;

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
$metas['dot-craft-social'] = array(
  'url'   => 'http://youtube__.com/watch?v=6a_KF7TYKVc',
  'url_ALT'=>'http://dotsub.com/view/3d2a8e25-fca0-465d-83e0-3c2ceca3e6a9',
  'captions' => 'http://dotsub.com/media/3d2a8e25-fca0-465d-83e0-3c2ceca3e6a9/c/eng/tt',
  'lang'  => 'en-US',
  'title' => 'Social Networking in Plain English',
  'duration' => '01:48',
);

$metas['yt-crotchet'] = array(
  'url'   =>'http://www.youtube__.com/watch?v=FIH0ntfwzCk',
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

$metas['yt-olnet-brian'] = array(
  'url'   =>'http://youtube.com/watch?v=VesKht_8HCo',
  'url_alt'=>'http://dotsub.com/view/86a1190e-dd05-49a1-b0a8-c5d2b92094dd',
  'file'  =>'http://dotsub.com/media/86a1190e-dd05-49a1-b0a8-c5d2b92094dd/em/flv/en',
  'image' =>'http://dotsub.com/media/86a1190e-dd05-49a1-b0a8-c5d2b92094dd/p',
  'title' =>'Brian Mcallister, Roadtrip Nation (OLnet)',
  'lang'  =>'en',
  'duration'=>'1:40',
  'captions_ALT'=>'http://dotsub.com/media/86a1190e-dd05-49a1-b0a8-c5d2b92094dd/c/eng/tt',
  'captions'=>'http://localhost/upload/dot_86a1190e-dd05-49a1-b0a8-c5d2b92094dd_c_eng_tt.xml',
  'provider_name'=>'dotSUB',
  'author_url'=>'http://dotsub.com/view/user/olnetchannel',
  'height'=> 347,
  'width' => 420,
);
    return $metas;
  }
  
};
