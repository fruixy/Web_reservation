# Projet de Réservation en Ligne - Cabinet Médical

## Description

Ce projet est un système de réservation en ligne destiné à un **cabinet médical**. Il permet aux patients de créer un compte, prendre des rendez-vous, consulter leurs réservations et annuler un rendez-vous si nécessaire.

## Fonctionnalités

### 🔹 Gestion des Utilisateurs

- **Inscription** avec email unique et vérification.
- **Connexion** sécurisée.
- **Modification du profil** (nom, prénom, email, téléphone, adresse, date de naissance).
- **Suppression du compte** avec suppression de toutes les données associées.

### 📅 Gestion des Rendez-vous

- **Prise de rendez-vous** via un formulaire simple.
- **Créneaux horaires adaptés aux horaires d'un cabinet médical**.
- **Liste des rendez-vous de l'utilisateur** avec possibilité d'annuler une réservation.
- **Gestion des créneaux pour éviter les doublons.**

### 🔒 Sécurité

- **Protection contre les attaques CSRF et injections SQL.**
- **Hachage des mots de passe avec `password_hash()`.**
- **Sécurisation des accès utilisateur avec session.**

## Technologies Utilisées

- **Frontend** : Bootstrap 5, HTML, CSS, JavaScript
- **Backend** : PHP (procédural)
- **Base de données** : MySQL

## Installation & Configuration

1. **Cloner le projet**
   git clone https://github.com/fruixy/Web_reservation

 
