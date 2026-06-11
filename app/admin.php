<?php

namespace App;

/**
 * Custom WordPress Admin for Client
 */

/**
 * 1. Role and User Management
 */
add_action('init', function () {
    // Add custom role or get it if it exists
    $role = get_role('client_viewer');
    
    if (!$role) {
        $role = add_role('client_viewer', 'Medicall Viewer', ['read' => true]);
    }

    // Ensure it has ONLY read cap
    $all_caps = $role->capabilities;
    foreach ($all_caps as $cap => $value) {
        if ($cap !== 'read') {
            $role->remove_cap($cap);
        }
    }
    $role->add_cap('read');

    // Create client user if it doesn't exist
    if (! username_exists('medic_client')) {
        $user_id = wp_create_user('medic_client', 'client123', 'client@medicall.com');
        $user = new \WP_User($user_id);
        $user->set_role('client_viewer');
    }
});

/**
 * 2. Custom Login URL (/login)
 * Using direct interception to avoid mandatory permalink flushing issues.
 */
add_action('init', function () {
    if (is_admin()) return;

    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $path = trim(parse_url($request_uri, PHP_URL_PATH), '/');

    if ($path === 'login') {
        require_once ABSPATH . 'wp-login.php';
        exit;
    }
});

add_filter('site_url', function ($url, $path, $scheme, $blog_id) {
    if ($path === 'wp-login.php' && $scheme === 'login_post') {
        return str_replace('wp-login.php', 'login', $url);
    }
    return $url;
}, 10, 4);

add_filter('login_url', function ($login_url, $redirect, $force_reauth) {
    return home_url('/login');
}, 10, 3);

/**
 * 3. Custom Login Logo
 */
add_action('login_enqueue_scripts', function () {
    $logo_url = wp_get_attachment_url(31); // Media ID 31
    if (! $logo_url) {
        return;
    }
    ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo $logo_url; ?>);
            height: 100px;
            width: 320px;
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
        body.login {
            background: #f9fcff;
        }
        .login #login_error, .login .message, .login .success {
            border-left: 4px solid #0e82fd;
        }
        .wp-core-ui .button-primary {
            background: #0e82fd !important;
            border-color: #0e82fd !important;
            border-radius: 8px !important;
            padding: 0 24px !important;
            font-weight: 600 !important;
        }
    </style>
    <?php
});

add_filter('login_headerurl', function () {
    return home_url();
});

add_filter('login_headertext', function () {
    return get_bloginfo('name');
});

/**
 * 4. Menu Restrictions
 */
add_action('admin_menu', function () {
    if (! current_user_can('client_viewer')) {
        return;
    }

    // remove_menu_page('index.php'); // Comentamos esto para que el dashboard sea visible
    remove_menu_page('edit-comments.php');
    remove_menu_page('themes.php');
    remove_menu_page('plugins.php');
    remove_menu_page('users.php');
    remove_menu_page('tools.php');
    remove_menu_page('options-general.php');
    remove_menu_page('carbon-fields-options');
    remove_menu_page('edit.php?post_type=acf-field-group');
}, 999);

/**
 * 5. Custom Dashboard
 */
