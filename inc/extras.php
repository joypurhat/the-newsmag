<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package The NewsMag
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function the_newsmag_body_classes($classes) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    return $classes;
}

add_filter('body_class', 'the_newsmag_body_classes');

/*
 * Display the date in the header
 */
if (!function_exists('the_newsmag_date_display')) :

    function the_newsmag_date_display() {
        ?>
        <div class="date-in-header">
            <?php echo date_i18n('l, F j, Y'); ?>
        </div>
        <?php
    }

endif;

/*
 * Creating Social Menu
 */
if (!function_exists('the_newsmag_social_menu')) :

    function the_newsmag_social_menu() {
        if (has_nav_menu('social')) {
            wp_nav_menu(
                    array(
                        'theme_location' => 'social',
                        'container' => 'div',
                        'container_class' => 'the-newsmag-social-menu',
                        'depth' => 1,
                        'menu_class' => 'menu-social',
                        'fallback_cb' => false,
                        'link_before' => '<span class="screen-reader-text">',
                        'link_after' => '</span>',
                        'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                    )
            );
        }
    }

endif;

add_action('the_newsmag_footer_copyright', 'the_newsmag_footer_copyright', 10);
/**
 * function to show the footer info, copyright information
 */
if (!function_exists('the_newsmag_footer_copyright')) :

    function the_newsmag_footer_copyright() {
        $site_link = '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name', 'display')) . '" ><span>' . get_bloginfo('name', 'display') . '</span></a>';

        $wp_link = '<a href="http://wordpress.org" target="_blank" title="' . esc_attr__('WordPress', 'the-newsmag') . '"><span>' . esc_html__('WordPress', 'the-newsmag') . '</span></a>';

        $my_link_name = '<a href="http://napitwptech.com" target="_blank" title="' . esc_attr__('Bishal Napit', 'the-newsmag') . '"><span>' . esc_html__('Bishal Napit', 'the-newsmag') . '</span></a>';

        $default_footer_value = sprintf(esc_html__('Copyright &copy; %1$s %2$s. All rights reserved.', 'the-newsmag'), date('Y'), $site_link) . '<br />' . sprintf(esc_html__('Theme: %1$s by %2$s.', 'the-newsmag'), esc_html__('The NewsMag', 'the-newsmag'), $my_link_name) . ' ' . sprintf(esc_html__('Powered by %s.', 'the-newsmag'), $wp_link);

        $the_newsmag_footer_copyright = '<div class="footer-copyright">' . $default_footer_value . '</div>';
        echo wp_kses_post($the_newsmag_footer_copyright);
    }

endif;

add_filter('body_class', 'the_newsmag_body_class');

/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function the_newsmag_body_class($classes) {
    // custom layout options for posts and pages
    global $post;

    if ($post) {
        $the_newsmag_layout_meta = get_post_meta($post->ID, 'the_newsmag_page_layout', true);
    }

    if (is_home()) {
        $queried_id = get_option('page_for_posts');
        $the_newsmag_layout_meta = get_post_meta($queried_id, 'the_newsmag_page_layout', true);
    }

    if (empty($the_newsmag_layout_meta) || is_archive() || is_search() || is_404()) {
        $the_newsmag_layout_meta = 'default_layout';
    }

    $the_newsmag_default_layout = get_theme_mod('the_newsmag_default_layout', 'right_sidebar');
    $the_newsmag_default_page_layout = get_theme_mod('the_newsmag_default_page_layout', 'right_sidebar');
    $the_newsmag_default_post_layout = get_theme_mod('the_newsmag_default_single_posts_layout', 'right_sidebar');

    if ($the_newsmag_layout_meta == 'default_layout') {
        if (is_page()) {
            if ($the_newsmag_default_page_layout == 'right_sidebar') {
                $classes[] = 'right-sidebar';
            } elseif ($the_newsmag_default_page_layout == 'left_sidebar') {
                $classes[] = 'left-sidebar';
            } elseif ($the_newsmag_default_page_layout == 'no_sidebar_full_width') {
                $classes[] = 'no-sidebar-full-width';
            } elseif ($the_newsmag_default_page_layout == 'no_sidebar_content_centered') {
                $classes[] = 'no-sidebar-content-centered';
            }
        } elseif (is_single()) {
            if ($the_newsmag_default_post_layout == 'right_sidebar') {
                $classes[] = 'right-sidebar';
            } elseif ($the_newsmag_default_post_layout == 'left_sidebar') {
                $classes[] = 'left-sidebar';
            } elseif ($the_newsmag_default_post_layout == 'no_sidebar_full_width') {
                $classes[] = 'no-sidebar-full-width';
            } elseif ($the_newsmag_default_post_layout == 'no_sidebar_content_centered') {
                $classes[] = 'no-sidebar-content-centered';
            }
        } elseif ($the_newsmag_default_layout == 'right_sidebar') {
            $classes[] = 'right-sidebar';
        } elseif ($the_newsmag_default_layout == 'left_sidebar') {
            $classes[] = 'left-sidebar';
        } elseif ($the_newsmag_default_layout == 'no_sidebar_full_width') {
            $classes[] = 'no-sidebar-full-width';
        } elseif ($the_newsmag_default_layout == 'no_sidebar_content_centered') {
            $classes[] = 'no-sidebar-content-centered';
        }
    } elseif ($the_newsmag_layout_meta == 'right_sidebar') {
        $classes[] = 'right-sidebar';
    } elseif ($the_newsmag_layout_meta == 'left_sidebar') {
        $classes[] = 'left-sidebar';
    } elseif ($the_newsmag_layout_meta == 'no_sidebar_full_width') {
        $classes[] = 'no-sidebar-full-width';
    } elseif ($the_newsmag_layout_meta == 'no_sidebar_content_centered') {
        $classes[] = 'no-sidebar-content-centered';
    }

    // custom layout option for site
    if (get_theme_mod('the_newsmag_site_layout', 'wide_layout') == 'wide_layout') {
        $classes[] = 'wide';
    } elseif (get_theme_mod('the_newsmag_site_layout', 'wide_layout') == 'boxed_layout') {
        $classes[] = 'boxed';
    }

    return $classes;
}

