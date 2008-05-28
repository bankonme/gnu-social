<?php
/*
 * Laconica - a distributed open-source microblogging tool
 * Copyright (C) 2008, Controlez-Vous, Inc.
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
 */

if (!defined('LACONICA')) { exit(1); }

require_once('markdown.php');

class DocAction extends Action {

	function handle($args) {
		parent::handle($args);
		$title = $this->trimmed('title');
		$filename = INSTALLDIR.'/doc/'.$title;
		if (!file_exists()) {
			common_user_error(_t('No such document.'));
			return;
		}
		$output = Markdown(file_get_contents($filename));
		common_show_header(_t(ucfirst($title)));
		common_raw($output);
		common_show_footer();
	}
}