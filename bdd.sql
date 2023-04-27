BEGIN TRANSACTION;

PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS Utilisateurs;

CREATE TABLE Utilisateurs (
    idUser INTEGER PRIMARY KEY,
    username TEXT NOT NULL,
    mail TEXT NOT NULL,
    password TEXT NOT NULL
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
    idCat INTEGER NOT NULL,
    FOREIGN KEY (idCat) REFERENCES Categories (idCat)
);

DROP TABLE IF EXISTS Paniers;

CREATE TABLE Paniers (
    idPanier INTEGER NOT NULL,
    idProd INTEGER NOT NULL,
    idUser INTEGER NOT NULL,
    quantite INTEGER NOT NULL,
    FOREIGN KEY (idUser) REFERENCES Utilisateurs (idUser),
    FOREIGN KEY (idProd) REFERENCES Articles (idProd)
);

DROP TABLE IF EXISTS Commandes;

CREATE TABLE Commandes (
    idCom INTEGER NOT NULL PRIMARY KEY,
    idPanier INTEGER NOT NULL,
    idUser INTEGER NOT NULL,
    adresse TEXT NOT NULL,
    FOREIGN KEY (idPanier) REFERENCES Paniers (idPanier),
    FOREIGN KEY (idUser) REFERENCES Utilisateurs (idUser)
);

DROP TABLE IF EXISTS Commentaires;

CREATE TABLE Commentaires (
    idCom INTEGER NOT NULL PRIMARY KEY,
    idUser INTEGER NOT NULL,
    eval INTEGER NOT NULL,
    texte TEXT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES Utilisateurs (idUser)
);


