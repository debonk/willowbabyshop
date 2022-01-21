<?php
class ModelMarketingCollection extends Model {
	public function addCollection($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "collection SET invoice = '" . $this->db->escape($data['invoice']) . "', total = '" . (int)$data['total'] . "', customer_id = '" . $this->db->escape($data['customer_id']) . "', name = '" . $this->db->escape($data['name']) . "', account = '" . $this->db->escape($data['account']) . "', date_added = NOW()";

		$this->db->query($sql);
	}
	
	public function getCollectionCountByInvoice($invoice) {
		$sql = "SELECT COUNT(collection_id) AS total FROM " . DB_PREFIX . "collection WHERE invoice = '" . $this->db->escape($invoice) . "'";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
}