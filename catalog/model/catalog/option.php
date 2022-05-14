<?php
class ModelCatalogOption extends Model
{
	public function getOption($option_id)
	{
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "option` o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE o.option_id = '" . (int)$option_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getOptionValues($option_id, $option_value_ids = [])
	{
		$option_value_data = array();

		$sql = "SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_id = '" . (int)$option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if ($option_value_ids) {
			$sql .= " AND ov.option_value_id IN (" . $this->db->escape(implode(', ', $option_value_ids)) . ")";
		}

		$sql .= " ORDER BY ov.sort_order, ovd.name";
		
		$option_value_query = $this->db->query($sql);

		foreach ($option_value_query->rows as $option_value) {
			$option_value_data[] = array(
				'option_value_id' => $option_value['option_value_id'],
				'name'            => $option_value['name'],
				'image'           => $option_value['image'],
				'sort_order'      => $option_value['sort_order']
			);
		}

		return $option_value_data;
	}
}
