<?php
class ModelMarketingCollection extends Model {
	public function getCollection($collection_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'collection_id=" . (int)$collection_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.collection_id = pd.collection_id) WHERE p.collection_id = '" . (int)$collection_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getCollections($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "collection";

		$implode_data = [];
		
		if (!empty($data['filter']['invoice'])) {
			$implode_data[] = "invoice LIKE '%" . $this->db->escape($data['filter']['invoice']) . "%'";
		}

		if (!empty($data['filter']['customer_id'])) {
			$implode_data[] = "customer_id LIKE '%" . $this->db->escape($data['filter']['customer_id']) . "%'";
		}

		if (!empty($data['filter']['name'])) {
			$implode_data[] = "name LIKE '%" . $this->db->escape($data['filter']['name']) . "%'";
		}

		if (!empty($data['filter']['account'])) {
			$implode_data[] = "account LIKE '%" . $this->db->escape($data['filter']['account']) . "%'";
		}

		if (!empty($data['filter']['date_start'])) {
			$implode_data[] = "DATE(date_added) >= DATE('" . $this->db->escape($data['filter']['date_start']) . "')";
		}

		if (!empty($data['filter']['date_end'])) {
			$implode_data[] = "DATE(date_added) <= DATE('" . $this->db->escape($data['filter']['date_end']) . "')";
		}

		if ($implode_data) {
			$sql .= " WHERE " . implode(' AND ', $implode_data);
		}

		$sort_data = [
			'invoice',
			'customer_id',
			'name',
			'total',
			'account',
			'date_added'
		];

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date_added";
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

	public function getTotalCollections($data = array()) {
		$sql = "SELECT COUNT(collection_id) AS total FROM " . DB_PREFIX . "collection";

		$implode_data = [];
		
		if (!empty($data['filter']['invoice'])) {
			$implode_data[] = "invoice LIKE '%" . $this->db->escape($data['filter']['invoice']) . "%'";
		}

		if (!empty($data['filter']['customer_id'])) {
			$implode_data[] = "customer_id LIKE '%" . $this->db->escape($data['filter']['customer_id']) . "%'";
		}

		if (!empty($data['filter']['name'])) {
			$implode_data[] = "name LIKE '%" . $this->db->escape($data['filter']['name']) . "%'";
		}

		if (!empty($data['filter']['account'])) {
			$implode_data[] = "account LIKE '%" . $this->db->escape($data['filter']['account']) . "%'";
		}

		if (!empty($data['filter']['date_start'])) {
			$implode_data[] = "DATE(date_added) >= DATE('" . $this->db->escape($data['filter']['date_start']) . "')";
		}

		if (!empty($data['filter']['date_end'])) {
			$implode_data[] = "DATE(date_added) <= DATE('" . $this->db->escape($data['filter']['date_end']) . "')";
		}

		if ($implode_data) {
			$sql .= " WHERE " . implode(' AND ', $implode_data);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}
