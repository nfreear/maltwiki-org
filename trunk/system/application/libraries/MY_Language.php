<?php
/**ou-specific
 *
config.php
if (defined('E_DEPRECATED')) {
  error_reporting(E_ALL ^ E_DEPRECATED);
}

maltplayer.php
$lang_r = $this->lang->load('malt', 'english', $ret=FALSE);  #@todo: TEST!
    $this->lang->load('malt', strtolower($this->config->item('language')));

 * Overriding Language Class to allow the parent/default language to be loaded first.
 * (Parses URIs and determines routing.)
 *
 * @author N.D.Freear, 25 October 2009.
 * @category	Language
 * @link		http://codeigniter.com/user_guide/libraries/language.html
 */
class MY_Language extends CI_Language {

	#var $language	= array();
	#var $is_loaded	= array();


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

}
// END Language Class
