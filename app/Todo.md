# Application Symfony Clone de Airbnb - MVP

Pour ce projet, j'ai sélectionné les fonctionnalités essentielles, communément présentes dans une application similaire à Airbnb.

## **FEATURE 1: Authentification et Gestion du compte utilisateur**

### **Story 1: Inscription**

En tant qu'utilisateur,
Je veux pouvoir créer un compte,
Afin d'accéder aux services de l'application.

- *RequestModel*: Paramètres de l'utilisateur (nom, email, mot de passe, etc.)
- *ReponseModel*: Identifiant du nouvel utilisateur
- *Presenter*: Interface de sortie d'inscription
- *ViewModel*: Affichage des informations du nouvel utilisateur
- *Interactor*: Interface d'entrée d'inscription

### **Story 2: Connexion**

En tant qu'utilisateur,
Je veux pouvoir me connecter à mon compte,
Afin de pouvoir accéder à mes informations et aux services.

- *RequestModel*:  Information de login de l'utilisateur (email, mot de passe)
- *ReponseModel*: Autorisation ou échec de la connexion
- *Presenter*: Interface de sortie de connexion
- *ViewModel*: Message d'autorisation ou d'échec
- *Interactor*: Interface d'entrée de connexion

## **FEATURE 2: Gestion des annonces**

### **Story 3: Création de l'annonce**

En tant qu'hôte,
Je veux pouvoir créer une annonce de location,
Afin de proposer mon logement aux autres utilisateurs.

- *RequestModel*:  Propriétés de l'annonce (titre, description, prix, localisation, images...)
- *ReponseModel*: Identifiant de l'annonce créée
- *Presenter*: Interface de sortie de création d'annonce
- *ViewModel*: Détails de l'annonce créée
- *Interactor*: Interface d'entrée de création d'annonce

### **Story 4: Visualisation de l'annonce**

En tant qu'utilisateur,
Je veux pouvoir visualiser les détails de l'annonce,
Afin d'évaluer si l'offre correspond à mes besoins.

- *RequestModel*: Identifiant de l'annonce à visualiser
- *ReponseModel*: Détails de l'annonce
- *Presenter*: Interface de sortie de visualisation d'annonce
- *ViewModel*: Affichage des détails de l'annonce
- *Interactor*: Interface d'entrée de visualisation d'annonce

## **FEATURE 3: Gestion des réservations**

### **Story 5: Réserver un logement**

En tant qu'utilisateur,
Je veux pouvoir réserver un logement,
Afin de sécuriser ma location pour une période donnée.

- *RequestModel*: Détails de la réservation (Identifiant de l'utilisateur, identifiant de l'annonce, dates de début et de fin)
- *ReponseModel*: Confirmation de la réservation
- *Presenter*: Interface de sortie de réservation
- *ViewModel*: Affichage de la confirmation de la réservation ou du message d'échec
- *Interactor*: Interface d'entrée de réservation

Dans un contexte DDD, chacun de ces fonctionnalités repose sur un modèle de domaine différent (Authentification, Annonces, Réservations) et chaque interactor représente une interaction spécifique dans ce domaine. Ces interacteurs peuvent communiquer entre eux via ACL pour garantir que les changements dans un modèle de domaine n'affectent pas les autres.