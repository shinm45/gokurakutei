<?php get_header(); ?>

<?php
$paged = $_GET['pagenum'];
global $NO_IMAGE_URL;
?>

<div class="blog-top"></div>

<section class=" cmn-section -black">
    <?php if( !(is_home() || is_front_page() )): ?>
        <div class="breadcrumb-area">
            <?php
                if ( function_exists( 'bcn_display' ) ) {
                bcn_display();
                }
            ?>
        </div>
    <?php endif; ?>

        <h2 class="cmn-title">
            <span class="main">ブログ</span>
            <span class="sub">blog</span>
        </h2>


    <div class="article-cont">
        <ul class="article-list">
        <?php
        $query_args = array(
            'post_status'=> 'publish',
            'post_type'=> 'post',
            'order'=>'DESC',
            'posts_per_page'=>10,
            'paged'=>$paged
        );
        $the_query = new WP_Query( $query_args );
        if ( $the_query->have_posts() ) :
            while ( $the_query->have_posts() ) :
                $the_query->the_post();
                $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;
                $title = max_excerpt_length(get_the_title( $post->ID ), 60);//記事タイトルを取得し、文字数を制限（functions.php）
                $desc = get_the_excerpt( $post->ID );//抜粋を取得
                $data = get_the_modified_date( 'Y-m-d', $post->ID );//更新日を取得
                $category = get_the_category( $post->ID )[0]->name;//カテゴリを取得（並び順で1番目にあるものを1つ）
                $link = get_permalink( $post->ID );
        ?>
        <li class="article-item">
            <a href="<?php echo $link;?>">
                <div class="article-text">
                    <p class="time"><time datetime="<?php echo $data;?>"><?php echo $data;?></time></p>
                    <div class="title"> <?php echo $title;?></div>
                    <div class="desc"><?php echo $desc;?></div>
                </div>
                <div class="article-image">
                    <?php
                    if( $category ){
                        echo '<p class="category">'.$category.'</p>';
                    };
                    ?>
                    <p class="image"><img src="<?php echo $thumbnail;?>" alt=""></p>
                </div>
            </a>
        </li>
        <?php
            endwhile;
        endif;
        wp_reset_query();//クエリをリセット
        ?>
        </ul>
    </div>
    <div class="article-pager">
<?php
$page_url = $_SERVER['REQUEST_URI'];//ページurlを取得
$page_url = strtok( $page_url, '?' );//パラメータは切り捨て
$the_category_id = null;
pagination($the_query->max_num_pages, $the_category_id, $paged, $page_url);//ページネーションを表示（functions.php）
?>
            </div>
</section>
<?php get_footer(); ?>