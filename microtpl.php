<?php
class MicroTpl{
  static function parse ($tpl){
		return preg_replace_callback('_{([\@\/\-\?\!\&]?)([^}]+)}_', function ($m) {
			$args = preg_split('/[\s]+/', trim($m[2]));
			switch($m[1]) {
				case '@':$args[1] = isset($args[1])?$args[1]:'key';$args[2] = isset($args[2])?$args[2]:'value';$r = "if(isset(\${$args[0]})) foreach(\${$args[0]} as \${$args[1]} => \${$args[2]}) {";break;
				case '?':$r = "if(isset(\${$args[0]})&&!!\${$args[0]}){";break;
				case '!':$r = "if(!isset(\${$args[0]})||!\${$args[0]}){";break;
				case '/':$r = '}';break;
				case '&':$r = "echo isset(\${$args[0]})?\${$args[0]}:null";break;
				case '-':$r = implode(' ', $args);break;
				default: $r = "echo isset(\${$args[0]})?htmlspecialchars(\${$args[0]},ENT_QUOTES):null";
			}
			return "<?php $r?>";	
		}, $tpl);
	}
  function render($_tpl, $_return = false){
    if ($_return) ob_start();
    extract((array) $this);
    eval('?>' . self::parse($_tpl));
    if ($_return) return ob_get_clean();
  }
  function renderFile($file, $return = false){
    return $this->render(file_get_contents($file), $return);
  }
}
