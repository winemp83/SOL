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
        $this->setAuctions();
    }
    
    private function getUser(){
        $user = 0;
        $result = $GLOBALS['DATABASE']->query("SELECT COUNT(id) FROM uni1_users");
        foreach($result as $erg){
            $user = $erg['COUNT(id)'];
        }
        return $user;
    }
    
    private function getMaxAuctions($toleranz = 0){
       $auc =  \floor($this->getUser() / 10);
       $aucMin = $auc - $toleranz;
       $aucMax = $auc + $toleranz;
       
       return \rand($aucMin, $aucMax);
    }
    
    private function setAuctionsValue(){
        $result = $GLOBALS['DATABASE']->query("SELECT AVG(total_points) FROM uni1_statpoints");
        foreach($result as $erg){$zwischen = $erg['AVG(total_points)'];}
        if($zwischen < 10000){
            $toleranz = 1000;}
        elseif($zwischen > 10000 && $zwischen < 100000){
            $toleranz = 2500;}
        else{$toleranz = 0;
            $zwischen = 100000;
        }
        return \rand($toleranz, $zwischen);
    }
    
    private function setAuctions(){
       
        $i = 0;
        $anz = $this->getMaxAuctions(2);
        do{
            $query = "INSERT INTO ".MARKET." SET
                                `sender` = 1,
                                `senderplanet` = 1,
                                `user` = 'Markt Kontrolle',
                                `type` = '".time(). "',
				`typeres` = 1,";
		                
                                
            $i++;
            $query .= $this->whatToDo();
            $query .= " `universe` = 1,
			`galaxie`  = 1,
			`systeme`  = 1,
			`planete`  = 1;";
            print_r($query);
            $this->doItNow($query);
        }
        while($anz != $i);
    }
    
    private function whatToDo(){
        $what = \mt_rand(1,3);
        if ($what == 1){
          return $this->doWhitMetall(\mt_rand(1,2));
        }else{
          return $this->doWhitKristall(\mt_rand(1,2));
        }
    }
    
    private function doWhitMetall($do){
        if(\mt_rand(1,2) == 1){
            $deut = true;}else{
            $deut = false;
        }if($do == 1){if($deut){
                $met = $this->setAuctionsValue();
                $deu = round($met*4);
                $string = " `metala` = '". $met ."',
                            `metals` = 0,
                            `cristala` = 0,
                            `cristals` = 0,
                            `deuta` = 0,
                            `deuts` = '". $deu ."',";
                return $string;}else{
                $met = $this->setAuctionsValue();
                $deu = round($met/4);
                $string = " `metala` = 0,
                            `metals` = '".$met."',
                            `cristala` = 0,
                            `cristals` = 0,
                            `deuta` = '". $deu ."',
                            `deuts` = 0,";
                return $string;}}else{if($deut){
                $met = $this->setAuctionsValue();
                $deu = round($met*2);
                $string = " `metala` ='". $met ."',
                            `metals` = 0,
                            `cristala` = 0,
                            `cristals` = '". $deu ."',
                            `deuta` = 0,
                            `deuts` = 0,";
                return $string;}else{
                $met = $this->setAuctionsValue();
                $deu = round($met/2);
                $string = " `metala` = 0,
                            `metals` = '".$met."',
                            `cristala` = '". $deu ."',
                            `cristals` = 0,
                            `deuta` = 0,
                            `deuts` = 0,";
                return $string;}}
    }
    
    private function doWhitKristall($do){
        if(\mt_rand(1,2) == 1){
            $deut = true;}else{
            $deut = false;
        }if($do == 1){if($deut){
                $met = $this->setAuctionsValue();
                $deu = round($met*2);
                $string = " `metala` = `metala` + '0',
                            `metals` = `metals` + '0',
                            `cristala` = `cristala` + '". $met ."',
                            `cristals` = `cristals` + '0',
                            `deuta` = `deuta` + '0',
                            `deuts` = `deuts` + '". $deu ."',";
                return $string;}else{
                $met = $this->setAuctionsValue();
                $deu = round($met/2);
                $string = " `metala` = `metala` + '0',
                            `metals` = `metals` + '0',
                            `cristala` = `cristala` + '0',
                            `cristals` = `cristals` + '".$met."',
                            `deuta` = `deuta` + '". $deu ."',
                            `deuts` = `deuts` + '0',";
                return $string;}}else{if($deut){
                $met = $this->setAuctionsValue();
                $deu = round($met/2);
                $string = " `metala` = `metala` + '". $met ."',
                            `metals` = `metals` + '0',
                            `cristala` = `cristala` + '0',
                            `cristals` = `cristals` + '". $deu ."',
                            `deuta` = `deuta` + '0',
                            `deuts` = `deuts` + '0',";
                return $string;}else{
                $met = $this->setAuctionsValue();
                $deu = round($met/4);
                $string = " `metala` = `metala` + '0',
                            `metals` = `metals` + '".$met."',
                            `cristala` = `cristala` + '". $deu ."',
                            `cristals` = `cristals` + '0',
                            `deuta` = `deuta` + '0',
                            `deuts` = `deuts` + '0',";
                return $string;}}
    }
       
    private function doItNow($query){
        echo $query;
        $GLOBALS['DATABASE']->query($query);
    }
    
}