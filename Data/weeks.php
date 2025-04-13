<?php

global $pack;
global $months;
$months = array(
    1 => "Январь",
    2 => "Февраль",
    3 => "Март",
    4 => "Апрель",
    5 => "Май",
    6 => "Июнь",
    7 => "Июль",
    8 => "Август",
    9 => "Сентябрь",
    10=> "Октябрь",
    11=> "Ноябрь",
    12=> "Декабрь"
);

class Week {      
    public string $start, $finish, $month, $path, $year;
    public int $month_int, $year_int;

    public function __construct(string $start, string $finish, string $year, int $month, string $path){
        global $months;
        $this->start = $start;
        $this->finish = $finish;
        $this->month_int = $month;
        $this->year = $year;
        $this->month = $months[$month];
        $this->path = 'schedule/'.$year.'/'.$path;
    }

}

class My_Month {
    public string $year, $name;
    public int $number;
    public array $weeks ;

    public function __construct(string $year, int $num){
        global $months;
        $this->year = $year;
        $this->number = $num;
        $this->name = $months[$num];
        $this->weeks = array();
    }

    public function addWeek(Week $week){
        $num = count( $this->weeks );
        $this->weeks[$num] = $week;
    }
    public function addWeekByValue(string $start, string $finish, string $path){
        $week = new Week($start, $finish, $this->year, $this->number, $path);
        $this->addWeek($week);
    }

}

class My_Year {
    public string $year;
    public int $year_int;
    public array $months;    
    public function __construct(string $name){
        $this->months = array();
        $this->year = $name;
        $this->year_int = (int) $this->year;        
    }
    public function addMonth(int $number){
        $month = new My_Month($this->year, $number);
        if (in_array($month, $this->months) == false) {
            $this->months[$number] = $month;
        }
    }
    public function getMonth(int $number){
        return $this->months[$number];
    }
}

class Pack {
    public array $collection;
    public function __construct($path){
        $this->collection = array();
        $text1 = file_get_contents($path);
        $stringArray = explode(PHP_EOL, $text1);
        foreach($stringArray as $line){
            $lineArray = explode(',', $line);
            $Year = new My_Year($lineArray[0]);
            if (in_array($Year, $this->collection) == false){
                $this->collection[$lineArray[0]] = $Year;
            }
        }
        foreach ($this->collection as $key){
            foreach($stringArray as $line){
                $lineArray = explode(',', $line);
                if ($key->year == $lineArray[0]){
                    $key->addMonth($lineArray[1]);
                }
            }
        }
        foreach($stringArray as $line){
            $lineArray = explode(',', $line);
            //$path = '/shedule'.'/'.$lineArray[0].'/'.$lineArray[4];
            $week = new Week($lineArray[2], $lineArray[3], $lineArray[0], $lineArray[1],$lineArray[4]);
            foreach ($this->collection as $key){
                foreach($key->months as $month){
                    if (($week->month == $month->name) and ($week->year == $key->year)){
                        $month->addWeek($week);
                    }
                }
            }
        }

    } 
    public function getYear(string $key){
        $col = $this->collection;
        return $col[$key];
    }
}
$pack = new Pack(realpath($_SERVER['DOCUMENT_ROOT'].'/Data/photo.txt'));


?>