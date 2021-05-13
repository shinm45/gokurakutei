<?php
global $post,$_HEADER;

// URLを取得
$http = is_ssl() ? 'https' : 'http' . '://';
$_HEADER['url'] = $http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

//ディスクリプションを取得
$_HEADER['description'] = wp_trim_words ( strip_shortcodes( $post->post_content  ), 55 );

//ogp画像を取得
$_HEADER['og_image'] = get_the_post_thumbnail_url($post->ID);

//ページタイトルを取得
if(is_single() || is_page()) {
    $_HEADER['title'] = (get_the_title($post->ID)) ? get_the_title($post->ID) : get_bloginfo('name');
} else {
    $_HEADER['title'] = get_bloginfo('name');
}

$og_image .= '?' . time(); // UNIXTIMEのタイムスタンプをパラメータとして付与（OGPのキャッシュ対策）

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <link rel="pingback" href="<?php bloginfo("pingback_url"); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <title><?php wp_title("|", true, "right"); ?><?php bloginfo("name"); ?></title>
    <?php wp_head(); ?>
</head>
<body>
    <header class="header">
        <div class="header-fixed">
            <h1 class="header-log"><img src="<?php echo get_template_directory_uri(); ?>/image/logo.png" alt="極楽亭"></h1>
            <button class="nav-btn" type="button" aria-label="メニュー"><span></span><span></span><span></span></button>
        </div>
        <div class="nav header-nav" id="nav">
            <nav class="nav-wrap">
                <ul class="nav-list">
                    <li class="item"><a href="<?php echo home_url()?>">宿泊予約</a></li>
                    <li class="item"><a href="<?php echo home_url()?>">観光情報</a></li>
                    <li class="item"><a href="<?php echo home_url()?>">よくあるご質問</a></li>
                    <li class="item"><a href="<?php echo home_url("/contact/")?>">お問い合わせ</a></li>
                </ul>
            </nav>
        </div>
    </header>