/*
 * function to display the sidebar according to layout choosed
 */
if (!function_exists('the_newsmag_sidebar_select')) :

    function the_newsmag_sidebar_select() {
        global $post;

        if ($post) {
            $the_newsmag_layout_meta = get_post_meta($post->ID, 'the_newsmag_page_layout', true);
        }

        if (is_home()) {
            $queried_id = get_option('page_for_posts');
            $the_newsmag_layout_meta = get_post_meta($queried_id, 'the_newsmag_page_layout', true);
        }

        if (empty($the_newsmag_layout_meta) || is_archive() || is_search() || is_404()) {
            $the_newsmag_layout_meta = 'default_layout';
        }

        $the_newsmag_default_layout = get_theme_mod('the_newsmag_default_layout', 'right_sidebar');
        $the_newsmag_default_page_layout = get_theme_mod('the_newsmag_default_page_layout', 'right_sidebar');
        $the_newsmag_default_post_layout = get_theme_mod('the_newsmag_default_single_posts_layout', 'right_sidebar');

        if ($the_newsmag_layout_meta == 'default_layout') {
            if (is_page()) {
                if ($the_newsmag_default_page_layout == 'right_sidebar') {
                    get_sidebar();
                } elseif ($the_newsmag_default_page_layout == 'left_sidebar') {
                    get_sidebar('left');
                }
            } elseif (is_single()) {
                if ($the_newsmag_default_post_layout == 'right_sidebar') {
                    get_sidebar();
                } elseif ($the_newsmag_default_post_layout == 'left_sidebar') {
                    get_sidebar('left');
                }
            } elseif ($the_newsmag_default_layout == 'right_sidebar') {
                get_sidebar();
            } elseif ($the_newsmag_default_layout == 'left_sidebar') {
                get_sidebar('left');
            }
        } elseif ($the_newsmag_layout_meta == 'right_sidebar') {
            get_sidebar();
        } elseif ($the_newsmag_layout_meta == 'left_sidebar') {
            get_sidebar('left');
        }
    }

endif;

add_action('wp_head', 'the_newsmag_custom_css');

/**
 * Hooks the Custom Internal CSS to head section
 */
function the_newsmag_custom_css() {
    // custom CSS codes goes here
    $the_newsmag_custom_css = get_theme_mod('the_newsmag_custom_css', '');
    if (!empty($the_newsmag_custom_css)) {
        echo '<!-- ' . get_bloginfo('name') . ' Custom Styles -->';
        ?><style type="text/css"><?php echo esc_html($the_newsmag_custom_css); ?></style><?php
    }
}

/*
 * Random Post in header
 */
