# site-yabonlapub

## Commande pour créer le projet :
```symfony new Yabonlapub --version="7.0.*" --webapp```

## Une fois cette commande terminée, se placer dans le dossier créé pour le projet et faire :
```git remote add origin https://github.com/Erwan888/site-yabonlapub.git \n
git checkout main```

## Puis :
```git rm --cached bin -r
git rm --cached composer.json
git rm --cached composer.lock
git rm --cached compose.override.yaml
git rm --cached compose.yaml
git rm --cached config/ -r
git add config/packages/security.yaml
git rm --cached symfony.lock
git rm --cached phpunit.xml.dist
git rm --cached importmap.php
git rm --cached migrations/ -r```

## Vous pourrez ensuite faire votre pull :
```git pull```
