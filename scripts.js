(function () {
    'use strict';

    var admin = window.yayforms_admin || {};
    var i18n = admin.i18n || {};

    function $(id) {
        return document.getElementById(id);
    }

    function clearChildren(el) {
        while (el.firstChild) {
            el.removeChild(el.firstChild);
        }
    }

    function field(labelText, input) {
        var label = document.createElement('label');
        label.className = 'yf-label';
        label.setAttribute('for', input.id);
        label.textContent = labelText;
        var frag = document.createDocumentFragment();
        frag.appendChild(label);
        frag.appendChild(input);
        return frag;
    }

    function textInput(id, name, value) {
        var el = document.createElement('input');
        el.className = 'yf-input';
        el.type = 'text';
        el.id = id;
        el.name = name;
        el.value = value;
        return el;
    }

    function colorInput(id, name, value) {
        var el = document.createElement('input');
        el.className = 'yf-input';
        el.type = 'color';
        el.id = id;
        el.name = name;
        el.value = value;
        return el;
    }

    function selectInput(id, name, options) {
        var el = document.createElement('select');
        el.className = 'yf-select';
        el.id = id;
        el.name = name;
        options.forEach(function (opt) {
            var o = document.createElement('option');
            o.value = opt.value;
            o.textContent = opt.label;
            el.appendChild(o);
        });
        return el;
    }

    function t(key, fallback) {
        return (i18n[key] !== undefined ? i18n[key] : fallback);
    }

    function appendCommonInputs(container) {
        container.appendChild(field(t('label_button_color', 'Button Color:'), colorInput('yf_button_color', 'button_color', '#2C2C2E')));
        container.appendChild(field(t('label_font_size', 'Font Size:'), textInput('yf_font_size', 'font_size', '20px')));
        container.appendChild(field(t('label_rounded', 'Rounded Corners:'), textInput('yf_rounded_corners', 'rounded_corners', '0px')));
        container.appendChild(field(t('label_button_text', 'Button Text:'), textInput('yf_button_text', 'button_text', 'Try me!')));
        container.appendChild(field(t('label_text_color', 'Text Color:'), colorInput('yf_color', 'color', '#FFFFFF')));
    }

    function updateFormOptions() {
        var mode = $('yf_mode').value;
        var container = $('dynamic-options');
        clearChildren(container);

        var shortcodeInput = $('yf_generated_shortcode');
        shortcodeInput.value = '';
        shortcodeInput.style.display = 'none';
        $('yf_generated_shortcode_label').style.display = 'none';
        $('yf_generated_shortcode_help').style.display = 'none';
        var preview = $('yf_form_preview_container');
        clearChildren(preview);
        preview.style.display = 'none';

        if (mode === 'standard') {
            container.appendChild(field(t('label_width', 'Width:'), textInput('yf_width', 'width', '100%')));
            container.appendChild(field(t('label_height', 'Height:'), textInput('yf_height', 'height', '500px')));
        } else if (mode === 'popup') {
            container.appendChild(field(t('label_size', 'Size:'), selectInput('yf_size', 'size', [
                { value: '50', label: t('option_small', 'Small') },
                { value: '70', label: t('option_medium', 'Medium') },
                { value: '100', label: t('option_large', 'Large') }
            ])));
            appendCommonInputs(container);
        } else if (mode === 'slider') {
            container.appendChild(field(t('label_position', 'Position:'), selectInput('yf_position', 'position', [
                { value: 'right', label: t('option_right', 'Right') },
                { value: 'left', label: t('option_left', 'Left') }
            ])));
            container.appendChild(field(t('label_width', 'Width:'), textInput('yf_width', 'width', '600px')));
            appendCommonInputs(container);
        } else if (mode === 'popover') {
            container.appendChild(field(t('label_button_color', 'Button Color:'), colorInput('yf_button_color', 'button_color', '#2C2C2E')));
        } else if (mode === 'side-tab') {
            container.appendChild(field(t('label_button_color', 'Button Color:'), colorInput('yf_button_color', 'button_color', '#2C2C2E')));
            container.appendChild(field(t('label_button_text', 'Button Text:'), textInput('yf_button_text', 'button_text', 'Try me!')));
        }
    }

    function getId() {
        var url = $('yf_id').value.trim();
        var lastSlash = url.lastIndexOf('/');
        if (lastSlash === -1) {
            return url;
        }
        var end = url.length;
        var q = url.lastIndexOf('?');
        var h = url.lastIndexOf('#');
        if (q !== -1) end = Math.min(end, q);
        if (h !== -1) end = Math.min(end, h);
        return url.substring(lastSlash + 1, end);
    }

    function getCommonAttributes() {
        return ' button_color="' + $('yf_button_color').value + '"' +
            ' font_size="' + $('yf_font_size').value + '"' +
            ' rounded_corners="' + $('yf_rounded_corners').value + '"' +
            ' button_text="' + $('yf_button_text').value + '"' +
            ' color="' + $('yf_color').value + '"';
    }

    function getShortcode(mode) {
        var id = getId();
        var shortcode = '[yayforms id="' + id + '"';

        if (mode === 'standard') {
            shortcode += ' mode="standard"';
            shortcode += ' width="' + $('yf_width').value + '"';
            shortcode += ' height="' + $('yf_height').value + '"';
        } else if (mode === 'full-page') {
            shortcode += ' mode="full-page"';
        } else if (mode === 'popup') {
            shortcode += ' mode="popup"';
            shortcode += ' size="' + $('yf_size').value + '"';
            shortcode += getCommonAttributes();
        } else if (mode === 'slider') {
            shortcode += ' mode="slider"';
            shortcode += ' width="' + $('yf_width').value + '"';
            shortcode += ' position="' + $('yf_position').value + '"';
            shortcode += getCommonAttributes();
        } else if (mode === 'popover') {
            shortcode += ' mode="popover"';
            shortcode += ' button_color="' + $('yf_button_color').value + '"';
        } else if (mode === 'side-tab') {
            shortcode += ' mode="side-tab"';
            shortcode += ' button_color="' + $('yf_button_color').value + '"';
            shortcode += ' button_text="' + $('yf_button_text').value + '"';
        }

        shortcode += ']';
        return shortcode;
    }

    function showNotification(id, timeout) {
        var el = $(id);
        if (!el) return;
        el.style.display = 'block';
        setTimeout(function () {
            el.style.display = 'none';
        }, timeout || 5000);
    }

    function showError(message) {
        var el = $('yf_error_notification');
        if (!el) return;
        el.textContent = message;
        el.style.display = 'block';
        setTimeout(function () {
            el.style.display = 'none';
        }, 5000);
    }

    function copyToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text).catch(function () {
                fallbackCopy(text);
            });
        }
        fallbackCopy(text);
        return Promise.resolve();
    }

    function fallbackCopy(text) {
        var tempInput = document.createElement('textarea');
        tempInput.value = text;
        tempInput.setAttribute('readonly', '');
        tempInput.style.position = 'absolute';
        tempInput.style.left = '-9999px';
        document.body.appendChild(tempInput);
        tempInput.select();
        try {
            document.execCommand('copy');
        } catch (err) {
            showError(i18n.copy_failed || 'Could not copy to clipboard.');
        }
        document.body.removeChild(tempInput);
    }

    function ensureEmbedScript() {
        var existing = document.getElementById('yayforms-embed-script');
        if (existing) existing.remove();
        var script = document.createElement('script');
        script.id = 'yayforms-embed-script';
        script.src = admin.embed_url;
        document.head.appendChild(script);
    }

    function generateShortcode() {
        var id = getId();
        if (id === '') {
            showError(i18n.invalid_id || 'Please enter a valid form ID.');
            return;
        }

        var mode = $('yf_mode').value;
        var nonce = $('yayforms_nonce').value;
        var shortcode = getShortcode(mode);

        var body = new URLSearchParams();
        body.set('action', 'yayforms_preview');
        body.set('shortcode', shortcode);
        body.set('yayforms_nonce', nonce);

        fetch(admin.ajax_url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
            body: body.toString()
        })
            .then(function (r) { return r.json(); })
            .then(function (response) {
                if (!response || !response.success) {
                    showError((response && response.data) || i18n.generic_error || 'An error occurred.');
                    return;
                }

                $('yf_generated_shortcode').value = shortcode;
                $('yf_generated_shortcode').style.display = 'block';
                $('yf_generated_shortcode_label').style.display = 'block';
                $('yf_generated_shortcode_help').style.display = 'block';

                var previewContainer = $('yf_form_preview_container');
                clearChildren(previewContainer);

                if (mode === 'standard' || mode === 'full-page') {
                    previewContainer.innerHTML = response.data;
                } else {
                    var wrap = document.createElement('div');
                    wrap.className = 'yf-preview-container';
                    var h = document.createElement('h1');
                    h.className = 'yf-heading';
                    h.textContent = i18n.preview_heading || 'Preview:';
                    wrap.appendChild(h);
                    var bodyEl = document.createElement('div');
                    bodyEl.innerHTML = response.data;
                    wrap.appendChild(bodyEl);
                    var note = document.createElement('div');
                    note.className = 'yf-preview-note';
                    note.textContent = (i18n.preview_note || 'Click the button to see the form in %s mode. Press ESC to exit the preview.').replace('%s', mode);
                    wrap.appendChild(note);
                    previewContainer.appendChild(wrap);
                }
                previewContainer.style.display = 'block';

                ensureEmbedScript();

                copyToClipboard(shortcode).then(function () {
                    showNotification('yf_copy_notification');
                });

                if (mode !== 'standard' && mode !== 'full-page') {
                    showNotification('yf_preview_notification');
                }
            })
            .catch(function () {
                showError(i18n.generic_error || 'An error occurred.');
            });
    }

    function init() {
        var modeSelect = $('yf_mode');
        if (modeSelect) {
            modeSelect.addEventListener('change', updateFormOptions);
        }
        var btn = $('yf_btn_primary');
        if (btn) {
            btn.addEventListener('click', generateShortcode);
        }
        updateFormOptions();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
