=== Project Panorama ===
Contributors: 3pointross
Tags: project, management, project management, basecamp, status, client, admin, intranet
Requires at least: 3.5.0
Tested up to: 4.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WordPress project management / communication plugin designed to communicate project progress and timing.

== Description ==

WordPress project management and communication plugin designed to keep your clients and team in the loop.

Project Panorama is designed to communicate project progress to your clients and team members. By giving parties a visual indication of project progress, you reduce the number of "where are things at?" calls and e-mails.

Panorama allows you to detail important project details including overall project status, project phases, documents and document status, key milestones and timing.

Panorama automatically calculates the time elapsed against the total project progress allowing you to see if you're behind or on schedule.

Instead of sending clients to a list of tasks that have been completed or not, give them a progress bar with key milestones that indicate how the project is progressing.

= Website =
https://www.projectpanorama.com

= Documentation =
https://www.projectpanorama.com/docs

= Bug Submission and Support =
https://www.projectpanorama.com/support


== Installation ==

1. Upload 'project-panorama-lite' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Click on the new menu item "Projects" and create your first project
4. Projects have progress bar, phases, milestones, start / end date, documents and descriptions

= Restricting Access =

You can restrict access to projects by making them private or password protected by changing the project visibility in the publish metabox.

= Using Your Own Theme =

Panorama by default has it's own project page theme, this is ensure the best rendering and design across all themes. If you'd rather use your own theme, you can go into Projects > Settings > Appearance and click the "use custom template" option. We recommend using a full width template for best display. Not all themes will render the complex visuals in Panorama equally.

= Shortcodes =

[project_list] - output a list of public projects, options include:

type -- specify the slug of a project type defined in Projects > Project Types
status -- 'active' or 'complete' to display completed or active projects
count -- number to display before pagination
sort - 'start','end','title'. Sort by start date, end date or alphabetically by title. Default is creation date.

[project_status] - embed a project into a page or post

[project_status_part] - embed a portion of a project into a page or post

[before-phase] [/before-phase] - Show content wrapped in shortcode in a phase description before the phase has started.
[during-phase] [/during-phase] - Show content wrapped in shortcode in a phase description after it has started before it has been completed.
[after-phase] [/after-phase] - Show content wrapped in shortcode in a phase description after the phase has ended.

[before-milestone] [/before-milestone] - Show content wrapped in shortcode before milestone is reached
[after-milestone] [/after-milestone] - Show content wrapped in a shortcode after milestone is reached

== Screenshots ==

1. Indicate overall project progress and identify key milestones
2. Break up projects into individual phases, automatically calculate total project completion by modifying phase completion
3. Provide key project information and automatically track elapsed time
4. Upload key documents and files
5. Get an overview of project progress vs time left before deadline
6. Embed project lists into your site
7. Embed projects into your site, mobile friendly

== Changelog ==

= 1.2.7 =
* Fixes issues with documents not outputting in a embed
* Added shortcodes for before / after milestones
* Added a project calendar

= 1.2.6.5 =
* Checks to see if CMB2 is already loaded
* Updated widget construction method
* Updating front end styling

= 1.2.6.4 =
* Added calendar of start / stop dates

= 1.2.6.3 =
* Bug fixes

= 1.2.6 =

* Added phases and auto calculation to Project Panorama Lite!
* Added options to customize accent colors (phases, timeline, etc...)
* Added repeatable documents interface

= 1.2.6.2 =

* Improved styling for elements in description areas
* Added shortcodes [before-phase] [during-phase] and [after-phase] which display before a phase starts, during an active phase and once a phase is completed
* Date format on backend is determined by user settings
* Added ability to sort by title using the [project_list] shortcode, attribute sort="title"

= 1.2.5.3 =

* Fixed bug with shortcodes

= 1.2.5.2 =

* Document update notification fixes
* Checked for dates before displaying, fixes notices if date isn't set
* Switched last modified time to date on [project_list]
* Added pagination on project listing
* If there isn't a start or end date, hide the time elapsed bar
* [project_list] shortcode will now display a login form if access is set to user and user isn't logged in
* Added logo and home link to project dashboard page

= 1.2.5.2 =
* Fixed bug where timing could be off when using an embed shortcode
* Added a simple project list / archive page for logging in and seeing your list of projects (i.e. /panorama/project-name the login would be /panorama/)
* Added better support for handling wide height ranges between project phases
* Improved the UI of the project heading area
* Added the ability to sort by start or end date with [project_list]
* Fixed bug where if you had a project password protected and restricted to users you couldn't update tasks from the front end

