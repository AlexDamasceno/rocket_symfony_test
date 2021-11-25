# Versions: 
```yaml
    Php : 7.4.26
    Symfony : 5.3.11
    Composer : 2.1.12
``` 
# Installation : 

```bash
composer install
```
```bash
php bin/console doctrine:database:create
```
```bash
php bin/console make:migration
```
```bash
php bin/console doctrine:migrations:migrate
```
```bash
symfony server:start 
```
# Commande : 
```bash
php bin/console app:status-website
```
# Utilisation : 

- Créer un utilisateur 
- Ajouter, Modifier, Supprimer des liens de site
- Afficher la disponibilité du site sous forme de graphique 
