<?php declare(strict_types=1);
require_once "./utils/class/restaurant.php";

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Invoice::class)]
#[UsesClass(Money::class)]
final class RestaurantTest extends TestCase{

    public function testgetOsmid(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("node/3422189698", $restau->getOsmid());
        $this->assertIsString($restau->getOsmid());
        $this->assertNotEquals("node/34221898", $restau->getOsmid());
    }

    public function testgetNom(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("Le Bistrot de la Place", $restau->getNom());
        $this->assertNotEquals("Le Bistrot de la Peace", $restau->getNom());
    }

    public function testgetNbEtoile(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals(1, $restau->getNbEtoile());
        $this->assertNotEquals(2, $restau->getNbEtoile());
    }

    public function testgetCodeCommune(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("75056", $restau->getCodeCommune());
        $this->assertNotEquals("75057", $restau->getCodeCommune());
    }

    public function testgetNomCommune(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("Paris", $restau->getNomCommune());
        $this->assertNotEquals("Paris 1", $restau->getNomCommune());
    }

    public function testgetCuisines(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals(["Française"], $restau->getCuisines());
        $this->assertNotEquals(["Française", "Italienne"], $restau->getCuisines());
    }
    public function testgetTelephone(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("01 42 78 31 64", $restau->getTelephone());
        $this->assertNotEquals("01 42 78 31 65", $restau->getTelephone());
    }
    public function testgetSite(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("http://www.bistrotdelaplace.fr/", $restau->getSite());
        $this->assertNotEquals("http://www.bistrotdelaplace.com/", $restau->getSite());
    }
    public function testgetImageVertical(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", $restau->getImageVertical());
        $this->assertNotEquals("https://www.data.gouv.fr/s/resources/le-bistrot-de-la", $restau->getImageVertical());
    }

    public function testgetImageHorizontal(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", $restau->getImageHorizontal());
        $this->assertNotEquals("https://www.data.gouv.fr/s/resources/le-bistrot-de-la", $restau->getImageHorizontal());
    }
    public function testgetNoteMoyenne(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals(4, $restau->getNoteMoyenne());
        $this->assertNotEquals(3, $restau->getNoteMoyenne());
    }
    public function testformatAdresseCommune(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("75056 Paris", $restau->formatAdresseCommune());
        $this->assertNotEquals("75057 Paris", $restau->formatAdresseCommune());
    }
    public function testformatAdresse(): void {
        $json = [
            "address" => [
                "house_number" => "12",
                "retail" => "Avenue des Champs-Élysées",
                "city" => "Paris",
                "postcode" => "75008",
                "country" => "France"
            ]
        ];
        $this->assertEquals("12 Avenue des Champs-Élysées Paris 75008 France", formatAdresse($json));
        $this->assertNotEquals("12 Avenue des Champs-Élysées Paris 75008", formatAdresse($json));
    
        $jsonSansHouseNumber = [
            "address" => [
                "retail" => "Avenue des Champs-Élysées",
                "city" => "Paris",
                "postcode" => "75008",
                "country" => "France"
            ]
        ];
        $this->assertEquals(" Avenue des Champs-Élysées Paris 75008 France", formatAdresse($jsonSansHouseNumber));
    
        $jsonSansRetail = [
            "address" => [
                "house_number" => "12",
                "city" => "Paris",
                "postcode" => "75008",
                "country" => "France"
            ]
        ];
        $this->assertEquals("12 rue ..? Paris 75008 France", formatAdresse($jsonSansRetail));
    
        $jsonSansCity = [
            "address" => [
                "house_number" => "12",
                "retail" => "Avenue des Champs-Élysées",
                "postcode" => "75008",
                "country" => "France"
            ]
        ];
        $this->assertEquals("12 Avenue des Champs-Élysées 75008 France", formatAdresse($jsonSansCity));
    
        $jsonSansPostcode = [
            "address" => [
                "house_number" => "12",
                "retail" => "Avenue des Champs-Élysées",
                "city" => "Paris",
                "country" => "France"
            ]
        ];
        $this->assertEquals("12 Avenue des Champs-Élysées Paris France", formatAdresse($jsonSansPostcode));
    
        $jsonSansCountry = [
            "address" => [
                "house_number" => "12",
                "retail" => "Avenue des Champs-Élysées",
                "city" => "Paris",
                "postcode" => "75008"
            ]
        ];
        $this->assertEquals("12 Avenue des Champs-Élysées Paris 75008 ", formatAdresse($jsonSansCountry));
    }
    
    public function testformatetoile(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("<span class=\"colorEtoile\">★</span>☆☆☆☆", $restau->formatetoile());
        $this->assertNotEquals("★★☆☆☆", $restau->formatetoile());
    }
    public function testformatCuisine(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("Française", $restau->formatCuisine());
        $this->assertNotEquals("Française, Italienne", $restau->formatCuisine());
    }
    public function testformatUrlResto(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("pages/restaurant.php?osmID=node/3422189698&resto=Le Bistrot de la Place", $restau->formatUrlResto());
        $this->assertNotEquals("pages/restaurant.php?osmID=node/3422189698&resto=Le Bistrot de la Peace", $restau->formatUrlResto());
    }
    public function testformatUrlRestoFavoris(): void {
        $restau = new Restaurant("node/3422189698", "Le Bistrot de la Place", 1, "75056", "Paris", ["Française"], "01 42 78 31 64", "http://www.bistrotdelaplace.fr/", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place/20190701-112303/LeBistrotDeLaPlace.jpg", "https://www.data.gouv.fr/s/resources/le-bistrot-de-la-place", 4);
        $this->assertEquals("./restaurant.php?osmID=node/3422189698&resto=Le Bistrot de la Place", $restau->formatUrlRestoFavoris());
        $this->assertNotEquals("pages/restaurant.php?osmID=node/3422189698&resto=Le Bistrot de la Peace", $restau->formatUrlRestoFavoris());
    }
}

?>