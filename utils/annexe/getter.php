<?php


function getRecommendation2(PDO $bdd):array{
    return array(
        [
            "nomRestaurant"=>"Nom",
            "etoiles"=>3,
            "codeCommune"=>"45000",
            "nomCommune"=>"orleans",
            "cuisines"=>["jap", "french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>5,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "cuisines"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>1,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "cuisines"=>["french"]
        ]);
}

function getLesRestaurants2(PDO $bdd):array{


    return array(
        [
            "nomRestaurant"=>"Nom",
            "etoiles"=>3,
            "codeCommune"=>"45000",
            "nomCommune"=>"orleans",
            "cuisines"=>["jap", "french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>5,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "cuisines"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>1,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "cuisines"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>2,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "cuisines"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>3,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "cuisines"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>4,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "cuisines"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>5,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "cuisines"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>6,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "cuisines"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>0,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "cuisines"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "cuisines"=>["french"]
        ]
        );

}


// function getLesRestaurants2(PDO $bdd):array{

//     return array(
//         [
//             "nomRestaurant"=>"Nom",
//             "etoiles"=>3,
//             "codeCommune"=>"45000",
//             "nomCommune"=>"orleans",
//             "cuisines"=>["jap", "french"]
//         ] 
// }

function getRestaurantByID2(){
    return Array
    (
    "osmid" => "node/3422189698"
    ,"0" => "node/3422189698"
    ,"nomrestaurant" => "Cha+"
    ,"1" => "Cha+"
    ,"telephone" => "+33 2 38 53 78 02"
    ,"2" => "+33 2 38 53 78 02"
    ,"siret" => "83037025000011"
    ,"3" => "83037025000011"
    ,"etoiles" => ""
    ,"4" => ""
    ,"siteinternet" => "http://www.le-dream-s-coffee.com"
    ,"5" => "http://www.le-dream-s-coffee.com"
    ,"codecommune" => 45234
    ,"6" => 45234
    ,"vegetarien" => ""
    ,"7" => ""
    ,"vegan" => ""
    ,"8" => ""
    ,"livraison" => ""
    ,"9" => ""
    ,"aemporter" => ""
    ,"10" => ""
    ,"drive" => ""
    ,"11" => ""
    ,"accessinternet" => ""
    ,"12" => ""
    ,"capacite" => ""
    ,"13" => ""
    ,"marque" => ""
    ,"14" => ""
    ,"operateur" => ""
    ,"15" => ""
    ,"cuisines" => "fast_food"
    ,"16" => "fast_food"
    ,"wikidata" => ""
    ,"17" => ""
    ,"marquewikidata" => ""
    ,"18" => ""
    ,"espacefumeur" => ""
    ,"19" => ""
    ,"fauteuilroulant" => "no"
    ,"20" => "no"
    ,"facebook" => ""
    ,"21" => ""
    ,"longitude" => "1.9052942"
    ,"22" => "1.9052942"
    ,"latitude" => "47.901149799961"
    ,"23" => "47.901149799961",
    "cuisines"=>["french", "ba"]

    );
}

function getCommentaireByResto2(){
    return array (
        "noteMoy" => 4.2,
        "commentaires" => [
            array(
                "username" => "Alice75",
                "osmID" => "123456",
                "note" => 5.0,
                "commentaire" => "Meilleur restaurant dans lequel j’ai pu manger dans cette ville d’aigri, je recommande Super restaurant, service impeccable !",
                "datecommentaire" => "2024-02-01"
            ),
            array(
                "username" => "JeanMichel",
                "osmID" => "654321",
                "note" => 3.8,
                "commentaire" => "Bonne cuisine mais un peu cher.",
                "datecommentaire" => "2024-01-15"
            ),
            array(
                "username" => "SophieB",
                "osmID" => "789456",
                "note" => 4.5,
                "commentaire" => "Excellente ambiance et plats délicieux !",
                "datecommentaire" => "2024-01-30"
            ),
            array(
                "username" => "Tommy88",
                "osmID" => "321789",
                "note" => 2.7,
                "commentaire" => "Service un peu lent, mais la nourriture était correcte.",
                "datecommentaire" => "2024-01-10"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "Laura92",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            ),
            array(
                "username" => "jeanMich",
                "osmID" => "963852",
                "note" => 4.9,
                "commentaire" => "Un régal du début à la fin !",
                "datecommentaire" => "2024-02-02"
            )
        ]
    );
}
