<?php declare(strict_types=1);
namespace Graal\Bone\Node;
/**
 * @author Niels A.D.
 * @package Ganon
 * @link http://code.google.com/p/ganon/
 * @license http://dev.perl.org/licenses/artistic.html Artistic License
 */
/**
 * Node subclass for asp tags
 */
class HtmlNodeASP extends HtmlNodeEmbedded {
	#php4 Compatibility with PHP4, this gets changed to a regular var in release tool
	#static $NODE_TYPE = self::NODE_ASP;
	#php4e
	#php5
	const NODE_TYPE = self::NODE_ASP;
	#php5e

	/**
	 * Class constructor
	 * @param HtmlNode $parent
	 * @param string $tag {@link $tag}
	 * @param string $text
	 * @param array $attributes array('attr' => 'val')
	 */
	function __construct($parent, $tag = '', $text = '', $attributes = array()) {
		return parent::__construct($parent, '%', $tag, $text, $attributes);
	}
	
	#php4 PHP4 class constructor compatibility
	#function HtmlNodeASP($parent, $tag = '', $text = '', $attributes = array()) {return $this->__construct($parent, $tag, $text, $attributes);}
	#php4e
}