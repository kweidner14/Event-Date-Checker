<?php

/*
Plugin Name: AMG Event Date Checker
Description: Checks if the "Dates of Event" from the "Events" CPT has passed and updates the "Date Passed" ACF field.
Version: 1.0
Author: Kyle Weidner
*/

// Function to check if event date has passed and update ACF field
function check_event_date_passed()
{
    // Get events that haven't been marked as passed or recently modified
    $args = array(
        'post_type' => 'events',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'date_passed',
                'value' => 'True',
                'compare' => '!=',
            ),
            array(
                'key' => 'date_passed',
                'compare' => 'NOT EXISTS',
            ),
        ),
    );

    $events = new WP_Query($args);

    if ($events->have_posts()):
        while ($events->have_posts()): $events->the_post();

            $event_id = get_the_ID();
            $event_date = get_field('dates_of_event', $event_id);

            // Convert event date to a DateTime object
            $event_date_obj = DateTime::createFromFormat('F j, Y', $event_date);
            $current_date_obj = new DateTime(); // Current date

            // Check if the event date has passed
            if ($event_date_obj < $current_date_obj) {
                update_field('date_passed', 'True', $event_id);
            }

        endwhile;
        wp_reset_postdata();
    endif;
}

// Schedule the event and run the function upon plugin activation
function daily_event_check_activation()
{
    check_event_date_passed(); // Run immediately upon activation
    if (!wp_next_scheduled('daily_event_check')) {
        wp_schedule_event(time(), 'daily', 'daily_event_check');
    }
}

register_activation_hook(__FILE__, 'daily_event_check_activation');

// Hook our function to run on the scheduled event
add_action('daily_event_check', 'check_event_date_passed');

// Clear the scheduled event upon plugin deactivation
function daily_event_check_deactivation()
{
    wp_clear_scheduled_hook('daily_event_check');
}

register_deactivation_hook(__FILE__, 'daily_event_check_deactivation');

