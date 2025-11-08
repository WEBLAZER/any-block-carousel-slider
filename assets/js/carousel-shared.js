(function (global) {
  'use strict';

  const shared = global.NativeBlocksCarouselShared || {};

  const DEFAULT_ARROW_STYLE = 'chevron';

  const ICON_BASE = {
    chevron: {
      viewBox: '0 0 320 512',
      paths: {
        left: {
          d: 'M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z'
        },
        right: {
          d: 'M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z'
        }
      }
    },
    arrow: {
      viewBox: '0 0 640 640',
      paths: {
        right: {
          d: 'M566.6 342.6C579.1 330.1 579.1 309.8 566.6 297.3L406.6 137.3C394.1 124.8 373.8 124.8 361.3 137.3C348.8 149.8 348.8 170.1 361.3 182.6L466.7 288L96 288C78.3 288 64 302.3 64 320C64 337.7 78.3 352 96 352L466.7 352L361.3 457.4C348.8 469.9 348.8 490.2 361.3 502.7C373.8 515.2 394.1 515.2 406.6 502.7L566.6 342.7z'
        },
        left: {
          d: 'M566.6 342.6C579.1 330.1 579.1 309.8 566.6 297.3L406.6 137.3C394.1 124.8 373.8 124.8 361.3 137.3C348.8 149.8 348.8 170.1 361.3 182.6L466.7 288L96 288C78.3 288 64 302.3 64 320C64 337.7 78.3 352 96 352L466.7 352L361.3 457.4C348.8 469.9 348.8 490.2 361.3 502.7C373.8 515.2 394.1 515.2 406.6 502.7L566.6 342.7z',
          transform: 'scale(-1 1) translate(-640 0)'
        }
      }
    }
  };

  const ICON_ALIASES = {
    classic: 'chevron',
    'solid-full': 'arrow',
    arrowfull: 'arrow'
  };

  const ARROW_ICONS = {
    ...ICON_BASE,
    classic: ICON_BASE.chevron,
    'solid-full': ICON_BASE.arrow
  };

  const hasOwn = Object.prototype.hasOwnProperty;

  function normalizeStyleKey(styleKey) {
    if (!styleKey) {
      return DEFAULT_ARROW_STYLE;
    }

    if (hasOwn.call(ICON_BASE, styleKey)) {
      return styleKey;
    }

    if (hasOwn.call(ICON_ALIASES, styleKey)) {
      return ICON_ALIASES[styleKey];
    }

    return DEFAULT_ARROW_STYLE;
  }

  function getIconDefinition(styleKey) {
    const normalized = normalizeStyleKey(styleKey);
    return ARROW_ICONS[normalized] || ARROW_ICONS[DEFAULT_ARROW_STYLE];
  }

  function buildSvgElement(direction, color, styleKey, fillAttr) {
    const icon = getIconDefinition(styleKey);
    const directionKey = direction === 'left' ? 'left' : 'right';
    const pathConfig = icon.paths[directionKey] || icon.paths.right;
    const attributes = [`${fillAttr}='${color}'`, `d='${pathConfig.d}'`];

    if (pathConfig.transform) {
      attributes.push(`transform='${pathConfig.transform}'`);
    }

    return `<svg xmlns='http://www.w3.org/2000/svg' viewBox='${icon.viewBox}' aria-hidden='true'><path ${attributes.join(' ')} /></svg>`;
  }

  function generateArrowSvg(direction, color, styleKey) {
    const svg = buildSvgElement(direction, color, styleKey, 'fill');
    return 'data:image/svg+xml,' + encodeURIComponent(svg);
  }

  function generateArrowMarkup(direction, color, styleKey) {
    return buildSvgElement(direction, color, styleKey, 'fill');
  }

  shared.DEFAULT_ARROW_STYLE = DEFAULT_ARROW_STYLE;
  shared.normalizeStyleKey = normalizeStyleKey;
  shared.getIconDefinition = getIconDefinition;
  shared.generateArrowSvg = generateArrowSvg;
  shared.generateArrowMarkup = generateArrowMarkup;

  global.NativeBlocksCarouselShared = shared;
})(window);

