<?php
class User {
public function index() {
echo 'Index of User';
return;
}



public function name($name = 'John') {
// echo 'Hello ' . urldecode($name);
if (StringX::isEncoded($name)) {
$name = urldecode($name);
}
echo 'Dear ' . $name;
return;
}
}?>