if (!function_exists('the_newsmag_random_post')) :

    function the_newsmag_random_post() {

        $get_random_post = new WP_Query(array(
            'posts_per_page' => 1,
            'post_type' => 'post',
            'ignore_sticky_posts' => true,
            'orderby' => 'rand'
        ));
        ?>
        <?php while ($get_random_post->have_posts()):$get_random_post->the_post(); ?>
            <?php return '<a href="' . esc_url(get_the_permalink()) . '" title="' . esc_html__('Random Post', 'the-newsmag') . '" class="random-post"><i class="fa fa-random"></i></a>'; ?>
        <?php endwhile; ?>
        <?php
        // Reset Post Data
        wp_reset_postdata();
    }

endif;

/*
 * Category Color Options
 */
if (!function_exists('the_newsmag_category_color')) :

    function the_newsmag_category_color($wp_category_id) {
        $args = array(
            'orderby' => 'id',
            'hide_empty' => 0
        );
        $category = get_categories($args);
        foreach ($category as $category_list) {
            $color = get_theme_mod('the_newsmag_category_color_' . $wp_category_id);
            return esc_attr($color);
        }
    }

endif;

/*
 * Category Color display
 */
if (!function_exists('the_newsmag_colored_category')) :

    function the_newsmag_colored_category($color = true) {
        global $post;
        $categories = get_the_category();
        $separator = '&nbsp;';
        $output = '';
        if ($categories) {
            foreach ($categories as $category) {
                $color_code = the_newsmag_category_color(get_cat_id($category->cat_name));
                if (!empty($color_code)) {
                    $output .= '<a href="' . get_category_link($category->term_id) . '" style="background:' . the_newsmag_category_color(get_cat_id($category->cat_name)) . '" rel="category tag">' . $category->cat_name . '</a>' . $separator;
                } else {
                    $output .= '<a href="' . get_category_link($category->term_id) . '"  rel="category tag">' . $category->cat_name . '</a>' . $separator;
                }
            }
            if ($color == false) {
                $output = trim($output, $separator);
            }
            if ($color == true) {
                echo trim($output, $separator);
            }
        }
        if ($color == false) {
            return $output;
        }
    }

endif;

/**
 * adding the hooks to filter the single category title to display the colored category title
 */
if (!function_exists('the_newsmag_colored_category_title')) :

    function the_newsmag_colored_category_title($title) {
        $color_value = the_newsmag_category_color(get_cat_id($title));
        $color_border_value = the_newsmag_category_color(get_cat_id($title));
        if (!empty($color_value)) {
            return '<h1 class="page-title" style="border-bottom: 4px solid' . esc_attr($color_border_value) . '">' . '<span style="background: ' . esc_attr($color_value) . '">' . sprintf(esc_html__('Category: %s', 'the-newsmag'), $title) . '</span></h1>';
        } else {
            return '<h1 class="page-title"><span>' . sprintf(esc_html__('Category: %s', 'the-newsmag'), $title) . '</span></h1>';
        }
    }

endif;

/*
 * Adding the custom function to filter the category title
 */

function the_newsmag_category_title_function($category_title) {
    add_filter('single_cat_title', 'the_newsmag_colored_category_title');
}

add_action('the_newsmag_category_title', 'the_newsmag_category_title_function');

/**
 * Controlling the excerpt length
 */
function the_newsmag_excerpt_length($length) {
    return 75;
}

add_filter('excerpt_length', 'the_newsmag_excerpt_length');

/**
 * Controlling the excerpt string
 */
function the_newsmag_excerpt_string($more) {
    return '&hellip;';
}

add_filter('excerpt_more', 'the_newsmag_excerpt_string');

/*
 * Breaking News/Latest Posts ticker section in the header
 */
if (!function_exists('the_newsmag_breaking_news')) :

    function the_newsmag_breaking_news() {
        $get_featured_posts = new WP_Query(array(
            'posts_per_page' => 10,
            'post_type' => 'post',
            'ignore_sticky_posts' => true
        ));
        ?>
        <ul class="latest-news">
            <?php while ($get_featured_posts->have_posts()):$get_featured_posts->the_post(); ?>
                <li class="latest-news-lists">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

                        <?php if (has_post_thumbnail()) : ?>
                            <figure class="featured-image">
                                <?php the_post_thumbnail('the-newsmag-featured-small-thumbnail'); ?>
                            </figure>
                        <?php endif; ?>
                        <span class="entry-title"><?php the_title(); ?></span>
                        <?php the_newsmag_date_only(); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
        <?php
        // Reset Post Data
        wp_reset_query();
    }

endif;

// function to display the post date only
if (!function_exists('the_newsmag_date_only')) :

    function the_newsmag_date_only() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf($time_string, esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_attr(get_the_modified_date('c')), esc_html(get_the_modified_date())
        );

        echo $time_string;
    }

