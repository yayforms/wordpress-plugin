function updateFormOptions() {
    var mode = document.getElementById('yf_mode').value;
    var optionsContainer = document.getElementById('dynamic-options');
    optionsContainer.innerHTML = '';

    // Inputs para o modo 'standard'
    if (mode === 'standard') {
        optionsContainer.innerHTML +=
            '<label class="yf-label" for="yf_width">Width:</label>' +
            '<input class="yf-inputs" type="text" id="yf_width" name="width" value="100%">' +
            '<label class="yf-label" for="yf_height">Height:</label>' +
            '<input class="yf-input" type="text" id="yf_height" name="height" value="500px">';
    }

    // Inputs para o modo 'full-page'
    if (mode === 'full-page') {
        // Adicione aqui os inputs específicos para o modo 'full-page', se houver
    }

    // Inputs para o modo 'popup'
    if (mode === 'popup') {
        optionsContainer.innerHTML +=
            '<label class="yf-label" for="yf_size">Size:</label>' +
            '<select class="yf-select" id="yf_size" name="size">' +
            '<option value="50">Small</option><option value="70">Medium</option><option value="100">Large</option>' +
            '</select>' +
            commonInputs(); // Função para inputs comuns
    }

    // Inputs para o modo 'slider'
    if (mode === 'slider') {
        optionsContainer.innerHTML +=
            '<label class="yf-label" for="yf_position">Position:</label>' +
            '<select class="yf-select" id="yf_position" name="position">' +
            '<option value="right">Right</option><option value="left">Left</option>' +
            '</select>' +
            '<label class="yf-label" for="yf_width">Width:</label>' +
            '<input class="yf-input" type="text" id="yf_width" name="width" value="600px">' +
            commonInputs(); // Função para inputs comuns
    }

    // Inputs para o modo 'popover'
    if (mode === 'popover') {
        optionsContainer.innerHTML +=
            '<label class="yf-label" for="yf_button_color">Button Color:</label>' +
            '<input class="yf-input" type="color" id="yf_button_color" name="button_color" value="#000000">';
    }

    // Inputs para o modo 'side-tab'
    if (mode === 'side-tab') {
        optionsContainer.innerHTML +=
            '<label class="yf-label" for="yf_button_color">Button Color:</label>' +
            '<input class="yf-input" type="color" id="yf_button_color" name="button_color" value="#000000">' +
            '<label class="yf-label" for="yf_button_text">Button Text:</label>' +
            '<input class="yf-input" type="text" id="yf_button_text" name="button_text" value="Try me!">';
    }
}

// Função para gerar inputs comuns entre os modos 'popup' e 'slider'
function commonInputs() {
    return '<label class="yf-label" for="yf_button_color">Button Color:</label>' +
        '<input class="yf-input yf-color" type="color" id="yf_button_color" name="button_color" value="#000000">' +
        '<label class="yf-label" for="yf_font_size">Font Size (px):</label>' +
        '<input class="yf-input" type="number" id="yf_font_size" name="font_size" value="20">' +
        '<label class="yf-label" for="yf_rounded_corners">Rounded Corners (px):</label>' +
        '<input class="yf-input" type="number" id="yf_rounded_corners" name="rounded_corners" value="4">' +
        '<label class="yf-label" for="yf_button_text">Button Text:</label>' +
        '<input class="yf-input" type="text" id="yf_button_text" name="button_text" value="Try me!">' +
        '<label class="yf-label" for="yf_color">Button Text Color:</label>' +
        '<input class="yf-input yf-color" type="color" id="yf_color" name="color" value="#ffffff">';
}

function generateShortcode() {

    var id = getId()

    if (id === '') {
        alert('Please enter a valid form ID.');
        return;
    }

    var mode = document.getElementById('yf_mode').value;
    var shortcode = getShortcode(mode);

    showPreview(shortcode);
    copyToClipboard();

    if (mode !== 'standard' && mode !== 'full-page') {
        showNotification('yf_preview_notification');
    }
}

function showPreview(shortcode) {
    document.getElementById('yf_generated_shortcode').value = shortcode;
    document.getElementById('yf_generated_shortcode').style.display = 'block';
    document.getElementById('yf_generated_shortcode_label').style.display = 'block';
    document.getElementById('yf_generated_shortcode_help').style.display = 'block';

    jQuery.post(ajaxurl, {
        action: 'yayforms_preview',
        shortcode: shortcode
    }, function(response) {
        var previewContainer = document.getElementById('yf_form_preview_container');
        previewContainer.innerHTML = response;
        previewContainer.style.display = 'block';

        // Carregar o script de embed do formulário
        var script = document.createElement('script');
        script.src = "//embed.yayforms.link/next/embed.js";
        script.onload = function () {
            // Ações adicionais após o carregamento do script, se necessário
        };
        document.head.appendChild(script);
    });
}

