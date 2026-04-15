<?php
/*
Plugin Name: Yay! Forms
Plugin URI: https://yayforms.com
Description: Embeds Yay! Forms in WordPress with various options and a user-friendly GUI for shortcode generation.
Version: 1.4.1
Requires at least: 6.0
Requires PHP: 7.4
Author: Yay! Forms
Author URI: https://www.yayforms.com/?utm_source=wordpressorg&utm_medium=referral&utm_campaign=wordpressorg_integration&utm_content=directory
License: GNU General Public License v3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: yayforms
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit;
}

define('YAYFORMS_VERSION', '1.4.1');
define('YAYFORMS_EMBED_URL', 'https://embed.yayforms.link/next/embed.js');

function yayforms_load_textdomain() {
    load_plugin_textdomain('yayforms', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'yayforms_load_textdomain');

function yayforms_menu() {
    $icon_path = plugin_dir_path(__FILE__) . 'assets/icon.svg';
    $icon = file_exists($icon_path)
        ? 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($icon_path))
        : 'dashicons-feedback';

    add_menu_page(
        __('Yay! Forms', 'yayforms'),
        __('Yay! Forms', 'yayforms'),
        'manage_options',
        'yayforms-generator',
        'yayforms_shortcode_generator',
        $icon,
        100
    );
}
add_action('admin_menu', 'yayforms_menu');

function yayforms_register_embed_script() {
    if (wp_script_is('yayforms-embed', 'registered')) {
        return;
    }

    wp_register_script('yayforms-embed', YAYFORMS_EMBED_URL, array(), YAYFORMS_VERSION, true);

    $hydration_js = file_get_contents(plugin_dir_path(__FILE__) . 'hidden-fields.js');
    if ($hydration_js) {
        wp_add_inline_script('yayforms-embed', $hydration_js, 'before');
    }
}
add_action('wp_enqueue_scripts', 'yayforms_register_embed_script');
add_action('admin_enqueue_scripts', 'yayforms_register_embed_script');

function yayforms_shortcode_generator() {
    $logo_url = plugin_dir_url(__FILE__) . 'assets/logo.svg';
    ?>
    <div class="yf-admin-page">
        <div class="yf-logo-container">
            <img class="yf-logo" src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr__('Yay! Forms', 'yayforms'); ?>">
        </div>
        <div class="yf-container">
            <div class="yf-card">
                <div class="yf-copy-notification" id="yf_copy_notification" role="status" aria-live="polite">
                    <?php echo esc_html__('Shortcode copied to clipboard!', 'yayforms'); ?>
                </div>
                <div class="yf-copy-notification" id="yf_preview_notification" role="status" aria-live="polite">
                    <?php echo esc_html__('Preview ready — click the button below to try the form.', 'yayforms'); ?>
                </div>
                <div class="yf-copy-notification yf-error-notification" id="yf_error_notification" role="alert" aria-live="assertive"></div>
                <h1 class="yf-heading"><?php echo esc_html__('Yay! Forms', 'yayforms'); ?></h1>
                <p class="yf-text"><?php echo esc_html__('Yay! Forms is an online form builder software featuring user-friendly design and AI-driven insights, streamlining form creation and data analysis. It caters to businesses seeking efficient, engaging, and intelligent form-building solutions.', 'yayforms'); ?></p>
                <p class="yf-text">
                    <?php
                    printf(
                        /* translators: %s: link to yayforms.com */
                        esc_html__('This plugin offers a streamlined interface for generating shortcodes to embed custom forms, surveys, and quizzes into your posts, pages, or widgets. Requires a Yay! Forms account, available at %s.', 'yayforms'),
                        '<a href="https://www.yayforms.com" target="_blank" rel="noopener">Yay! Forms</a>'
                    );
                    ?>
                </p>
                <form id="yf_form" class="yf-form">
                    <?php wp_nonce_field('yayforms_preview_action', 'yayforms_nonce'); ?>
                    <label class="yf-label" for="yf_id"><?php echo esc_html__('Your Form URL or ID:', 'yayforms'); ?></label>
                    <input class="yf-input" type="text" id="yf_id" name="id" required value="53omzj7">

                    <label class="yf-label" for="yf_mode"><?php echo esc_html__('Display Mode:', 'yayforms'); ?></label>
                    <select class="yf-select" id="yf_mode" name="mode">
                        <option value="standard"><?php echo esc_html__('Standard', 'yayforms'); ?></option>
                        <option value="full-page"><?php echo esc_html__('Full-page', 'yayforms'); ?></option>
                        <option value="popup"><?php echo esc_html__('Popup', 'yayforms'); ?></option>
                        <option value="slider"><?php echo esc_html__('Slider', 'yayforms'); ?></option>
                        <option value="popover"><?php echo esc_html__('Popover', 'yayforms'); ?></option>
                        <option value="side-tab"><?php echo esc_html__('Side Tab', 'yayforms'); ?></option>
                    </select>

                    <div id="dynamic-options"></div>

                    <button id="yf_btn_primary" type="button" class="yf-btn-primary"><?php echo esc_html__('Generate and copy shortcode', 'yayforms'); ?></button>
                    <label for="yf_generated_shortcode" id="yf_generated_shortcode_label" class="yf-label yf-generated-shortcode-label" style="display: none;"><?php echo esc_html__('Generated Shortcode:', 'yayforms'); ?></label>
                    <input type="text" id="yf_generated_shortcode" class="yf-generated-shortcode" readonly disabled>
                    <p id="yf_generated_shortcode_help" class="yf-text yf-text-hide yf-generated-shortcode-help"><?php echo esc_html__('*Use this shortcode in your posts, pages or widgets to show your form.', 'yayforms'); ?></p>
                </form>

                <div id="yf_form_preview_container" class="yf-form-preview" style="display: none;"></div>
            </div>
        </div>
    </div>
    <?php

    wp_enqueue_script('yayforms-admin-script');
}

