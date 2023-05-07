#!/usr/bin/env python3
import sqlite3
import base64
import os

db = '../bdd.db'
os.system(f"cp {db} {db}.bak")
print(f"Copie enregistrée sous le nom {db}.bak")

con = sqlite3.connect(db)
cur = con.cursor()

nom = input("nom de l'article:")
qte = input("quantité:")
prix = input("prix:")

description = input("description:")
description = description.replace("'", "''")

cat = input("idCat:")
img = input("image:")
with open(img, "rb") as f:
    b64img = base64.b64encode(f.read())
    b64img = b64img.decode("utf-8")

req = f"INSERT INTO Articles (nom, quantite, prix, description, idCat, b64img) VALUES ('{nom}', {qte}, {prix}, '{description}', {cat}, '{b64img}');"
cur.execute(req)
con.commit()

con.close()