function showNotification(element) {
    var notification = document.getElementById(element);
    notification.style.display = 'block';

    setTimeout(function() {
        notification.style.display = 'none';
    }, 5000);
}

function getId() {
    var url = document.getElementById('yf_id').value;
    var lastSlashIndex = url.lastIndexOf('/');
    var questionMarkIndex = url.indexOf('?', lastSlashIndex);

    if (lastSlashIndex !== -1) {
        if (questionMarkIndex !== -1) {
            // Se houver uma barra e um ponto de interrogação, pega o texto entre eles
            id = url.substring(lastSlashIndex + 1, questionMarkIndex);
        } else {
            // Se houver apenas uma barra, pega o texto depois dela
            id = url.substring(lastSlashIndex + 1);
        }
    } else {
        if (questionMarkIndex !== -1) {
            // Se não houver barra, mas houver um ponto de interrogação, pega o texto antes dele
            id = url.substring(0, questionMarkIndex);
        } else {
            // Se não houver barra nem ponto de interrogação, considera toda a string
            id = url;
        }
    }

    return id;
}

function getShortcode(mode) {
    var shortcode = '[yayform id="' + id + '" mode="' + mode;

    if (mode === 'standard') {
        var width = document.getElementById('yf_width').value;
        var height = document.getElementById('yf_height').value;
        shortcode += '" width="' + width + '" height="' + height;
    }

// Adicionar parâmetros para o modo 'full-page'
    if (mode === 'full-page') {
        // Adicione aqui os parâmetros específicos para o modo 'full-page', se houver
    }

// Adicionar parâmetros para o modo 'popover'
    if (mode === 'popover') {
        var popoverButtonColor = document.getElementById('yf_button_color').value;
        shortcode += '" button_color="' + popoverButtonColor;
    }

// Adicionar parâmetros para o modo 'side-tab'
    if (mode === 'side-tab') {
        var sideTabButtonColor = document.getElementById('yf_button_color').value;
        var sideTabButtonText = document.getElementById('yf_button_text').value;
        shortcode += '" button_color="' + sideTabButtonColor + '" button_text="' + sideTabButtonText;
    }

    var buttonText = '';
    var buttonTextColor = '';
    // Adicionar parâmetros para o modo 'popup'
    if (mode === 'popup') {
        var buttonColor = document.getElementById('yf_button_color').value;
        var fontSize = document.getElementById('yf_font_size').value + 'px';
        var roundedCorners = document.getElementById('yf_rounded_corners').value + 'px';
        var size = document.getElementById('yf_size').value;
        buttonText = document.getElementById('yf_button_text').value;
        buttonTextColor = document.getElementById('yf_color').value;
        shortcode += '" button_color="' + buttonColor + '" font_size="' + fontSize + '" rounded_corners="' + roundedCorners + '" size="' + size + '" color="' + buttonTextColor + '" button_text="' + buttonText;
    }

// Adicionar parâmetros para o modo 'slider'
    if (mode === 'slider') {
        var sliderButtonColor = document.getElementById('yf_button_color').value;
        var sliderFontSize = document.getElementById('yf_font_size').value + 'px';
        var sliderRoundedCorners = document.getElementById('yf_rounded_corners').value + 'px';
        var sliderPosition = document.getElementById('yf_position').value;
        var sliderWidth = document.getElementById('yf_width').value;
        buttonText = document.getElementById('yf_button_text').value;
        buttonTextColor = document.getElementById('yf_color').value;
        shortcode += '" button_color="' + sliderButtonColor + '" font_size="' + sliderFontSize + '" rounded_corners="' + sliderRoundedCorners + '" position="' + sliderPosition + '" width="' + sliderWidth + '" color="' + buttonTextColor + '" button_text="' + buttonText;
    }

    shortcode += '"]'; // Fecha a string do shortcode
    return shortcode;
}

function copyToClipboard() {
    var element = document.getElementById("yf_generated_shortcode");
    var tempInput = document.createElement('input');
    tempInput.value = element.value;
    document.body.appendChild(tempInput);
    tempInput.select();

    // Copia o texto selecionado
    try {
        var successful = document.execCommand('copy');
        if (successful) {
            showNotification('yf_copy_notification');
        }
    } catch (err) {
        console.log('Oops, unable to copy');
    }

    // Remove o input temporário
    document.body.removeChild(tempInput);
}

window.onload = updateFormOptions;