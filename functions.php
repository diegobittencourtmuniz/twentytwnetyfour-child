<?php


// enqueue parent styles -
function enqueue_parent_styles() {
wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
//wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );
}
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );


add_action( 'wp_enqueue_scripts', 'enqueue_consent_banner_script' );
function enqueue_consent_banner_script() {
    wp_enqueue_script( 'consent-banner-script', get_stylesheet_directory_uri() . '/consent-banner.php', array(), '1.0.0', true );
}


function custom_css() {
  if (strpos(get_site_url(), 'lucymesquita.store') !== false) {
    wp_enqueue_style( 'lucymesquita-custom', get_stylesheet_directory_uri() . '/lucymesquita.css' );
  } else 
  if (strpos(get_site_url(), 'rosadaurora.com') !== false) {
    wp_enqueue_style( 'rosa-custom', get_stylesheet_directory_uri() . '/rosadaurora.css' );
  }
}
add_action( 'wp_enqueue_scripts', 'custom_css' );

function my_theme_scripts() {
  // Lottie Animation Player
  wp_enqueue_script( 'lottie-player', 'https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js', array(), 'latest', true );
}

add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );

function my_login_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo_url = ''; // Initialize to empty string

    if ($custom_logo_id) {  // Simplified check
        $image = wp_get_attachment_image_src($custom_logo_id, 'full');
        if ($image) { // Check if image data was retrieved
          $logo_url = esc_url($image[0]);
        }
    }

    if (empty($logo_url)) { // Use empty() to check if logo_url is still empty
        $logo_url = get_stylesheet_directory_uri() . '/images/site-login-logo.png';
    }
    ?>
    <style type="text/css">
        #login h1 a {
            background-image: url(<?php echo $logo_url; ?>);
            width: 320px;
            background-repeat: no-repeat;
            margin: 0;
        }
    </style>
    <?php
}
add_action('login_enqueue_scripts', 'my_login_logo');

function enqueue_google_tag_manager() {
  // Replace G-RTH9YLD5T3 with your actual GTM container ID
  $container_id = 'G-RTH9YLD5T3';
  $script_url = "https://www.googletagmanager.com/gtag/js?id=$container_id";

  // Enqueue GTM script with async attribute
  wp_enqueue_script( 'google-analytics', $script_url, array(), '1.0', true );

  // Inline script for dataLayer and gtag initialization (optional)
  if ( ! current_user_can( 'administrator' ) ) {  // Only add inline script on non-admin pages
    ?>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?= $container_id; ?>');
    </script>
    <?php
  }
}

add_action( 'wp_enqueue_scripts', 'enqueue_google_tag_manager' );






/* codigo para Open Web Analytics pegar Perspectiva e Rosa da Aurora no mesmo child-theme
e para o script ser mostrado so na URL equivalente */

function enqueue_owa_script() {
    wp_enqueue_script( 'owa-tracker', 'https://analytics.perspectivaempreendedora.com/modules/base/dist/owa.tracker.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_owa_script' );

function initialize_owa() {
    $site_id = '';

    if (strpos($_SERVER['HTTP_HOST'], 'perspectivaempreendedora.com') !== false) {
        $site_id = '9cbe758bcaaa43eac13a50799aaac7fb';
    } elseif (strpos($_SERVER['HTTP_HOST'], 'rosadaurora.com') !== false) {
        $site_id = '37e994fc7b721df6ec9b6c464b2ee421';
    }
    elseif (strpos($_SERVER['HTTP_HOST'], 'lucymesquita.store') !== false) {
        $site_id = 'e3d68ca4aa60a4480c0724ae9fa13cd4';
    }

    if ($site_id) {
        ?>
        <script type="text/javascript">
        //<![CDATA[
        var owa_baseUrl = 'https://analytics.perspectivaempreendedora.com/';
        var owa_cmds = owa_cmds || [];
        owa_cmds.push(['setSiteId', '<?php echo $site_id; ?>']);
        owa_cmds.push(['trackPageView']);
        owa_cmds.push(['trackClicks']);
        //]]>
        </script>
        <?php
    }
}
add_action( 'wp_head', 'initialize_owa' );


function allow_svg_upload($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');


function register_custom_post_types() {
    $custom_post_types = [
        'team' => [
            'labels' => [
                'name' => __('Equipe', 'your-theme-textdomain'),
                // ... other labels
            ],
            'menu_icon'           => 'dashicons-groups',
            // ... other arguments
        ],
        'lyrics' => [
            'labels' => [
                'name' => __('Letras', 'your-theme-textdomain'),
                // ... other labels
            ],
            'menu_icon'           => 'dashicons-welcome-write-blog',
            // ... other arguments
        ],
        'webdesign' => [
            'labels' => [
                'name' => __('Web Design', 'textdomain'),
                'singular_name' => __('Web Design', 'textdomain'),
            ],

            // ... other arguments
        ],
        'mei' => [
            'labels' => [
                'name' => __('MEI'),
                'singular_name' => __('MEI')
            ],

            // ... other arguments
        ],
        'empreendedorismo' => [
            'labels' => [
                'name' => __('Empreendedorismo'),
                'singular_name' => __('Empreendedorismo')
            ],

            // ... other arguments
        ],
        'marketing' => [
            'labels' => [
                'name' => __('Marketing'),
                'singular_name' => __('Marketing')
            ],
            'menu_icon' => 'dashicons-chart-bar',
            // ... other arguments
        ],
        'books' => [
            'labels' => [
                'name' => __('Livros', 'textdomain'),
                'singular_name' => __('Livros', 'textdomain'),
                // ... other labels
            ],
            
            'menu_icon'           => 'dashicons-book',
        ],
    ];

    foreach ($custom_post_types as $post_type => $args) {
        $args = wp_parse_args($args, [
            'public' => true,
            'has_archive' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => ['slug' => $post_type],
            'show_in_rest' => true, // to appear in the new block editor
            'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'], // 'editor' is necessary to appear the new block editor
        ]);

        register_post_type($post_type, $args);
    }
}

add_action('init', 'register_custom_post_types');
