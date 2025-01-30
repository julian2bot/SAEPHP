CREATE TABLE UTILISATEUR(
    username VARCHAR(32) PRIMARY KEY,
    mdp VARCHAR(100) NOT NULL,
    estAdmin BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE REGION(
    codeRegion VARCHAR(5) PRIMARY KEY,
    nomRegion VARCHAR(32) NOT NULL
);

CREATE TABLE DEPARTEMENT(
    codeRegion VARCHAR(5),
    codeDepartement VARCHAR(5) PRIMARY KEY,
    nomDepartement VARCHAR(32) NOT NULL,

    FOREIGN KEY (codeRegion) REFERENCES REGION (codeRegion)
);

CREATE TABLE COMMUNE(
    codeDepartement VARCHAR(5),
    codeCommune VARCHAR(5) PRIMARY KEY,
    nomCommune VARCHAR(32) NOT NULL,

    FOREIGN KEY (codeDepartement) REFERENCES DEPARTEMENT (codeDepartement)
);

CREATE TABLE RESTAURANT(
    osmID VARCHAR(40) PRIMARY KEY,
    nomRestaurant VARCHAR(100),
    telephone VARCHAR(32),
    siret VARCHAR(40),
    etoiles SMALLINT CHECK (etoiles >= 0 AND etoiles <=5),
    siteInternet VARCHAR(100),

    codeCommune VARCHAR(5),
    
    vegetarien VARCHAR(32),
    vegan VARCHAR(32),
    livraison VARCHAR(32),
    aEmporter VARCHAR(32),
    drive VARCHAR(32),
    accessInternet VARCHAR(32),

    capacite INT,

    marque VARCHAR(32),
    operateur VARCHAR(32),
    type VARCHAR(32),
    wikidata VARCHAR(32),
    marqueWikidata VARCHAR(32),

    espaceFumeur VARCHAR(32),
    fauteuilRoulant VARCHAR(32),
    facebook VARCHAR(100),

    longitude VARCHAR(32),
    latitude VARCHAR(32),

    FOREIGN KEY (codeCommune) REFERENCES COMMUNE (codeCommune)
);

CREATE TABLE HEURE_OUVERTURE(
    osmID VARCHAR(32),
    jourOuverture VARCHAR(3) CHECK (jourOuverture in ('Mo','Tu','We','Th','Fr','Sa','Su', 'PH')),
    heureDebut TIME,
    heureFin TIME,

    PRIMARY KEY (osmID, jourOuverture, heureDebut),
    FOREIGN KEY (osmID) REFERENCES RESTAURANT(osmID)
);

CREATE TABLE CUISINE(
    idCuisine INT PRIMARY KEY,
    nomCuisine VARCHAR(32)
);

CREATE TABLE PROPOSE(
    osmID VARCHAR(32),
    idCuisine INT,

    PRIMARY KEY (osmID, idCuisine),
    FOREIGN KEY (osmID) REFERENCES RESTAURANT(osmID),
    FOREIGN KEY (idCuisine) REFERENCES CUISINE(idCuisine)
);

CREATE TABLE CUISINE_FAVORITES(
    username VARCHAR(32),
    idCuisine INT,

    PRIMARY KEY (username, idCuisine),
    FOREIGN KEY (username) REFERENCES UTILISATEUR(username),
    FOREIGN KEY (idCuisine) REFERENCES CUISINE(idCuisine)
);

CREATE TABLE AVIS(
    username VARCHAR(32),
    osmID VARCHAR(32),
    note SMALLINT CHECK (note <= 0 AND note >= 5),
    commentaire VARCHAR(255),

    PRIMARY KEY (username, osmID),
    FOREIGN KEY (username) REFERENCES UTILISATEUR(username),
    FOREIGN KEY (osmID) REFERENCES RESTAURANT(osmID)
);

CREATE TABLE RESTAURANT_FAVORIS(
    username VARCHAR(32),
    osmID VARCHAR(32),

    PRIMARY KEY (username, osmID),
    FOREIGN KEY (username) REFERENCES UTILISATEUR(username),
    FOREIGN KEY (osmID) REFERENCES RESTAURANT(osmID)
);