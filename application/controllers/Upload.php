<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Upload extends CI_Controller{

    function __construct(){

        parent::__construct();
        $this->yield    = FALSE;
        $this->data["upload_path"]  = $this->config->item("upload_path");
    }

    // 이미지 업로드
    function imageUpload(){
        $img_name                   = "file-0";
        $today                      = date("Ymd");
        $img_path                   = '/upload/' . $today . '/';
        $config["upload_path"]      = $this->data['upload_path'] . $today . '/';
        $config["allowed_types"]    = 'gif|jpg|jpeg|png';
        $config["max_size"]         = '30720';
        $config["encrypt_name"]     = true;

        if(!is_dir($config["upload_path"])){
            mkdir($config["upload_path"] , 0777, true);
        }

        $this->load->library("upload", $config);
        $this->upload->initialize($config);

        $this->upload->do_upload($img_name);
        if( $this->upload->display_errors() != '' ){
            $result          = array("status" => "error" , "message" => $this->upload->display_errors());
        } else {
            $data 			 = $this->upload->data();
            $result 		 = array(
                "status"     => "success",
                "img_path"   => $img_path . $data["file_name"],
                "img_name"   => $data["orig_name"]
            );

        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    // 엑셀파일 업로드
    function excelUpload(){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        $this->load->model("m_ai");
        // 엑셀 파일 업로드 설정
        $upload_name                = "file-0";
        $today                      = date("Ymd");
        $config["upload_path"]      = APPPATH . "third_party/" . $today . "/";
        $config["allowed_types"]    = 'xls|xlsx';
        $config["max_size"]         = '30720';
        $config["encrypt_name"]     = true;

        if(!is_dir($config["upload_path"])){
            mkdir($config["upload_path"] , 0777, true);
        }

        $this->load->library('upload', $config);
        $this->upload->do_upload($upload_name);
        if( $this->upload->display_errors() != '' ){
            $result         = array("status" => "error" , "message" => $this->upload->display_errors());
        } else {
            $data 	        = $this->upload->data();
            $file_path      = $config["upload_path"] . $data['file_name'];

            try {
                // 엑셀 파일 읽기
                $spreadsheet        = IOFactory::load($file_path);
                $sheet              = $spreadsheet->getActiveSheet();
                $last_row           = $sheet->getHighestRow();
                // 엑셀의 2번째 행부터 데이터로 가정 (1번째 행은 보통 헤더)
                for( $row = 2; $row <= $last_row; $row++ ){
                    // DB에 저장할 데이터 배열 생성
                    $data_to_insert = [
                        "A"     => $sheet->getCell("A" . $row)->getValue(),
                        "B"     => $sheet->getCell("B" . $row)->getValue(),
                        "C"     => $sheet->getCell("C" . $row)->getValue(),
                        "D"     => $sheet->getCell("D" . $row)->getValue(),
                        "E"     => $sheet->getCell("E" . $row)->getValue(),
                        "F"     => $sheet->getCell("F" . $row)->getValue(),
                        "G"     => $sheet->getCell("G" . $row)->getValue(),
                        "H"     => $sheet->getCell("H" . $row)->getValue(),
                        "I"     => $sheet->getCell("I" . $row)->getValue(),
                        "J"     => $sheet->getCell("J" . $row)->getValue(),
                        "K"     => $sheet->getCell("K" . $row)->getValue(),
                        "L"     => $sheet->getCell("L" . $row)->getValue(),
                        "M"     => $sheet->getCell("M" . $row)->getValue(),
                        "N"     => $sheet->getCell("N" . $row)->getValue(),
                        "O"     => $sheet->getCell("O" . $row)->getValue(),
                        "P"     => $sheet->getCell("P" . $row)->getValue(),
                        "Q"     => $sheet->getCell("Q" . $row)->getValue(),
                        "R"     => $sheet->getCell("R" . $row)->getValue(),
                        "S"     => $sheet->getCell("S" . $row)->getValue(),
                        "T"     => $sheet->getCell("T" . $row)->getValue(),
                        "U"     => $sheet->getCell("U" . $row)->getValue(),
                        "V"     => $sheet->getCell("V" . $row)->getValue(),
                        "W"     => $sheet->getCell("W" . $row)->getValue(),
                        "X"     => $sheet->getCell("X" . $row)->getValue(),
                        "Y"     => $sheet->getCell("Y" . $row)->getValue(),
                        "Z"     => $sheet->getCell("Z" . $row)->getValue(),
                        "AA"    => $sheet->getCell("AA" . $row)->getValue(),
                        "AB"    => $sheet->getCell("AB" . $row)->getValue(),
                        "AC"    => $sheet->getCell("AC" . $row)->getValue(),
                        "AD"    => $sheet->getCell("AD" . $row)->getValue(),
                        "AE"    => $sheet->getCell("AE" . $row)->getValue(),
                        "AF"    => $sheet->getCell("AF" . $row)->getValue(),
                        "AG"    => $sheet->getCell("AG" . $row)->getValue(),
                        "AH"    => $sheet->getCell("AH" . $row)->getValue(),
                        "AI"    => $sheet->getCell("AI" . $row)->getValue(),
                        "AJ"    => $sheet->getCell("AJ" . $row)->getValue(),
                        "AK"    => $sheet->getCell("AK" . $row)->getValue(),
                        "AL"    => $sheet->getCell("AL" . $row)->getValue(),
                        "AM"    => $sheet->getCell("AM" . $row)->getValue(),
                        "AN"    => $sheet->getCell("AN" . $row)->getValue(),
                        "AO"    => $sheet->getCell("AO" . $row)->getValue(),
                        "AP"    => $sheet->getCell("AP" . $row)->getValue(),
                        "AQ"    => $sheet->getCell("AQ" . $row)->getValue(),
                        "AS"    => $sheet->getCell("AS" . $row)->getValue(),
                        "AT"    => $sheet->getCell("AT" . $row)->getValue(),
                        "AU"    => $sheet->getCell("AU" . $row)->getValue(),
                        "AV"    => $sheet->getCell("AV" . $row)->getValue(),
                        "AW"    => $sheet->getCell("AW" . $row)->getValue(),
                        "AX"    => $sheet->getCell("AX" . $row)->getValue(),
                        "AY"    => $sheet->getCell("AY" . $row)->getValue(),
                        "AZ"    => $sheet->getCell("AZ" . $row)->getValue(),
                        "BA"    => $sheet->getCell("BA" . $row)->getValue(),
                        "BB"    => $sheet->getCell("BB" . $row)->getValue(),
                        "BC"    => $sheet->getCell("BC" . $row)->getValue(),
                        "BD"    => $sheet->getCell("BD" . $row)->getValue(),
                        "BE"    => $sheet->getCell("BE" . $row)->getValue(),
                        "BF"    => $sheet->getCell("BF" . $row)->getValue(),
                        "BG"    => $sheet->getCell("BG" . $row)->getValue(),
                        "BH"    => $sheet->getCell("BH" . $row)->getValue(),
                        "BI"    => $sheet->getCell("BI" . $row)->getValue(),
                        "BJ"    => $sheet->getCell("BJ" . $row)->getValue(),
                        "BK"    => $sheet->getCell("BK" . $row)->getValue(),
                        "BL"    => $sheet->getCell("BL" . $row)->getValue(),
                        "BM"    => $sheet->getCell("BM" . $row)->getValue(),
                        "BN"    => $sheet->getCell("BN" . $row)->getValue(),
                        "BO"    => $sheet->getCell("BO" . $row)->getValue(),
                        "BP"    => $sheet->getCell("BP" . $row)->getValue(),
                        "BQ"    => $sheet->getCell("BQ" . $row)->getValue(),
                        "BR"    => $sheet->getCell("BR" . $row)->getValue(),
                        "BS"    => $sheet->getCell("BS" . $row)->getValue(),
                        "BT"    => $sheet->getCell("BT" . $row)->getValue(),
                        "BU"    => $sheet->getCell("BU" . $row)->getValue(),
                        "BV"    => $sheet->getCell("BV" . $row)->getValue(),
                        "BW"    => $sheet->getCell("BW" . $row)->getValue(),
                        "BX"    => $sheet->getCell("BX" . $row)->getValue(),
                        "BY"    => $sheet->getCell("BY" . $row)->getValue(),
                        "BZ"    => $sheet->getCell("BZ" . $row)->getValue(),
                        "CA"    => $sheet->getCell("CA" . $row)->getValue(),
                        "CB"    => $sheet->getCell("CB" . $row)->getValue(),
                        "CC"    => $sheet->getCell("CC" . $row)->getValue(),
                        "CD"    => $sheet->getCell("CD" . $row)->getValue(),
                        "CE"    => $sheet->getCell("CE" . $row)->getValue(),
                        "CF"    => $sheet->getCell("CF" . $row)->getValue(),
                        "CG"    => $sheet->getCell("CG" . $row)->getValue(),
                        "CH"    => $sheet->getCell("CH" . $row)->getValue(),
                        "CI"    => $sheet->getCell("CI" . $row)->getValue(),
                        "CJ"    => $sheet->getCell("CJ" . $row)->getValue(),
                        "CK"    => $sheet->getCell("CK" . $row)->getValue(),
                        "CL"    => $sheet->getCell("CL" . $row)->getValue(),
                        "CM"    => $sheet->getCell("CM" . $row)->getValue(),
                        "CN"    => $sheet->getCell("CN" . $row)->getValue(),
                        "CO"    => $sheet->getCell("CO" . $row)->getValue(),
                    ];
                    $this->m_ai->insertData($data_to_insert);
                }
                $result 		 = array("status"     => "success");
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                // 엑셀 파일 읽기 실패 시 에러 처리
                $result         = array("status" => "error" , "message" => $this->upload->display_errors());
            }

        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}