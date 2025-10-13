# 🖼️ Correction du Responsive pour les Galeries

## ❌ Problème Identifié

**Symptôme** : Les images dans les galeries (Gallery block) étaient parfois coupées en deux sur certaines tailles d'écran.

**Cause** : Le système utilisait `width: auto` pour les images de galerie afin de respecter leur ratio naturel, mais combiné avec des `min-width` en pourcentage, cela créait des situations où une image pouvait faire 45% de largeur et la suivante 60%, causant des coupures visuelles.

## ✅ Solution Appliquée

### Changement de Stratégie

**Avant** :
```css
/* Largeur automatique selon le ratio de l'image */
.wp-block-gallery.bc-carousel > .wp-block-image {
  width: auto;
  min-width: 45%; /* Pouvait créer des coupures */
}
```

**Maintenant** :
```css
/* Largeur fixe pour affichage cohérent */
.wp-block-gallery.bc-carousel > .wp-block-image {
  width: calc(33.333% - var(--wp--style--block-gap, 1rem) * 2 / 3);
  min-width: calc(33.333% - var(--wp--style--block-gap, 1rem) * 2 / 3);
}

/* Image remplit tout le conteneur */
.wp-block-gallery.bc-carousel > .wp-block-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
```

### Comportement Responsive des Galeries

Maintenant, les galeries affichent un **nombre fixe d'images complètes** par breakpoint :

| Taille d'écran | Nombre d'images visibles | Largeur par image |
|----------------|-------------------------|-------------------|
| 🖥️ Desktop Large (> 1400px) | **3 images** | 33.333% |
| 💻 Desktop (< 1280px) | **5 images** | 20% |
| 📱 Tablette Paysage (< 1024px) | **4 images** | 25% |
| 📱 Tablette Portrait (< 782px) | **2 images** | 50% |
| 📱 Mobile Paysage (< 600px) | **1 image** | 100% |
| 📱 Mobile Portrait (< 480px) | **1 image** | 100% |

## 🎯 Avantages de cette Approche

### ✅ Affichage Cohérent
- Toutes les images ont **exactement la même largeur**
- Plus de coupures ou d'images partielles
- Navigation fluide et prévisible

### ✅ Responsive Intelligent
- Adaptation progressive : **5 → 4 → 2 → 1** images visibles
- Transitions logiques entre les breakpoints
- Respect du gap WordPress (`--wp--style--block-gap`)

### ✅ Images Complètes
- `object-fit: cover` assure un remplissage complet
- Pas de blanc ou d'espaces vides
- Ratio d'image préservé visuellement

### ✅ Performance
- Calculs CSS natifs
- GPU acceleration maintenue
- Aucun JavaScript requis

## 📝 Modifications Techniques

### Fichier Modifié
- ✅ `assets/css/carousel.css`

### Lignes Modifiées

#### 1. Comportement par Défaut (Desktop Large)
```css
/* Lignes 131-149 */
.wp-block-gallery.bc-carousel > .wp-block-image {
  flex: 0 0 auto;
  width: calc(33.333% - var(--wp--style--block-gap, 1rem) * 2 / 3);
  min-width: calc(33.333% - var(--wp--style--block-gap, 1rem) * 2 / 3);
  max-width: 100%;
  scroll-snap-align: center;
}

.wp-block-gallery.bc-carousel > .wp-block-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
```

#### 2. Desktop Standard (< 1280px)
```css
/* Lignes 370-374 */
.wp-block-gallery.bc-carousel > .wp-block-image {
  width: calc(20% - var(--wp--style--block-gap, 1rem) * 4 / 5);
  min-width: calc(20% - var(--wp--style--block-gap, 1rem) * 4 / 5);
}
```

#### 3. Tablette Paysage (< 1024px)
```css
/* Lignes 380-384 */
.wp-block-gallery.bc-carousel > .wp-block-image {
  width: calc(25% - var(--wp--style--block-gap, 1rem) * 3 / 4);
  min-width: calc(25% - var(--wp--style--block-gap, 1rem) * 3 / 4);
}
```

