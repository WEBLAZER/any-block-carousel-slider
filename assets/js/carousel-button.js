/**
 * Ajoute un bouton "Carousel" dans les paramètres des blocs Group, Post Template et Gallery
 * pour activer/désactiver facilement la classe .cfg-carousel
 */
(function (wp) {
  const { addFilter } = wp.hooks;
  const { createHigherOrderComponent } = wp.compose;
  const { Fragment, useEffect, useMemo, createElement } = wp.element;
  const { InspectorControls, BlockListBlock } = wp.blockEditor;
  const { PanelBody, ToggleControl } = wp.components;
  const { __ } = wp.i18n;

  /**
   * Blocs supportés pour le carousel
   */
  const SUPPORTED_BLOCKS = ['core/group', 'core/post-template', 'core/gallery'];

  /**
   * Ajoute l'attribut 'carouselEnabled' aux blocs supportés
   */
  function addCarouselAttribute(settings, name) {
    if (!SUPPORTED_BLOCKS.includes(name)) {
      return settings;
    }

    return {
      ...settings,
      attributes: {
        ...settings.attributes,
        carouselEnabled: {
          type: 'boolean',
          default: false,
        },
      },
    };
  }

  /**
   * Ajoute le contrôle Toggle dans l'Inspector
   */
  const withCarouselControl = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      const { attributes, setAttributes, name } = props;

      // Ne s'applique qu'aux blocs supportés
      if (!SUPPORTED_BLOCKS.includes(name)) {
        return createElement(BlockEdit, props);
      }

      const { carouselEnabled } = attributes;

      // Mémoriser la sérialisation du layout pour éviter les re-renders inutiles
      const layoutKey = useMemo(
        () => JSON.stringify(attributes.layout),
        [attributes.layout?.type, attributes.layout?.columnCount, attributes.layout?.minimumColumnWidth]
      );

      /**
       * Toggle le carousel : ajoute/retire la classe 'carousel'
       * Pour les grilles, détecte automatiquement le nombre de colonnes
       */
      const toggleCarousel = (enabled) => {
        setAttributes({ carouselEnabled: enabled });

        // Gérer la classe CSS
        const currentClasses = attributes.className || '';
        const classArray = currentClasses.split(' ').filter(Boolean);

        // Retirer toutes les classes carousel-* existantes (nouvelles ET anciennes)
        const filteredClasses = classArray.filter(
          (cls) =>
            !cls.startsWith('cfg-carousel-cols-') &&
            cls !== 'cfg-carousel-min-width' &&
            // Retirer aussi les anciennes classes pour migration
            !cls.startsWith('carousel-cols-') &&
            cls !== 'carousel-min-width'
        );

        if (enabled) {
          // Ajouter la classe 'cfg-carousel' si elle n'existe pas
          if (!filteredClasses.includes('cfg-carousel')) {
            filteredClasses.push('cfg-carousel');
          }

          // Pour les grilles (Group et Post Template), détecter et ajouter la classe cfg-carousel-cols-X
          if (
            (name === 'core/group' || name === 'core/post-template') &&
            attributes.layout?.type === 'grid'
          ) {
            const columnCount = attributes.layout?.columnCount;
            const minimumColumnWidth = attributes.layout?.minimumColumnWidth;

            // Si un nombre de colonnes est défini
            if (columnCount && columnCount >= 1 && columnCount <= 6) {
              filteredClasses.push(`cfg-carousel-cols-${columnCount}`);
            }
            // Si une largeur minimale est définie, ajouter une classe spéciale
            else if (minimumColumnWidth) {
              filteredClasses.push('cfg-carousel-min-width');
            }
            // Sinon, utiliser 3 colonnes par défaut
            else {
              filteredClasses.push('cfg-carousel-cols-3');
            }
          }
        } else {
          // Retirer la classe 'cfg-carousel'
          const index = filteredClasses.indexOf('cfg-carousel');
          if (index > -1) {
            filteredClasses.splice(index, 1);
          }
        }

        setAttributes({
          className: filteredClasses.join(' ').trim(),
        });
      };

      /**
       * Synchroniser automatiquement la classe cfg-carousel-cols-X
       * quand le nombre de colonnes Grid change
       */
      useEffect(() => {
        // Seulement si le carousel est activé et que c'est un Grid (Group ou Post Template)
        if (
          carouselEnabled &&
          (name === 'core/group' || name === 'core/post-template') &&
          attributes.layout?.type === 'grid'
        ) {
          const currentClasses = attributes.className || '';
          const classArray = currentClasses.split(' ').filter(Boolean);

          // Trouver les classes cfg-carousel-* actuelles
          const currentColsClass = classArray.find((cls) =>
            cls.startsWith('cfg-carousel-cols-')
          );
          const hasMinWidthClass = classArray.includes('cfg-carousel-min-width');

          const columnCount = attributes.layout?.columnCount;
          const minimumColumnWidth = attributes.layout?.minimumColumnWidth;

          let expectedColsClass = null;
          let shouldHaveMinWidthClass = false;

          // Si un nombre de colonnes est défini
          if (columnCount && columnCount >= 1 && columnCount <= 6) {
            expectedColsClass = `cfg-carousel-cols-${columnCount}`;
            shouldHaveMinWidthClass = false;
          }
          // Si une largeur minimale est définie
          else if (minimumColumnWidth) {
            expectedColsClass = null;
            shouldHaveMinWidthClass = true;
          }
          // Sinon, utiliser 3 colonnes par défaut
          else {
            expectedColsClass = 'cfg-carousel-cols-3';
            shouldHaveMinWidthClass = false;
          }

          // Si les classes ne correspondent pas, les mettre à jour
          if (currentColsClass !== expectedColsClass || hasMinWidthClass !== shouldHaveMinWidthClass) {
            const filteredClasses = classArray.filter(
              (cls) =>
                !cls.startsWith('cfg-carousel-cols-') &&
                cls !== 'cfg-carousel-min-width' &&
                // Retirer aussi les anciennes classes pour migration
                !cls.startsWith('carousel-cols-') &&
                cls !== 'carousel-min-width'
            );

            // Ajouter la nouvelle classe si nécessaire
            if (expectedColsClass) {
              filteredClasses.push(expectedColsClass);
            }
            if (shouldHaveMinWidthClass) {
              filteredClasses.push('cfg-carousel-min-width');
            }

            setAttributes({
              className: filteredClasses.join(' ').trim(),
            });
          }
        }
      }, [
        carouselEnabled,
        name,
        layoutKey,
      ]);

      return createElement(
        Fragment,
        null,
        createElement(BlockEdit, props),
        createElement(
          InspectorControls,
          null,
          createElement(
            PanelBody,
            {
              title: __('Carousel', 'carousel-for-gutenberg'),
              initialOpen: true,
            },
            createElement(ToggleControl, {
              label: __('Activer le carousel', 'carousel-for-gutenberg'),
              checked: carouselEnabled,
              onChange: toggleCarousel,
              help: carouselEnabled
                ? (name === 'core/group' || name === 'core/post-template') && attributes.layout?.type === 'grid'
                  ? __(
                    'Le carousel est activé. Le nombre de colonnes visibles est détecté automatiquement depuis les paramètres de la grille.',
                    'carousel-for-gutenberg'
                  )
                  : __(
                    'Le carousel est activé. Les éléments défilent horizontalement.',
                    'carousel-for-gutenberg'
                  )
                : __(
                  'Activez pour transformer ce bloc en carousel avec navigation.',
                  'carousel-for-gutenberg'
                ),
            })
          )
        )
      );
    };
  }, 'withCarouselControl');

  /**
   * Wrapper pour injecter les styles inline du carousel dans l'éditeur
   * (minimumColumnWidth, blockGap, etc.)
   */
  const withCarouselStyles = createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      const { attributes, name } = props;

      // Ne s'applique qu'aux blocs avec carousel activé
      if (!attributes.carouselEnabled) {
        return createElement(BlockListBlock, props);
      }

      const customStyles = {};

      // 1. Injecter --carousel-min-width pour les Grids avec minimumColumnWidth
      if (
        (name === 'core/group' || name === 'core/post-template') &&
        attributes.layout?.type === 'grid' &&
        attributes.layout?.minimumColumnWidth
      ) {
        customStyles['--carousel-min-width'] = attributes.layout.minimumColumnWidth;
      }

      // 2. Injecter --wp--style--block-gap pour tous les carousels
      let blockGap = attributes.style?.spacing?.blockGap;

      // Exception pour Gallery : utiliser le gap horizontal (left) pour le carousel
      if (name === 'core/gallery' && blockGap && typeof blockGap === 'object') {
        blockGap = blockGap.left || blockGap.top || null;
      }

      // Si c'est un preset WordPress (ex: "var:preset|spacing|50"), le convertir
      if (blockGap && typeof blockGap === 'string' && blockGap.startsWith('var:preset|spacing|')) {
        const presetSlug = blockGap.replace('var:preset|spacing|', '');
        blockGap = `var(--wp--preset--spacing--${presetSlug})`;
      }

      // Injecter le gap (même si c'est "0" pour None)
      if (blockGap !== undefined && blockGap !== null && blockGap !== '') {
        // Convertir "0" en "0px" pour les calculs CSS
        customStyles['--wp--style--block-gap'] = (blockGap === '0' || blockGap === 0) ? '0px' : blockGap;
      }

      // Si aucun style à injecter, retourner le bloc tel quel
      if (Object.keys(customStyles).length === 0) {
        return createElement(BlockListBlock, props);
      }

      // Créer le wrapper avec les styles inline
      const wrapperProps = {
        ...props,
        wrapperProps: {
          ...props.wrapperProps,
          style: {
            ...props.wrapperProps?.style,
            ...customStyles,
          },
        },
      };

      return createElement(BlockListBlock, wrapperProps);
    };
  }, 'withCarouselStyles');

  // Enregistrer les filtres
  addFilter(
    'blocks.registerBlockType',
    'carousel-for-gutenberg/add-carousel-attribute',
    addCarouselAttribute
  );

  addFilter(
    'editor.BlockEdit',
    'carousel-for-gutenberg/with-carousel-control',
    withCarouselControl
  );

  addFilter(
    'editor.BlockListBlock',
    'carousel-for-gutenberg/with-carousel-styles',
    withCarouselStyles
  );
})(window.wp);
