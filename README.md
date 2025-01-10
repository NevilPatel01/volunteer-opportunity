# Volunteer Opportunity Plugin - Development Checklist

## Plugin Folder Structure

- [x] Create a subfolder in `/wp-content/plugins` named `volunteer-opportunity-plugin`.

## Plugin Activation/Deactivation

- [x] Ensure the plugin can be:
  - [x] Activated
  - [x] Deactivated (remove data from the table)
  - [x] Uninstalled (complete removal of plugin data and database table)

## Volunteer Opportunities Management

### Fields
- [x] Add fields for each volunteer opportunity:
  - [x] Position (e.g., "Club Volunteer")
  - [x] Organization
  - [x] Type (one-time, recurring, seasonal)
  - [x] E-mail
  - [x] Description
  - [x] Location
  - [x] Hours
  - [x] Skills Required

### Admin Menu
- [x] Add a "Volunteer" menu to the WordPress admin panel.
- [x] Allow admin users to:
  - [x] Create opportunities
  - [x] Update opportunities
  - [x] Delete opportunities
  - [x] View all opportunities

### Form Validation
- [x] Implement basic form validation for create and update operations.
- [x] Use appropriate form elements for inputs (e.g., dropdown for opportunity type).

## Volunteer Opportunities Display

### Shortcode Implementation
- [x] Create a shortcode `[volunteer]`.
  - [x] Display a table of all opportunities when used without parameters.
  - [x] Professionally format the table using:
    - Spacing
    - Newlines
    - Italics/Bold
- [x] Add conditional row colors based on hour commitments:
  - [x] Green for commitments < 10 hours
  - [x] Yellow for commitments between 10 and 100 hours
  - [x] Red for commitments > 100 hours
- [x] Allow shortcode to filter results based on parameters:
  - [x] Filter by `hours` (e.g., `[volunteer hours="10"]`)
  - [x] Filter by `type` (e.g., `[volunteer type="seasonal"]`)
  - [x] Support combined parameters (e.g., `[volunteer hours="10" type="seasonal"]`)

## Database Management

- [x] Create a MySQL table to store volunteer opportunities when the plugin is activated.
- [x] Delete volunteer opportunities from the MySQL table when the plugin is deactivated.
- [x] Drop the MySQL table when the plugin is uninstalled.
- [x] Use the WordPress Database API (`wpdb`) for all database interactions.

## Installation and Testing

- [x] Install the plugin on a WordPress website hosted locally using XAMPP.
- [x] Create at least 4 volunteer opportunities to demonstrate:
  - [x] Default shortcode behavior.
  - [x] Filtered display using `hours` parameter.
  - [x] Filtered display using `type` parameter.
  - [x] Combined filtering (`hours` and `type`).

## Testing and Validation

- [x] Test plugin activation/deactivation/uninstallation behavior.
- [x] Validate that the admin panel options work as expected (create/update/delete).
- [x] Ensure proper rendering of the shortcode with and without parameters.
- [x] Verify all row colors are applied correctly.
- [x] Ensure database interactions are secure and functional.
