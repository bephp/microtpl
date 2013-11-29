# MicroTpl

MicroTpl is small templating system for PHP.

## Example

    <?php

    function render($tpl, $data = array(), $return = false) {
        if ($return) ob_start();
        extract($data);
        eval('?>' .preg_replace_callback('_{([\@\/\-\?\!\&]?)([^}]+)}_', function ($m) {
            $args = preg_split('/([\s]+)/', trim(str_replace(array('as', '=>'), '', $m[2])));
            switch($m[1]) {// {@messages as index => message}  list array. 
                case '@':
                    if(count($args) == 3)
                        $r = "if(isset(\${$args[0]})) foreach(\${$args[0]} as \${$args[1]} => \${$args[2]}) {";
                    else {
                        $args[1] = isset($args[1])?$args[1]:'value';
                        $r = "if(isset(\${$args[0]})) foreach(\${$args[0]} as \${$args[1]}) {";
                    }break;
                case '?':$r = "if(isset(\${$args[0]})&&!!\${$args[0]}){";break; // {?var} show on true
                case '!':$r = "if(!isset(\${$args[0]})||!\${$args[0]}){";break; // {!var} show on false
                case '/':$r = '}';break; // end mark
                case '&':$r = "echo isset(\${$args[0]})?\${$args[0]}:null";break; // {&var} echo 
                case '-':$r = implode(' ', $args);break; // php code
                default: $r = "echo isset(\${$args[0]})?htmlspecialchars(\${$args[0]},ENT_QUOTES):null"; // {var} echo 
            }
            return "<?php $r?>";    
        }, $tpl));
        if ($return) return ob_get_clean();
    }
    render(file_get_contents('index.tpl.php'), array(
        'title' => 'Hello world.', 
        'messages' => array('Hello, Earth', 'We confiscates this planet.')
    ));
    ?>

## Syntax

    {var}         echo escaped variable
    {&var}        echo unescaped variable
    {@list}       list array
    {?bool}       show block on true
    {!bool}       show block on false
    {/list}       end of array or block
    {php code}    process php code
    {var='value'} assign value to variable
