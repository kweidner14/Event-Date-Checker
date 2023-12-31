# Event Date Checker

## Description

Checks if the "Dates of Event" from the "Events" Custom Post Type (CPT) has passed and updates the "Date Passed" ACF (Advanced Custom Fields) field.<br><br>
This was built specifically for a client but can be modified to run on any website that utilizes ACF and CPT.

## Version

1.2.0

## Author

Kyle Weidner

## Features

1. Automatically checks if ACF field, `dates_of_event`, from the "Events" CPT have passed.
2. Updates the `date_passed` ACF field based on the results.
3. The event check runs daily via a scheduled WordPress cron job.
4. Immediate event check upon plugin activation.
5. The cron job is cleared upon plugin deactivation.
6. Also checks any time an Event is updated manually by hooking into the `save_post_{post_type}` action for individual post saves, ensuring up-to-date information.

## Installation

1. Upload the zipped folder containing the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Ensure that the Advanced Custom Fields (ACF) plugin is installed and activated, as this plugin relies on ACF functions.
4. Ensure the Custom Post Type, `Events`, exists.
5. The `Events` Custom Post Type must also have an ACF "Date Picker" field named `dates_of_event`, as well as a "True/False" field named `date_passed`. These specific names can be changed, but the references to these field names in the PHP must also be changed to match the updated field names.

## Usage

Once activated, the plugin automatically checks the "Dates of Event" for each event in the "Events" CPT every day. It will update the "Date Passed" ACF field if the event's date has passed. Additionally, this check is performed every time an event post is saved.

## Hooks

- `daily_event_check`: Runs daily to check all event dates.
- `save_post_{post_type}`: Triggered every time a post is saved, this plugin uses it specifically for the "Events" CPT to check an event's date on save.

## Changelog

### 1.2

- Added functionality to check event dates upon individual post saves.
- Minor bug fixes and improvements.
