<?php
/**
 * @package		FAQ - Frequently Asked Questions
 * @copyright	Copyright (C) 2016 Fido-X IT (John Simon). All rights reserved. (fido-x.net)
 * @license		GNU General Public License version 3; see http://www.gnu.org/licenses/gpl-3.0.en.html
 */

class ModelFidoFaq extends Model {
	public function getTopic($faq_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "faq f LEFT JOIN " . DB_PREFIX . "faq_description fd ON (f.faq_id = fd.faq_id) LEFT JOIN " . DB_PREFIX . "faq_to_store f2s ON (f.faq_id = f2s.faq_id) WHERE f.faq_id = '" . (int)$faq_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND f2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND f.status = '1'");

		return $query->row;
	}

	public function getTopics($topic_id = 0, $data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "faq f LEFT JOIN " . DB_PREFIX . "faq_description fd ON (f.faq_id = fd.faq_id) LEFT JOIN " . DB_PREFIX . "faq_to_store f2s ON (f.faq_id = f2s.faq_id) WHERE f.topic_id = '" . (int)$topic_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND f2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND f.status = '1' ORDER BY f.sort_order";

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

	public function getTotalFaqsByTopicId($topic_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "faq f LEFT JOIN " . DB_PREFIX . "faq_to_store f2s ON (f.faq_id = f2s.faq_id) WHERE f.topic_id = '" . (int)$topic_id . "' AND f2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND f.status = '1'");

		return $query->row['total'];
	}

	public function getFaqLayoutId($faq_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faq_to_layout WHERE faq_id = '" . (int)$faq_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return false;
		}
	}
}