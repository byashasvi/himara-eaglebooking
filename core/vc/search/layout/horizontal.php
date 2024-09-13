<div class="hbf eb-search-form eb-horizontal-search-form <?php echo esc_attr( $eb_search_form_class ); ?>">
  <div class="inner">

      <form id="search-form" class="search-form" action="<?php echo $eagle_booking_action ?>" method="get" target="<?php echo esc_attr( $eagle_booking_target ) ?>">

      <div class="eb-form-fields">

        <?php

        include eb_load_template('elements/custom-parameters.php');

        include eb_load_template('elements/dates-picker.php');

        include eb_load_template('elements/guests-picker.php');

        ?>

        <button id="eb_search_form" class="button btn eb-btn eb-btn-search-form" type="submit">
            <span class="eb-btn-text"><?php echo __('Check Availability','eagle-booking') ?></span>
        </button>

      </div>

    </form>

  </div>
</div>
