# Tuto pour créer le projet et pouvoir travailler dessus

## 1) Commande pour créer le projet :
```
symfony new Yabonlapub --version="7.0.*" --webapp
```

## 2) Une fois cette commande terminée, se placer dans le dossier créé pour le projet et faire :
```
git remote add origin https://github.com/Erwan888/site-yabonlapub.git
```

## 3) Puis :
```
git rm --cached bin -r
git rm --cached composer.json
git rm --cached composer.lock
git rm --cached compose.override.yaml
git rm --cached compose.yaml
git rm --cached config/ -r
git add config/packages/security.yaml
git rm --cached symfony.lock
git rm --cached phpunit.xml.dist
git rm --cached importmap.php
git rm --cached migrations/ -r
```

## 4) Maintenant, vous devez déplacer la liste des fichiers supprimer du git hors du projet pour pouvoir y avoir accès après avoir changé de branche.
Déplacez-les donc dans un dossier sur votre bureau par exemple.

Faites un commit pour sauvegarder vos modifications :
```
git commit -a -m "commit pre-switch"
```

# IMPORTANT : si votre projet se trouve sur la branche master, suivre à l'étape 4. Sinon, demander assistance.

## 5) Vous pouvez maintenant vous placer sur la branche principale du projet (main) :
```
git checkout main
```

## 6) Vous pouvez récupérer vos dossiers précédemment déplacés et les remettre dans le projet. Normalement, le fichier security.yaml est sensé être doublé, ignorer celui que vous rajouter (garder celui que vous avez récupéré du projet Git).

## 7) Vous pourrez ensuite faire votre pull :
```
git pull
```
