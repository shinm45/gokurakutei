<?php get_header(); ?>

<section class="single cmn-section -black">

    <?php if( !(is_home() || is_front_page() )): ?>
        <div class="breadcrumb-area">
            <?php
                breadcrumb($post->ID);
            ?>
        </div>
    <?php endif; ?>
    <div class="inner">
        <div class="blog-detail">
            <?php
            if(have_posts()) :
            while(have_posts()): the_post(); 
                $title = get_the_title();//記事タイトル
                $content = get_the_content();//記事本文
                $category = get_the_category()[0]->name;//カテゴリを取得（並び順で1番目にあるものを1つ）
                $date = get_the_modified_date( 'Y-m-d', $post->ID );//更新日を取得
                $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;//アイキャッチ画像を表示（設定されていない場合はデフォルト画像を表示）
                $thumbID = get_post_thumbnail_id( $postID );//アイキャッチのID
                $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);//アイキャッチIDからaltを取得
                $categorys = get_the_category();//カテゴリ
                $categoryList = '';
                foreach($categorys as $val) {
                    $categoryList = ($categoryList) ? $categoryList.','.$val->slug : $categoryList.$val->slug;
                }
            ?>
            <div class="single-title">
                <p class="category"><?php echo $category; ?></p>
                <h1 class="title"><?php echo $title; ?></h1>
            </div>
            <div class="entry">
                <article class="single-entry">
                    <div class="info">
                        <div class="sns">
                            <?php wp_social_bookmarking_light_output_e(null, get_permalink(), the_title("", "", false)); ?>
                        </div>
                        <p class="time"><time datetime="<?php echo $date ?>"><?php echo $date ?></time></p>
                    </div>
                    <div class="body">
                        <div class="image"><img src="<?php echo $thumbnail ?>" alt="<?php echo $alt ?>"></div>
                        <?php echo $content ?>
                    </div>
                </article>
            <?php
                endwhile;
            else:
                //記事がない場合
                echo 'すみません。お探しの記事は存在しません。';
            endif;
            ?>
            <aside class="single-widget">
            <?php
            $args = array (
                'post_status' => 'publish',
                'post_type' => 'post',
                'order' => 'DESC',
                'posts_per_page' => 5,
                'orderby' => 'menu_order',
                'category_name' => $categoryList
            );
            $the_query = new WP_Query($args);
            if($the_query->have_posts()) :
            ?>
                <div class="widget-relative widget-section">
                    <div class="title">関連記事</div>
                    <div class="list">
                    <?php
                    while($the_query->have_posts()) :
                        $the_query->the_post();
                        $title = get_the_title($post->ID);
                        $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;
                        $link = get_permalink($post->ID);
                    ?>
                        <div class="item">
                            <a href="<?php echo $link ?>">
                                <div class="title"><?php echo $title; ?></div>
                                <div class="image">
                                    <img src="<?php echo $thumbnail; ?>" alt="">
                                </div>
                            </a>
                        </div>
                    <?php
                        endwhile;
                    ?>
                    </div>
                </div>
            <?php
            endif;
            wp_reset_query();
            ?>
            <?php
            $args = array(
                'post_status' => 'publish',
                'post_type' => 'post',
                'order' => 'DESC',
                'post_per_page' => 5,
                'tag' => 'recommend'
            );
            $the_query = new WP_Query($args);
            if($the_query->have_posts()) :
            ?>
                <div class="widget-relative widget-section">
                    <div class="title">おすすめ記事</div>
                    <div class="list">
                    <?php
                    while($the_query->have_posts()) :
                        $the_query->the_post();
                        $title = get_the_title($post->ID);
                        $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;
                        $link = get_permalink($post->ID);
                    ?>
                        <div class="item">
                            <a href="<?php echo $link; ?>">
                                <div class="title"><?php echo $title; ?></div>
                                <div class="image">
                                    <img src="<?php echo $thumbnail; ?>" alt="">
                                </div>
                            </a>
                        </div>
                    <?php
                        endwhile;
                    ?>
                    </div>
                </div>
            <?php
            endif;
            wp_reset_query();
            ?>
            </aside>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>