function yayforms_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => '',
        'width' => '100%',
        'height' => '500px',
        'mode' => 'standard',
        'size' => '70',
        'position' => 'right',
        'button_color' => '#FFFFFF',
        'font_size' => '20px',
        'rounded_corners' => '0px',
        'button_text' => 'Try me!',
        'color' => '#000000',
    ), $atts);

    $id              = esc_attr(sanitize_text_field($atts['id']));
    $width           = esc_attr(sanitize_text_field($atts['width']));
    $height          = esc_attr(sanitize_text_field($atts['height']));
    $mode            = esc_attr(sanitize_text_field($atts['mode']));
    $size            = esc_attr(sanitize_text_field($atts['size']));
    $position        = esc_attr(sanitize_text_field($atts['position']));
    $button_color    = esc_attr(sanitize_hex_color($atts['button_color']) ?? '#FFFFFF');
    $font_size       = esc_attr(sanitize_text_field($atts['font_size']));
    $rounded_corners = esc_attr(sanitize_text_field($atts['rounded_corners']));
    $button_text_attr = esc_attr(sanitize_text_field($atts['button_text']));
    $button_text_html = esc_html(sanitize_text_field($atts['button_text']));
    $color           = esc_attr(sanitize_hex_color($atts['color']) ?? '#000000');

    $embed_code = '';
    switch ($mode) {
        case 'standard':
            $embed_code = sprintf(
                '<div data-yf-widget="%s" data-yf-hidden="" style="width:%s;height:%s;"></div>',
                $id,
                $width,
                $height
            );
            break;
        case 'full-page':
            $embed_code = sprintf(
                '<div data-yf-widget="%s" data-yf-hidden="" style="width:100%%;height:100%%;opacity:100;"></div>',
                $id
            );
            break;
        case 'popup':
            $embed_code = sprintf(
                '<button data-yf-popup="%s" data-yf-size="%s" data-yf-hidden="" style="all:unset; font-family:Helvetica,Arial,sans-serif; display:inline-block; max-width:100%%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-size:%s; padding:0 33px; font-weight:bold; height:50px; cursor:pointer; line-height:50px; text-align:center; margin:0; text-decoration:none; background-color:%s; border-radius:%s; color:%s; box-shadow:0 0 10px rgba(0,0,0,0.2); transition:all 0.2s ease-in-out;">%s</button>',
                $id,
                $size,
                $font_size,
                $button_color,
                $rounded_corners,
                $color,
                $button_text_html
            );
            break;
        case 'slider':
            $embed_code = sprintf(
                '<button data-yf-slider="%s" data-yf-width="%s" data-yf-position="%s" data-yf-button-color="%s" data-yf-hidden="" style="all:unset; font-family:Helvetica,Arial,sans-serif; display:inline-block; max-width:100%%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; background-color:%s; color:%s; padding:0 33px; font-weight:bold; height:50px; cursor:pointer; line-height:50px; text-align:center; margin:0; text-decoration:none; font-size:%s; border-radius:%s;">%s</button>',
                $id,
                $width,
                $position,
                $button_color,
                $button_color,
                $color,
                $font_size,
                $rounded_corners,
                $button_text_html
            );
            break;
        case 'popover':
            $embed_code = sprintf(
                '<div data-yf-popover="%s" data-yf-button-color="%s" data-yf-hidden="" style="background-color:%s;"></div>',
                $id,
                $button_color,
                $button_color
            );
            break;
        case 'side-tab':
            $embed_code = sprintf(
                '<div data-yf-sidetab="%s" data-yf-button-text="%s" data-yf-button-color="%s" data-yf-hidden=""></div>',
                $id,
                $button_text_attr,
                $button_color
            );
            break;
        default:
            return '';
    }

    wp_enqueue_script('yayforms-embed');

    // In admin/AJAX contexts (e.g. page builder previews) wp_footer may not run,
    // so print the registered script (with its inline 'before' hydration) inline.
    if (is_admin() || wp_doing_ajax()) {
        ob_start();
        wp_print_scripts('yayforms-embed');
        $embed_code .= ob_get_clean();
    }

    return $embed_code;
}
add_shortcode('yayforms', 'yayforms_shortcode');

