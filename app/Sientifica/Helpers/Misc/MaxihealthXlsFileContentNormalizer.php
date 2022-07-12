<?php

namespace Sientifica\Helpers\Misc;

use \Sientifica\Helpers\Misc\interfaces\IFileContentNormalizer;
use \PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class MaxihealthXlsFileContentNormalizer implements IFileContentNormalizer{



	public function normalizeFileContent ($filePath){


		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		$reader->setLoadSheetsOnly(["Product Data"]);
		$reader->setReadEmptyCells(true);
		$spreadsheet = $reader->load($filePath);
		$workSheet = $spreadsheet->getActiveSheet();
		$fileContent = '';


		for ($i=1;$i<=$workSheet->getHighestRow();$i++){
		//foreach ($workSheet->getRowIterator() as $row) {

			$arrRow = array();
			$arrRow[0] = ($workSheet->getCell('A'.$i)->getDataType() != 'null') ? $workSheet->getCell('A'.$i)->getValue() : '""';
			$arrRow[1] = ($workSheet->getCell('B'.$i)->getDataType() != 'null')  ? $workSheet->getCell('B'.$i)->getValue() : '""';
			$arrRow[2] = ($workSheet->getCell('C'.$i)->getDataType() != 'null')  ? $workSheet->getCell('C'.$i)->getValue() : '""';
			$arrRow[3] = ($workSheet->getCell('D'.$i)->getDataType() != 'null')  ? $workSheet->getCell('D'.$i)->getValue() : '""';
			$arrRow[4] = ($workSheet->getCell('E'.$i)->getDataType() != 'null')  ? $workSheet->getCell('E'.$i)->getValue() : '""';
			$arrRow[5] = ($workSheet->getCell('F'.$i)->getDataType() != 'null')  ? $workSheet->getCell('F'.$i)->getValue() : '""';
			$arrRow[6] = ($workSheet->getCell('G'.$i)->getDataType() != 'null')  ? $workSheet->getCell('G'.$i)->getValue() : '""';
			$arrRow[7] = ($workSheet->getCell('H'.$i)->getDataType() != 'null')  ? $workSheet->getCell('H'.$i)->getValue() : '""';
			$arrRow[8] = ($workSheet->getCell('I'.$i)->getDataType() != 'null')  ? $workSheet->getCell('I'.$i)->getValue() : '""';
			$arrRow[9] = ($workSheet->getCell('J'.$i)->getDataType() != 'null')  ? $workSheet->getCell('J'.$i)->getValue() : '""';
			$arrRow[10] = ($workSheet->getCell('K'.$i)->getDataType() != 'null')  ? $workSheet->getCell('K'.$i)->getValue() : '""';
			$arrRow[11] = ($workSheet->getCell('L'.$i)->getDataType() != 'null')  ? $workSheet->getCell('L'.$i)->getValue() : '""';
			$arrRow[12] = ($workSheet->getCell('M'.$i)->getDataType() != 'null')  ? $workSheet->getCell('M'.$i)->getValue() : '""';
			$arrRow[13] = ($workSheet->getCell('N'.$i)->getDataType() != 'null')  ? $workSheet->getCell('N'.$i)->getValue() : '""';
			$arrRow[14] = ($workSheet->getCell('O'.$i)->getDataType() != 'null')  ? $workSheet->getCell('O'.$i)->getValue() : '""';
			$arrRow[15] = ($workSheet->getCell('P'.$i)->getDataType() != 'null')  ? $workSheet->getCell('P'.$i)->getValue() : '""';
			$arrRow[16] = ($workSheet->getCell('Q'.$i)->getDataType() != 'null')  ? $workSheet->getCell('Q'.$i)->getValue() : '""';
			$arrRow[17] = "\n";
			$row = implode("__-__",$arrRow);
			$fileContent .= $row;
		}
		$fileContent = $this->cleanUselessNewLineCharacters($fileContent);
		$fileContent = $this->cleanHTMLEntities($fileContent);
		$fileContent = preg_replace("/__\-__$/","",$fileContent);
		return $fileContent;

	}



	/**
	 * This function removes any unnecessary new line chars, 
	 * it makes clean every record of the file, ready to be
	 * read line by line.
	 * 
	 * @param string $fileContent 	Raw file content.
	 * @return string $fileContent 	Cleaned file content, every record in one file row.
	 */

	private function cleanUselessNewLineCharacters($fileContent){

		$fileContent = preg_replace("/>([\ \	]){0,300}([\r\n|\n|\r]{1,3})([\ \	]){0,300}/",'>',$fileContent);
		$fileContent = preg_replace("/(\ ){0,100}([\r\n|\n|\r]{1,3})(\ ){0,100}</",'<',$fileContent);
		$fileContent = preg_replace("/\-__(\r\n|\n|\r)([0-9]{1,4})__/","||$2__",$fileContent);
		$fileContent = preg_replace("/(\r\n|\n|\r)/","",$fileContent);
		$fileContent = preg_replace("/\|\|/","\n",$fileContent);

		return $fileContent;

	}

	/**
	 * This function removes any HTML entities definition because of semicolons, 
	 * 
	 * 
	 * @param string $fileContent 	Raw file content.
	 * @return string $fileContent 	Cleared of HTML entities
	 */

	private function cleanHTMLEntities($fileContent){

		$fileContent = html_entity_decode($fileContent,ENT_QUOTES);
		return $fileContent;

	}



}