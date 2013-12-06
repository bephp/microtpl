# MicroTpl

MicroTpl is small templating system for PHP.

## Example
### layout.

	<!DOCTYPE html>
	<html>
	  <head>
		<title class="title" tal:content="$title">title place holder</title>
	  </head>
	  <body>
		<h1 tal:content="$title">title place holder</h1>
		<hr/>
		<div tal:replace="$content">Contents</div>
	  </body>
	</html>

### index.html

	<div id="content">
		<div tal:condition="isset($messages)">
			<p tal:repeat="$messages as $key => $message" tal:content="$message">message1 place holder</p>
			<p tal:replace="">message2 place holder</p>
		</div>
	</div>	

### index.php

	<?php
	include "MicroTpl.php";

	$t = new MicroTpl();
	$t->title = 'Hello Micro Template';
	$t->messages = array('message 1', 'message 2');
	$t->parse(file_get_contents('index.html'));
    ?>

### Output

	<!DOCTYPE html>
	<html>
	  <head>
		<title class="title">Hello Micro Template</title>
	  </head>
	  <body>
			<h1>Hello Micro Template</h1>
			<hr></hr>
		<div id="content">
		<div>
			<p>message 1</p>
	<p>message 2</p>
		</div>
	</div>
	  </body>
	</html>
	
## Syntax

    tal:content="$title"
	tal:condition="isset($messages)"	
	tal:repeat="$messages as $key => $message"
	tal:replace=""
	/**
	 * Replace the attributes of the tag with php code. 
	 * Can using the attribute names such as 'id', 'href', 'class' and so on.
	 */
	tal:id="'message-'.($key+1)"
	tal:href="'#message-'.($key+1)"
	tal:class="($key%2 ? 'odd' : 'even')" 
	......

## API refrence

	// parse the template from string 
	public static function parse($template)
	//	render file with layout by using $data.
	public static function render($view, $data = array(), $layout = '')	