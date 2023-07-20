<?php

namespace App\Http\Controllers;

use App\Helpers\Cryptography;
use App\Http\Requests\CryptographyRequest;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Http\UploadedFile;

class CryptographyController extends Controller
{
    public function index()
    {
        return view('file-encryption');
    }

    public function encrypt(CryptographyRequest $request)
    {
        $plain = $request->file;
        $path = storage_path('app/encrypted-files/');
        $this->saveUploadedFileIfStorageNotExists($path, $plain);
        $outputPath = $path . ($request->fileName ?? $plain->getBaseName());
        Cryptography::encrypt($plain, $outputPath);
        return response()->download($outputPath);
    }

    public function decrypt(CryptographyRequest $request)
    {
        $plain = $request->file;
        $path = storage_path('app/encrypted-files/');
        $this->saveUploadedFileIfStorageNotExists($path, $plain);
        $outputPath = $path . ($request->fileName ?? $plain->getBaseName());
        Cryptography::decrypt($plain, $outputPath);
        return response()->download($outputPath);
    }

    public function saveUploadedFileIfStorageNotExists(string $path, UploadedFile $file)
    {
        if (!file_exists($path)) {
            Storage::put('encrypted-files/', $file);
        }
    }
}
