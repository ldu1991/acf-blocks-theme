/**
 * is jQuery
 * @param obj
 * @returns {*}
 */
export const isjQuery = (obj) => (obj instanceof jQuery ? obj[0] : obj);

/**
 * is Even
 * @param num
 * @returns {boolean}
 */
export const isEven = (num) => num % 2 === 0;

/**
 * Video Adaptive Resize
 * @param elements
 * @param className
 */
export const videoResize = (elements, className) => {
  function wrapperVideo(parent, className) {
    const wrapper = document.createElement('div');
    if (className !== undefined) wrapper.classList = className;
    wrapper.setAttribute('style', 'position: absolute;top: 0;left: 0;width: 100%;height: 100%;overflow: hidden;');

    parent.parentNode.insertBefore(wrapper, parent);
    wrapper.appendChild(parent);
  }

  document.querySelectorAll(elements).forEach((el) => {
    wrapperVideo(el, className);

    let fnResize = () => {
      // Get a native video size
      let videoHeight = el.videoHeight;
      let videoWidth = el.videoWidth;

      // Get a wrapper size
      let wrapperHeight = el.parentNode.offsetHeight;
      let wrapperWidth = el.parentNode.offsetWidth;

      if (wrapperWidth / videoWidth > wrapperHeight / videoHeight) {
        el.setAttribute(
          'style',
          'width:' +
            (wrapperWidth + 3) +
            'px;height:auto;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);'
        );
      } else {
        el.setAttribute(
          'style',
          'width:auto;height:' +
            (wrapperHeight + 3) +
            'px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);'
        );
      }
    };

    fnResize();
    window.addEventListener('resize', fnResize);
  });
};

/**
 * Render Block
 * @param type
 * @param fn
 */
export const renderBlock = (type = '', fn) => {
  const selector = '.' + wp_ajax.prefix + '-' + type;

  const isGutenberg = typeof wp !== 'undefined' && typeof wp.domReady !== 'undefined' && typeof wp.data !== 'undefined';

  if (isGutenberg) {
    wp.domReady(() => {
      const editorStore = wp.data.select('core/editor');

      if (editorStore && typeof acf !== 'undefined') {
        const getBlockEl = (el) => {
          const node = el instanceof jQuery ? el[0] : el;
          return node.querySelector(selector) ?? node;
        };

        acf.addAction('render_block_preview/type=' + type, (el) => fn(getBlockEl(el), true));
      }
    });
  } else {
    document.querySelectorAll(selector).forEach((el) => fn(el, false));
  }
};

/**
 * @param minSize
 * @param maxSize
 * @param minViewport
 * @param maxViewport
 * @param unit
 * @returns {string}
 */
export function mathClamp(minSize, maxSize, minViewport = 768, maxViewport = 1400, unit = 'rem') {
  const toUnit = (size) => {
    const context = 16;
    switch (unit) {
      case 'rem':
        return `${+(size / context).toFixed(6)}rem`;
      case 'em':
        return `${+(size / context).toFixed(6)}em`;
      default:
        return `${size}px`;
    }
  };

  if (minSize === maxSize) return toUnit(minSize);

  const viewPortWidthOffset = toUnit(minViewport / 100);
  const sizeDifference = maxSize - minSize;
  const viewportDifference = maxViewport - minViewport;
  const linearFactor = Math.round(100 * (sizeDifference / viewportDifference) * 1000) / 1000;

  const fluid = `${toUnit(minSize)} + ((1vw - ${viewPortWidthOffset}) * ${linearFactor})`;

  const [clampMin, clampMax] =
    minSize > maxSize ? [toUnit(maxSize), toUnit(minSize)] : [toUnit(minSize), toUnit(maxSize)];

  return `clamp(${clampMin}, ${fluid}, ${clampMax})`;
}

/**
 * Paginate Links
 * @param paginateWrap
 * @param total
 * @param current
 */
export const paginateLinks = (paginateWrap, total, current) => {
  if (total > 1) {
    let page_links = '';

    let prev_class = current && 1 < current ? 'prev' : 'paginate-none';
    page_links += '<button class="' + prev_class + '" data-page="' + (current - 1) + '">Previous</button>';

    let dots = false;
    page_links += '<div class="paginate-wrap">';
    for (let n = 1; n <= total; n++) {
      if (n === current) {
        page_links += '<div class="current">' + n + '</div>';

        dots = true;
      } else {
        if (n <= 1 || (current && n >= current - 1 && n <= current + 1) || n > total - 1) {
          page_links += '<button class="page-numbers" data-page="' + n + '">' + n + '</button>';

          dots = true;
        } else if (dots) {
          page_links += '<div class="dots">&hellip;</div>';

          dots = false;
        }
      }
    }
    page_links += '</div>';

    let next_class = current && current < total ? 'next' : 'paginate-none';
    page_links += '<button class="' + next_class + '" data-page="' + (current + 1) + '">Next</button>';

    paginateWrap.style.display = '';
    paginateWrap.innerHTML = page_links;
  } else {
    paginateWrap.style.display = 'none';
    paginateWrap.innerHTML = '';
  }
};
