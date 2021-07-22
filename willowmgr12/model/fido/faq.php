<?php
/**
 * @package		FAQ - Frequently Asked Questions
 * @copyright	Copyright (C) 2016 Fido-X IT (John Simon). All rights reserved. (fido-x.net)
 * @license		GNU General Public License version 3; see http://www.gnu.org/licenses/gpl-3.0.en.html
 */

class ModelFidoFaq extends Model {
	public function createFAQs() {
		$create_faq = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "faq` (`faq_id` int(11) NOT NULL auto_increment, `topic_id` int(11) NOT NULL default '0', `status` int(1) NOT NULL default '0', `sort_order` int(3) NOT NULL default '0', PRIMARY KEY  (`faq_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		$this->db->query($create_faq);

		$create_faq_description = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "faq_description` (`faq_id` int(11) NOT NULL default '0', `language_id` int(11) NOT NULL default '0', `title` varchar(64) NOT NULL default '', `meta_description` varchar(255), `description` text NOT NULL, PRIMARY KEY  (`faq_id`,`language_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		$this->db->query($create_faq_description);

		$create_faq_path = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "faq_path` (`faq_id` int(11) NOT NULL, `path_id` int(11) NOT NULL, `level` int(11) NOT NULL, PRIMARY KEY  (`faq_id`, `path_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		$this->db->query($create_faq_path);

		$create_faq_to_layout = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "faq_to_layout` (`faq_id` int(11) NOT NULL, `store_id` int(11) NOT NULL, `layout_id` int(11) NOT NULL, PRIMARY KEY  (`faq_id`, `store_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		$this->db->query($create_faq_to_layout);

		$create_faq_to_store = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "faq_to_store` (`faq_id` int(11) NOT NULL, `store_id` int(11) NOT NULL, PRIMARY KEY  (`faq_id`, `store_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		$this->db->query($create_faq_to_store);
	}

	public function dropFAQs() {
		$drop_faq = "DROP TABLE IF EXISTS `" . DB_PREFIX . "faq`;";
		$this->db->query($drop_faq);

		$drop_faq_description = "DROP TABLE IF EXISTS `" . DB_PREFIX . "faq_description`;";
		$this->db->query($drop_faq_description);

		$drop_faq_path = "DROP TABLE IF EXISTS `" . DB_PREFIX . "faq_path`;";
		$this->db->query($drop_faq_path);

		$drop_faq_to_layout = "DROP TABLE IF EXISTS `" . DB_PREFIX . "faq_to_layout`;";
		$this->db->query($drop_faq_to_layout);

		$drop_faq_to_store = "DROP TABLE IF EXISTS `" . DB_PREFIX . "faq_to_store`;";
		$this->db->query($drop_faq_to_store);
	}

