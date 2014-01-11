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
        $this->updateFleetTrader();
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
    
    function rndShips(){
        $a = mt_rand(1,15);
        return $a;
    }
    function rndDef(){
        $a = mt_rand(1,7);
        return $a;
    }
    function getShips($a){
        switch($a){
            case 1  : return 202;
                      break;
            case 2  : return 203;
                      break;
            case 3  : return 204;
                      break;
            case 4  : return 205;
                      break;
            case 5  : return 206;
                      break;
            case 6  : return 207;
                      break;
            case 7  : return 209;
                      break;
            case 8  : return 211;
                      break;
            case 9  : return 213;
                      break;
            case 10  : return 214;
                      break;
            case 11  : return 215;
                      break;
            case 12  : return 216;
                      break;
            case 13  : return 217;
                      break;
            case 14  : return 218;
                      break;
            case 15  : return 219;
                      break;
        }
    }
    function getDef($a){
        switch ($a){
            case 1 : return 401;
                break;
            case 2 : return 402;
                break;
            case 3 : return 403;
                break;
            case 4 : return 404;
                break;
            case 5 : return 405;
                break;
            case 6 : return 406;
                break;
            case 7 : return 410;
                break;
        }
    }
    function createArt(){
        $a = $this->rndDef();
        $b = 0;
        $c = 0;
        while($b === $c){
            $b = $this->rndShips();
            $c = $this->rndShips();
        }
        $ba = $this->getShips($b);
        $bb = $this->getShips($c);
        $bc = $this->getDef($a);
        $result = $ba.",".$bb.",".$bc;
        return $result;
    }
    function updateFleetTrader(){
        $sql = "UPDATE uni1_config SET trade_allowed_ships='".$this->createArt()."'";
        $GLOBALS['DATABASE']->query($sql);
    }
}