function yayforms_preview_shortcode() {
    if (!isset($_POST['yayforms_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['yayforms_nonce'])), 'yayforms_preview_action')) {
        wp_send_json_error(esc_html__('Error: Security check failed.', 'yayforms'));
    }

    if (!current_user_can('manage_options')) {
        wp_send_json_error(esc_html__('Unauthorized user.', 'yayforms'));
    }

    if (!isset($_POST['shortcode'])) {
        wp_send_json_error(esc_html__('Shortcode parameter is missing.', 'yayforms'));
    }

    $shortcode = sanitize_text_field(wp_unslash($_POST['shortcode']));

    if (!preg_match('/^\[yayforms(\s|\])/', $shortcode)) {
        wp_send_json_error(esc_html__('Only [yayforms] shortcodes can be previewed.', 'yayforms'));
    }

    wp_send_json_success(do_shortcode($shortcode));
}
add_action('wp_ajax_yayforms_preview', 'yayforms_preview_shortcode');

function yayforms_enqueue_admin_styles($hook) {
    if ($hook !== 'toplevel_page_yayforms-generator') {
        return;
    }

    wp_enqueue_style('yayforms-admin-styles', plugin_dir_url(__FILE__) . 'style.css', array(), YAYFORMS_VERSION);
    wp_register_script('yayforms-admin-script', plugin_dir_url(__FILE__) . 'scripts.js', array(), YAYFORMS_VERSION, true);

    wp_localize_script('yayforms-admin-script', 'yayforms_admin', array(
        'ajax_url'  => admin_url('admin-ajax.php'),
        'nonce'     => wp_create_nonce('yayforms_preview_action'),
        'embed_url' => YAYFORMS_EMBED_URL,
        'i18n'      => array(
            'invalid_id'       => __('Please enter a valid form ID.', 'yayforms'),
            'generic_error'    => __('An error occurred. Please try again.', 'yayforms'),
            'copy_failed'      => __('Could not copy to clipboard. Please copy manually.', 'yayforms'),
            'preview_heading'  => __('Preview:', 'yayforms'),
            /* translators: %s: display mode name (e.g. popup, slider) */
            'preview_note'     => __('Click the button to see the form in %s mode. Press ESC to exit the preview.', 'yayforms'),
            'label_width'      => __('Width:', 'yayforms'),
            'label_height'     => __('Height:', 'yayforms'),
            'label_size'       => __('Size:', 'yayforms'),
            'label_position'   => __('Position:', 'yayforms'),
            'label_button_color' => __('Button Color:', 'yayforms'),
            'label_font_size'  => __('Font Size:', 'yayforms'),
            'label_rounded'    => __('Rounded Corners:', 'yayforms'),
            'label_button_text' => __('Button Text:', 'yayforms'),
            'label_text_color' => __('Text Color:', 'yayforms'),
            'option_small'     => __('Small', 'yayforms'),
            'option_medium'    => __('Medium', 'yayforms'),
            'option_large'     => __('Large', 'yayforms'),
            'option_right'     => __('Right', 'yayforms'),
            'option_left'      => __('Left', 'yayforms'),
        ),
    ));
}
add_action('admin_enqueue_scripts', 'yayforms_enqueue_admin_styles');
