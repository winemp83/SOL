<?php

/* 
 * 
 * Createt by winemp83
 * all Copyrights by winemp83
 * Do not Change anything if you don't know what to do!
 * 
 */

class MarketCronjob {
    public function run (){
        $i = 5;
        for($j = 0; $j < $i; $j++){
            //$this->insertAuction();
            
           $this->insertAuction();
        }
    }
    function insertAuction(){
        $GLOBALS['DATABASE']->query($this->prepareAuction());
    }
    function prepareAuction(){
        $query = $this->Statement();
        return $query;
    }
    function Statement(){
      $statement =  "INSERT INTO ".MARKET." SET ";
      $statement .= $this->prepareStatment();
      return $statement;
    }
    function prepareStatment(){
        $statment = "`sender` = '60',
		    `senderplanet` = '361',
		    `user` = 'Markt',
                    `type` = '".time(). "',
                    `typeres` = '1',".$this->WhatToDo()."
		    `universe` ='1',
                    `galaxie`  ='9',
                    `systeme`  ='399',
                    `planete`  ='15';";
        return $statment;
    }
    function auction($a, $b){
        $c = $this->ressSale();
        if($a === 1){
            $statement = "`metala` = 0,
                          `metals` = '".$c."',";
            if($b === 1){
                $statement .= "`cristala` = '". $this->changeRess(1, $c) ."',
                               `cristals` = '0',
                               `deuta` = '0',
                               `deuts` = '0',";
            }else{
                $statement .= "`deuta` = '". $this->changeRess(2, $c) ."',
                               `deuts` = '0',
                               `cristala` = '0',
                               `cristals` = '0',";
            }
        }elseif($a === 2){
            $statement = "`cristala` = '0',
                          `cristals` = '".$c."',";
            if($b === 1){
                $statement .= "`metala` = ". $this->changeRess(3, $c) .",
                               `metals` = '0',
                               `deuta` = '0',
                               `deuts` = '0',";
                
            }else{
                $statement .= "`deuta` = '". $this->changeRess(4, $c) ."',
                               `deuts` = '0',
                               `metala` = '0',
                               `metals` = '0',";
            }
        }else{
            $statement = "`deuta` = '0',
                          `deuts` = '".$c."',";
            if($b === 1){
                $statement .= "`metala` = ". $this->changeRess(5, $c) .",
                               `metals` = '0',
                               `cristala` = '0',
                               `cristals` = '0',";
            }else{
                $statement .= "`cristala` = '". $this->changeRess(6, $c) ."',
                               `cristals` = '0',
                               `metala` = '0',
                               `metals` = '0',";
            }
        }
        
        return $statement;
    }
    function ressSale(){
        $result = $GLOBALS['DATABASE']->query("SELECT AVG(build_points) FROM uni1_statpoints WHERE build_points != 0");
        foreach($result as $erg){
            if($erg['AVG(build_points)'] > 100000){
                $g = rand(1000, 100000);  
            }
            else{
                $g = rand(1000,$erg['AVG(build_points)']);
            }
            return $g;
        }
    }
    function changeRess($c, $e){
        switch ($c) {
            case 1: $d = mt_rand(10, 30);
                    $d *= 0.1;
                    $f = $e / $d;
                    break;
            case 2: $d = mt_rand(20, 40);
                    $d *= 0.1;
                    $f = $e / $d;
                    break;
            case 3: $d = mt_rand(20, 40);
                    $d *= 0.1;
                    $f = $e * $d;
                    break;
            case 4: $d = mt_rand(20, 40);
                    $d *= 0.1;
                    $f = $e / $d;
                    break;
            case 5: $d = mt_rand(40, 60);
                    $d *= 0.1;
                    $f = $e * $d;
                    break;
            default: $d = mt_rand(20, 40);
                     $d *= 0.1;
                     $f = $e * $d;
                    break;
        }
        $f = round($f);
        return $f;
    }
    function WhatToDo(){
        $a = mt_rand(0,3);
        $b = mt_rand(1,2);
       return $this->auction($a,$b);
    }
}