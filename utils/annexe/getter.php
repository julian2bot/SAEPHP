<?php


function getRecommendation(PDO $bdd):array{
    return array(
        [
            "nomRestaurant"=>"Nom",
            "etoiles"=>3,
            "codeCommune"=>"45000",
            "nomCommune"=>"orleans",
            "type"=>["jap", "french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>5,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "type"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>1,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "type"=>["french"]
        ]);
}

function getLesRestaurants(PDO $bdd):array{


    return array(
        [
            "nomRestaurant"=>"Nom",
            "etoiles"=>3,
            "codeCommune"=>"45000",
            "nomCommune"=>"orleans",
            "type"=>["jap", "french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>5,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "type"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>1,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "type"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>2,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "type"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>3,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "type"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>4,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "type"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>5,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "type"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>6,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "type"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "etoiles"=>0,
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "type"=>["french"]
        ],
        [
            "nomRestaurant"=>"Nom1",
            "codeCommune"=>"45480",
            "nomCommune"=>"leans",
            "type"=>["french"]
        ]
        );
}