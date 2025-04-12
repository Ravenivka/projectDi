<?php
 
    
    
 
    class MyUsers {      
        private array $Collz;
        public array $Coll;
    
        public function __construct(string $base){
           $array = explode(PHP_EOL, file_get_contents($base));            
            $this->Collz = $array;
            $arr = array();
            $i = 0;
            foreach($array as $line){
                $ar = explode(',', $line);
                $arr[$i] = $ar;
                $i++;
            }
            $this->Coll = $arr;
        }

        public function getUser(int $index) {
            try {            
                $array = $this->Coll;
                return $array[$index];
            } catch (Exception $e) {
                return -1;
            }
        }
        public function getUserByName(string $string) {
            $array = $this->Coll;
            foreach($array as $arr) {
                if ($string == $arr[0]) {
                    return $arr;
                }
            }
            return null;
        }
        public function getRoleByName(string $string) {
            $array = $this->Coll;
            foreach($array as $arr) {
                if ($string == $arr[0]) {
                    return $arr[2];
                }
            }
            return 0;
        }
    
    }
?>