add_action('wp_dashboard_setup', function () {
    if (! current_user_can('client_viewer')) {
        return;
    }

    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']);

    wp_add_dashboard_widget('medicall_dashboard', 'Welcome to Medicall', function () {
        ?>
        <div class="medicall-dashboard-widget">
            <h1 style="color: #012047; font-size: 24px; margin-bottom: 20px;">Medicall Administration</h1>
            <p style="font-size: 16px; color: #465d7c; line-height: 1.6;">
                Welcome to your website administration panel. From here you can visualize all the information about your medical center.
            </p>
            <div style="margin-top: 30px; display: grid; grid-template-cols: 1fr 1fr; gap: 20px;">
                <div style="background: #f0f7ff; padding: 20px; border-radius: 12px; border-left: 4px solid #0e82fd;">
                    <h3 style="margin-top: 0; color: #012047;">Content</h3>
                    <ul style="margin-bottom: 0;">
                        <li><a href="<?php echo admin_url('edit.php'); ?>">View Blog Posts</a></li>
                        <li><a href="<?php echo admin_url('edit.php?post_type=page'); ?>">View Pages</a></li>
                    </ul>
                </div>
                <div style="background: #f0f7ff; padding: 20px; border-radius: 12px; border-left: 4px solid #0e82fd;">
                    <h3 style="margin-top: 0; color: #012047;">Medical Data</h3>
                    <ul style="margin-bottom: 0;">
                        <li><a href="<?php echo admin_url('edit.php?post_type=doctors'); ?>">View Doctors</a></li>
                        <li><a href="<?php echo admin_url('edit.php?post_type=speciality'); ?>">View Specialities</a></li>
                        <li><a href="<?php echo admin_url('edit.php?post_type=appointments'); ?>">View Appointments</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    });
}, 999);

/**
 * 6. Admin Branding & Styling
 */
add_action('admin_head', function () {
    ?>
    <style>
        /* Typography */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        
        body, #wpadminbar, .wp-core-ui, .foldertree {
            font-family: 'Inter', sans-serif !important;
        }

        /* Colors */
        #adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap {
            background-color: #012047 !important;
        }

        #adminmenu .wp-has-current-submenu .wp-submenu, 
        #adminmenu .wp-has-current-submenu.opensub .wp-submenu, 
        #adminmenu .wp-submenu.sub-open, 
        #adminmenu a.wp-has-current-submenu:focus + .wp-submenu {
            background-color: #000f28 !important;
        }

        #adminmenu li.current a.menu-top, 
        #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, 
        #adminmenu li.wp-has-current-submenu .wp-submenu .wp-submenu-head {
            background-color: #0e82fd !important;
        }

        /* Dashboard Branding */
        #medicall_dashboard {
            border: none;
            box-shadow: 0 4px 20px rgba(1, 32, 71, 0.08);
            border-radius: 15px;
            overflow: hidden;
        }

        #medicall_dashboard h2.hndle {
            background: #012047;
            color: #fff;
            border: none;
            padding: 12px 20px;
        }

        /* Specific viewer user fixes */
        <?php if (current_user_can('client_viewer')) : ?>
            #wp-admin-bar-wp-logo,
            #wp-admin-bar-comments,
            #wp-admin-bar-new-content,
            #wp-admin-bar-updates,
            .update-nag,
            .notice-info,
            #footer-thankyou,
            .page-title-action,
            #major-publishing-actions,
            #minor-publishing-actions,
            .column-posts,
            .row-actions .edit,
            .row-actions .inline,
            .row-actions .trash,
            #import-upload-form,
            .wrap .add-new-h2,
            .wrap .page-title-action,
            .edit-post-header__settings,
            .edit-post-header-toolbar__add-menu,
            .editor-post-publish-panel__header-publish-button,
            .editor-post-publish-button,
            .editor-post-publish-button__button {
                display: none !important;
            }
        <?php endif; ?>
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (current_user_can('client_viewer')) : ?>
                // Prevent form submission if they somehow get to an edit page
                const form = document.getElementById('post');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        alert('You do not have permission to edit content.');
                        return false;
                    });
                }
            <?php endif; ?>
        });
    </script>
    <?php
});

/**
 * 7. Server-side Protection (Strict Read-Only)
 */
add_filter('wp_insert_post_data', function ($data, $postarr) {
    if (current_user_can('client_viewer')) {
        wp_die('You do not have permission to edit content.');
    }
    return $data;
}, 10, 2);

add_action('admin_init', function () {
    if (current_user_can('client_viewer')) {
        // Block "Add New" pages directly
        global $pagenow;
        if ($pagenow === 'post-new.php') {
            wp_die('You do not have permission to create new content.');
        }
    }
});
