# MicroTpl

MicroTpl is small templating system for PHP.

## Install

    composer require lloydzhou/microtpl 

There is one [Blog demo](https://github.com/lloydzhou/blog), work with [ActiveRecord](https://github.com/lloydzhou/activerecord) and [Router](https://github.com/lloydzhou/router).

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

### output layout.htmlc

	<!DOCTYPE html>
	<html>
	  <head>
		<title class="title"><?php echo $title;?></title>
	  </head>
	  <body>
		<h1><?php echo $title;?></h1>
		<hr></hr>
		<?php echo $content;?>
	  </body>
	</html>
	
### index.html

	<div id="content">
		<div id="menu">
			<ul tal:condition="isset($messages)">
				<li tal:repeat="$messages as $key => $message" >
					<a href="#message-1" tal:content="$message['title']" tal:href="'#message-'.($key+1)">message1</a>
				</li>
				<li tal:replace="">
					<a href="#message-2">message2</a>
				</li>
			</ul>
		</div>
		<div id="message" tal:condition="isset($messages)">
			<div id="message-1" tal:id="'message-'.($key+1)" tal:repeat="$messages as $key => $message" tal:class="($key%2 ? 'odd' : 'even')" >
				<h2>Message #<span tal:replace="$key+1"> 1</span></h2>
				<pre tal:content="$message['content']">message1 place holder</pre>
			</div>
			<div id="message-2" tal:replace="">
				<h2>message # 2</h2>
				<pre>message2 place holder</pre>
			</div>
		</div>
	</div>   

### output index.htmlc

	<div id="content">
		<div id="menu">
			<?php if(isset($messages)):?><ul>
				<?php foreach($messages as $key => $message):?><li>
					<a href="<?php echo '#message-'.($key+1);?>"><?php echo $message['title'];?></a>
				</li><?php endforeach;?>
				
			</ul><?php endif;?>
		</div>
		<?php if(isset($messages)):?><div id="message">
			<?php foreach($messages as $key => $message):?><div id="<?php echo 'message-'.($key+1);?>" class="<?php echo ($key%2 ? 'odd' : 'even');?>">
				<h2>Message #<?php echo $key+1;?></h2>
				<pre><?php echo $message['content'];?></pre>
			</div><?php endforeach;?>
			
		</div><?php endif;?>
	</div>
	
### index.php

	<?php
	include "MicroTpl.php";

	$content = <<<STRING
	small template attribute language implement for PHP (using xml_parse)
	small template attribute language implement for PHP (using xml_parse)
	small template attribute language implement for PHP (using xml_parse)
	small template attribute language implement for PHP (using xml_parse)
	small template attribute language implement for PHP (using xml_parse)
	STRING
	;
	MicroTpl::render('index.html', array(
		'title' => 'Hello Micro Template', 
		'messages' => array(
			array('title' => 'message 1', 'content' => $content),
			array('title' => 'message 2', 'content' => $content),
			array('title' => 'message 3', 'content' => $content),
			array('title' => 'message 4', 'content' => $content),
			array('title' => 'message 5', 'content' => $content),
			array('title' => 'message 6', 'content' => $content),
			array('title' => 'message 7', 'content' => $content),
			array('title' => 'message 8', 'content' => $content),
			array('title' => 'message 9', 'content' => $content),
			array('title' => 'message 10', 'content' => $content)
		)
	), 'layout.html');
	
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
