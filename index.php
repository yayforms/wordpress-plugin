<?php
/*
Plugin Name: Yay! Forms
Plugin URI: https://yayforms.com
Description: Embeds Yay! Forms in WordPress with various options and a user-friendly GUI for shortcode generation.
Version: 1.0
Author: Yay! Forms
Author URI: https://www.yayforms.com/?utm_source=wordpressorg&utm_medium=referral&utm_campaign=wordpressorg_integration&utm_content=directory
License: GNU General Public License v3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

// Add menu item for the shortcode generator in the WordPress admin
function yayforms_menu() {

    $logo = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="500" zoomAndPan="magnify" viewBox="0 0 375 374.999991" height="500" preserveAspectRatio="xMidYMid meet" version="1.0"><path fill="#ffffff" d="M 302.289062 1.308594 C 295.671875 3.023438 282.597656 9.722656 273.285156 16.175781 C 268.789062 19.28125 257.191406 27.941406 247.550781 35.457031 C 194.769531 76.390625 166.75 88.234375 122.46875 88.234375 C 102.53125 88.234375 86.683594 86.273438 61.03125 80.472656 C 44.933594 76.878906 32.925781 75.164062 24.347656 75.164062 C 18.21875 75.164062 16.828125 75.488281 12.335938 77.695312 C 7.027344 80.390625 4.328125 83.167969 1.714844 89.050781 C -0.410156 93.628906 -0.570312 103.511719 1.226562 108.742188 C 3.839844 116.011719 11.03125 129.085938 20.425781 143.382812 C 48.773438 186.601562 62.5 221.242188 65.523438 257.109375 C 66.75 271.648438 65.523438 289.625 62.011719 310.457031 C 58.25 332.269531 58.007812 334.558594 57.84375 344.28125 C 57.761719 354.410156 58.578125 357.269531 62.910156 362.253906 C 67.972656 367.972656 74.101562 369.851562 81.453125 367.972656 C 89.542969 365.851562 97.304688 360.050781 116.75 341.667969 C 148.9375 311.191406 170.179688 296.324219 194.445312 287.335938 C 202.125 284.558594 217.074219 280.472656 217.566406 281.128906 C 217.730469 281.289062 217.566406 286.191406 217.15625 292.074219 C 216.503906 302.207031 216.828125 315.277344 217.890625 326.714844 C 218.21875 330.71875 218.789062 332.433594 220.261719 333.90625 C 222.628906 336.273438 227.695312 336.4375 230.472656 334.230469 L 232.351562 332.761719 L 232.351562 306.128906 C 232.433594 291.503906 232.761719 279.25 233.089844 278.839844 C 233.496094 278.511719 241.585938 278.1875 251.0625 278.1875 C 278.023438 278.1875 291.75 281.535156 318.871094 294.445312 C 331.945312 300.734375 340.605469 303.1875 351.308594 303.59375 C 359.148438 304.003906 360.128906 303.839844 363.070312 302.125 C 371.242188 297.304688 373.773438 289.789062 373.121094 272.875 C 372.628906 260.050781 371.324219 253.675781 366.339844 238.644531 C 358.007812 213.5625 344.363281 190.277344 326.226562 170.179688 L 319.363281 162.582031 L 325.082031 154.902344 C 334.886719 141.828125 353.429688 122.386719 370.34375 107.269531 C 374.589844 103.511719 375 102.859375 375 99.753906 C 375 95.097656 372.304688 92.320312 367.730469 92.320312 C 364.789062 92.320312 363.644531 92.972656 357.679688 98.203125 C 341.667969 112.253906 325.652344 129.085938 315.113281 142.808594 C 312.5 146.242188 309.96875 149.429688 309.558594 149.835938 C 308.496094 150.980469 305.800781 144.199219 304.738281 137.828125 C 302.449219 123.367188 307.679688 106.289062 325.570312 69.851562 C 336.847656 46.8125 339.296875 41.09375 341.667969 31.617188 C 343.546875 24.265625 343.300781 16.585938 341.175781 12.335938 C 339.050781 8.25 333.007812 3.675781 327.207031 1.796875 C 320.832031 -0.328125 309.3125 -0.570312 302.289062 1.308594 Z M 139.214844 118.21875 C 141.828125 120.832031 141.910156 119.933594 138.152344 137.664062 C 129.328125 179.65625 118.789062 208.742188 101.46875 238.890625 C 96.570312 247.46875 93.136719 249.019531 88.480469 244.851562 C 85.785156 242.402344 86.109375 238.96875 89.542969 233.25 C 95.996094 222.628906 108.824219 195.179688 111.4375 186.601562 C 112.011719 184.804688 111.929688 184.804688 106.863281 186.847656 C 102.53125 188.644531 100.898438 188.890625 95.261719 188.5625 C 89.707031 188.316406 87.828125 187.746094 83.496094 185.457031 C 73.609375 180.230469 65.851562 168.464844 61.765625 152.695312 C 59.394531 143.628906 57.925781 133.578125 58.578125 131.699219 C 59.558594 128.839844 62.335938 126.632812 64.949219 126.632812 C 69.199219 126.632812 70.914062 129.328125 72.304688 138.152344 C 76.144531 163.234375 85.703125 176.878906 98.449219 175.488281 C 107.761719 174.429688 114.132812 164.625 120.996094 140.929688 C 124.589844 128.269531 128.023438 120.015625 130.390625 117.808594 C 133.171875 115.359375 136.519531 115.523438 139.214844 118.21875 Z M 289.949219 139.378906 C 292.730469 142.972656 292.15625 144.933594 284.804688 155.066406 C 254.65625 197.222656 236.683594 237.746094 233.089844 271.976562 C 232.515625 277.859375 232.191406 278.1875 224.511719 279.003906 C 217.972656 279.65625 218.300781 280.882812 220.589844 266.175781 C 223.367188 247.957031 229.25 227.777344 236.03125 212.910156 C 237.417969 209.804688 238.5625 207.109375 238.5625 206.863281 C 238.5625 206.699219 237.011719 206.78125 235.050781 207.027344 C 227.289062 208.167969 218.789062 204.410156 214.378906 197.792969 L 212.253906 194.527344 L 207.679688 198.285156 C 200.164062 204.410156 190.03125 208.25 184.230469 207.191406 C 180.636719 206.453125 176.632812 203.105469 174.917969 199.265625 L 173.53125 196.242188 L 168.871094 199.347656 C 159.148438 205.882812 149.265625 208.089844 142.808594 205.230469 C 133.414062 201.144531 130.964844 189.707031 136.847656 177.695312 C 141.585938 167.972656 154.25 156.046875 162.828125 153.269531 C 165.03125 152.53125 169.117188 151.960938 171.894531 151.960938 C 177.042969 151.960938 184.640625 153.921875 184.640625 155.308594 C 184.640625 155.636719 183.332031 158.332031 181.699219 161.273438 C 179.003906 166.257812 178.675781 166.503906 176.796875 165.851562 C 174.101562 164.789062 170.261719 164.871094 166.339844 165.929688 C 162.335938 167.074219 151.308594 177.777344 148.855469 183.089844 C 146.894531 187.171875 146.488281 192.730469 148.121094 192.890625 C 157.597656 193.710938 169.527344 183.90625 180.882812 165.851562 C 187.988281 154.574219 189.625 152.777344 192.566406 152.777344 C 195.015625 152.777344 199.347656 156.945312 199.347656 159.3125 C 199.347656 160.292969 197.304688 164.460938 194.851562 168.710938 C 188.234375 179.65625 184.96875 189.789062 186.765625 193.054688 C 187.746094 194.769531 192.15625 193.21875 197.710938 189.132812 C 205.71875 183.25 208.332031 177.859375 209.96875 163.808594 C 210.539062 159.3125 211.4375 154.492188 212.171875 153.023438 C 214.460938 148.039062 220.507812 147.710938 223.53125 152.371094 C 224.835938 154.328125 224.835938 155.308594 223.9375 162.828125 C 221.976562 177.859375 221.976562 180.066406 223.449219 185.128906 C 225.734375 193.136719 229.003906 195.097656 236.191406 192.730469 C 243.21875 190.359375 251.226562 181.289062 264.542969 160.949219 C 272.957031 148.203125 279.574219 139.378906 281.699219 138.070312 C 284.394531 136.519531 288.152344 137.171875 289.949219 139.378906 Z M 313.480469 158.496094 L 317.648438 162.988281 L 311.273438 173.203125 C 307.679688 178.839844 303.921875 184.070312 302.777344 184.96875 C 299.183594 187.746094 293.300781 184.558594 293.300781 179.738281 C 293.300781 178.429688 294.445312 175.410156 295.832031 173.039062 C 300.734375 164.707031 308.25 153.511719 308.742188 153.757812 C 308.988281 153.921875 311.109375 156.046875 313.480469 158.496094 Z M 290.605469 199.753906 C 293.464844 201.796875 293.628906 204.984375 291.175781 211.109375 C 288.890625 216.910156 286.847656 218.953125 283.414062 218.953125 C 280.800781 218.953125 276.960938 215.359375 276.960938 212.828125 C 276.960938 210.292969 280.148438 202.613281 282.109375 200.328125 C 284.070312 198.203125 287.988281 197.957031 290.605469 199.753906 Z M 290.605469 199.753906 " fill-opacity="1" fill-rule="nonzero"/></svg>');

    add_menu_page(
        'Yay! Forms',
        'Yay! Forms',
        'manage_options',
        'yayforms-generator',
        'yayforms_shortcode_generator',
        $logo,
        100
    );
}
add_action('admin_menu', 'yayforms_menu');
function yayforms_shortcode_generator() {
    ?>
    <!-- Adicione isso em algum lugar do seu HTML -->
    <div class="yf-logo-container">
        <svg class="yf-logo" id="yf_logo" xmlns="http://www.w3.org/2000/svg" width="166.632" height="60" viewBox="0 0 166.632 60">
            <path id="Path_37303" data-name="Path 37303" d="M-36.4-16.536H-46.86V0h3.768V-6.5h5.3V-9.768h-5.3v-3.48h6.7ZM-22.98.288A8.528,8.528,0,0,0-14.556-8.28a8.507,8.507,0,0,0-8.424-8.544A8.481,8.481,0,0,0-31.428-8.28,8.5,8.5,0,0,0-22.98.288ZM-23-3.264A4.7,4.7,0,0,1-27.636-8.28,4.68,4.68,0,0,1-23-13.272,4.713,4.713,0,0,1-18.348-8.28,4.733,4.733,0,0,1-23-3.264ZM4.6,0,.348-6.024a5.3,5.3,0,0,0,3.864-5.04,5.228,5.228,0,0,0-5.568-5.472H-8.124V0h3.768V-5.808h.768L.2,0ZM-1.86-13.248a2.2,2.2,0,0,1,2.28,2.28A2.144,2.144,0,0,1-1.956-8.784h-2.4v-4.464Zm29.88-3.288H24.8L20.052-6.192,15.228-16.536H12.084L10.044,0h3.864l1.1-9.384,3.6,7.488h2.88l3.6-7.512L26.172,0h3.864ZM41.676.288c3.024,0,6.1-1.584,6.1-5.136,0-3-2.4-4.2-4.752-4.92l-1.728-.552c-1.536-.432-1.632-1.176-1.632-1.512a1.791,1.791,0,0,1,1.944-1.7,1.732,1.732,0,0,1,1.9,1.824h3.768c0-3.216-2.424-5.112-5.592-5.112-3.288,0-5.832,2.088-5.832,5.064,0,1.56.7,3.792,4.344,4.776l1.968.6C43.62-5.9,43.98-5.3,43.98-4.656c0,1.08-.936,1.7-2.16,1.7a2.14,2.14,0,0,1-2.352-1.872H35.7C35.7-1.776,38.148.288,41.676.288Z" transform="translate(118.86 37.825)" fill="#2c2c2e"/>
            <g id="icon-yayforms">
                <rect id="Rectangle_11" data-name="Rectangle 11" width="60" height="60" fill="none"/>
                <path id="Exclusion_1" data-name="Exclusion 1" d="M12.167,58.711h0a2.412,2.412,0,0,1-1.244-.344,3.366,3.366,0,0,1-1.688-2.939,21.517,21.517,0,0,1,.519-4.742,47.212,47.212,0,0,0,.827-6.724,26.569,26.569,0,0,0-1.011-8.41A46.843,46.843,0,0,0,3.234,22.681a28.776,28.776,0,0,1-2.85-5.051,4.218,4.218,0,0,1,.257-4.036A3.722,3.722,0,0,1,4.078,12a27.471,27.471,0,0,1,5.284.827c.4.085.8.172,1.213.26a42.173,42.173,0,0,0,8.857,1.087,27.743,27.743,0,0,0,5.734-.582c5.8-1.21,10.459-4.852,14.572-8.064C43.538,2.562,46.818,0,50.1,0a6.1,6.1,0,0,1,2.507.536,3.09,3.09,0,0,1,1.808,1.778c.749,2.079-.864,5.3-2.571,8.7a41.053,41.053,0,0,0-2.962,6.907c-.727,2.583-.613,4.637.348,6.279a44.7,44.7,0,0,0-2.461,3.837,1.131,1.131,0,0,0,.987,1.677,1.133,1.133,0,0,0,.989-.582c.006-.011.766-1.375,2.009-3.167a29.678,29.678,0,0,1,7.084,10.738c1.562,3.986,2.048,7.625,1.3,9.736a2.62,2.62,0,0,1-2.418,1.951c-.157.009-.316.014-.471.014a12.9,12.9,0,0,1-5.522-1.64c-.317-.147-.677-.314-1.043-.478a21.73,21.73,0,0,0-9.512-2.118,29.867,29.867,0,0,0-3.085.168,32.452,32.452,0,0,1,1.336-6.5,45.956,45.956,0,0,1,4.79-9.775c1.63-2.586,3.029-4.382,3.088-4.457a1.13,1.13,0,0,0-1.7-1.489,23.258,23.258,0,0,0-2.327,3.211,30.641,30.641,0,0,1-2.905,3.994,3.79,3.79,0,0,1-2.453,1.5c-.042,0-.083,0-.124-.005a.971.971,0,0,1-.771-.423,4.468,4.468,0,0,1-.515-2.731c.051-.219.1-.447.135-.678a14.183,14.183,0,0,0,.2-1.962,1.125,1.125,0,0,0-.85-1.327,1.138,1.138,0,0,0-.259-.03,1.125,1.125,0,0,0-1.1.872l-.008.036c-.012.045-.022.09-.029.132a17.641,17.641,0,0,0-.325,2.429l-.011.205a4.458,4.458,0,0,1-.85,1.856,6.436,6.436,0,0,1-1.64,1.336,2.314,2.314,0,0,1-.923.329,2.764,2.764,0,0,1,.117-1.547,8.423,8.423,0,0,1,.677-1.651c.593-.9,1.011-1.626,1.054-1.705a1.129,1.129,0,1,0-1.969-1.106l0,.006c-.062.109-.166.289-.311.527a1.208,1.208,0,0,0-.125.153c-.211.312-.41.638-.59.971-.14.211-.29.43-.446.65a10.526,10.526,0,0,1-2.788,2.965,3.854,3.854,0,0,1-1.713.6.461.461,0,0,1-.188-.029.441.441,0,0,1-.108-.25,2.618,2.618,0,0,1,.529-1.584A7.342,7.342,0,0,1,25.952,26.8a2.392,2.392,0,0,1,1.4-.45,2.634,2.634,0,0,1,.31.019,2.82,2.82,0,0,1,.87.25l-.007,0,1.106-1.969a4.842,4.842,0,0,0-1.575-.5,4.951,4.951,0,0,0-.707-.051,4.663,4.663,0,0,0-2.692.86,9.543,9.543,0,0,0-2.591,2.731,4.45,4.45,0,0,0-.82,3.222,2.5,2.5,0,0,0,1.374,1.849,2.687,2.687,0,0,0,1.137.237,3.919,3.919,0,0,0,.751-.078,7.361,7.361,0,0,0,2.05-.806,6.238,6.238,0,0,0,1.08-.778,2.969,2.969,0,0,0,.254.677,2.057,2.057,0,0,0,1.625,1.1,2.472,2.472,0,0,0,.308.018,6.37,6.37,0,0,0,3.976-2.1,4,4,0,0,0,.4.691,3.235,3.235,0,0,0,2.4,1.35c.111.01.222.014.339.014a3.9,3.9,0,0,0,1.009-.135,36.534,36.534,0,0,0-1.67,4.193,33.623,33.623,0,0,0-1.268,5.615c-.087.617-.161,1.254-.22,1.892H34.8l.05-.008c.766-.127,1.521-.23,2.246-.306-.116,1.089-.188,2.207-.213,3.322a34.082,34.082,0,0,0,.167,4.545,1.132,1.132,0,0,1-.98,1.262,1.272,1.272,0,0,1-.142.008,1.13,1.13,0,0,1-1.119-.987,36.5,36.5,0,0,1-.185-4.832c.022-1.007.079-2.017.17-3a23.4,23.4,0,0,0-9.374,3.928A54.665,54.665,0,0,0,18.6,54.324C16.015,56.775,13.971,58.71,12.167,58.711Zm5.582-29.175v0l0,.008,0,.006-.008.023a45.548,45.548,0,0,1-3.9,8.158,1.13,1.13,0,0,0,1.908,1.21,47.311,47.311,0,0,0,4.116-8.613,68.537,68.537,0,0,0,2.552-10.177.061.061,0,0,0,.007-.012,1.13,1.13,0,0,0-.953-1.733,1.266,1.266,0,0,0-1.215.975s0,.008,0,.019a18.792,18.792,0,0,0-1.021,2.912l0,.006a18.112,18.112,0,0,1-1.561,4.092c-.827,1.353-1.668,1.509-2.228,1.509l-.125,0A2.542,2.542,0,0,1,13.478,27a6.7,6.7,0,0,1-1.254-2.278,15.257,15.257,0,0,1-.75-3.591,1.131,1.131,0,0,0-1.126-1.058l-.073,0a1.129,1.129,0,0,0-1.056,1.2,17.453,17.453,0,0,0,.858,4.154,8.96,8.96,0,0,0,1.71,3.071,5.217,5.217,0,0,0,1.475,1.16,4.636,4.636,0,0,0,1.958.515c.062,0,.129,0,.205,0a4.369,4.369,0,0,0,2.32-.642Zm27.91,1.973a1.125,1.125,0,0,0-1.049.71l-.474,1.187a1.129,1.129,0,1,0,2.1.839l.475-1.187a1.13,1.13,0,0,0-1.049-1.549Zm5.1-5.541h0c-.069-.064-.141-.13-.235-.214a6.43,6.43,0,0,1-1.288-1.55c.846-1.188,1.713-2.292,2.579-3.282A56.381,56.381,0,0,1,57.866,15,1.129,1.129,0,0,1,59.3,16.752a55.029,55.029,0,0,0-5.783,5.657,40.366,40.366,0,0,0-2.755,3.558Z" fill="#2c2c2e"/>
            </g>
        </svg>
    </div>
    <div class="yf-container">
        <div class="yf-card">
            <div class="yf-copy-notification" id="yf_copy_notification">
                Shortcode copied to clipboard!
            </div>
            <div class="yf-preview-notification" id="yf_preview_notification">
                Press ESC to exit the preview...
            </div>
            <h1 class="yf-heading">Yay! Forms</h1>
            <p class="yf-text">Yay! Forms is an online form builder software featuring user-friendly design and AI-driven insights, streamlining form creation and data analysis. It caters to businesses seeking efficient, engaging, and intelligent form-building solutions.</p>
            <p class="yf-text">This plugin offers a streamlined interface for generating shortcodes to embed custom forms, surveys, and quizzes into your posts, pages, or widgets. Requires a Yay! Forms account, available at <a href="https://www.yayforms.com" target="_blank">Yay! Forms</a>.</p>
            <form id="yf_form" class="yf-form">
                <!-- Form ID -->
                <label class="yf-label" for="yf_id">Your Form URL or ID:</label>
                <input class="yf-input" type="text" id="yf_id" name="id" required value="53omzj7">

                <!-- Display Mode -->
                <label class="yf-label" for="yf_mode">Display Mode:</label>
                <select class="yf-select" id="yf_mode" name="mode" onchange="updateFormOptions()">
                    <option value="standard">Standard</option>
                    <option value="full-page">Full-page</option>
                    <option value="popup">Popup</option>
                    <option value="slider">Slider</option>
                    <option value="popover">Popover</option>
                    <option value="side-tab">Side Tab</option>
                </select>

                <!-- Dynamic Options Container -->
                <div id="dynamic-options"></div>

                <!-- Generate Shortcode Button -->
                <button id="yf_btn_primary" type="button" class="yf-btn-primary" onclick="generateShortcode()">Copy shortcode</button>
                <label for="yf_generated_shortcode" id="yf_generated_shortcode_label" class="yf-label yf-generated-shortcode-label" style="display: none;">Generated Shortcode:</label>
                <input type="text" id="yf_generated_shortcode" class="yf-generated-shortcode" readonly disabled>
                <p id="yf_generated_shortcode_help" class="yf-text yf-text-hide yf-generated-shortcode-help">*Use this shortcode in your posts, pages or widgets to show your form.</p>
            </form>

            <div id="yf_form_preview_container" class="yf-form-preview" style="display: none;">
                <!-- O preview do formulário será exibido aqui -->
            </div>
        </div>
    </div>

    <script src="<?php echo plugin_dir_url(__FILE__) . 'scripts.js'; ?>"></script>
    <?php
}

// Register the shortcode in WordPress
function yayforms_shortcode($atts) {
    // Default and custom attributes
    $atts = shortcode_atts(array(
        'id' => '',
        'width' => '100%',   // Usado apenas para os modos 'standard' e 'full-page'
        'height' => '500px', // Usado apenas para os modos 'standard' e 'full-page'
        'mode' => 'standard',
        'size' => '70',     // Usado apenas para o modo 'popup'
        'position' => 'right', // Usado apenas para o modo 'slider'
        'button_color' => '#ffffff', // Usado em vários modos
        'font_size' => '20px', // Usado em 'popup' e 'slider'
        'rounded_corners' => '0px', // Usado em 'popup' e 'slider'
        'button_text' => 'Try me!', // Usado em 'side-tab'
        'color' => '#000000',
    ), $atts);

    // Capture URL parameters for hidden fields
    $hidden_fields = array();
    foreach ($_GET as $key => $value) {
        $hidden_fields[] = htmlspecialchars($key) . '=' . htmlspecialchars($value);
    }
    $hidden_fields_str = implode(',', $hidden_fields);

    // Generate embed code based on the chosen mode
    $embed_code = "";
    switch ($atts['mode']) {
        case 'standard':
            $embed_code = "<div data-yf-widget='{$atts['id']}' data-yf-hidden='{$hidden_fields_str}' style='width:{$atts['width']};height:{$atts['height']};'></div>";
            break;
        case 'full-page':
            $embed_code = "<div data-yf-widget='{$atts['id']}' data-yf-hidden='{$hidden_fields_str}' style='width:100%;height:100%;opacity:100;'></div>";
            break;
        case 'popup':
            $embed_code = "<button data-yf-popup='{$atts['id']}' data-yf-size='{$atts['size']}' data-yf-hidden='{$hidden_fields_str}' style='all:unset; font-family:Helvetica,Arial,sans-serif; display:inline-block; max-width:100%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-size:{$atts['font_size']}; padding:0 33px; font-weight:bold; height:50px; cursor:pointer; line-height:50px; text-align:center; margin:0; text-decoration:none; background-color:{$atts['button_color']}; border-radius:{$atts['rounded_corners']}; color: {$atts['color']};'>{$atts['button_text']}</button>";
            break;
        case 'slider':
            $embed_code = "<button data-yf-slider='{$atts['id']}' data-yf-width='{$atts['width']}' data-yf-position='{$atts['position']}' data-yf-button-color='{$atts['button_color']}' data-yf-hidden='{$hidden_fields_str}' style='all:unset; font-family:Helvetica,Arial,sans-serif; display:inline-block; max-width:100%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; background-color:{$atts['button_color']}; color:{$atts['color']}; padding:0 33px; font-weight:bold; height:50px; cursor:pointer; line-height:50px; text-align:center; margin:0; text-decoration:none; font-size:{$atts['font_size']}; border-radius:{$atts['rounded_corners']};'>{$atts['button_text']}</button>";
            break;
        case 'popover':
            $embed_code = "<div data-yf-popover='{$atts['id']}' data-yf-button-color='{$atts['button_color']}' data-yf-hidden='{$hidden_fields_str}' style='background-color: {$atts['button_color']};'></div>";
            break;
        case 'side-tab':
            $embed_code = "<div data-yf-sidetab='{$atts['id']}' data-yf-button-text='{$atts['button_text']}' data-yf-button-color='{$atts['button_color']}' data-yf-hidden='{$hidden_fields_str}'></div>";
            break;
        default:
            $embed_code = "<p>Error: Unsupported display mode.</p>";
            break;
    }

    $embed_code .= "<script src='//embed.yayforms.link/next/embed.js'></script>";
    return $embed_code;
}

function yayforms_preview_shortcode() {
    // Verifica se o shortcode está definido
    if (isset($_POST['shortcode'])) {
        // Processa o shortcode e retorna o HTML
        echo do_shortcode(stripslashes($_POST['shortcode']));
    }
    wp_die(); // Encerra a execução do script
}

add_action('wp_ajax_yayforms_preview', 'yayforms_preview_shortcode');

function yayforms_enqueue_admin_styles() {
    wp_enqueue_style('yayforms-admin-styles', plugin_dir_url(__FILE__) . 'style.css');
    wp_enqueue_script('yayforms-admin-script', plugin_dir_url(__FILE__) . 'scripts.js', array('jquery'), false, true);
}
add_action('admin_enqueue_scripts', 'yayforms_enqueue_admin_styles');

add_shortcode('yayform', 'yayforms_shortcode');
