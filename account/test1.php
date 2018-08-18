<?php
class foo
{
  public function change1( $input )
  {
    $input = 200;
  }
  public function change2( $input )
  {
    $input->value = 200;
  }
}
class bar
{
  public $value;
}

$obj = new foo();
$var = new bar();

// Object variable set with a value of 100
$var->value = 100;

$obj->change1( $var->value );
echo $var->value;
// Value 100

$var->value = 100;
$obj->change2( $var );
echo $var->value;
// Value 200
?>