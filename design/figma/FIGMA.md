# Figma (match du site actuel)

Ce dépôt utilise principalement Bootstrap 5 + des styles custom pour la page d’accueil (`public/assets/styles/accueil/*.css`).
Je ne peux pas générer un lien Figma à ta place, mais je peux te donner une maquette Figma “prête à recréer” + des design tokens importables.

## 1) Import rapide des tokens (recommandé)

1. Dans Figma, installe le plugin **Tokens Studio for Figma**.
2. Dans Tokens Studio → **Import** → choisis le fichier `design/tokens/btp-consulting.tokens.json`.
3. Applique le set `core` et publie les styles/variables si besoin.

Ces tokens sont dérivés des variables CSS et des couleurs visibles :
- `public/assets/styles/accueil/accueil.css` (palette principale)
- `public/assets/styles/accueil/product.css` (cards/boutons produits)
- `templates/header.html.twig` + `templates/footer.html.twig` (navbar/footer Bootstrap `bg-dark`)

## 2) Structure du fichier Figma

Crée 3 pages :
- **00 · Foundations** : couleurs, typo, espacements, ombres, radius.
- **01 · Components** : composants réutilisables (boutons, cards, navbar, footer, inputs).
- **02 · Screens** : écrans (Accueil, Inscription, Connexion, Admin/CRUD).

Frames (breakpoints cohérents avec tes CSS/Bootstrap) :
- Desktop : `1440 × 1024`
- Tablet : `768 × 1024`
- Mobile : `375 × 812`

Grille Desktop (Bootstrap-like) :
- 12 colonnes
- marge extérieure ~`80`
- gutter `24`

## 3) Composants à créer (ceux qui font “l’identité” du site)

### Navbar (header)
Source : `templates/header.html.twig`
- Fond : `neutral.800` (#212529) (équivalent Bootstrap `bg-dark`)
- Logo : image `public/images/logo.jpg` (50px de large dans le code)
- Liens : blanc, hover légèrement plus clair
- CTA : bouton “Connexion” style warning (tu peux map sur `brand.accent` si tu veux harmoniser)

### Hero (Accueil)
Sources : `public/assets/styles/accueil/heroAccueil.css` + `public/assets/styles/accueil/accueil.css`
- Fond : gradient `neutral.900 → brand.secondary`
- Titre : H1 très grand (≈ 56px), mot accentué en `brand.accent`
- Boutons :
  - Primary : fond `brand.primary`, radius `pill`
  - Secondary : outline blanc
- Image : à droite, avec drop-shadow

### Product card (Accueil)
Source : `public/assets/styles/accueil/product.css`
- Card : fond blanc, radius `lg` (20), shadow `sm`
- Header image : 280px de haut
- Badge “Stock limité” : fond `brand.primary`, radius `pill`
- Boutons :
  - “Voir les détails” : fond `brand.secondary`, radius `md` (12)
  - “Ajouter au panier” : fond `brand.accent`, texte `neutral.900`

### Stats tiles
Source : `public/assets/styles/accueil/accueil.css`
- 4 tuiles en grid, fond blanc, shadow `md`
- Valeur (stats) : très large, couleur `brand.primary`

### Service card
Source : `public/assets/styles/accueil/accueil.css`
- Card “glass” sur section sombre : fond blanc à ~10–15% d’opacité + blur
- Icone blanche + titre blanc + texte blanc 80%

### Footer
Source : `templates/footer.html.twig`
- Fond `neutral.800` (bg-dark), texte blanc
- Colonnes : identité / infos / réseaux

### Formulaires (Inscription / Connexion / CRUD)
Sources : `templates/home/inscription.html.twig`, `templates/security/login.html.twig`, `templates/category_metier/edit.html.twig`
- Inputs : hauteur ~44px, radius `xs` ou `sm`
- Panel login : 380px max, shadow légère
- CRUD simple : “card” centre, radius 12

## 4) Checklist “match visuel”

- Les 3 couleurs brand (primary/secondary/accent) sont des styles globaux
- Boutons pill (CTA) + cards 20px (produits/services) respectés
- Header/footer en `bg-dark` Bootstrap
- Typo : Inter (proche du rendu “sans-serif” actuel)

