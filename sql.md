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
