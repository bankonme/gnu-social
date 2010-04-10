<?php
/**
 * StatusNet - the distributed open-source microblogging tool
 * Copyright (C) 2010, StatusNet, Inc.
 *
 * Creates a dynamic sitemap for a StatusNet site
 *
 * PHP version 5
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  Sample
 * @package   StatusNet
 * @author    Evan Prodromou <evan@status.net>
 * @copyright 2010 StatusNet, Inc.
 * @license   http://www.fsf.org/licensing/licenses/agpl-3.0.html AGPL 3.0
 * @link      http://status.net/
 */

if (!defined('STATUSNET')) {
    // This check helps protect against security problems;
    // your code file can't be executed directly from the web.
    exit(1);
}

/**
 * Sitemap plugin
 *
 * @category  Sample
 * @package   StatusNet
 * @author    Evan Prodromou <evan@status.net>
 * @copyright 2010 StatusNet, Inc.
 * @license   http://www.fsf.org/licensing/licenses/agpl-3.0.html AGPL 3.0
 * @link      http://status.net/
 */

class SitemapPlugin extends Plugin
{
    const USERS_PER_MAP = 25000;

    /**
     * Load related modules when needed
     *
     * @param string $cls Name of the class to be loaded
     *
     * @return boolean hook value; true means continue processing, false means stop.
     */

    function onAutoload($cls)
    {
        $dir = dirname(__FILE__);

        switch ($cls)
        {
        case 'SitemapindexAction':
        case 'NoticesitemapAction':
        case 'UsersitemapAction':
            require_once $dir . '/' . strtolower(mb_substr($cls, 0, -6)) . '.php';
            return false;
        case 'SitemapAction':
            require_once $dir . '/' . strtolower($cls) . '.php';
        default:
            return true;
        }
    }

    /**
     * Map URLs to actions
     *
     * @param Net_URL_Mapper $m path-to-action mapper
     *
     * @return boolean hook value; true means continue processing, false means stop.
     */

    function onRouterInitialized($m)
    {
        $m->connect('sitemapindex.xml',
                    array('action' => 'sitemapindex'));

        $m->connect('/sitemaps/notice/:year/:month/:day/:index.xml',
                    array('action' => 'noticesitemap'),
                    array('year' => '[0-9]{4}',
                          'month' => '[01][0-9]',
                          'day' => '[0123][0-9]',
                          'index' => '[1-9][0-9]*'));

        $m->connect('/sitemaps/user/:year/:month/:day/:index.xml',
                    array('action' => 'usersitemap'),
                    array('year' => '[0-9]{4}',
                          'month' => '[01][0-9]',
                          'day' => '[0123][0-9]',
                          'index' => '[1-9][0-9]*'));
        return true;
    }
}
