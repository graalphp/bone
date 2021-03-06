<?php declare(strict_types=1);
namespace Graal\Bone\Parser;
use Graal\Bone\Node\HtmlNode;
/**
 * @author Niels A.D.
 * @package Ganon
 * @link http://code.google.com/p/ganon/
 * @license http://dev.perl.org/licenses/artistic.html Artistic License
 */
/**
 * HTML5 specific parser (adds support for omittable closing tags)
 */
class HtmlParserHtml5 extends HtmlParser {

	/**
	 * Tags with ommitable closing tags
	 * @var array array('tag2' => 'tag1') will close tag1 if following (not child) tag is tag2
	 * @access private
	 */
	var $tags_optional_close = array(
		//Current tag	=> Previous tag
		'li' 			=> array('li' => true),
		'dt' 			=> array('dt' => true, 'dd' => true),
		'dd' 			=> array('dt' => true, 'dd' => true),
		'address' 		=> array('p' => true),
		'article' 		=> array('p' => true),
		'aside' 		=> array('p' => true),
		'blockquote' 	=> array('p' => true),
		'dir' 			=> array('p' => true),
		'div' 			=> array('p' => true),
		'dl' 			=> array('p' => true),
		'fieldset' 		=> array('p' => true),
		'footer' 		=> array('p' => true),
		'form' 			=> array('p' => true),
		'h1' 			=> array('p' => true),
		'h2' 			=> array('p' => true),
		'h3' 			=> array('p' => true),
		'h4' 			=> array('p' => true),
		'h5' 			=> array('p' => true),
		'h6' 			=> array('p' => true),
		'header' 		=> array('p' => true),
		'hgroup' 		=> array('p' => true),
		'hr' 			=> array('p' => true),
		'menu' 			=> array('p' => true),
		'nav' 			=> array('p' => true),
		'ol' 			=> array('p' => true),
		'p' 			=> array('p' => true),
		'pre' 			=> array('p' => true),
		'section' 		=> array('p' => true),
		'table' 		=> array('p' => true),
		'ul' 			=> array('p' => true),
		'rt'			=> array('rt' => true, 'rp' => true),
		'rp'			=> array('rt' => true, 'rp' => true),
		'optgroup'		=> array('optgroup' => true, 'option' => true),
		'option'		=> array('option'),
		'tbody'			=> array('thread' => true, 'tbody' => true, 'tfoot' => true),
		'tfoot'			=> array('thread' => true, 'tbody' => true),
		'tr'			=> array('tr' => true),
		'td'			=> array('td' => true, 'th' => true),
		'th'			=> array('td' => true, 'th' => true),
		'body'			=> array('head' => true)
	);

	protected function parse_hierarchy($self_close = null) {
		$tag_curr = strtolower($this->status['tag_name']);
		if ($self_close === null) {
			$this->status['self_close'] = ($self_close = isset($this->tags_selfclose[$tag_curr]));
		}

		if (! ($self_close || $this->status['closing_tag'])) {
			//$tag_prev = strtolower(end($this->hierarchy)->tag);
			$tag_prev = strtolower($this->hierarchy[count($this->hierarchy) - 1]->tag);			
			if (isset($this->tags_optional_close[$tag_curr]) && isset($this->tags_optional_close[$tag_curr][$tag_prev])) {
				array_pop($this->hierarchy);
			}
		}

		return parent::parse_hierarchy($self_close);
	}
}