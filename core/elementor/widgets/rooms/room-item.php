
<div class="room-item">

  <figure>

    <a href="<?php echo esc_url( $eb_room_url ) ?>">
        <img src="<?php echo esc_url( $eb_room_img_url ) ?>" alt="<?php echo esc_html( $eb_room_title ) ?>">
    </a>

  </figure>

    <?php

      /**
      * Room Price
      */
      eb_room_price( get_the_ID(), ' / '.__('night', 'eagle-booking') )

    ?>

    <div class="room-details">

      <div class="room-details-inner">

        <h4 class="room-title"><a href="<?php echo esc_url( $eb_room_url ) ?>"><?php echo esc_html( $eb_room_title ) ?></a></h4>

        <?php

            /**
            * Room Info
            */
            include eb_load_template('room-info.php');

            /**
            * Include room services
            */
            include eb_load_template('room-services.php');
        ?>

    </div>

    </div>

</div>
