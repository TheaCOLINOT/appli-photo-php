# Framework CSS & SASS

Cette application utilise un framework CSS/JS personnalisé reposant sur une bibliothèque de composants.

## Caractéristiques principales

- **Composants réutilisables :** Les classes telles que `.button`, `.modal`, `.card`, etc., sont prévues pour l’affichage sur le front-end et le back-office.
- **Méthodologie BEM :** La structure des classes respecte la convention BEM pour une meilleure maintenabilité.
- **Mobile First et Dark Mode :** Les composants sont conçus pour être responsives et supportent un mode sombre activable via la classe `.dark` ou des media queries.
- **Personnalisation :** L'administrateur peut choisir parmi plusieurs thèmes graphiques pour l'affichage.

## Bonnes pratiques

- **Unités relatives et variables CSS :** Pour assurer une mise en page flexible et un thème cohérent.
- **Organisation en layers :** Séparation des styles de base, des modules et des composants spécifiques.

Pour appliquer vos modifications au CSS, utilisez SASS. Une fois vos modifications effectuées, compilez le CSS avec :
```bash
npm run build
