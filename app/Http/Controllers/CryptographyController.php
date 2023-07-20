<?php

namespace App\Http\Controllers;

use App\Helpers\Cryptography;
use App\Http\Requests\CryptographyRequest;

class CryptographyController extends Controller
{
    public function index()
    {
        return view('file-encryption');
    }

    public function encrypt(CryptographyRequest $request)
    {
        $plain = $request->file;
        $storage = storage_path('encrypted-files/' . ($request->fileName ?? $plain->getBaseName()));
        Cryptography::encrypt($plain, $storage);
        return response()->download($storage);
    }

    public function decrypt(CryptographyRequest $request)
    {
        $plain = $request->file;
        $storage = storage_path('encrypted-files/' . ($request->fileName ?? $plain->getBaseName()));
        Cryptography::decrypt($plain, $storage);
        return response()->download($storage);
    }
}