= 1.2.5.1 =
* Separated jQuery from frontend lib file
* Reworking of how and when admin scripts are enqueued for compatibility
* Added Advanced tab for debugging
* Switched dashboard widget chart to chart.js
* Renamed comments.php to psp-comments.php for compatibility
* Core fixes

= 1.2.5 =
* Added front end updating of tasks
* Added front end updating of documents
* Added notification system for document updates
* New project page interface
* Added time elapsed feature, tracks overall time elapsed compared to project completion
* Improved project listing interface on the backend
* Improved project listing shortcode display
* Split project templates into sub parts for easier customization
* Reworked file structure
* Misc bug fixes and improvements
* Split field loading into individual parts, function to check if field files exist in theme directory for customization
* BETA FEATURE: Load Panorama into your theme templates

= 1.2.2.2 =
* Only enqueue javascript files on pages that need them for compatibility
* Improved formatting of e-mail notifications on smaller screens
* Added password reset link to Panorama login
* Removed dashboard widget for users who are not editor level or higher
* Fixed issue where some users can't set a default e-mail / from name for notifications

= 1.2.2.1 =
* Fixed calculation bug with shortcodes
* Fixed weighting issue with previously completed projects
* Switched method of designated completed projects to custom taxonomy
* Fixed conflicts with ACF5 users and progress bars

= 1.2.2 =
* Added e-mail notifications
* Broke settings into three tabs
* Cleaned up admin interface
* Added ability to expand and collapse phases in admin (Thanks Mark Root-Wiley http://mrwweb.com/)
* Added graph to dashboard widget
* Reworked phase weighting, you can now specify hours instead of percentage
* Phases now have project specific settings rather than each individual phase
* Added setting to expand tasks by default
* Fixed unset variable PHP notice
* You can now specify number of projects to display in the [project_list] shortcode


= 1.2.1.8.2 =
* Added the ability to use your own template, simply create a folder called "panorama" in your theme directory and then copy /wp-content/plugins/panorama/lib/templates/single.php into it. You can then modify the file as you'd like
* Added project listing widget
* You can now use URLs for documents
* Added color customizations and an open css text box to the settings page
* Fixed bug with DISQUS plugins

= 1.2.1.8.1 =
* Minor bug fix

= 1.2.1.8 =
* Adjusted project_list shortcode to only display projects viewing user has access to, this can be overwritten by adding an access="all" attribute
* Added two user roles, 'Project Owner' and 'Project Manager' - More information here http://www.projectpanorama.com/docs/permissions
* Project editing in the admin is now restricted by the access control settings, i.e. authors/editors/project owners can only edit projects assigned to them (admins and project managers can edit all projects)
* Fixed issue where auto-calculation wouldn't work if you only had one task

= 1.2.1.6 =
* Added function to translate ACF fields

= 1.2.1.5 =
* Fixed output of "Fired" on plugin page
* Added [panorama_dashboard] shortcode
* Expanding and collapsing task lists
* Fixed issue where project list wouldn't output completed only projects
* Slightly redesigned interface

= 1.2.1.2 =
* Working translation and textdomain
* Added translations for French and Bulgarian - Thanks Gregory Further and Yassen Yotov!
* Move settings into the Project Panorama menu
* Added hooks into the template for future addons and easier styling adjustments
* Login form no longer trips security on WPEngine
* Fixed some misc bugs
* Adds dashboard widget

= 1.2.1 =
* Better translation and textdomain support
* Reworked shortcode system, now you can embed parts of projects, configure your project output and adjust what projects are listed
* Added "Project Type" custom taxonomy
* Added the ability to alter your project slug (from panorama to anything else)
* Added the ability to brand your projects
* Styling improvements and fixes
* Expanded WYSIWYG tools
* Support for WP 3.9

= 1.2 =
* Swapped out donut charts for Pizza Charts by Zurb (much nicer at all resoultions, better IE support)
* Added password protection
* Added user management / restrictions
* Check for duplicate post plugin before including
* Added option to noindex projects
* Minor styling tweaks
* Only load scripts and styles when a shortcode is used or on a project page

= 1.1.3 =
Small Bug Fixes - Added icons to new shortcode buttons

= 1.0 =
* Initial Release!
