<?php
    namespace utils\class;

    require_once __DIR__."/AutoLoad.php" ;
    require_once __DIR__."/../BD/connexionBD.php";
    require_once __DIR__."/../annexe/annexe.php";

    use utils\class\Commentaire as Commentaire;

    use PDO;

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
    private ?int $noteMoyen;

    private PDO $bdd;

    public array $lesCommentaires;

    public function __construct(
                $bdd,
                $osmid,
                $nom, 
                $nbEtoile, 
                $codeCommune, 
                $nomCommune, 
                $cuisines=null,
                $telephone = null,
                $site = null,
                $imageVertical = null,
                $imageHorizontal = null,
                $noteMoyen = null
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
        $this-> noteMoyen = $noteMoyen;
        $this-> lesCommentaires = [];
        $this-> bdd = $bdd;
        $this-> updateLesCommentaires();
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

    public function getNoteMoyenne() {
        return $this->noteMoyen;
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


    function renderFavoris(){
        echo  '
            <div class="recommendationResto">
                <span class="hearts positionHeart"> &#10084 </span>
                <img src="../assets/img/backgroundImage2.png" alt="resto:">
                
                <div class="nomnote">
                    <p class="soustitre">'.$this->getNom().'</p>  
                    <div class="note">'.$this->formatetoile().'</div>
                </div>
                <div class="adresse">
                    <p>'.$this->formatAdresseCommune().'</p>
                </div>
                <div class="attr">
                    <p>🍽</p>
                    <p>'.$this->formatCuisine().'</p>
                </div>
                
                <p><a href="'.$this->formatUrlRestoFavoris().'" style="text-decoration:none; color:black;">Voir plus</a></p>
            </div>
       ';
    }


    function renderIndexLesRestosRecherche(){
       echo ' <div class="resto">
                <a href="'. $this -> formatUrlResto().'">
                    <div class="nomnote" style="justify-content:space-between;">
                        <p class="soustitre">'.  $this ->getNom().'</p>  
                        
                        <div style="display:flex;">
                            <div class="note">'. $this->formatetoile().'</div>
                            <div>'. $this ->getNbEtoile().'/5</div>
                        </div>
                    </div>
                    <div class="adresse">
                        <p>'. $this->formatAdresseCommune().'</p>
                    </div>
                    <div class="attr">
                        <p>🍽</p>
                        <p>
                        '.
                            $this->formatCuisine()
                        .'
                        </p>
                    </div>
                </a>
            </div>
            ';
    }


    function renderIndexLesRecommandations(){
        echo '<div class="recommendationResto">
                <img src="assets/img/backgroundImage2.png" alt="resto:">

                <div class="nomnote">
                    <p class="soustitre">'. $this->getNom().'</p>  
                    <div class="note">'. $this->formatetoile().'</div>
                </div>
                <div class="adresse">
                <p>'. $this->formatAdresseCommune().'</p>
                </div>
                <div class="attr">
                    <p>🍽</p>
                    <p>
                        '. $this->formatCuisine().'
                    </p>
                </div>
                
                <p><a href="'. $this->formatUrlResto().'" style="text-decoration:none; color:black;">Voir plus</a></p>
            </div>';
    }

    function updateLesCommentaires():void{

        $this->lesCommentaires = [];
        foreach (getCommentairesResto($this->bdd, $this->osmid)["commentaires"] as $CommUser) {
            if (! isset($_SESSION["connecte"]["username"]) || (isset($_SESSION["connecte"]["username"]) && $_SESSION["connecte"]["username"] != $CommUser["username"])){
                $commentaireClass = new Commentaire(
                    $CommUser["username"],
                    $CommUser["note"]??0,
                    $CommUser["datecommentaire"],
                    $this->osmid,
                    $CommUser["commentaire"]
                ) ;
                array_push($this->lesCommentaires,$commentaireClass);
            }
        }
    }

    /**
     * Liste des services proposés 
     * @return string[]
     */
    function getAllServices(): array {
        return [
            "vegetarien" => "vege.png",
            "vegan" => "vegan.png",
            "livraison" => "livraison.png",
            "aemporter" => "emporter.png",
            "drive" => "drive.png",
            "accessinternet" => "internet.png",
            "espacefumeur" => "fumeur.png",
            "fauteuilroulant" => "fauteuil.png"
        ];
    }
    

    function lesServices(){
        $result = [];
        $services = $this->getAllServices();
        
        foreach ($services as $service => $image) {
            
            $sql = "SELECT $service FROM RESTAURANT WHERE osmid = :osmid";
        
            $stmt = $this->bdd->prepare($sql);
            $stmt->bindParam(':osmid', $this->osmid, PDO::PARAM_STR);
        
            $stmt->execute();
        
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($row && $row[$service] !== null) {
                $result[$service] = [
                    'res' => $row[$service], 
                    'img' => $image
                ];
            }
        }
    
        return $result;
    }
    

}
