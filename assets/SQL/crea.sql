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
    codeDepartement INT PRIMARY KEY,
    nomDepartement VARCHAR(32) NOT NULL,

    FOREIGN KEY (codeRegion) REFERENCES REGION (codeRegion)
);

CREATE TABLE COMMUNE(
    codeDepartement INT,
    codeCommune INT PRIMARY KEY,
    nomCommune VARCHAR(32) NOT NULL,

    FOREIGN KEY (codeDepartement) REFERENCES DEPARTEMENT (codeDepartement)
);

CREATE TABLE RESTAURANT(
    osmID VARCHAR(40) PRIMARY KEY,
    nomRestaurant VARCHAR(100),
    telephone VARCHAR(32),
    siret VARCHAR(40) UNIQUE,
    etoiles SMALLINT CHECK (etoiles >= 0 AND etoiles <=5),
    siteInternet VARCHAR(100),

    codeCommune INT,

    FOREIGN KEY (codeCommune) REFERENCES COMMUNE (codeCommune)
);

CREATE TABLE HEURE_OUVERTURE(
    osmID VARCHAR(32),
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

CREATE TABLE SERVICE(
    idService INT PRIMARY KEY,
    nomService VARCHAR(32)
);

CREATE TABLE SERVICE_PROPOSE(
    idService INT,
    osmID VARCHAR(32),

    PRIMARY KEY(idService, osmID),
    FOREIGN KEY(idService) REFERENCES SERVICE(idService),
    FOREIGN KEY(osmID) REFERENCES RESTAURANT(osmID)
);