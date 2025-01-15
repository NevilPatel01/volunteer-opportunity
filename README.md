# Volunteer Opportunity Plugin - Development Checklist

## Plugin Folder Structure

- [x] Create a subfolder in `/wp-content/plugins` named `volunteer-opportunity-plugin`.

## Plugin Activation/Deactivation

- [ ] Ensure the plugin can be:
  - [X] Activated
  - [X] Deactivated (remove data from the table)
  - [ ] Uninstalled (complete removal of plugin data and database table)

## Volunteer Opportunities Management

### Fields
- [X] Add fields for each volunteer opportunity:
  - [X] Position (e.g., "Club Volunteer")
  - [X] Organization
  - [X] Type (one-time, recurring, seasonal)
  - [X] E-mail
  - [X] Description
  - [X] Location
  - [X] Hours
  - [X] Skills Required

### Admin Menu
- [X] Add a "Volunteer" menu to the WordPress admin panel.
- [X] Allow admin users to:
  - [X] Create opportunities
  - [X] Update opportunities
  - [X] Delete opportunities
  - [X] View all opportunities

### Form Validation
- [X] Implement basic form validation for create and update operations.
- [X] Use appropriate form elements for inputs (e.g., dropdown for opportunity type).

## Volunteer Opportunities Display

### Shortcode Implementation
- [ ] Create a shortcode `[volunteer]`.
  - [ ] Display a table of all opportunities when used without parameters.
  - [ ] Professionally format the table using:
    - Spacing
    - Newlines
    - Italics/Bold
- [ ] Add conditional row colors based on hour commitments:
  - [ ] Green for commitments < 10 hours
  - [ ] Yellow for commitments between 10 and 100 hours
  - [ ] Red for commitments > 100 hours
- [ ] Allow shortcode to filter results based on parameters:
  - [ ] Filter by `hours` (e.g., `[volunteer hours="10"]`)
  - [ ] Filter by `type` (e.g., `[volunteer type="seasonal"]`)
  - [ ] Support combined parameters (e.g., `[volunteer hours="10" type="seasonal"]`)

## Database Management

- [ ] Create a MySQL table to store volunteer opportunities when the plugin is activated.
- [ ] Delete volunteer opportunities from the MySQL table when the plugin is deactivated.
- [ ] Drop the MySQL table when the plugin is uninstalled.
- [ ] Use the WordPress Database API (`wpdb`) for all database interactions.

## Installation and Testing

- [ ] Install the plugin on a WordPress website hosted locally using XAMPP.
- [ ] Create at least 4 volunteer opportunities to demonstrate:
  - [ ] Default shortcode behavior.
  - [ ] Filtered display using `hours` parameter.
  - [ ] Filtered display using `type` parameter.
  - [ ] Combined filtering (`hours` and `type`).

## Testing and Validation

- [ ] Test plugin activation/deactivation/uninstallation behavior.
- [ ] Validate that the admin panel options work as expected (create/update/delete).
- [ ] Ensure proper rendering of the shortcode with and without parameters.
- [ ] Verify all row colors are applied correctly.
- [ ] Ensure database interactions are secure and functional.
