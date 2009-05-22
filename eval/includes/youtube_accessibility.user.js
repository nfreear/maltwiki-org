// ==UserScript==
// @name           Youtube transcripts
// @namespace      http://freear.org.uk
// @description    Accessibility experiment, 1 October 2008.
// @include        http://*.youtube.com/watch?*
// ==/UserScript==
/*
@include        http://*.youtube.com/user/TheOpenUniversity

http://youtube.com/rss/tag/open2.net.rss
http://youtube.com/rss/tag/Open+University.rss
http://youtube.com/rss/user/TheOpenUniversity/videos.rss
http://uk.youtube.com/results?search_query=open+university
*/

var ous = [
/*
 se:Title search/keywords, vi:Video ID, no:Notes, du:Duration ([H:]m:s), ad:Added date (d MMM Y), fr:From user, tr:Transcipt text.
*/
{ se:'Arts Past & Present (AA100)', vi:'eIupVqDWoFM', du:'5:58', ad:'9 Sep 2008', fr:'TheOpenUniversity',
  no:'0:16/5:58; Dr Richard Danson Brown, Course Team Chair', tr:
 "The Arts Past and Present - AA100 - is a broad ranging course which is designed to appeal to anyone"
+" who's interested in the Arts, especially people who haven't studied at the university level before."
+" It covers the full range of subjects we teach in the Arts Faculty"
  },

{ se:"James May's Big Ideas", vi:'EPLQPe66r7o', du:'0:23', ad:'26 Sep 2008', fr:'TheOpenUniversity', 
  no:'More at, http://open2.net/jamesmay/', ca:'Education', ta:'ou_AA100 art history open2.net', tr:
"Hi I'm James May. I've just finished filming my big ideas program about the future of transport" }, 

{ se:'Susan Baxter, Open Uni', vi:'HsXo4-dE9pA', du:'2:52', ad:'28 Nov 2007',
  no:'...point of view as a student with a disability', ca:'Education', ta:'Susan  Baxter  student  OU ... disability', tr:
 "My name is Susan Baxter, and I've done 2 open university courses."
+" first one is studying mammals and the second is The human genome, and they're both for 10 point courses."
+" I suffer with 2 conditions, one is dyslexia, and one is dystonia (sp?)"
  }
];

function getX(e) {
  var x = 0;
  if (e.nodeType != Node.ELEMENT_NODE) {
    e = e.parentNode;
  }
  while(e) {
    x += e.offsetLeft;
    e = e.offsetParent;
  }
  return x;
}
function getY(e) {
  var y = 0;
  if (e.nodeType != Node.ELEMENT_NODE) {
    e = e.parentNode;
  }
  while(e) {
    y += e.offsetTop;
    e = e.offsetParent;
  }
  //for(e=element.parentNode; e && e != document.body; e = e.parentNode)
  //  if (e.scrollTop) y -= e.scrollTop;
  // Y coordinate with document-internal scrolling accounted for.
  return y;
}


( function ytAccess() {
  var title = document.getElementsByTagName('title')[0].innerHTML;
  title = title.replace(/YouTube - /, '').substr(0, 22);

  var link = document.createElement('button');
  link.addEventListener('click', function(event) {
    var pop = document.createElement('div');
    /*pop.addEventListener('click', function(ev2) {
      pop.
    }, true);*/
    pop.setAttribute('style',
    'position:absolute; background:#fafafa; padding:.4em; border:2px solid #d33; font-size:1.1em;'); //#bbb

    //var p   = url.indexOf('v=');
    //var vid = url.substr(p+2, url.indexOf('&', p)-(p+2));
    var url = document.location.search;

    var result = url.match( /.*?v\=([^&]+)/ );
    var vid = result[1];

    var trans = null;
    for (var i=0; i< ous.length; i++) {
      if (ous[i].vi == vid) {
        trans = ous[i];
        break;
      }
    }
    if (trans) {
      pop.innerHTML = '<h2>Transcript for '+trans.se+'</h2><p>'+trans.tr+' ...</p> [Greasemonkey user-Javascript]';
    } else {
      pop.innerHTML = "<h2>Transcript for ...</h2>"+
      "<p>[This is a placeholder created by a &ldquo;Greasemonkey&rdquo; user-Javascript.]</p>"+vid;
    }
    /*var sel = window.getSelection();
    pop.style.left= getX(sel.focusNode) +'px';
    pop.style.top = getY(sel.focusNode) +'px'; //(y+pop.style.fontSize)?
    pop.innerHTML += sel.getRangeAt(0);*/

    var desc=null;
    var metas = document.getElementsByTagName('meta');
    for (var j=0; j< metas.length; j++) {
      if (metas[j].getAttribute('name')=='description') {
        desc = metas[j].getAttribute('content');
        break;
      }
    }
    desc.replace(/(http:\/\/.+?)/, '<a href="$1">$1</a>');
    pop.innerHTML += '<p>'+desc+'</p>';

    event.target.parentNode.appendChild(pop);
    //event.target.disabled = true;
    event.stopPropagation();
    event.preventDefault();
  }, true);

  //link.setAttribute('href', '#');
  link.style.cursor = 'pointer';
  link.style.margin = '.5em 0';
  link.innerHTML = "Transcript for &ldquo;"+title+"&rdquo;";

  var player = document.getElementById('watch-player-div');
  //if (!player) player = document.getElementById('profile-player-div');
  player.appendChild(link);

  GM_log(title);
} )();
