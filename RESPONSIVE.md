# Système Responsive - Block Carousel

Le plugin Block Carousel intègre désormais un système responsive complet qui adapte automatiquement le nombre de colonnes visibles selon la taille de l'écran.

## Breakpoints WordPress Standards

Le système utilise les breakpoints standards de WordPress et du web :

| Breakpoint | Taille d'écran | Colonnes max | Description |
|------------|---------------|--------------|-------------|
| **Desktop Large** | > 1280px | 6 colonnes | Écrans larges, comportement par défaut |
| **Desktop Standard** | < 1280px | 5 colonnes | Écrans standards |
| **Tablette Paysage** | < 1024px | 4 colonnes | iPad paysage, petits laptops |
| **Tablette Portrait** | < 782px | 3 colonnes | iPad portrait, breakpoint WordPress admin |
| **Mobile Paysage** | < 600px | 2 colonnes | Smartphones paysage, breakpoint WordPress mobile |
| **Mobile Portrait** | < 480px | 1 colonne | Smartphones portrait |
| **Mobile Très Petit** | < 375px | 1 colonne | iPhone SE, petits smartphones |

## Fonctionnement Automatique

### Grilles (Grid Layout)

Pour les blocs avec layout Grid (Group ou Post Template), le système adapte automatiquement le nombre de colonnes :

- **6 colonnes** sur desktop → **5** (1280px) → **4** (1024px) → **3** (782px) → **2** (600px) → **1** (480px)
- **5 colonnes** sur desktop → **5** (1280px) → **4** (1024px) → **3** (782px) → **2** (600px) → **1** (480px)
- **4 colonnes** sur desktop → **4** (1024px) → **3** (782px) → **2** (600px) → **1** (480px)
- **3 colonnes** sur desktop → **3** (782px) → **2** (600px) → **1** (480px)
- **2 colonnes** sur desktop → **2** (600px) → **1** (480px)

### Carousels Standards (Flexbox)

Pour les blocs sans Grid (Group simple, Post Template flexbox) :

- **Desktop/Tablette (> 782px)** : Items à leur largeur naturelle (100% par défaut)
- **Tablette (< 782px)** : 60% de largeur (environ 1.5-2 items visibles)
- **Mobile (< 600px)** : 85-100% de largeur (1 item visible)
- **Mobile Portrait (< 480px)** : 100% de largeur (1 item complet)

### Galeries (Gallery Block)

Les galeries s'adaptent en fonction du ratio des images :

- **Tablette (< 782px)** : min-width 45% (2-3 images visibles)
- **Mobile (< 600px)** : min-width 70% (1-2 images visibles)
- **Mobile Portrait (< 480px)** : 100% de largeur

### Carousels avec Largeur Minimale

Pour les grilles avec `minimumColumnWidth` (classe `bc-carousel-min-width`) :

- **Tablette (< 782px)** : `min(var(--carousel-min-width), 45%)` → max 2-3 colonnes
- **Mobile (< 600px)** : `min(var(--carousel-min-width), 50%)` → max 2 colonnes
- **Mobile Portrait (< 480px)** : 100% → forcer 1 colonne

## Adaptations UI

Le système ajuste également les éléments d'interface :

### Tailles des Boutons

| Breakpoint | Taille des boutons |
|------------|-------------------|
| Desktop | 3rem (48px) |
| Tablette (< 782px) | 2.75rem (44px) |
| Mobile (< 600px) | 2.5rem (40px) |
| Mobile Portrait (< 480px) | 2rem (32px) |
| Très Petit (< 375px) | 1.75rem (28px) |

### Marqueurs (Dots)

| Breakpoint | Taille des marqueurs |
|------------|---------------------|
| Desktop | 0.66rem |
| Tablette (< 782px) | 0.5rem |
| Mobile (< 600px) | 0.45rem |
| Mobile Portrait (< 480px) | 0.4rem |
| Très Petit (< 375px) | 0.35rem |

### Espacements (Gap)

Les espaces entre les items sont également réduits progressivement :

- **Desktop** : `var(--wp--style--block-gap, 1rem)`
- **Tablette (< 782px)** : `var(--wp--style--block-gap, 0.75rem)`
- **Mobile (< 600px)** : `var(--wp--style--block-gap, 0.5rem)`
- **Mobile Portrait (< 480px)** : `var(--wp--style--block-gap, 0.25rem)`

## Utilisation

Le système est **entièrement automatique**. Vous n'avez rien à configurer :

1. **Activez le carousel** sur votre bloc (Group, Gallery, Post Template)
2. **Définissez le nombre de colonnes** (pour les grilles) dans les paramètres WordPress standard
3. **Le système responsive s'occupe du reste** automatiquement

### Exemple avec un Bloc Grid

```
Bloc Group → Layout Grid → 4 colonnes
↓ Activer le carousel
↓ Le système adapte automatiquement :
  - Desktop (> 1024px) : 4 colonnes
  - Tablette (< 782px) : 3 colonnes
  - Mobile (< 600px) : 2 colonnes
  - Mobile Portrait (< 480px) : 1 colonne
```

## Personnalisation CSS

Vous pouvez surcharger le comportement avec du CSS personnalisé si nécessaire :

```css
/* Forcer 3 colonnes max sur tablette pour un carousel spécifique */
@media (max-width: 782px) {
  .mon-carousel-custom.bc-carousel.bc-carousel-cols-4 > * {
    --carousel-grid-item-width: calc(33.333% - var(--wp--style--block-gap, 1rem) * 2 / 3);
  }
}

/* Garder 2 colonnes sur mobile pour un carousel spécifique */
@media (max-width: 480px) {
  .mon-carousel-custom.bc-carousel > * {
    min-width: 50% !important;
    width: 50% !important;
  }
}
```

## Accessibilité

Le système responsive respecte les préférences utilisateur :

- **`prefers-reduced-motion`** : Désactive les animations smooth scroll
- **`prefers-color-scheme: dark`** : Adapte les couleurs de l'interface
- **`prefers-contrast: high`** : Augmente le contraste des boutons et marqueurs

## Compatibilité

- ✅ WordPress 6.0+
- ✅ Tous les navigateurs modernes
- ✅ Tous les thèmes WordPress (Block themes et thèmes classiques)
- ✅ Compatible avec l'éditeur Gutenberg
- ✅ Compatible avec les modes Preview responsive de l'éditeur

## Performance

Le système utilise uniquement du **CSS pur** avec :

- Variables CSS natives (`--carousel-*`)
- Media queries standards
- Aucun JavaScript pour le responsive
- GPU acceleration (`transform: translateZ(0)`)
- Optimisation du rendu (`will-change`, `contain`)

## Notes Importantes

1. **Les largeurs sont relatives** : Le système utilise des pourcentages pour s'adapter à tous les conteneurs
2. **Le gap est respecté** : Les calculs de largeur prennent en compte le `blockGap` WordPress
3. **Scroll snap** : Le snap center est maintenu sur tous les breakpoints
4. **Touch-friendly** : Les tailles de boutons respectent les recommandations d'accessibilité (44px minimum sur mobile)

## Support

Pour toute question ou problème :
- [GitHub Issues](https://github.com/WEBLAZER/block-carousel/issues)
- [Documentation](https://github.com/WEBLAZER/block-carousel)

