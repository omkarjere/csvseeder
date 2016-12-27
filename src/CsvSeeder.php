<?php

namespace Ojrao\CsvSeeder;

class CsvSeeder {
	protected $filteredData = [];
	protected $rowCount = 0;
	protected $columnCount = 0;

	public function __construct($fileName) {
		// Open the specifed file for reading.
		$csvFile = database_path() . '/csv/'. $fileName . '.csv';
		$openFile = fopen($csvFile, 'r');

		// Read all the raw data
		$rawData = [];
		while (!feof($openFile)) {
			$rawData[] = fgetcsv($openFile);
		}
		fclose($openFile);

		// Set the row & column count
		$this->rowCount = count($rawData) - 1;
		$this->columnCount = count($rawData[0]);

		// Seperate the first row, remove it from raw data and filter rest of the data
		$columnNames = $rawData[0];
		unset($rawData[0]);

		foreach ($columnNames as $key => $value) {
			$this->filteredData[$value] = array_column($rawData, $key);
		}
	}

	public function getRowCount() {
		return $this->rowCount;
	}

	public function getColumnCount() {
		return $this->columnCount;
	}

	public function getData($col, $record) {
		if(!empty($this->filteredData)) {
			return $this->filteredData[$col][$record];
		}
	}
}