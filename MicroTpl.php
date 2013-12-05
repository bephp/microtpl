<?php 
class MicroTpl{
	public $depth;
	public $repeat = array();
	public $condition = array();
	public $content = array();
	public $replace = array();
	public $parser;
	public $data = array();
	const PREFIX = 'tal:';
	
	public function __construct() {
		$this->parser = xml_parser_create();
        xml_set_object($this->parser, $this);
		xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_element_handler($this->parser, "tag_open", "tag_close");
        xml_set_character_data_handler($this->parser, "cdata");
	}
	public function __set($var, $val) {
		$this->data[$var] = $val;
	}
	public function & __get($var) {
		if (!isset($this->data[$var])) $this->data[$var] = null;
		return $this->data[$var];
	}
    public function parse($data) {
		preg_match('@<\!DOCTYPE[^>]*>@', $data, $doctype);
		ob_start();
		echo (isset($doctype[0]) ? $doctype[0] . "\n" : '');
        xml_parse($this->parser, $data);
		extract($this->data);
		//echo ob_get_clean();
		eval('?>'. ob_get_clean());
    }
    protected function tag_open($parser, $tag, $attr) {
		$this->depth++;
		if (count($this->content)) return ;
		
		foreach(array('condition' => 'if', 'repeat' => 'foreach') as $k => $v) {
			if (isset($attr[$key = self::PREFIX.$k])) {
				$this->{$k}[$this->depth] = $v;
				echo "<?php $v({$attr[$key]}):?>";
				unset($attr[$key]);
			}
		}
		foreach(array('content', 'replace') as $k) {
			if (isset($attr[$key = self::PREFIX.$k])) {
				$this->{$k}[$this->depth] = $attr[$key];
				unset($attr[$key]);
				if ('replace' === $k) return ;
			}
		}
		if (count($attr)) {
			array_walk($attr, function(&$n, $i) { $n = $i. '="'. $n. '"';});
			echo "<$tag ". implode(' ', $attr). ">";
		} else echo "<$tag>";
    }
    protected function cdata($parser, $cdata) {
		if (!count($this->content) && !count($this->replace)) echo $cdata;
    }
    protected function tag_close($parser, $tag) {
		foreach(array('content', 'replace') as $k) {
			if (isset($this->{$k}[$this->depth])) {
				if ($this->{$k}[$this->depth])
					echo "<?php echo {$this->{$k}[$this->depth]};?>";
				unset($this->{$k}[$this->depth]);
				if ('replace' === $k) return $this->depth--;
			}
		}
		if (!count($this->content)) echo "</$tag>\n";
		
		foreach(array('condition' => 'if', 'repeat' => 'foreach') as $k => $v) {
			if (isset($this->{$k}[$this->depth])) {
				echo "<?php end$v;?>";
				unset($this->{$k}[$this->depth]);
			}
		}
		$this->depth--;
    }
}