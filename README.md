![Master branch](https://codeship.com/projects/cfcb2ca0-0f1b-0134-80e0-1e1c023ab022/status?branch=master) on Master branch

![Staging branch](https://codeship.com/projects/cfcb2ca0-0f1b-0134-80e0-1e1c023ab022/status?branch=staging) on Staging branch

# AgriLife College (WordPress Plugin)

Functionality for College of Agriculture and Life Sciences sites

## WordPress Requirements

1. [AgriFlex3 theme](https://github.com/agrilife/agriflex3)
2. [AgriLife Core plugin](https://github.com/agrilife/agrilife-core)
3. Advanced Custom Fields 5+ plugin (for Page Templates)
4. Soliloquy Slider plugin (for Page Templates)

## Installation

1. [Download the latest release](https://github.com/AgriLife/agrilife-college/releases/latest)
2. Upload the plugin to your site

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
