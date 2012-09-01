# MicroTpl

## Usage
 
    <?php
    $tpl = new StdClass();
    $tpl->title = 'MicroTpl';
    $tpl->text = 'templating system';
    
    ob_start();
    ?>

    <html>
      <title>{title}</title>
      <body>{text}</body>
    </html>

    <?php MicroTpl::render(ob_get_clean(), $tpl);

## Syntax

    {var}    echo escaped variable
    {&var}   echo unescaped variable
    {@list}  list array
    {?bool}  show block on true
    {!bool}  show block on false
    {/list}  end of array or block
    {-php}   alias for <?php php ?>

