function updateFormOptions() {
    var mode = document.getElementById('yf_mode').value;
    var optionsContainer = document.getElementById('dynamic-options');
    optionsContainer.innerHTML = '';

    document.getElementById('yf_generated_shortcode').value = '';
    document.getElementById('yf_generated_shortcode').style.display = 'none';
    document.getElementById('yf_generated_shortcode_label').style.display = 'none';
    document.getElementById('yf_generated_shortcode_help').style.display = 'none';
    document.getElementById('yf_form_preview_container').innerHTML = '';
    document.getElementById('yf_form_preview_container').style.display = 'none';

    if (mode === 'standard') {
        optionsContainer.innerHTML +=
            '<label class="yf-label" for="yf_width">Width:</label>' +
            '<input class="yf-input" type="text" id="yf_width" name="width" value="100%">' +
            '<label class="yf-label" for="yf_height">Height:</label>' +
            '<input class="yf-input" type="text" id="yf_height" name="height" value="500px">';
    }

    if (mode === 'popup') {
        optionsContainer.innerHTML +=
            '<label class="yf-label" for="yf_size">Size:</label>' +
            '<select class="yf-select" id="yf_size" name="size">' +
            '<option value="50">Small</option><option value="70">Medium</option><option value="100">Large</option>' +
            '</select>' +
            commonInputs();
    }

    if (mode === 'slider') {
        optionsContainer.innerHTML +=
            '<label class="yf-label" for="yf_position">Position:</label>' +
            '<select class="yf-select" id="yf_position" name="position">' +
            '<option value="right">Right</option><option value="left">Left</option>' +
            '</select>' +
            '<label class="yf-label" for="yf_width">Width:</label>' +
            '<input class="yf-input" type="text" id="yf_width" name="width" value="600px">' +
            commonInputs();
    }

    if (mode === 'popover') {
        optionsContainer.innerHTML +=
            '<label class="yf-label" for="yf_button_color">Button Color:</label>' +
            '<input class="yf-input" type="color" id="yf_button_color" name="button_color" value="#2C2C2E">';
    }

    if (mode === 'side-tab') {
        optionsContainer.innerHTML +=
            '<label class="yf-label" for="yf_button_color">Button Color:</label>' +
            '<input class="yf-input" type="color" id="yf_button_color" name="button_color" value="#2C2C2E">' +
            '<label class="yf-label" for="yf_button_text">Button Text:</label>' +
            '<input class="yf-input" type="text" id="yf_button_text" name="button_text" value="Try me!">';
    }
}

function commonInputs() {
    return '<label class="yf-label" for="yf_button_color">Button Color:</label>' +
           '<input class="yf-input" type="color" id="yf_button_color" name="button_color" value="#2C2C2E">' +
           '<label class="yf-label" for="yf_font_size">Font Size:</label>' +
           '<input class="yf-input" type="text" id="yf_font_size" name="font_size" value="20px">' +
           '<label class="yf-label" for="yf_rounded_corners">Rounded Corners:</label>' +
           '<input class="yf-input" type="text" id="yf_rounded_corners" name="rounded_corners" value="0px">' +
           '<label class="yf-label" for="yf_button_text">Button Text:</label>' +
           '<input class="yf-input" type="text" id="yf_button_text" name="button_text" value="Try me!">' +
           '<label class="yf-label" for="yf_color">Text Color:</label>' +
           '<input class="yf-input" type="color" id="yf_color" name="color" value="#FFFFFF">';
}

function generateShortcode() {
    var id = getId()

    if (id === '') {
        alert('Please enter a valid form ID.');
        return;
    }

    var mode = document.getElementById('yf_mode').value;
    var nonce = document.getElementById('yayforms_nonce').value;
    var shortcode = getShortcode(mode);

    jQuery.post(yayforms_admin.ajax_url, {
        action: 'yayforms_preview',
        shortcode: shortcode,
        yayforms_nonce: nonce
    }, function(response) {
        if (!response.success) {
            alert(response.data || 'An error occurred. Please try again.');
            return;
        }

        document.getElementById('yf_generated_shortcode').value = shortcode;
        document.getElementById('yf_generated_shortcode').style.display = 'block';
        document.getElementById('yf_generated_shortcode_label').style.display = 'block';
        document.getElementById('yf_generated_shortcode_help').style.display = 'block';

        var previewContainer = document.getElementById('yf_form_preview_container');
        
        if (mode === 'standard' || mode === 'full-page') {
            previewContainer.innerHTML = response.data;
        } else {
            var previewHtml = '<div class="yf-preview-container">';
            previewHtml += '<h1 class="yf-heading">Preview:</h1>';
            previewHtml += response.data;
            previewHtml += '<div class="yf-preview-note">Click the button to see the form in ' + mode + ' mode. Press ESC to exit the preview.</div>';
            previewHtml += '</div>';
            previewContainer.innerHTML = previewHtml;
        }
        previewContainer.style.display = 'block';

        var existingScript = document.getElementById('yayforms-embed-script');
        if (existingScript) {
            existingScript.remove();
        }

        var script = document.createElement('script');
        script.id = 'yayforms-embed-script';
        script.src = '//embed.yayforms.link/next/embed.js';
        document.head.appendChild(script);

        copyToClipboard();

        if (mode !== 'standard' && mode !== 'full-page') {
            showNotification('yf_preview_notification');
        }
    });
}

