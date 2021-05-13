<?php

//標準機能

function my_setup() {
    add_theme_support("post-thumbnails"); /*アイキャッチ*/
    add_theme_support("title-tag"); /*タイトルタグ自動生成*/
    add_theme_support("html5", array(
        "search-form",
        "comment-form",
        "comment-list",
        "gallery",
        "caption",
    ));
}
add_action("after_setup_theme", "my_setup");

//CSS / JavaScriptの読み込み

function my_script_init() {
    wp_enqueue_style("reset-name", get_template_directory_uri(). "/css/reset.css", array(), "1.0.0", "all");
    wp_enqueue_style("style-name", get_template_directory_uri(). "/style.css", array(), "1.0.0", "all");
    if(is_page(5) || is_page(9)) {
        wp_enqueue_style("inquery-name", get_template_directory_uri(). "/css/inquery.css", array(), "1.0.0", "all");
    }
    wp_enqueue_style("breadcrumb-name", get_template_directory_uri(). "/css/breadcrumb.css", array(), "1.0.0", "all");
    if(is_page(21)) {
        wp_enqueue_style("page-blog-name", get_template_directory_uri(). "/css/page-blog.css", array(), "1.0.0", "all");
    }
    if(is_single()) {
        wp_enqueue_style("single-name", get_template_directory_uri(). "/css/single.css", array(), "1.0.0", "all");
    }
    wp_enqueue_script("script-name", get_template_directory_uri(). "/js/script.js", array(), "1.0.0", true);
    wp_enqueue_script("wow-name", get_template_directory_uri(). "/js/wow.min.js", array(), "1.0.0", true);
}
add_action("wp_enqueue_scripts", "my_script_init");

//投稿スラッグ英字自動切換え

function auto_post_slug( $slug, $post_ID, $post_status, $post_type ) {
    if ( preg_match( '/(%[0-9a-f]{2})+/', $slug ) ) {
    $slug = utf8_uri_encode( $post_type ) . '-' . $post_ID;
    }
    return $slug;
    }
    add_filter( 'wp_unique_post_slug', 'auto_post_slug', 10, 4 );

//アイキャッチ画像有効化

global $NO_IMAGE_URL;

$NO_IMAGE_URL = '/image/noimg.png';

add_theme_support('post-thumbnails');//アイキャッチを有効化

//文字数の設定

function max_excerpt_length($string, $maxLength) {
    $length = mb_strlen($string, 'UTF-8');
    if($length < $maxLength) {
        return $string;
    } else {
        $string = mb_substr($string, 0, $maxLength, 'UTF-8');
        return $string.'[...]';
    }
}

//ページネーション
/*
使い方↓
$page_url = $_SERVER['REQUEST_URL'];//ページurlを取得
$page_url = strtok($page_url, '?');//パラメータは切り捨て
pagination($the_query->max_num_pages, $the_category_id, $paged, $page_url);

引数↓
@ $pages =>      ページ数
@ $term_id =>    タクソノミーID
@ $paged =>      現在のページ
@ $page_url =>   ページURL
@ $range =>      前後に何ページ分表示するか　(引数がなければ2ページ表示する)
*/

/*ページネーション
---------------------------------------------------------*/
/*
使い方↓
$page_url = $_SERVER['REQUEST_URI'];//ページurlを取得
$page_url = strtok( $page_url, '?' );//パラメータは切り捨て
pagination($the_query->max_num_pages, $the_category_id, $paged, $page_url);

引数↓
@ $pages =>     ページ数
@ $term_id =>   タクソノミーID
@ $paged =>     現在のページ
@ $page_url =>  ページURL
@ $range =>     前後に何ページ分表示するか（引数が無ければ2ページ表示する）
*/
function pagination( $pages, $term_id, $paged, $page_url, $range = 2) {

    $pages = ( int ) $pages;//全てのページ数。float型で渡ってくるので明示的に int型 へ
    $paged = $paged ?: 1;//現在のページ
    $term_id = ( $term_id ) ? $term_id : 0;//タームID
    $s = $_GET['s'];//検索ワードを取得
    $search = ($s) ? '&s='.$s : '';//検索パラメータを制作
  
    if ($pages === 1 ) {
        // 1ページ以上の時 => 出力しない
        return;
    };
  
    if ( 1 !== $pages ) {
        //２ページ以上の時
        echo '<div class="inner">';
        if ( $paged > $range + 1 ) {
                  // 一番初めのページへのリンク
                  echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum=1'.$search.'"><span>1</span></a></div>';
          echo '<div class="dots"><span>...</span></div>';
              };
        for ( $i = 1; $i <= $pages; $i++ ) {
          //ページ番号の表示
          if ( $i <= $paged + $range && $i >= $paged - $range ) {
            if ( $paged == $i ) {
              //現在表示しているページ
              echo '<div class="number -current"><span>'.$i.'</span></div>';
            } else {
              //前後のページ
              echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum='.$i.$search.'"><span>'.$i.'</span></a></div>';
            };
          };
        };
        if ( $paged < $pages - $range ) {
                  // 一番最後のページへのリンク
          echo '<div class="dots"><span>...</span></div>';
          echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum='. $pages.$search.'"><span>'. $pages .'</span></a></div>';
        }
        echo '</div>';
    };
  };

  /*パンくず
--------------------------------------------------------- */
function breadcrumb($postID) {
    $title = get_the_title($postID);//記事タイトル
    echo '<ol class="breadcrumb-list">';
    if ( is_single() ) {
      //詳細ページの場合
      echo '<li class="breadcrumb-item"><a href="/">ホーム</a></li>';
      echo '<li class="breadcrumb-item"><a href="/blog/">ブログ</a></li>';
      echo '<li class="breadcrumb-item" aria-current="page">'.$title.'</li>';
    }
    else if( is_page() ) {
      //固定ページの場合
      echo '<li class="breadcrumb-item"><a href="/">ホーム</a></li>';
      echo '<li class="breadcrumb-item" aria-current="page">'.$title.'</li>';
    }
    echo "</ol>";
  }