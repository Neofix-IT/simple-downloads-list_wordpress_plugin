=== Simple Downloads List ===
Contributors: neofix
Donate link: https://neofix.ch
Tags: downloads-list, simple, downloads, table, files
Requires at least: 6.1
Tested up to: 6.8
Requires PHP: 8.2
Stable tag: 1.5.0
License: MIT
License URI: https://github.com/Neofix-IT/simple-downloads-list_wordpress_plugin/blob/main/LICENSE

Provide a list of downloads for your visitors - quick and easy. With download categories and mobile friendly design.

== Description ==

Simple Downloads List allows you to provide multiple downloads as a beautiful list for your visitors. Simply add your downloads in the admin section and start using the block or shortcode.

= Main features: =

* Fully free - there's no pro version
* Mobile friendly list design
* A search bar allows your visitors to search for downloads
* Filtering possible using categories

== How to use ==

= Using WordPress block: =

Add new "Simple Downloads List" Block and (optionally) filter category within the sidepanel

= Using shortcode: =

Simply add this shortcode

`[neofix_sdl category=""]`

**category:** Which categories should be displayed? If this option is missing or empty, all downloads will be visible.

== Installation ==

Download and install "Simple Downloads List" from WordPress plugins. Add your downloads inside the admin menu. Finally, add the Simple Downloads List block or use the shortcode.

== Screenshots ==
1. Frontend desktop
2. Frontend mobile
3. Adminpanel

== Changelog ==

= v 1.5.0 = 

Plugin structure overhaul, separate assets & code, combine shared templates
Major adminpanel rework, replaced bootstrap and updated fontawesome to v7.1.0
Migrated from AJAX to REST API
Fixed security vulnerabilities, allowing logged-in users to modify downloads
Minor improvements & bug fixes

= v 1.4.3 = 

Security vuln: Fix possible SQL injection (Possible by passing malicious shortcode parameter).

= v 1.4.2 = 

Minor bugfixes (Block translation not working, wrong icon)

= v 1.4.1 = 

Added Gutenberg Block support
Documentation updated
Minor styling fixes
Compatibility updated according to new tests

= v 1.4.0 =

Refactoring code
Minor translation expansion

= v 1.3.0 =

Added default WordPress translations
Added placeholder if there are no downloads available

= v 1.2.1 =

Bugfix: After adding a row, the WordPress file dialog wasn't working -> Fixed.

= v 1.2.0 =

New: Select files and content by using the WordPress file dialog.
New: Preventing file opening via browser after a click on download -> preferring a download instead.
Improved description for admin panel and readme.txt

= v 1.1.1 =

Fix: Line breaks now working for the frontend.
Small typo fixed within readme.txt

= v 1.1.0 =

Tested with WordPress 6.0 and minor optimizations.

= v 1.0.0 =

Release