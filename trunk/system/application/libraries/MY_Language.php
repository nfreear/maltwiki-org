<?php
/**ou-specific
 *
 * Overriding Language Class to allow the parent/default language to be loaded first.
 * Plus, functions to list available languages, and to facilitate translation.
 *
config.php
if (defined('E_DEPRECATED')) {
  error_reporting(E_ALL ^ E_DEPRECATED);
}

maltplayer.php
    $lang_r = $this->lang->load('malt', 'english', $ret=FALSE);
    $this->lang->load('malt', strtolower($this->config->item('language')));
 *
 * @author N.D.Freear, 25 October 2009.
 * @category	Language
 * @link		http://codeigniter.com/user_guide/libraries/language.html
 */
class MY_Language extends CI_Language {

	#var $language	= array();
	#var $is_loaded	= array();
    var $last_lang = NULL;


	/**
	 * Load a language file
	 *
	 * @access	public
	 * @param	mixed	the name of the language file to be loaded. Can be an array
	 * @param	string	the language (english, etc.)
	 * @return	mixed
	 */
	function load($langfile = '', $idiom = '', $return = FALSE)
	{
		#$langfile = str_replace(EXT, '', str_replace('_lang.', '', $langfile)).'_lang'.EXT;

		/*if (in_array($langfile, $this->is_loaded, TRUE))
		{  
			return;
		}*/

		if ($idiom == '')
		{
			$CI =& get_instance();
			$deft_lang = $CI->config->item('language');
			$idiom = ($deft_lang == '') ? 'english' : $deft_lang;
		}
        $this->last_lang = $idiom;

$langfile = $idiom.'/'.str_replace(EXT, '', str_replace('_lang.', '', $langfile)).'_lang'.EXT; #@todo.
$idiom='';
    if (in_array($langfile, $this->is_loaded, TRUE))
		{  
			return;
		}

		// Determine where the language file is and load it
		if (file_exists(APPPATH.'language/'.$idiom.'/'.$langfile))
		{
			include(APPPATH.'language/'.$idiom.'/'.$langfile);
		}
		else
		{
			if (file_exists(BASEPATH.'language/'.$idiom.'/'.$langfile))
			{
				include(BASEPATH.'language/'.$idiom.'/'.$langfile);
			}
			else
			{
				show_error('Unable to load the requested language file: language/'.$langfile);
			}
		}

		if ( ! isset($lang))
		{
			log_message('error', 'Language file contains no data: language/'.$idiom.'/'.$langfile);
			return;
		}

		if ($return == TRUE)
		{
			return $lang;
		}
		$this->is_loaded[] = $langfile;
		$this->language = array_merge($this->language, $lang);
		unset($lang);

		log_message('debug', 'Language file loaded: language/'.$idiom.'/'.$langfile);
		return TRUE;
	}

    function span($line='', $args=NULL, $lang=NULL, $tags=TRUE) {
        $line = $this->line($line);
        if ($tags) {
          $line = str_replace('%s', "<em lang=\"$lang\">%s</em>", $line);
        }
        $line = sprintf($line, $args);
        if ($tags) {
            return $line;
        }
        $lang_ui = $this->last_lang;
        return "<span lang=\"$lang_ui\">$line</span>";
    }

    function available() { #@todo: Order matters :(
      $available = array('zh-cn'=>'cmn-hans', 'zh'=>'cmn-hans', 'cmn-hans'=>null,
                         'fr'=>null, 'es-la'=>'es', 'es'=>null, 'en'=>null);
      return $available;
    }

    function select_names() {
      return array('en' =>'English', 'es'=>'Español', 'fr'=>'Français', 'cmn-Hans'=>'简体中文 Simplified Chinese', ); 
    }

    function text_file($lang=NULL) {
      if (!$lang) $lang = $this->last_lang;
      @header('Content-Type: text/plain; charset=UTF-8');
      @header("Content-Disposition: inline; filename=maltwiki-lang-$lang.txt"); #size=$octets");
      $out = "@link http://maltwiki.org/about#translate\r\n@lang $lang".PHP_EOL; #base_url().
      $out.= "@count ".count($this->language).PHP_EOL.PHP_EOL;
      foreach ($this->language as $key => $value) {
        $out .= "[$key] = ";
        if (is_array($value)) {
          $out .= var_export($value, TRUE);
        } else {
          $out .= "\"$value\"";
        }
        $out .= ";".PHP_EOL;
      }
      return $out;
    }

}
// END Language Class
