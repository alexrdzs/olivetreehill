<?php
$cats_id = $instance['cat'];
$limit = isset($instance['limit']) ? $instance['limit'] : 5;
$query_args = array(
    'cat' => $instance['cat'],
    'posts_per_page' => $limit,
);
$posts_display = new WP_Query($query_args);
if ($posts_display->have_posts()) :
    ?>
    <div class="wrapper-filter-controls">
        <div class="filter-controls">
            <a class="filter active" data-filter="*" href="javascript:;"><?php esc_html_e('All', 'sailing'); ?></a>
            <?php
            while ($posts_display->have_posts()) : $posts_display->the_post();
                echo '<a class="filter" href="javascript:;" data-filter=".filter-gallery-' . get_the_ID() . '">' . get_the_title(get_the_ID()) . '</a>';
            endwhile;
            ?>
        </div>
    </div>
    <div class="wrapper-gallery-filter grid row" itemscope itemtype="http://schema.org/ItemList">
        <?php
        while ($posts_display->have_posts()) : $posts_display->the_post();
            $images = thim_meta('thim_gallery', "type=image&single=false&size=full");
            if (empty($images)) {
                break;
            }
            foreach ($images as $image) {
                if ($image['url']) {
                    $data = @getimagesize($image['url']);
                    if ($data) {
                        $width_data = $data[0];
                        $height_data = $data[1];
                        if (!($width_data > 380) || !($height_data > 310)) {
                            echo '<div class="item-photo element-item col-sm-4 filter-gallery-' . get_the_ID() . '">';
                            echo '<div class="inner">';
                            echo '<a class="fancybox" data-fancybox-group="gallery" href="' . esc_url($image['url']) . '"><img src="' . esc_url($image['url']) . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" /></a>';
                            echo '</div>';
                            echo '</div>';
                        } else {
                            $crop = ($height_data < 310) ? false : true;
                            $image_crop = aq_resize($image['url'], 380, 310, $crop);
                            echo '<div class="item-photo element col-sm-4 filter-gallery-' . get_the_ID() . '">';
                            echo '<div class="inner">';
                            echo '<a class="fancybox" data-fancybox-group="gallery" href="' . esc_url($image['url']) . '"><img src="' . esc_url($image_crop) . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" /></a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        $image_crop = aq_resize($image['url'], 380, 310, true);
                        echo '<div class="item-photo element col-sm-4 filter-gallery-' . get_the_ID() . '">';
                        echo '<div class="inner">';
                        echo '<a class="fancybox" data-fancybox-group="gallery" href="' . esc_url($image['url']) . '"><img src="' . esc_url($image_crop) . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" /></a>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }
        endwhile;

        ?>
    </div>
    <?php
endif;
wp_reset_postdata();
