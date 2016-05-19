# AgriLife College (WordPress Plugin)

Functionality for College of Agriculture and Life Sciences sites

## WordPress Requirements

1. AgriFlex3 theme
2. AgriLife Core plugin
3. Advanced Custom Fields 5 plugin (for Page Templates)
4. Soliloquy Slider plugin (for Page Templates)

## Installation

1. Copy this repository to your desktop
2. Do one of the following:
    a. Compress this repository and upload it to your WordPress site as a new plugin
    b. Use FTP/SFTP to upload your copy to the *plugins* folder of your WordPress directory

## Features

* Required appearance and information for Colleges of Agriculture and Life Sciences
* Page Templates
    * Landing Page 1: This page template provides a Soliloquy slider, a welcome text field, and a way to list the programs provided by your unit. It is typically used on the front page.
    * aglifesciences: This page template provides the standard home page content layout seen on most COALS sites. It includes header links, college priorities, a Soliloquy slider, welcome text, and widget areas.
* Widget Areas - for aglifesciences template only
    * Home right sidebar: Positioned beneath the Soliloquy slider and to the right of both the welcome text and other widget areas
    * Home Page Bottom Left: Positioned beneath the left side of the welcome text
    * Home Page Bottom Right: Positioned beneath the right side of the welcome text
* Page Layouts

![Content Sidebar](http://agrilife.org/wp-content/themes/genesis/lib/admin/images/layouts/cs.gif)
![Sidebar Content](http://agrilife.org/wp-content/themes/genesis/lib/admin/images/layouts/sc.gif)
![Content](http://agrilife.org/wp-content/themes/genesis/lib/admin/images/layouts/c.gif)

## Development Installation

1. Copy this repo to the desired location
2. In your terminal, navigate to the plugin location `cd /path/to/the/plugin`
3. Run `composer install` to set up the php modules
