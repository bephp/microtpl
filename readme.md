# MicroTpl

MicroTpl is small templating system for PHP.

## Example

    <?php
    require_once 'microtpl.php';

    $tpl = new MicroTpl();
    $tpl->title = 'MicroTpl';
    $tpl->messages = array(
      array('message' => 'Hello, Earth'),
      array('message' => 'We confiscates this planet.')
    );

    ob_start();

    ?><!DOCTYPE html>
    <html>
      <head>
        <title>{title}</title>
      </head>
      <body>
        <h1>{title}</h1>
        {@messages}
        <p>{message}</p>
        {/messages}
      </body>
    </html><?php

    $tpl->render(ob_get_clean());

## Syntax

    {var}         echo escaped variable
    {&var}        echo unescaped variable
    {@list}       list array
    {?bool}       show block on true
    {!bool}       show block on false
    {/list}       end of array or block
    {php code}    process php code
    {var='value'} assign value to variable

## API

### MicroTpl::parse()

    string parse(string $tpl)

Converts template to php code.

### $microTpl->render()

    mixed render(string $_tpl, bool $_return = false)

Converts template to php code and execute it.

If `$_return` is set to true, method will return the output instead of outputing it.

### $microTpl->renderFile()

    mixed renderFile(string $file, bool $return = false)

Same as `render()` but loads template from file.
