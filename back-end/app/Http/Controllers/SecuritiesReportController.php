<?php

namespace App\Http\Controllers;

use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Http\JsonResponse;

class SecuritiesReportController extends Controller
{
    // Problem
    // XBRL形式で取得できるが、項目が統一されておらず画一化できない
    function getXBRLFromEdinet()
    {
        $startDate = "2023-11-01";
        $endDate = "2023-11-07";
        $date = date('Y-m-d');
        $outputDir = base_path("content/SecuritiesReport/{$date}");
        $baseUrl = 'https://api.edinet-fsa.go.jp/api/v2/';
        $apiKey = env('EDINET_API_KEY');

        if (!$apiKey) {
            echo "API Key is not set. Please check your environment configuration.\n";
            return;
        }

        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        $currentDate = $startDate;
        $downloadCount = 0;

        while (strtotime($currentDate) <= strtotime($endDate)) {
            $documentListUrl = $baseUrl . 'documents.json?date=' . $currentDate . '&type=2&Subscription-Key=' . $apiKey;

            echo "Fetching document list from URL: $documentListUrl\n";
            $response = file_get_contents($documentListUrl);

            if (!$response) {
                echo "Failed to fetch document list for date: $currentDate\n";
                $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                continue;
            }

            $documentData = json_decode($response, true);
            if ($documentData['metadata']['status'] != '200') {
                echo "Error fetching document list for date: $currentDate. Response: " . $response . "\n";
                $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                continue;
            }

            foreach ($documentData['results'] as $document) {
                $docID = $document['docID'];
                $docTypeCode = $document['docTypeCode']; // 書類種別コード

                // docTypeCodeが140または160のファイルのみ処理
                if (in_array($docTypeCode, [140, 160])) {
                    $downloadUrl = $baseUrl . "documents/$docID?type=1&Subscription-Key=$apiKey"; // type=1 はXBRL形式
                    echo "Fetching XBRL document from URL: $downloadUrl\n";

                    $zipContent = file_get_contents($downloadUrl);

                    if (!$zipContent) {
                        echo "Failed to fetch document for docID: $docID\n";
                        continue;
                    }

                    $zipPath = $outputDir . '/' . $docID . '.zip';
                    file_put_contents($zipPath, $zipContent);

                    $zip = new ZipArchive();
                    if ($zip->open($zipPath) === true) {
                        $extractDir = $outputDir . '/' . $docID;
                        $zip->extractTo($extractDir);
                        $zip->close();

                        echo "Extracted files to: $extractDir\n";

                        // Find the extracted XBRL files
                        $files = scandir($extractDir);
                        foreach ($files as $file) {
                            if (pathinfo($file, PATHINFO_EXTENSION) === 'xbrl') {
                                $xbrlFilePath = $extractDir . '/' . $file;
                                echo "Extracted XBRL file: $xbrlFilePath\n";
                            }
                        }
                    } else {
                        echo "Failed to extract ZIP for docID: $docID\n";
                    }

                    // 動作確認用。20社取得して止める
                    $downloadCount++;
                    if ($downloadCount >= 20) {
                        echo "Downloaded 20 files. Stopping the process.\n";
                        return;
                    }
                }
            }

            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        echo "Finished processing all dates. Total files downloaded: $downloadCount\n";
    }

    function getSecuritiesReportList(): JsonResponse
    {
        $filePath = base_path("content/SecuritiesReport/dummy/data.json");
        $fileContent = File::get($filePath);
        $data = json_decode($fileContent, true);

        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getSecuritiesReport(int $company_id): JsonResponse
    {
        $filePath = base_path("content/SecuritiesReport/dummy/{$company_id}.json");

        // ファイルが存在しない場合のエラーハンドリング
        if (!File::exists($filePath)) {
            return response()->json([
                'status' => 'error',
                'message' => "File for company_id {$company_id} not found."
            ], 404);
        }

        $fileContent = File::get($filePath);
        $data = json_decode($fileContent, true);

        return response()->json($data);
    }
}
