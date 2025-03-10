<?php declare(strict_types=1);
require_once "./utils/class/restaurant.php";

use PHPUnit\Framework\TestCase;

final class CommentaireTest extends TestCase{
    public function testformatetoileV2(){
        $commentaire = new Commentaire( "JeanDupont", 4, "2024-03-03", "Super restaurant, très bonne ambiance !");
    $this->assertEquals("<span class=\"colorEtoileNoShadow\">★★★★</span>☆", $commentaire->formatetoileV2());
    }   
}


?>
