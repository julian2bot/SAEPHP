<?php
// echo __DIR__."/../BD/connexionBD.php";
    require_once __DIR__."/../BD/connexionBD.php";
    require_once __DIR__."/../annexe/annexe.php";

class Restaurant{

    private string $osmid;
    private string $nom;
    private int $nbEtoile;
    private string $codeCommune;
    private string $nomCommune;
    private array $cuisines;


    private ?string $telephone;
    private ?string $site;
    private ?string $imageVertical;
    private ?string $imageHorizontal;

    public function __construct(
                $osmid,
                $nom, 
                $nbEtoile, 
                $codeCommune, 
                $nomCommune, 
                $cuisines=null,
                $telephone = null,
                $site = null,
                $imageVertical = null,
                $imageHorizontal = null
                ) {
    
        $this-> osmid = $osmid;
        $this-> nom = $nom;
        $this-> nbEtoile = $nbEtoile??0;
        $this-> codeCommune = $codeCommune??"";
        $this-> nomCommune = $nomCommune??"";
        $this-> cuisines = $cuisines??[];
        $this-> telephone = $telephone??null;
        $this-> site = $site??null;
        $this-> imageVertical = $imageVertical;
        $this-> imageHorizontal = $imageHorizontal;
    }

    // Getter for $osmid
    public function getOsmid() {
        return $this->osmid;
    }

    // Getter for $nom
    public function getNom() {
        return $this->nom;
    }

    // Getter for $nbEtoile
    public function getNbEtoile() {
        return $this->nbEtoile;
    }

    // Getter for $codeCommune
    public function getCodeCommune() {
        return $this->codeCommune;
    }

    // Getter for $nomCommune
    public function getNomCommune() {
        return $this->nomCommune;
    }

    // Getter for $cuisine
    public function getCuisines() {
        return $this->cuisines;
    }


    // Getters
    public function getTelephone() {
        return $this->telephone;
    }

    public function getSite() {
        return $this->site;
    }

    public function getImageVertical() {
        return $this->imageVertical;
    }

    public function getImageHorizontal() {
        return $this->imageHorizontal;
    }

    function formatAdresseCommune():string{
        return $this->codeCommune." ".$this->nomCommune;
    }

    function formatAdresse($dataResto):string {
        return ($dataResto["address"]["house_number"] ?? '') ." ".
        ($dataResto["address"]["retail"] ?? 'rue ..?') ." ".
        ($dataResto["address"]["city"] ?? '') ." ".
        ($dataResto["address"]["postcode"] ?? '') ." ".
        ($dataResto["address"]["country"] ?? '');
    }

    function formatetoile():string {
        $this->nbEtoile = max(0, min(5, $this->nbEtoile));
    
        $etoilesDorees = str_repeat('★', $this->nbEtoile);
    
        $etoilesVides = str_repeat('☆', 5 - $this->nbEtoile);
    
        return '<span class="colorEtoile">' . $etoilesDorees . '</span>' . $etoilesVides;
    }
    

    function formatCuisine():string {
        
        if (!empty($this->cuisines) && is_array($this->cuisines)) {
            return implode(",\n", $this->cuisines);
        }
        return "Pas de cuisine dispo";    
    }

    
    function formatUrlResto():string{
        return "pages/restaurant.php?osmID=".$this->osmid."&resto=".$this->nom."";
    }
    function formatUrlRestoFavoris():string{
        return "./restaurant.php?osmID=".$this->osmid."&resto=".$this->nom."";
    }
}


