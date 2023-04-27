BEGIN TRANSACTION;

PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS Utilisateurs;

CREATE TABLE Utilisateurs (
    idUser INTEGER PRIMARY KEY,
    username TEXT NOT NULL,
    mail TEXT NOT NULL,
    password TEXT NOT NULL,
);

DROP TABLE IF EXISTS Categories;

CREATE TABLE Categories (
    idCat INTEGER PRIMARY KEY,
    titre TEXT NOT NULL
);

DROP TABLE IF EXISTS Articles;

CREATE TABLE Articles (
    idProd INTEGER PRIMARY KEY,
    nom TEXT NOT NULL,
    quantite INTEGER NOT NULL,
    prix INTEGER NOT NULL,
    description TEXT NOT NULL,
    FOREIGN KEY (idCat) REFERENCES Categorie (idCat)
);

DROP TABLE IF EXISTS Paniers;

CREATE TABLE Paniers (
    idPanier INTEGER NOT NULL,
    FOREIGN KEY (idProd) REFERENCES Articles (idProd),
    FOREIGN KEY (idUser) REFERENCES Utilisateurs (idUser),
    quantite INTEGER NOT NULL
);

DROP TABLE IF EXISTS Commandes;

CREATE TABLE Commandes (
    idCom INTEGER NOT NULL PRIMARY KEY,
    FOREIGN KEY (idPanier) REFERENCES Paniers (idPanier),
    FOREIGN KEY (idUser) REFERENCES Utilisateurs (idUser),
    adresse TEXT NOT NULL
);

DROP TABLE IF EXISTS Commentaires;

CREATE TABLE Commentaires (
    idCom INTEGER NOT NULL PRIMARY KEY,
    FOREIGN KEY (idUser) REFERENCES Utilisateurs (idUser),
    eval INTEGER NOT NULL,
    texte TEXT NOT NULL
);