function getId() {
    var url = document.getElementById('yf_id').value;
    var lastSlashIndex = url.lastIndexOf('/');
    var lastQuestionMarkIndex = url.lastIndexOf('?');
    var lastHashIndex = url.lastIndexOf('#');

    if (lastSlashIndex === -1) {
        return url;
    }

    var endIndex = url.length;
    if (lastQuestionMarkIndex !== -1) {
        endIndex = Math.min(endIndex, lastQuestionMarkIndex);
    }
    if (lastHashIndex !== -1) {
        endIndex = Math.min(endIndex, lastHashIndex);
    }

    return url.substring(lastSlashIndex + 1, endIndex);
}

function getShortcode(mode) {
    var id = getId();
    var shortcode = '[yayforms id="' + id + '"';

    if (mode === 'standard') {
        var width = document.getElementById('yf_width').value;
        var height = document.getElementById('yf_height').value;
        shortcode += ' mode="standard"';
        shortcode += ' width="' + width + '"';
        shortcode += ' height="' + height + '"';
    }

    if (mode === 'full-page') {
        shortcode += ' mode="full-page"';
    }

    if (mode === 'popup') {
        var size = document.getElementById('yf_size').value;
        shortcode += ' mode="popup"';
        shortcode += ' size="' + size + '"';
        shortcode += getCommonAttributes();
    }

    if (mode === 'slider') {
        var width = document.getElementById('yf_width').value;
        var position = document.getElementById('yf_position').value;
        shortcode += ' mode="slider"';
        shortcode += ' width="' + width + '"';
        shortcode += ' position="' + position + '"';
        shortcode += getCommonAttributes();
    }

    if (mode === 'popover') {
        var buttonColor = document.getElementById('yf_button_color').value;
        shortcode += ' mode="popover"';
        shortcode += ' button_color="' + buttonColor + '"';
    }

    if (mode === 'side-tab') {
        var buttonColor = document.getElementById('yf_button_color').value;
        var buttonText = document.getElementById('yf_button_text').value;
        shortcode += ' mode="side-tab"';
        shortcode += ' button_color="' + buttonColor + '"';
        shortcode += ' button_text="' + buttonText + '"';
    }

    shortcode += ']';
    return shortcode;
}

function getCommonAttributes() {
    var buttonColor = document.getElementById('yf_button_color').value;
    var fontSize = document.getElementById('yf_font_size').value;
    var roundedCorners = document.getElementById('yf_rounded_corners').value;
    var buttonText = document.getElementById('yf_button_text').value;
    var color = document.getElementById('yf_color').value;

    return ' button_color="' + buttonColor + '"' +
           ' font_size="' + fontSize + '"' +
           ' rounded_corners="' + roundedCorners + '"' +
           ' button_text="' + buttonText + '"' +
           ' color="' + color + '"';
}

function showNotification(element) {
    var notification = document.getElementById(element);
    notification.style.display = 'block';

    setTimeout(function() {
        notification.style.display = 'none';
    }, 5000);
}

function copyToClipboard() {
    var element = document.getElementById('yf_generated_shortcode');
    var tempInput = document.createElement('input');
    tempInput.style = 'position: absolute; left: -1000px; top: -1000px';
    tempInput.value = element.value;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
}

document.addEventListener('DOMContentLoaded', function() {
    var modeSelect = document.getElementById('yf_mode');
    if (modeSelect) {
        modeSelect.addEventListener('change', function() {
            updateFormOptions();
        });
    }
});

window.onload = updateFormOptions;
