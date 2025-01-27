CREATE TABLE UTILISATEUR(
    username VARCHAR(32) PRIMARY KEY,
    mdp VARCHAR(100) NOT NULL,
    estAdmin BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE REGION(
    codeRegion INT PRIMARY KEY,
    nomRegion VARCHAR(32) NOT NULL
);

CREATE TABLE DEPARTEMENT(
    codeRegion INT,
    codeDepartement INT,
    nomDepartement VARCHAR(32) NOT NULL,

    PRIMARY KEY (codeRegion,codeDepartement),
    FOREIGN KEY (codeRegion) REFERENCES REGION (codeRegion)
);

CREATE TABLE COMMUNE(
    codeRegion INT,
    codeDepartement INT,
    codeCommune INT,
    nomCommune VARCHAR(32) NOT NULL,

    PRIMARY KEY (codeRegion,codeDepartement, codeCommune),
    FOREIGN KEY (codeRegion,codeDepartement) REFERENCES DEPARTEMENT (codeRegion,codeDepartement)
);

CREATE TABLE RESTAURANT(
    osmID INT PRIMARY KEY,
    nomRestaurant VARCHAR(32),
    telephone VARCHAR(32),
    siret VARCHAR(32),
    etoiles SMALLINT CHECK (etoiles >= 0 AND etoiles <=5),
    siteInternet VARCHAR(100),

    codeRegion INT,
    codeDepartement INT,
    codeCommune INT,

    FOREIGN KEY (codeRegion,codeDepartement, codeCommune) REFERENCES COMMUNE (codeRegion,codeDepartement, codeCommune)
);

CREATE TABLE HEURE_OUVERTURE(
    osmID INT,
    jourOuverture VARCHAR(10),
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
    osmID INT,
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
    osmID INT,
    note SMALLINT CHECK (note <= 0 AND note >= 5),
    commentaire VARCHAR(255),

    PRIMARY KEY (username, osmID),
    FOREIGN KEY (username) REFERENCES UTILISATEUR(username),
    FOREIGN KEY (osmID) REFERENCES RESTAURANT(osmID)
);

CREATE TABLE RESTAURANT_FAVORIS(
    username VARCHAR(32),
    osmID INT,

    PRIMARY KEY (username, osmID),
    FOREIGN KEY (username) REFERENCES UTILISATEUR(username),
    FOREIGN KEY (osmID) REFERENCES RESTAURANT(osmID)
);