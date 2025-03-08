<?php
    namespace utils\class;
    use utils\class\Commentaire as Commentaire;
    use \PDO;

    require_once __DIR__."/AutoLoad.php" ;
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
        $this-> noteMoyen = (int)$noteMoyen;
        $this-> lesCommentaires = [];
        $this-> bdd = $bdd;
        $this-> updateLesCommentaires();
    }
    
    /**
     * return osmid du restaurant
     * @return string
     */
    public function getOsmid() {
        return $this->osmid;
    }

    /**
     * return le nom du restaurant
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * return le nombre d'étoile du restaurant
     * @return int
     */
    public function getNbEtoile() {
        return $this->nbEtoile;
    }

    /**
     * return le code commune du restaurant
     * @return string
     */
    public function getCodeCommune() {
        return $this->codeCommune;
    }
    
    /**
     * return le nom de la commune du restaurant
     * @return string
     */
    public function getNomCommune() {
        return $this->nomCommune;
    }

    /**
     * return les cuisines du restaurant
     * @return array
     */
    public function getCuisines() {
        return $this->cuisines;
    }

    /**
     * return le téléphone du restaurant
     * @return string|null
     */
    public function getTelephone() {
        return $this->telephone;
    }

    /**
     * return le site du restaurant
     * @return string|null
     */
    public function getSite() {
        return $this->site;
    }

    /**
     * return les coordonées vertical du restaurant
     * @return string|null
     */
    public function getImageVertical() {
        return $this->imageVertical;
    }
    
    /**
     * return les coordonées horizontal du restaurant
     * @return string|null
     */
    public function getImageHorizontal() {
        return $this->imageHorizontal;
    }

    /**
     * return la note moyenne du restaurant
     * @return int|null
     */
    public function getNoteMoyenne() {
        return $this->noteMoyen;
    }

    /**
     * return l'adresse de la commune du restaurant formaté
     * @return string
     */
    function formatAdresseCommune():string{
        return $this->codeCommune." ".$this->nomCommune;
    }

    /**
     * return l'adresse du restaurant formaté
     * @return string
     */
    function formatAdresse($dataResto):string {
        return ($dataResto["address"]["house_number"] ?? '') ." ".
        ($dataResto["address"]["retail"] ?? 'rue ..?') ." ".
        ($dataResto["address"]["city"] ?? '') ." ".
        ($dataResto["address"]["postcode"] ?? '') ." ".
        ($dataResto["address"]["country"] ?? '');
    }

    /**
     * return les étoiles du restaurant formaté
     * @return string
     */
    function formatetoile():string {
        $this->nbEtoile = max(0, min(5, $this->nbEtoile));
    
        $etoilesDorees = str_repeat('★', $this->nbEtoile);
    
        $etoilesVides = str_repeat('☆', 5 - $this->nbEtoile);
    
        return '<span class="colorEtoile">' . $etoilesDorees . '</span>' . $etoilesVides;
    }
    
    /**
     * return les cuisines du restaurant formaté
     * @return string
     */
    function formatCuisine():string {

        if (!empty($this->cuisines) && is_array($this->cuisines)) {
            return implode(",\n", $this->cuisines);
        }
        return "Pas de cuisine dispo";    
    }

    /**
     * return l'url du restaurant formaté
     * @return string
     */
    function formatUrlResto():string{
        return "pages/restaurant.php?osmID=".$this->osmid."&resto=".$this->nom."";
    }

    /**
     * return l'url du restaurant formaté
     * @return string
     */
    function formatUrlRestoFavoris():string{
        return "./restaurant.php?osmID=".$this->osmid."&resto=".$this->nom.""; // todo même que formatUrlResto ??
    }

    /**
     * render les cartes des restaurants favoris
     * @param PDO $bdd
     * @return void
     */
    function renderFavoris(){
       echo '<div class="recommendationResto">
                <img src="../assets/img/backgroundImage2.png" alt="resto:">
                <div class="nomnote">
                    <p class="soustitre">'. $this->getNom().'</p>  
                    <div class="note">'. $this->formatetoile().'
                    <span class="hearts positionHeart" id="fav-'.$this->osmid.'"> &#10084 </span>
                    </div>
                    
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
                
                <p><a href="../'. $this->formatUrlResto().'" style="text-decoration:none; color:black;">Voir plus</a></p>
            </div>';
    }

    /**
     * render les cartes des restaurants dans la recherche
     * @param PDO $bdd
     * @return void
     */
    function renderIndexLesRestosRecherche(){
       echo ' <div class="resto">
                <a href="'. $this -> formatUrlResto().'">
                    <div class="nomnote" style="justify-content:space-between;">
                        <p class="soustitre">'.  $this ->getNom().'</p>  
                        
                        <div style="display:flex;">
                            <div class="note">'. $this->formatetoile().'</div>
                            <div>'. $this ->getNbEtoile().'/5</div>
                            '.$this->renderCoeur().'
                            
                        </div>
                        
                    </div>
                    <div class="adresse">
                        <p>'. $this->formatAdresseCommune().'</p>
                    </div>
                    <div class="attr">
                        <p>🍽</p>
                        <p>'.$this->formatCuisine().'</p>
                    </div>
                </a>
            </div>
            ';
    }

    /**
     * render un coeur si le restaurant est dans les favoris de l'utilisateur
     * @param PDO $bdd
     * @return void
     */
    function renderIndexLesRecommandations(){
        echo '<div class="recommendationResto">
                <img src="assets/img/backgroundImage2.png" alt="resto:">
                <div class="nomnote">
                    <p class="soustitre">'. $this->getNom().'</p>  
                    <div class="note">'. $this->formatetoile().'
                    '.$this->renderCoeur().'
                    </div>
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
    

    /**
     * render un coeur si le restaurant est dans les favoris de l'utilisateur
     * @return string
     */
    function renderCoeur(){
        if(!isset($_SESSION["connecte"]) || $this->bdd == null){
            // si pas connecté ne rien faire
            return '<span class="positionHeart"></span>';
        }
        if(estFavoris($this->bdd, $this->getOsmid(), $_SESSION["connecte"]["username"])){
            return '<span class="hearts positionHeart"  id="fav-'.$this->osmid.'"> &#10084 </span>';
        } else {
            return '<span class="heartsgrey positionHeart" id="fav-'.$this->osmid.'"> &#10084 </span>';
        }
    }

}
