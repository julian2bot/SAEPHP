<?php
    require_once __DIR__."/../BD/connexionBD.php";

    /**
     * Renvoie une liste de jours à partir d'un jour de départ et d'un jour d'arrivé
     * @param string $firstDay
     * @param string $lastDay
     * @return array
     */
    function getAllDays(string $firstDay, string $lastDay):array{
        $days = ["Mo","Tu","We","Th","Fr","Sa","Su"];

        $res = [];

        $firstIndex = array_search($firstDay, $days);
        $lastIndex = array_search($lastDay, $days);

        if ($firstIndex === false || $lastIndex === false) {
            return [];
        }

        for ($i=$firstIndex; $i < $lastIndex+1; $i++) { 
            array_push($res, $days[$i]);
        }

        return $res;
    }
    
    /**
     * Transforme un string d'heure d'ouverture en liste de jour et de créneau horaire
     * @param string $opening
     * @return array Liste de liste contenant une liste de jours et une liste d'horaires 
     */
    function transformOpeningHours(string $opening):array{
        $res = [];

        $lesHoraires = explode("; ",$opening);
        foreach ($lesHoraires as $value) {
            $truc = [];
            $temp = explode(" ", $value,2);
            // $tempJour1 = explode(",",$temp[0]);
            $lesJours = [];
            foreach(explode(",",$temp[0]) as $key => $value) {
                $oui = [];
                $tempJour = explode("-",$value);
                if(sizeof($tempJour)>1){
                    $oui= getAllDays($tempJour[0],$tempJour[1]);
                }
                else{
                    $oui= $tempJour;
                }

                $lesJours = array_merge($lesJours, $oui);
            }
            $truc["jours"] = $lesJours;
            $truc["heures"] = [];

            if(! empty($truc["jours"])){
                if(sizeof($temp)>1){
                    $temp[1] = str_replace(" ", "",$temp[1]);
                    $tempHeures = explode(",",$temp[1]);
        
                    foreach($tempHeures as $uneHeure){
                        $resUneHeure = [];
                        $tempUneHeure = explode("-", $uneHeure);
                        $resUneHeure["debut"] = $tempUneHeure[0];
                        if(sizeof($tempUneHeure)>1){
                            $resUneHeure["fin"] = $tempUneHeure[1];
                        }
                        else{
                            $resUneHeure["fin"] = "00:00";
                        }
        
                        array_push($truc["heures"],$resUneHeure);
                    }
                }
                else{
                    $resUneHeure["debut"] = "00:00";
                    $resUneHeure["fin"] = "00:00";
                    // $resUneHeure["fin"] = null;
    
                    array_push($truc["heures"],$resUneHeure);
                }
    
                array_push($res,$truc);
            }

        }
        return $res;
    }
?>