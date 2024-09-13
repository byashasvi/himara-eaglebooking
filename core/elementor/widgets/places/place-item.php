<div class="eb-place-item" style="background-image: url( <?php echo $eb_place_img_url ?> ) ">
    <a href="<?php echo esc_url( $eb_place_url ) ?>"></a>
    <?php if ( $settings['title'] == true  ) : ?>
        <div class="details">
            <h4 class="title"><?php echo esc_html( $eb_place_title ) ?><span></span></h4>
        </div>
    <?php endif ?>
</div>
