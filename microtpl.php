<?php

class MicroTpl{
  static function parse($tpl){
    return preg_replace(array(
        '_{\@([^}]+)}_',    # list array
        '_{\?([^}]+)}_',    # show on true
        '_{\!([^}]+)}_',    # show on false
        '_{\/([^}]+)}_',    # closing mark
        '_{\-([^}]+)}_',    # php code
        '_{\&([^}]+)}_',    # unescaped echo
        '_{([^ }][^}]*)}_', # escaped echo
      ), array(
        '<?php $_save_\1=get_defined_vars();'
          . 'foreach((isset($\1)&&is_array($\1)?$\1:array())as$_item){ '
          . 'if(is_array($_item))extract($_item)?>',
        '<?php if(isset($\1)&&!!$\1){ ?>',
        '<?php if(!isset($\1)||!$\1){ ?>',
        '<?php }if(is_array($_save_\1))extract($_save_\1)?>',
        '<?php \1?>',
        '<?php echo isset($\1)?$\1:null?>',
        '<?php echo isset($\1)?htmlspecialchars(\$\1,ENT_QUOTES):null?>',
      ), $tpl
    );
  }
  function render($_tpl){
    extract((array) $this);
    eval('?>' . self::parse($_tpl));
  }
}
