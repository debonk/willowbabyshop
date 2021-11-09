<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

class ModelToolSpreadsheet extends Model
{
	public function getSheetData($filename)
	{
		$spreadsheet = IOFactory::load($filename);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		return $sheetData;
	}
}
