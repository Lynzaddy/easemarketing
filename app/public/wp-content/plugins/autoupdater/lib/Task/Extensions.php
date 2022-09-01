<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_Extensions extends AutoUpdater_Task_Base
{
    protected $admin_privileges = true;
    protected $high_priority = false;
    protected $current_theme = '';
    protected $updates = array();

    /**
     * @return array
     */
    public function doTask()
    {
        AutoUpdater_Loader::loadClass('Helper_Version');
        AutoUpdater_Loader::loadClass('Helper_SiteTransient');

        AutoUpdater_Config::set('update_themes', (int) $this->input('update_themes', 0));

        $extensions = $this->getExtensions();

        return array(
            'success' => true,
            'extensions' => array(
                'changed' => $extensions,
                'checksum' => sha1(json_encode($extensions)),
            ),
            /** @see AutoUpdater_Task_Environment::doTask() */
            'environment' => AutoUpdater_Task::getInstance('Environment')->doTask(),
        );
    }

    /**
     * @return array
     */
    protected function getExtensions()
    {
        require_once ABSPATH . '/wp-admin/includes/plugin.php';
        require_once ABSPATH . '/wp-admin/includes/theme.php';

        $extensions = array();
        $this->updates = $this->getUpdatesFromRemoteServers();

        $core = new stdClass();
        $core->name = 'WordPress';
        $core->type = 'core';
        $core->slug = 'wordpress';
        $core->version = AUTOUPDATER_WP_VERSION;
        $core->enabled = 1;
        $core->update = null;

        $translations = new stdClass();
        $translations->name = 'Translations';
        $translations->type = 'translation';
        $translations->slug = 'core';
        $translations->version = AUTOUPDATER_WP_VERSION;
        $translations->enabled = 1;
        $translations->update = $this->checkForUpdates($translations->slug, $translations->type);

        $extensions[] = $core;
        $extensions[] = $translations;

        $list = get_plugins();

        if (version_compare(AUTOUPDATER_WP_VERSION, '3.4.0', '>=')) {
            $list = array_merge($list, wp_get_themes());
            $this->current_theme = AutoUpdater_Helper_Version::filterHTML(wp_get_theme()->get('Name'));
        } else {
            $list = array_merge($list, get_themes()); // phpcs:ignore WordPress.WP.DeprecatedFunctions.get_themesFound
            $this->current_theme = AutoUpdater_Helper_Version::filterHTML(get_current_theme()); // phpcs:ignore WordPress.WP.DeprecatedFunctions.get_get_current_themeFound
        }

        foreach ($list as $slug => $item) {
            if ($item instanceof WP_Theme || isset($item['Template'])) {
                $extensions[] = $this->getThemeInfo($slug, $item);
            } elseif (isset($item['PluginURI'])) {
                $plugin = $this->getPluginInfo($slug, $item);
                $extensions[] = $plugin;
            }
        }

        return $extensions;
    }

    /**
     * @param string $slug
     * @param array  $plugin
     *
     * @return array
     */
    protected function getPluginInfo($slug, $plugin)
    {
        $item = new stdClass();
        $item->name = AutoUpdater_Helper_Version::filterHTML($plugin['Name']);
        $item->type = 'plugin';
        $item->slug = $slug;
        $item->version = strtolower(AutoUpdater_Helper_Version::filterHTML((string) $plugin['Version']));
        $item->enabled = (int) is_plugin_active($slug);
        $item->update = $this->checkForUpdates($item->slug, $item->type);

        if ($slug == AUTOUPDATER_WP_PLUGIN_SLUG) {
            $item->name = AutoUpdater_Helper_Version::filterHTML(AutoUpdater_Config::get('whitelabel_name', $item->name));
        }

        return $item;
    }

    /**
     * @param string         $slug
     * @param array|WP_Theme $theme
     *
     * @return array
     */
    protected function getThemeInfo($slug, $theme)
    {
        /**
         * @var WP_Theme $theme
         * @since 3.4.0
         */
        $legacy = !($theme instanceof WP_Theme);

        // build array with themes data to Dashboard
        $item = new stdClass();
        $item->name = AutoUpdater_Helper_Version::filterHTML($legacy ? $theme['Name'] : $theme->get('Name'));
        $item->type = 'theme';
        $item->slug = $legacy ? $theme['Stylesheet'] : pathinfo($slug, PATHINFO_FILENAME);
        $item->version = strtolower(AutoUpdater_Helper_Version::filterHTML((string) ($legacy ? $theme['Version'] : $theme->get('Version'))));
        $item->enabled = (int) ($this->current_theme == $item->name);
        $item->update = $this->checkForUpdates($item->slug, $item->type);

        $template = $legacy ? $theme['Template'] : $theme->get_template();
        if ($template !== $item->slug) {
            $item->parent_slug = (string) $template;
        }

        return $item;
    }

    /**
     * @return array
     */
    protected function getUpdatesFromRemoteServers()
    {
        // Convince WordPress that we're currently viewing the update-core.php page
        AutoUpdater_Helper_SiteTransient::simulateUpdateCorePage();

        // get updates
        $plugins = get_site_transient('update_plugins');
        $themes = get_site_transient('update_themes');

        $updates = array();

        if (!empty($plugins->response)) {
            foreach ($plugins->response as $slug => $plugin) {
                if (!is_object($plugin)) {
                    if (!is_array($plugin)) {
                        continue;
                    }
                    $plugin = (object) $plugin;
                }
                if (!empty($plugin->new_version)) {
                    if (isset($plugin->package)) {
                        // Filter and validate download URL
                        $plugin->package = trim(html_entity_decode($plugin->package, ENT_QUOTES, 'UTF-8'));
                        if (filter_var($plugin->package, FILTER_VALIDATE_URL) === false) {
                            $plugin->package = '';
                        }
                    } else {
                        $plugin->package = '';
                    }

                    $updates[$slug . '_plugin'] = array(
                        'version' => (string) $plugin->new_version,
                        'download_url' => $plugin->package,
                        'core_version_min' => !empty($plugin->requires) ? (string) $plugin->requires : null,
                        'core_version_max' => !empty($plugin->tested) ? (string) $plugin->tested : null,
                        'php_version_min' => !empty($plugin->requires_php) ? (string) $plugin->requires_php : null
                    );
                }
            }
        }

        if (!empty($themes->response)) {
            foreach ($themes->response as $slug => $theme) {
                if (!is_object($theme)) {
                    if (!is_array($theme)) {
                        continue;
                    }
                    $theme = (object) $theme;
                }
                if (!empty($theme->new_version)) {
                    if (isset($theme->package)) {
                        // Filter and validate download URL
                        $theme->package = trim(html_entity_decode($theme->package, ENT_QUOTES, 'UTF-8'));
                        if (filter_var($theme->package, FILTER_VALIDATE_URL) === false) {
                            $theme->package = '';
                        }
                    } else {
                        $theme->package = '';
                    }

                    $updates[$slug . '_theme'] = array(
                        'version' => (string) $theme->new_version,
                        'download_url' => $theme->package,
                        'core_version_min' => !empty($theme->requires) ? (string) $theme->requires : null,
                        'core_version_max' => !empty($theme->tested) ? (string) $theme->tested : null,
                        'php_version_min' => !empty($theme->requires_php) ? (string) $theme->requires_php : null
                    );
                }
            }
        }

        $translations = false;
        if (!empty($plugins->translations) || !empty($themes->translations)) {
            $translations = true;
        } else {
            $core = get_site_transient('update_core');
            if (!empty($core->translations)) {
                $translations = true;
            }
        }

        if ($translations) {
            $updates['core_translation'] = array(
                'version' => AUTOUPDATER_WP_VERSION . (substr_count(AUTOUPDATER_WP_VERSION, '.') === 1 ? '.0.1' : '.1'),
                'download_url' => null,
                'core_version_max' => AUTOUPDATER_WP_VERSION,
            );
        }

        return $updates;
    }

    /**
     * @param string $slug
     * @param string $type
     *
     * @return object|null
     */
    protected function checkForUpdates($slug, $type)
    {
        return isset($this->updates[$slug . '_' . $type]) ? $this->updates[$slug . '_' . $type] : null;
    }
}
