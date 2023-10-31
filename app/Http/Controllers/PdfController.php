<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class PdfController extends Controller
{
    public function viewPdf($filename)
    {
        $path = storage_path('app/pdfs/' . $filename);

        if (file_exists($path)) {
            return response()->file($path);
        } else {
            abort(404); // O devolver una vista de error
        }
    }
}
