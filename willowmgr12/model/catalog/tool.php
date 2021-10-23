<?php
use PhpOffice\PhpSpreadsheet\IOFactory;

class ModelCatalogTool extends Model {
	public function getSheetData($filename) {
		$spreadsheet = IOFactory::load($filename);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		return $sheetData;
	}

	public function upload($sql) {
		set_time_limit(100);//Bonk10
		
		// foreach (explode(";\n", $sql) as $sql) {
		// 	$sql = trim($sql);

		// 	if ($sql) {
		// 		$this->db->query($sql);
		// 	}
		// }

		// $this->cache->delete('*');
	}

	//// Belum digunakan hingga akhir file
	public function getTables() {
		$table_data = array();

		$query = $this->db->query("SHOW TABLES FROM `" . DB_DATABASE . "`");

		foreach ($query->rows as $result) {
			if (utf8_substr($result['Tables_in_' . DB_DATABASE], 0, strlen(DB_PREFIX)) == DB_PREFIX) {
				if (isset($result['Tables_in_' . DB_DATABASE])) {
					$table_data[] = $result['Tables_in_' . DB_DATABASE];
				}
			}
		}

		return $table_data;
	}

	public function backup($tables) {
		$output = '';

		foreach ($tables as $table) {
			if (DB_PREFIX) {
				if (strpos($table, DB_PREFIX) === false) {
					$status = false;
				} else {
					$status = true;
				}
			} else {
				$status = true;
			}

			if ($status) {
				$output .= 'TRUNCATE TABLE `' . $table . '`;' . "\n\n";

				$query = $this->db->query("SELECT * FROM `" . $table . "`");

				foreach ($query->rows as $result) {
					$fields = '';

					foreach (array_keys($result) as $value) {
						$fields .= '`' . $value . '`, ';
					}

					$values = '';

					foreach (array_values($result) as $value) {
						$value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
						$value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
						$value = str_replace('\\', '\\\\',	$value);
						$value = str_replace('\'', '\\\'',	$value);
						$value = str_replace('\\\n', '\n',	$value);
						$value = str_replace('\\\r', '\r',	$value);
						$value = str_replace('\\\t', '\t',	$value);

						$values .= '\'' . $value . '\', ';
					}

					$output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
				}

				$output .= "\n\n";
			}
		}

		return $output;
	}

	//Bonk
	public function csv($tables) {
		$output = '';

		foreach ($tables as $table) {
			if (DB_PREFIX) {
				if (strpos($table, DB_PREFIX) === false) {
					$status = false;
				} else {
					$status = true;
				}
			} else {
				$status = true;
			}

			if ($status) {
				$output .= $table . "\n\n";

				$query = $this->db->query("SELECT * FROM `" . $table . "`");

					$fields = '';
					$values = '';

					foreach (array_keys($query->row) as $value) {
						$fields .= $value . '|';
					}

					$output .= $fields . "\n";
//					$output .= preg_replace('/|$/', '', $fields) . "\n";
					
				foreach ($query->rows as $result) {
/*					$fields = '';

					foreach (array_keys($result) as $value) {
						$fields .= $value . ',';
					}

					$output .= preg_replace('/,$/', '', $fields) . "\n";
					
*/					$values = '';

					foreach (array_values($result) as $value) {
						$value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
						$value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
						$value = str_replace('\\', '\\\\',	$value);
						$value = str_replace('\'', '\\\'',	$value);
						$value = str_replace('\\\n', '\n',	$value);
						$value = str_replace('\\\r', '\r',	$value);
						$value = str_replace('\\\t', '\t',	$value);

						$values .= $value . '|';
					}

					$output .= $values . "\n";
//					$output .= preg_replace('/|$/', '', $values) . "\n";
//					$output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
				}

				$output .= "\n\n";
			}
		}

		return $output;
	}
}