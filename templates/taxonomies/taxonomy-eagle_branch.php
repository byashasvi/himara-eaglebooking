<?php
/**
 * The Template for displaying hotel branch
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/taxonomies/taxanomy_eagle_branch.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.6
 */

defined('ABSPATH') || exit;

get_header();

?>

<main class="eb-branch-page no-padding">

    <?php

    $eb_branch_id = get_queried_object()->term_id;

    $args = array('post_type' => 'eagle_rooms',
        'tax_query' => array(
            array(
                'taxonomy' => 'eagle_branch',
                'field' => 'term_id',
                'terms' => $eb_branch_id,
            ),
        ),
    );

    $eb_branches_query = new WP_Query($args);

    $term = get_queried_object();
    $term_id = $term->term_id;
    $eb_branch_desc = $term->description;
    $eb_branch_logo = get_term_meta( $term_id, 'eb_branch_logo', true );
    $eb_branch_bg = get_term_meta( $term_id, 'eb_branch_bg', true );
    $eb_branch_address = get_term_meta( $term_id, 'eb_branch_address', true );
    $eb_branch_phone = get_term_meta( $term_id, 'eb_branch_phone', true );
    $eb_branch_email = get_term_meta( $term_id, 'eb_branch_email', true );

    include_once EB_PATH . '/core/admin/form-parameters.php';

    ?>

    <div class="eb-branch-header">

        <div class="eb-container">

            <div class="eb-branch-cover">

                <div class="eb-branch-image" data-src="<?php echo esc_url( $eb_branch_bg ) ?>" data-parallax="scroll" data-speed="0.3" data-mirror-selector=".eb-branch-image" data-z-index="0"></div>

                <div class="eb-branch-details">
                    <div class="eb-branch-info">
                        <h1 class="eb-branch-title"><?php echo single_term_title() ?></h1>
                        <p class="eb-branch-desc"><?php echo $eb_branch_desc ?></p>

                        <ul class="eb-branch-contact">
                            <?php if ( $eb_branch_address ) : ?><li><i class="icon-location-pin"></i><?php echo esc_html( $eb_branch_address ) ?></li><?php endif ?>
                            <?php if ( $eb_branch_phone ) : ?><li><i class="icon-phone"></i><?php echo esc_html( $eb_branch_phone ) ?></li><?php endif ?>
                            <?php if ( $eb_branch_email ) : ?><li><i class="icon-envelope"></i><?php echo esc_html( $eb_branch_email ) ?></li><?php endif ?>
                        </ul>

                        <div class="eb-branch-search-form">
                            <form id="search-form" class="search-form" action="<?php echo $eagle_booking_action ?>" method="GET" target="<?php echo esc_attr( $eagle_booking_target ) ?>">

                                <?php

                                    include eb_load_template('elements/dates-picker.php');

                                    include eb_load_template('elements/guests-picker.php');

                                ?>

                                <input type="hidden" name="eb_branch" value="<?php echo $term_id  ?>">
                                <button id="eb_search_form" class="btn eb-btn" type="submit">
                                    <span class="eb-btn-text"><?php echo __('Search', 'eagle-booking') ?></span>
                                </button>

                            </form>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="eb-container">

        <div class="eb-rooms eb-branch-rooms">

            <div class="eb-rooms-list">

            <?php

            $eagle_booking_checkin = '';
            $eagle_booking_checkout = '';

            if( $eb_branches_query->have_posts()) {

                echo '<div class="eb-branch-bar"><h2 class="eb-branch-rooms-title">'. __('Rooms of', 'eagle-booking').' '.single_term_title("", false).'</h2></div>';

                while ( $eb_branches_query->have_posts() ) : $eb_branches_query->the_post();
                    /**
                     * Include Room
                    */
                    include eb_load_template('search/room.php');

                endwhile;

            } else {

                echo '<div id="eb-no-search-results" class="eb-alert mt20 text-center" role="alert">' .__('There are no rooms for this hotel branch', 'eagle-booking').'</div>';
            }

            wp_reset_query()

        ?>
        </div>

        </div>

    </div>

</main>

<?php get_footer() ?>
