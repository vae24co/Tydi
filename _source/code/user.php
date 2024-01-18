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
}



$crud = new DatabaseX::connect("localhost", "username", "password", "database");

// Example: Insert data
$insertData = array(
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'age' => 25
);
$crud->create('users', $insertData);

// Example: Read data
$readData = $crud->read('users', "age > 20");
print_r($readData);

// Example: Update data
$updateData = array(
    'age' => 26
);
$crud->update('users', $updateData, "name = 'John Doe'");

// Example: Delete data
$crud->delete('users', "age < 25");

?>