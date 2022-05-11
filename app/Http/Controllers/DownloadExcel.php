<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class DownloadExcel extends Controller
{
    public function getDownload()
    {
        //PDF file is stored under project/public/download/info.pdf
        $file= Storage::url('app/Order.xlsx');

        $headers = [
            'Content-Type' => 'application/xlsx',
        ];

        return Storage::download('Order.xlsx', 'Order.xlsx', $headers);
    }
}