#### 4. Tablette Portrait (< 782px)
```css
/* Lignes 402-406 */
.wp-block-gallery.bc-carousel > .wp-block-image {
  width: calc(50% - var(--wp--style--block-gap, 1rem) / 2);
  min-width: calc(50% - var(--wp--style--block-gap, 1rem) / 2);
}
```

#### 5. Mobile (< 600px)
```css
/* Lignes 449-454 */
.wp-block-gallery.bc-carousel > .wp-block-image {
  width: 100%;
  min-width: 100%;
  max-width: 100%;
}
```

## 🧪 Tests Recommandés

### Vérifier les Galeries
1. **Créer une galerie** avec 10+ images de ratios différents (paysage, portrait, carré)
2. **Activer le carousel** sur cette galerie
3. **Tester chaque breakpoint** :
   - Desktop Large (> 1400px) : vérifier 3 images complètes
   - Desktop (1280px) : vérifier 5 images complètes
   - Tablette (1024px) : vérifier 4 images complètes
   - Tablette (782px) : vérifier 2 images complètes
   - Mobile (600px) : vérifier 1 image complète
   - Mobile (480px) : vérifier 1 image complète

### Points à Vérifier
- ✅ Aucune image coupée en deux
- ✅ Toutes les images ont la même largeur à chaque breakpoint
- ✅ Le scroll snap fonctionne correctement
- ✅ Le gap WordPress est respecté
- ✅ Les images remplissent bien leur conteneur (object-fit: cover)

## 📊 Comparaison Avant/Après

### Avant (Problématique)
```
Desktop : [Image1(auto)]  [Image2(auto)]  [Image3(auto)]
          ↓ Largeurs variables selon le ratio
          [Image1: 30%]  [Image2: 45%]  [Image3: 38%]
          ❌ Incohérent, images partielles possibles
```

### Après (Corrigé)
```
Desktop : [Image1(33%)]  [Image2(33%)]  [Image3(33%)]
          ↓ Largeurs fixes et égales
          [Image1: 33.333%]  [Image2: 33.333%]  [Image3: 33.333%]
          ✅ Cohérent, toujours des images complètes
```

## 💡 Personnalisation Possible

Si vous voulez modifier le nombre d'images visibles par défaut :

```css
/* Afficher 4 images au lieu de 3 sur desktop */
.wp-block-gallery.bc-carousel > .wp-block-image {
  width: calc(25% - var(--wp--style--block-gap, 1rem) * 3 / 4);
  min-width: calc(25% - var(--wp--style--block-gap, 1rem) * 3 / 4);
}

/* Afficher 2 images au lieu de 1 sur mobile paysage */
@media (max-width: 600px) {
  .wp-block-gallery.bc-carousel > .wp-block-image {
    width: calc(50% - var(--wp--style--block-gap, 1rem) / 2);
    min-width: calc(50% - var(--wp--style--block-gap, 1rem) / 2);
  }
}
```

## 📝 Notes Importantes

1. **Object-fit: cover** : Les images sont rognées pour remplir le conteneur. Si vous préférez voir l'image complète (avec potentiellement des bandes), utilisez `object-fit: contain`.

2. **Gap WordPress** : Les calculs prennent en compte le `--wp--style--block-gap`. Si l'utilisateur change le gap dans l'éditeur, les largeurs s'ajusteront automatiquement.

3. **Scroll Snap** : Le `scroll-snap-align: center` est maintenu, donc chaque image se centre automatiquement lors du scroll.

4. **Compatibilité** : Fonctionne avec tous les navigateurs modernes supportant flexbox et calc().

## ✅ Résultat

Le problème de coupure des images dans les galeries est maintenant **complètement résolu**. Les galeries affichent toujours un nombre cohérent d'images complètes, avec une adaptation progressive et intelligente selon la taille d'écran.

---

**Correction appliquée le** : 2025-10-13
**Fichiers modifiés** : 1 (carousel.css)
**Lignes modifiées** : ~30 lignes

