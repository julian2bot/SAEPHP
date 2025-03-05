<?php
    require_once __DIR__."/../BD/connexionBD.php";
    require_once __DIR__."/../annexe/annexe.php";
    require_once __DIR__."/../BD/requettes/insert.php";
    require_once __DIR__."/../BD/requettes/select.php";
    require_once __DIR__."/../BD/requettes/delete.php";
    
    class Commentaire{
        private string $resto;
        private string $username;
        private int $nbEtoile;
        private string $dateCommentaire;
        private string $commentaire;

        public function __construct(
            $username,
            $nbEtoile,
            $dateCommentaire,
            $resto,
            $commentaire
            ) {
                $this->username = $username;
                $this->nbEtoile = $nbEtoile??0;
                $this->resto = $resto;
                $this->dateCommentaire = $dateCommentaire;
                $this->commentaire = $commentaire;
        }


        function formatetoileV2():string {
            $this->nbEtoile = max(0, min(5, $this->nbEtoile));
        
            $etoilesDorees = str_repeat('★', $this->nbEtoile);
        
            $etoilesVides = str_repeat('☆', 5 - $this->nbEtoile);
        
            return '<span class="colorEtoileNoShadow">' . $etoilesDorees . '</span>' . $etoilesVides;
        }


        function renderCommentaire(){
        echo '
            <div class="commentaire">
                <h3>'. $this->username.'</h3>
                <div>

                    <div class="etoiles">'. $this->formatetoileV2() .'</div>
                    <span class="date">'. $this->dateCommentaire.'</span>
                </div>                        
                <div>
                    '. $this->commentaire.'
                </div>
            </div>';
        }

        /**
         * Envoie ou modifie un commentaire
         * @return void
         */
        function sendCommentaire(PDO $bdd):void{
            if (existCommentairesRestoUser($bdd, $this->resto, $this->username)){
                updateCommentaire($bdd, $this->resto, $this->username, $this->commentaire, $this->nbEtoile);
            }
            else{
                insertCommentaire($bdd, $this->resto, $this->username, $this->nbEtoile, $this->commentaire);
            }
        }

        function deleteCommentaire(PDO $bdd):void{
            // todo do proper user class ; function doest not exist
            deleteCommentaireUser($bdd, $this->resto, $this->username);
        }
    }
?>