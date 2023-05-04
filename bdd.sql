BEGIN TRANSACTION;

PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS Utilisateurs;

CREATE TABLE Utilisateurs (
    idUser INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    mail TEXT NOT NULL,
    password TEXT NOT NULL
);

DROP TABLE IF EXISTS Categories;

CREATE TABLE Categories (
    idCat INTEGER PRIMARY KEY AUTOINCREMENT,
    titre TEXT NOT NULL,
    b64img TEXT NOT NULL
);

DROP TABLE IF EXISTS Articles;

CREATE TABLE Articles (
    idProd INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    quantite INTEGER NOT NULL,
    prix REAL NOT NULL,
    description TEXT NOT NULL,
    b64img TEXT,
    idCat INTEGER NOT NULL,
    FOREIGN KEY (idCat) REFERENCES Categories (idCat)
);

DROP TABLE IF EXISTS Paniers;

CREATE TABLE Paniers (
    idPanier INTEGER PRIMARY KEY AUTOINCREMENT,
    idProd INTEGER NOT NULL,
    idUser INTEGER NOT NULL,
    quantite INTEGER NOT NULL,
    FOREIGN KEY (idUser) REFERENCES Utilisateurs (idUser),
    FOREIGN KEY (idProd) REFERENCES Articles (idProd)
);

DROP TABLE IF EXISTS Commandes;

CREATE TABLE Commandes (
    idCom INTEGER PRIMARY KEY AUTOINCREMENT,
    idPanier INTEGER NOT NULL,
    idUser INTEGER NOT NULL,
    adresse TEXT NOT NULL,
    FOREIGN KEY (idPanier) REFERENCES Paniers (idPanier),
    FOREIGN KEY (idUser) REFERENCES Utilisateurs (idUser)
);

DROP TABLE IF EXISTS Commentaires;

CREATE TABLE Commentaires (
    idCom INTEGER PRIMARY KEY AUTOINCREMENT,
    idUser INTEGER NOT NULL,
    eval INTEGER NOT NULL,
    texte TEXT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES Utilisateurs (idUser)
);

COMMIT;
