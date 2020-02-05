<?php
/*
Plugin Name: Akeeba Backup for WordPress
Plugin URI: https://www.akeebabackup.com
Description: The complete backup solution for WordPress
Version: 3.1.1
Author: Akeeba Ltd
Author URI: https://www.akeebabackup.com
License: GPLv3
*/

/*
 * Copyright 2014-2018 Nicholas K. Dionysopoulos / Akeeba Ltd
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * You can contact Akeeba Ltd through our contact page:
 * https://www.akeebabackup.com/contact-us
 */

/**
 * Make sure we are being called from WordPress itself
 */
defined('WPINC') or die;

/**
 * This should never happen unless your site is broken! It'd mean that you're double loading our plugin which is not how
 * WordPress works. We still defend against this because we've learned to expect the unexpected ;)
 */
if (defined('AKEEBA_SOLOWP_PATH'))
{
	return;
}

// Preload our helper classes
require_once dirname(__FILE__) . '/helpers/AkeebaBackupWP.php';
require_once dirname(__FILE__) . '/helpers/AkeebaBackupWPUpdater.php';

// Initialization of our helper class
AkeebaBackupWP::preboot_initialization(__FILE__);

/**
 * Register public plugin hooks
 */
register_activation_hook(__FILE__, ['AkeebaBackupWP', 'install']);

/**
 * Register the plugin updater hooks (if necessary)
 */
AkeebaBackupWP::loadIntegratedUpdater();

/**
 * Register administrator plugin hooks
 */
if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX))
{
	add_action('admin_menu', ['AkeebaBackupWP', 'adminMenu']);
	add_action('network_admin_menu', ['AkeebaBackupWP', 'networkAdminMenu']);

	if (!AkeebaBackupWP::$wrongPHP)
	{
		add_action('init', ['AkeebaBackupWP', 'startSession'], 1);
		add_action('init', ['AkeebaBackupWP', 'loadJavascript'], 1);
		add_action('plugins_loaded', ['AkeebaBackupWP', 'fakeRequest'], 1);
		add_action('wp_logout', ['AkeebaBackupWP', 'endSession']);
		add_action('wp_login', ['AkeebaBackupWP', 'endSession']);
		add_action('in_admin_footer', ['AkeebaBackupWP', 'clearBuffer']);
		add_action('clear_auth_cookie', ['AkeebaBackupWP', 'onUserLogout'], 1);
	}
}

// Register WP-CLI commands
if (defined('WP_CLI') && WP_CLI)
{
	if (file_exists(__DIR__ . '/wpcli/register_commands.php'))
	{
		require_once __DIR__ . '/wpcli/register_commands.php';
	}
}