	public function addFaq($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "faq SET topic_id = '" . (int)$data['topic_id'] . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$faq_id = $this->db->getLastId(); 

		foreach ($data['faq_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "faq_description SET faq_id = '" . (int)$faq_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "faq_path` WHERE faq_id = '" . (int)$data['topic_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "faq_path` SET `faq_id` = '" . (int)$faq_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "faq_path` SET `faq_id` = '" . (int)$faq_id . "', `path_id` = '" . (int)$faq_id . "', `level` = '" . (int)$level . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'faq_id=" . (int)$faq_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['faq_store'])) {		
			foreach ($data['faq_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "faq_to_store SET faq_id = '" . (int)$faq_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['faq_layout'])) {
			foreach ($data['faq_layout'] as $store_id => $layout) {
				if ($layout) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "faq_to_layout SET faq_id = '" . (int)$faq_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		$this->cache->delete('faq');

		return $faq_id;
	}

	public function editFaq($faq_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "faq SET topic_id = '" . (int)$data['topic_id'] . "', status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE faq_id = '" . (int)$faq_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_description WHERE faq_id = '" . (int)$faq_id . "'");

		foreach ($data['faq_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "faq_description SET faq_id = '" . (int)$faq_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "faq_path` WHERE path_id = '" . (int)$faq_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $faq_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "faq_path` WHERE faq_id = '" . (int)$faq_path['faq_id'] . "' AND level < '" . (int)$faq_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "faq_path` WHERE faq_id = '" . (int)$data['topic_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "faq_path` WHERE faq_id = '" . (int)$faq_path['faq_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "faq_path` SET faq_id = '" . (int)$faq_path['faq_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "faq_path` WHERE faq_id = '" . (int)$faq_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "faq_path` WHERE faq_id = '" . (int)$data['topic_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "faq_path` SET faq_id = '" . (int)$faq_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "faq_path` SET faq_id = '" . (int)$faq_id . "', `path_id` = '" . (int)$faq_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'faq_id=" . (int)$faq_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'faq_id=" . (int)$faq_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_to_store WHERE faq_id = '" . (int)$faq_id . "'");

		if (isset($data['faq_store'])) {		
			foreach ($data['faq_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "faq_to_store SET faq_id = '" . (int)$faq_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_to_layout WHERE faq_id = '" . (int)$faq_id . "'");

		if (isset($data['faq_layout'])) {
			foreach ($data['faq_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "faq_to_layout SET faq_id = '" . (int)$faq_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		$this->cache->delete('faq');
	}

	public function deleteFaq($faq_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_path WHERE faq_id = '" . (int)$faq_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faq_path WHERE path_id = '" . (int)$faq_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteFaq($result['faq_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "faq WHERE faq_id = '" . (int)$faq_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_description WHERE faq_id = '" . (int)$faq_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_to_store WHERE faq_id = '" . (int)$faq_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "faq_to_layout WHERE faq_id = '" . (int)$faq_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'faq_id=" . (int)$faq_id . "'");

		$this->cache->delete('faq');
	}

	public function getFaq($faq_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(fd1.title ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "faq_path fp LEFT JOIN " . DB_PREFIX . "faq_description fd1 ON (fp.path_id = fd1.faq_id AND fp.faq_id != fp.path_id) WHERE fp.faq_id = f.faq_id AND fd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY fp.faq_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'faq_id=" . (int)$faq_id . "') AS keyword FROM " . DB_PREFIX . "faq f LEFT JOIN " . DB_PREFIX . "faq_description fd2 ON (f.faq_id = fd2.faq_id) WHERE f.faq_id = '" . (int)$faq_id . "' AND fd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	} 

	public function getFaqs($data = array()) {
		$sql = "SELECT fp.faq_id AS faq_id, GROUP_CONCAT(fd1.title ORDER BY fp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS title, f1.topic_id, f1.sort_order, f1.status FROM " . DB_PREFIX . "faq_path fp LEFT JOIN " . DB_PREFIX . "faq f1 ON (fp.faq_id = f1.faq_id) LEFT JOIN " . DB_PREFIX . "faq f2 ON (fp.path_id = f2.faq_id) LEFT JOIN " . DB_PREFIX . "faq_description fd1 ON (fp.path_id = fd1.faq_id) LEFT JOIN " . DB_PREFIX . "faq_description fd2 ON (fp.faq_id = fd2.faq_id) WHERE fd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND fd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_title'])) {
			$sql .= " AND fd2.title LIKE '" . $this->db->escape($data['filter_title']) . "%'";
		}

		$sql .= " GROUP BY fp.faq_id";

		$sort_data = array(
			'title',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getFaqDescriptions($faq_id) {
		$faq_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faq_description WHERE faq_id = '" . (int)$faq_id . "'");

		foreach ($query->rows as $result) {
			$faq_description_data[$result['language_id']] = array(
				'title'            => $result['title'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}

		return $faq_description_data;
	}

	public function getFaqStores($faq_id) {
		$faq_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faq_to_store WHERE faq_id = '" . (int)$faq_id . "'");

		foreach ($query->rows as $result) {
			$faq_store_data[] = $result['store_id'];
		}

		return $faq_store_data;
	}

	public function getTotalFaqs() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "faq");

		return $query->row['total'];
	}

	public function getFaqLayouts($faq_id) {
		$faq_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faq_to_layout WHERE faq_id = '" . (int)$faq_id . "'");

		foreach ($query->rows as $result) {
			$faq_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $faq_layout_data;
	}

	public function getTotalFaqsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "faq_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}