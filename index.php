<?php

function render($tpl, $data = array(), $return = false) {
    if ($return) ob_start();
    extract($data);
    eval('?>' .preg_replace_callback('_{([\@\/\-\?\!\&]?)([^}]+)}_', function ($m) {
		$args = preg_split('/([\s]+)/', trim(str_replace(array('as', '=>'), '', $m[2])));
		switch($m[1]) {
			case '@':
				if(count($args) == 3)
					$r = "if(isset(\${$args[0]})) foreach(\${$args[0]} as \${$args[1]} => \${$args[2]}) {";
				else {
					$args[1] = isset($args[1])?$args[1]:'value';
					$r = "if(isset(\${$args[0]})) foreach(\${$args[0]} as \${$args[1]}) {";
				}break;
			case '?':$r = "if(isset(\${$args[0]})&&!!\${$args[0]}){";break;
			case '!':$r = "if(!isset(\${$args[0]})||!\${$args[0]}){";break;
			case '/':$r = '}';break;
			case '&':$r = "echo isset(\${$args[0]})?\${$args[0]}:null";break;
			case '-':$r = implode(' ', $args);break;
			default: $r = "echo isset(\${$args[0]})?htmlspecialchars(\${$args[0]},ENT_QUOTES):null";
		}
		return "<?php $r?>";	
	}, $tpl));
    if ($return) return ob_get_clean();
}
render(file_get_contents('index.tpl.php'), array('title' => 'Hello world.', 'messages' => array('Hello, Earth', 'We confiscates this planet.')));

