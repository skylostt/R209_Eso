# Liste de requêtes SQL à faire

# Connexion

```sql
SELECT *
    FROM Utilisateurs 
    WHERE username = $pseudo AND password = $mpd;
```

# Inscription

```sql
INSERT INTO Utilisateurs (username, mail, password)
VALUES ($pseudo, $email, $mdp)
```

# Modification de mot de passe

```sql
UPDATE Utilisateurs 
    SET password=$password 
    WHERE username=$pseudo AND password=$old_password;
```

# Recherche

```sql
SELECT idProd
    FROM Articles
    WHERE (nom LIKE '%$query%' OR description LIKE '%$query%') AND idCat=$cat;
```

# Ajout au panier

```sql
INSERT INTO Paniers (idPanier, idProd, idUser, qte)
VALUES ($panier, $id_prod, $id_user, $qte)
```
