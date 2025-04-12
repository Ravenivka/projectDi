<?php
class Users{
    public $User;
    private array $Coll;

    public function __construct() {
        $path = realpath($_SERVER['DOCUMENT_ROOT'].'/Data/user.txt');
    }

}


class MyUser{
    public string $name, $passwoed;
    public int $role;
    public function __construct(string $string){
        $text = explode(',', $string);
        $this->name = $text[0];
        $this->passwoed = $text[1];
        $this->role = (int) $text[2];
    }
}







?>