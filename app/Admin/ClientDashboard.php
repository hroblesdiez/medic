<?php

namespace App\Admin;

class ClientDashboard
{
  private const ROLE = 'client_viewer';

  private const ALLOWED_POST_TYPES = [
    'doctors',
    'appointments',
    'testimonial',
    'faq',
    'speciality',
  ];

  private const VIEWER_CAPS = [
    'read'               => true,
    'edit_posts'         => true,
    'edit_others_posts'  => true,
    'publish_posts'      => false,
    'delete_posts'       => false,
    'manage_options'     => false,
    'edit_theme_options' => false,
    'activate_plugins'   => false,
  ];

  private const MENUS_TO_REMOVE = [
    'index.php',
    'edit.php',
    'upload.php',
    'edit-comments.php',
    'themes.php',
    'plugins.php',
    'users.php',
    'tools.php',
    'options-general.php',
    'carbon-fields-options',
    'edit.php?post_type=acf-field-group',
    'edit.php?post_type=page',
  ];

  public function register(): void
  {
    add_action('init',            [$this, 'registerRole']);
    add_action('admin_menu',      [$this, 'restrictMenu'], 999);
    add_action('admin_init',      [$this, 'blockWriteAccess']);
    add_action('wp_dashboard_setup', [$this, 'setupDashboard'], 999);
    add_action('admin_head',      [$this, 'injectStyles']);
    add_filter('wp_insert_post_data', [$this, 'blockPostSave'], 10, 2);
  }

  public function registerRole(): void
  {
    $role = get_role(self::ROLE);

    if (!$role) {
      add_role(self::ROLE, 'Medicall Viewer', self::VIEWER_CAPS);
      return;
    }

    foreach (self::VIEWER_CAPS as $cap => $grant) {
      $grant ? $role->add_cap($cap) : $role->remove_cap($cap);
    }
  }

  public function restrictMenu(): void
  {
    if (!$this->isViewer()) {
      return;
    }

    foreach (self::MENUS_TO_REMOVE as $menu) {
      remove_menu_page($menu);
    }

    // Remove Media and Posts submenus
    remove_submenu_page('upload.php', 'upload.php');
    remove_submenu_page('edit.php', 'edit.php');
  }

  public function blockWriteAccess(): void
  {
    if (!$this->isViewer()) {
      return;
    }

    global $pagenow;

    if (in_array($pagenow, ['post-new.php', 'post.php'], true)) {
      wp_safe_redirect(admin_url('index.php'));
      exit;
    }
  }

  public function setupDashboard(): void
  {
    if (!$this->isViewer()) {
      return;
    }

    global $wp_meta_boxes;
    $wp_meta_boxes['dashboard'] = [];

    wp_add_dashboard_widget(
      'medicall_overview',
      'Medicall — Content Overview',
      [$this, 'renderDashboardWidget']
    );
  }

  public function renderDashboardWidget(): void
  {
    $sections = [
      'Medical Team' => [
        'doctors'      => 'Doctors',
        'speciality'   => 'Specialities',
      ],
      'Operations' => [
        'appointments' => 'Appointments',
      ],
      'Website Content' => [
        'testimonial'  => 'Testimonials',
        'faq'          => 'FAQ',
      ],
    ];
?>
    <div style="font-family: 'Inter', sans-serif;">
      <p style="color: #465d7c; margin-bottom: 24px; line-height: 1.6;">
        Welcome to your administration panel. Below you can view all the content of your medical center.
      </p>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <?php foreach ($sections as $section => $cpts) : ?>
          <div style="background: #f0f7ff; padding: 20px; border-radius: 12px; border-left: 4px solid #0e82fd;">
            <h3 style="margin: 0 0 12px; color: #012047; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo esc_html($section); ?></h3>
            <ul style="margin: 0; padding: 0; list-style: none;">
              <?php foreach ($cpts as $slug => $label) : ?>
                <li style="margin-bottom: 8px;">
                  <a href="<?php echo esc_url(admin_url("edit.php?post_type={$slug}")); ?>"
                    style="color: #0e82fd; text-decoration: none; font-weight: 600; font-size: 14px;">
                    &rarr; <?php echo esc_html($label); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php
  }

  public function injectStyles(): void
  {
    if (!$this->isViewer()) {
      return;
    }
  ?>
    <style>
      #adminmenu,
      #adminmenu .wp-submenu,
      #adminmenuback,
      #adminmenuwrap {
        background-color: #012047 !important;
      }

      #adminmenu li.current a.menu-top,
      #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu {
        background-color: #0e82fd !important;
      }

      #wp-admin-bar-wp-logo,
      #wp-admin-bar-comments,
      #wp-admin-bar-new-content,
      #wp-admin-bar-updates,
      .update-nag,
      .page-title-action,
      .row-actions .edit,
      .row-actions .inline,
      .row-actions .trash,
      #screen-meta,
      #contextual-help-link-wrap {
        display: none !important;
      }

      #medicall_overview {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(1, 32, 71, .08);
      }

      #medicall_overview h2.hndle {
        background: #012047;
        color: #fff;
        border: none;
        padding: 12px 20px;
      }
    </style>
<?php
  }

  public function blockPostSave(array $data, array $postarr): array
  {
    if ($this->isViewer()) {
      wp_die('You do not have permission to edit content.', 'Forbidden', ['response' => 403]);
    }

    return $data;
  }

  private function isViewer(): bool
  {
    $user = wp_get_current_user();
    return in_array(self::ROLE, (array) $user->roles, true);
  }
}