endif;

/*
 * Display the related posts
 */
if (!function_exists('the_newsmag_related_posts_function')) :

    function the_newsmag_related_posts_function() {
        global $post;

        // Define shared post arguments
        $args = array(
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'ignore_sticky_posts' => 1,
            'orderby' => 'rand',
            'post__not_in' => array($post->ID),
            'posts_per_page' => 3
        );
        // Related by categories
        if (get_theme_mod('the_newsmag_related_posts', 'categories') == 'categories') {

            $cats = get_post_meta($post->ID, 'related-posts', true);

            if (!$cats) {
                $cats = wp_get_post_categories($post->ID, array('fields' => 'ids'));
                $args['category__in'] = $cats;
            } else {
                $args['cat'] = $cats;
            }
        }
        // Related by tags
        if (get_theme_mod('the_newsmag_related_posts', 'categories') == 'tags') {

            $tags = get_post_meta($post->ID, 'related-posts', true);

            if (!$tags) {
                $tags = wp_get_post_tags($post->ID, array('fields' => 'ids'));
                $args['tag__in'] = $tags;
            } else {
                $args['tag_slug__in'] = explode(',', $tags);
            }
            if (!$tags) {
                $break = true;
            }
        }

        $query = !isset($break) ? new WP_Query($args) : new WP_Query;
        return $query;
    }

endif;

if (!function_exists('the_newsmag_posts_posted_on')) :

    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function the_newsmag_posts_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf($time_string, esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_attr(get_the_modified_date('c')), esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
                esc_html_x('%s', 'post date', 'the-newsmag'), '<a href="' . esc_url(get_permalink()) . '" rel="bookmark"><i class="fa fa-calendar"></i></a>' . '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        $byline = sprintf(
                esc_html_x('%s', 'post author', 'the-newsmag'), '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . get_avatar(get_the_author_meta('user_email'), '25') . '</a>' . '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>';

        echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

        echo '<span class="comments-link">';
        comments_popup_link(wp_kses(__('<i class="fa fa-comment"></i>Leave a reply', 'the-newsmag'), array('i' => array('class' => array()))), wp_kses(__('<i class="fa fa-comment"></i>1 Comment', 'the-newsmag'), array('i' => array('class' => array()))), wp_kses(__('<i class="fa fa-comment"></i>% Comments', 'the-newsmag'), array('i' => array('class' => array()))), '', wp_kses(__('<i class="fa fa-comment"></i>Comments Disabled', 'the-newsmag'), array('i' => array('class' => array()))));
        echo '</span>';
    }

endif;

/**
 * function to display the author bio
 */
if (!function_exists('the_newsmag_author_bio')) :

    function the_newsmag_author_bio() {
        if (get_the_author_meta('description')) :
            ?>
            <div class="author-box">
                <div class="author-img"><?php echo get_avatar(get_the_author_meta('user_email'), '100'); ?></div>
                <h4 class="author-name"><?php esc_html(the_author_meta('display_name')); ?></h4>
                <p class="author-description"><?php esc_textarea(the_author_meta('description')); ?></p>
                <?php
                if (get_theme_mod('the_newsmag_author_bio_social_links', 0) == 1) {
                    the_newsmag_author_bio_links();
                }
                ?>
            </div>
            <?php
        endif;
    }

endif;

/**
 * function to add the social links in the Author Bio section
 */
if (!function_exists('the_newsmag_author_bio_links')) :

    function the_newsmag_author_bio_links() {
        $author_name = get_the_author_meta('display_name');

        // pulling the author social links url which are provided through WordPress SEO and All In One SEO Pack plugin
        $author_facebook_link = get_the_author_meta('facebook');
        $author_twitter_link = get_the_author_meta('twitter');
        $author_googleplus_link = get_the_author_meta('googleplus');

        if ($author_twitter_link || $author_googleplus_link || $author_facebook_link) {
            echo '<div class="author-social-links">';
            printf(esc_html__('Follow %s on:', 'the-newsmag'), $author_name);
            if ($author_facebook_link) {
                echo '<a href="' . esc_url($author_facebook_link) . '" title="' . esc_html__('Facebook', 'the-newsmag') . '" target="_blank"><i class="fa fa-facebook"></i><span class="screen-reader-text">' . esc_html__('Facebook', 'the-newsmag') . '</span></a>';
            }
            if ($author_twitter_link) {
                echo '<a href="https://twitter.com/' . esc_attr($author_twitter_link) . '" title="' . esc_html__('Twitter', 'the-newsmag') . '" target="_blank"><i class="fa fa-twitter"></i><span class="screen-reader-text">' . esc_html__('Twitter', 'the-newsmag') . '</span></a>';
            }
            if ($author_googleplus_link) {
                echo '<a href="' . esc_url($author_googleplus_link) . '" title="' . esc_html__('Google Plus', 'the-newsmag') . '" rel="author" target="_blank"><i class="fa fa-google-plus"></i><span class="screen-reader-text">' . esc_html__('Google Plus', 'the-newsmag') . '</span></a>';
            }
            echo '</div>';
        }
    }

