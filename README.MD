# Atelier PROGRAMMATION WEB
Pour SMI-S6

## Version hébergée

https://atelierweb.mergrweb.me/

Hébergée sur un VPS Oracle Cloud Standard.E2.1.Micro, avec un proxy NGINX et serveur MySQL sur Docker.

//Peut être protégé par un portail Authelia.
### ⚠️ *ACTUELLEMENT HORS-LIGNE, SVP PUBLIEZ UN PROBLEME (ISSUE) POUR QUE JE LE METTRE EN-LIGNE*

## Installation

### 1. Clonez ou téléchargez le répositoire
Clonez ce répositoire dans votre local :
```bash
git clone https://github.com/MerGr/Atelier-PROG_WB.git
```

### 2. Configurez le fichier .env avec votre installation MySQL existante

Le fichier .env contient :

| Variable Environmentale | Description                                         |
| ----------------------- |-----------------------------------------------------|
| HOST                    | Addresse IP ou nom d'hôte de votre serveur MYSQL    |
| DBNAME                  | Nom du DB, par défault ```GesNotes```               |
| USERNAME                | Nom d'utilisateur MySQL, par défault ```root```     |
| PASSWORD                | Mot du passe d'utilisateur MySQL, par défaut ``` ```|

### 3. Importer la base de données à votre serveur MySQL

La base de données est situé sur ```GesNotes.sql```

## Utilisation

Les identifiants par défaut sont :

| Champ         | Valeur      |
| ------------- |-------------|
| Utilisateur   | ```admin``` |
| Mot de passe  | ```123456```|
