<?php 
class MicroTpl{
    public $depth;
    public $repeat = array();
    public $condition = array();
    public $content = array();
    public $replace = array();
    public $parser;
    const PREFIX = 'tal:';
    
    public function __construct() {
        $this->parser = xml_parser_create();
        xml_set_object($this->parser, $this);
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_element_handler($this->parser, "tag_open", "tag_close");
        xml_set_character_data_handler($this->parser, "cdata");
    }
    public function __destruct() {
        xml_parser_free($this->parser);
    }
    public static function parse($source) {
        $view = $source. 'c';
        if (!file_exists($view) || @filemtime($source)>@filemtime($view)) {
            $parser = new self();
            @file_put_contents($view, $parser->_parse(@file_get_contents($source)));
        }
        return $view;
    }
    protected function _parse($template) {
		return (ob_start() && xml_parse($this->parser, $template))
			? (preg_match('@<\!DOCTYPE[^>]*>@', $template, $doctype) ? $doctype[0] . "\n" : ''). ob_get_clean(). "\n"
			: $template;
    }
    public static function render($view, $data = array(), $layout = '') {
        if(!file_exists($view)) 
			throw new Exception('View file "'. $view. '" does not exist.');
        extract($data);
        ob_start();
        include (self::parse($view));
        $content = ob_get_clean();
        if (!file_exists($layout)) echo $content;
        else include (self::parse($layout));
    }
    protected function tag_open($parser, $tag, $attr) {
        $this->depth++;
        if (!empty($this->content) || !empty($this->replace)) return ;
        
        foreach($attr as $key => $val) {
            if (false !== ($i = strpos($key, self::PREFIX)) && $k = substr($key, $i+4)) {
                if (in_array($k, array_keys($temp = array('condition' => 'if', 'repeat' => 'foreach')))) {
                    $this->{$k}[$this->depth] = $temp[$k];
                    echo "<?php {$temp[$k]}({$attr[$key]}):?>";
                } elseif (in_array($k, array('content', 'replace'))) {
                    $this->{$k}[$this->depth] = $attr[$key];
                    if ('replace' === $k) {
                        unset($attr[$key]);
                        return ;
                    }
                } else {
                    $attr[$k] = "<?php echo {$attr[$key]};?>";
                }
                unset($attr[$key]);
            }
        }
        if (!empty($attr)) {
            array_walk($attr, create_function('&$n, $i','$n = $i. "=\"$n\"";'));
            echo "<$tag ". implode(' ', $attr). ">";
        } else echo "<$tag>";
    }
    protected function cdata($parser, $cdata) {
        if (empty($this->content) && empty($this->replace)) echo $cdata;
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
        if (empty($this->content) && empty($this->replace)) echo "</$tag>";
        
        foreach(array('condition' => 'if', 'repeat' => 'foreach') as $k => $v) {
            if (isset($this->{$k}[$this->depth])) {
                echo "<?php end$v;?>";
                unset($this->{$k}[$this->depth]);
            }
        }
        $this->depth--;
    }
}