endif;

// link post format support added
if (!function_exists('the_newsmag_link_post_format')) :

    function the_newsmag_link_post_format() {
        if (!preg_match('/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches))
            return false;

        return esc_url_raw($matches[1]);
    }

endif;

// status post format support added
if (!function_exists('the_newsmag_status_post_format_first_paragraph')) :

    function the_newsmag_status_post_format_first_paragraph() {
        $first_paragraph_str = wpautop(get_the_content());
        $first_paragraph_str = substr($first_paragraph_str, 0, strpos($first_paragraph_str, '</p>') + 4);
        $first_paragraph_str = strip_tags($first_paragraph_str, '<a><strong><em>');
        return '<p>' . $first_paragraph_str . '</p>';
    }

endif;

if (!function_exists('the_newsmag_status_post_format_avatar_image')) :

    function the_newsmag_status_post_format_avatar_image() {
        return get_avatar(get_the_author_meta('user_email'), '75');
    }

endif;

// quote post format support added
if (!function_exists('the_newsmag_quote_post_format_blockquote')) :

    function the_newsmag_quote_post_format_blockquote() {

        $document = new DOMDocument();
        $content = apply_filters('the_content', get_the_content('', true));
        $output = '';
        if ('' != $content) {
            libxml_use_internal_errors(true);
            $document->loadHTML(mb_convert_encoding($content, 'html-entities', 'utf-8'));
            libxml_clear_errors();
            $blockquotes = $document->getElementsByTagName('blockquote');
            if ($blockquotes->length) {
                $blockquote = $blockquotes->item(0);
                $document = new DOMDocument();
                $document->appendChild($document->importNode($blockquote, true));
                $output .= $document->saveHTML();
            }
        }
        return wpautop($output);
    }

endif;

// audio and video post format support added
if (!function_exists('the_newsmag_audio_video_post_format')) :

    function the_newsmag_audio_video_post_format() {
        $document = new DOMDocument();
        $content = apply_filters('the_content', get_the_content('', true));
        if ('' != $content) {
            libxml_use_internal_errors(true);
            $document->loadHTML($content);
            libxml_clear_errors();
            $iframes = $document->getElementsByTagName('iframe');
            $objects = $document->getElementsByTagName('object');
            $embeds = $document->getElementsByTagName('embed');
            $document = new DOMDocument();
            if ($iframes->length) {
                $iframe = $iframes->item($iframes->length - 1);
                $document->appendChild($document->importNode($iframe, true));
            } elseif ($objects->length) {
                $object = $objects->item($objects->length - 1);
                $document->appendChild($document->importNode($object, true));
            } elseif ($embeds->length) {
                $embed = $embeds->item($embeds->length - 1);
                $document->appendChild($document->importNode($embed, true));
            }
            return wpautop($document->saveHTML());
        }
        return false;
    }

endif;

if (!function_exists('the_newsmag_widget_posts_posted_on')) :

    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function the_newsmag_widget_posts_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf($time_string, esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_attr(get_the_modified_date('c')), esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
                esc_html_x('%s', 'post date', 'the-newsmag'), '<a href="' . esc_url(get_permalink()) . '" rel="bookmark"><i class="fa fa-calendar"></i></a>' . '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        $byline = sprintf(
                esc_html_x('%s', 'post author', 'the-newsmag'), '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . get_avatar(get_the_author_meta('user_email'), '25') . '</a>' . '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>';

        echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

        if (!post_password_required() && (comments_open() || get_comments_number())) :
            ?>
            <span class="comments-link">
                <a href="<?php esc_url(comments_link()); ?>" class="entry-meta-comments">
                    <?php
                    printf(_nx('<i class="fa fa-comment"></i> 1', '<i class="fa fa-comment"></i> %1$s', get_comments_number(), 'comments title', 'the-newsmag'), number_format_i18n(get_comments_number()));
                    ?>
                </a>
            </span>
            <?php
        endif;
    }

endif;
