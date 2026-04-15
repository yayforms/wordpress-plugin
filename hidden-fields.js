(function () {
    var params = new URLSearchParams(window.location.search);
    if (!params.toString()) {
        return;
    }

    var pairs = [];
    params.forEach(function (value, key) {
        pairs.push(key.replace(/,/g, '\\,') + '=' + value.replace(/,/g, '\\,'));
    });
    var hidden = pairs.join(',');

    var selectors = [
        '[data-yf-widget]',
        '[data-yf-popup]',
        '[data-yf-slider]',
        '[data-yf-popover]',
        '[data-yf-sidetab]'
    ].join(',');

    function hydrate() {
        document.querySelectorAll(selectors).forEach(function (el) {
            if (!el.hasAttribute('data-yf-hidden') || el.getAttribute('data-yf-hidden') === '') {
                el.setAttribute('data-yf-hidden', hidden);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', hydrate);
    } else {
        hydrate();
    }
})();
