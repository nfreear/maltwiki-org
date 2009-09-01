// ==UserScript==
// @name           YouTube Accessibility <?php echo $host ?>

// @namespace      http://freear.org.uk
// @author         N.D.Freear[AT]open.ac.uk
// @copyright      2008-10-03 N.D.Freear, The Open University.
// @version        0.1
// @description    Multimedia accessibility evaluation, May-August 2009.
//                 Requires Firefox 3.x and Greasemonkey http://greasespot.net/
// @include        http://*.youtube.com/watch?*
// @resource style <?php echo $style_url ?>

// ==/UserScript==

(function ytAccess() {
  ytFixes();

  var d = document;
  var header_replace = 'X-Replace-Player: 1';
  var player_div = d.getElementById('watch-player-div');
  var player_orig= d.getElementById('movie_player');
  var title      = d.getElementsByTagName('title')[0].innerHTML;
  title = title.replace(/YouTube - /, '').substr(0, 35);

  //Miss off the 'hash';
  var loc = d.location.protocol+'//'+d.location.host+d.location.pathname+d.location.search;
  var u = '<?php echo $oembed_url ?>'  //'http://localhost:8888/tt/oembed/?url='
    +encodeURIComponent(loc) //.search;
    +'&a=greasemonkey';
    //+'&t='+encodeURIComponent(title);
  GM_log(loc);
  GM_log(u);
  GM_xmlhttpRequest({
    method: 'GET',
    url: u,
    /*headers: {
        'User-agent': 'Mozilla/4.0 (compatible) Greasemonkey',
        'Accept': 'text/html', //'text/javascript,application/xml',
    },*/
    onload: function(resp) {
      var replace_player = (200 == resp.status && resp.responseHeaders.indexOf(header_replace) > 0); //.match(/X-Replace-Player: 1/)

      var pop = document.createElement('div');
      var json = resp.responseText.parseJSON();
      pop.innerHTML = json.html;

      /*var myStyle = json.stylesheet ? @TODO : GM_getResourceText("style");
      GM_addStyle(myStyle);
      GM_log('Adding styles.');*/

      if (player_div) {
        //pop.style.top = '-99em';
        var btn = document.createElement('button');
        btn.innerHTML = 'Hide transcript';
        btn.addEventListener('click', function(event) {
          if (event.target.innerHTML=='Show transcript') {
            event.target.innerHTML = 'Hide transcript';
            pop.style.top = 'inherit';
          } else {
            event.target.innerHTML = 'Show transcript';
            pop.style.top = '-99em';
          }
          event.stopPropagation();
          event.preventDefault();
        }, true);

        btn.id = 'yta-transcript';

        var skip = document.createElement('a');
        skip_id = 'movie_player';
        if (replace_player) skip_id = 'ma-player';
        skip.setAttribute('href', '#'+ skip_id); //btn.id);
        skip.id = 'ma-skip';
        skip.innerHTML = 'Skip to video'; //transcript';
        var body = document.getElementsByTagName('body')[0];
        body.insertBefore(skip, body.firstChild);

        //player_div.appendChild(btn);
        player_div.appendChild(pop);

        if (replace_player) {
          var obj = player_orig;
          GM_log('Hiding original YT player - '+obj+' '+obj.getAttribute('type'));
          obj.style.display = 'none';
        }
      } else {
        alert(pop);
      }
    },
    onerror: function(r) { alert('Error'); }
  });

})();


function ytFixes() {
  attachLabelById('masthead-search-term', 'Search ');
  attachLabelById('footer-search-term', 'Search ');
  removeTabindex('masthead-search-term');
  imageAltByClass('logo', 'You Tube home');

	function attachLabelById(id, text) {
	  var field = document.getElementById(id);
	  if (!field) return false;
	  var label = document.createElement('label');
	  label.setAttribute('for', id);
	  label.innerHTML = text;
	  field.parentNode.insertBefore(label, field);
	}
	function imageAltByClass(cls, altText) {
	  var els = document.getElementsByTagName('img');
	  if (!els) return false;
	  for (var j=0; j<els.length; j++) {
		var img = els[j];
		if (//!img.hasAttribute('alt') || img.getAttribute('alt')=='' &&
		  img.className==cls || img.parentNode.className==cls) {
		  img.setAttribute('alt', altText);
		  img.title = altText;
		}
	  }
	}
	function removeTabindex(id) {
	  var el = document.getElementById(id);
	  if (!el) return false;
	  var tab = el.getAttribute('tabindex');
	  if (tab > 0) {
		el.removeAttribute('tabindex');
	  }
	}
}


/*@TODO: secure?
  http://misc.slowchop.com/misc/browser/human-readable-json/human-readable-json.user.js?
*/
String.prototype.parseJSON = function () {
  try {
    return !(/[^,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]/.test(
      this.replace(/"(\\.|[^"\\])*"/g, ''))) &&
      eval('(' + this + ')');
  } catch (e) {
    return false;
  }
};
