@extends('layouts.app')
@section('title', 'Files Encryptor')

@section('content')
    <div class="row d-flex justify-content-center align-items-center vh-100 ">
        <div class="card p-4">
            <h1 class="text-center mb-4">File Encryptor/Decryptor</h1>
            <form id="crypt-form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="file" class="form-label">Select a file to encrypt/decrypt:</label>
                    <input type="file" class="form-control" id="file" name="file">
                    @error('file')
                        <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
                            <strong> {{ $errors->first() }} </strong>
                            <button type="button" class=" h-25 btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror
                </div>

                <div class="mb-3 d-none" id="save-location">
                    <label for="save-name" class="form-label">Write name to save encrypted/decrypted file:</label>
                    <input class="mb-2 form-control" id="save-name"  type="text" placeholder="write the new file's name"   name="fileName" />
                 </div>
                <div class="mb-3">
                    <button id="encrypt" class="btn btn-primary mx-2" onclick="encryptFile()">Encrypt</button>
                    <button id="decrypt" class="btn btn-primary mx-2" onclick="decryptFile()">Decrypt</button>
                </div>
            </form>


            <hr>
            <h3 class="mb-3">File Information</h3>
            <div class="mb-3">
                <p><strong>File Name:</strong> <span id="file-name"></span></p>
                <p><strong>File Size:</strong> <span id="file-size"></span></p>
                <p><strong>File Extension:</strong> <span id="file-extension"></span></p>
            </div>
        </div>

    </div>


@endsection

@push('js')
    <script>
        let cryptForm = document.getElementById('crypt-form');
        let fileInput = document.getElementById('file');
        let fileName = document.getElementById('file-name');
        let fileSize = document.getElementById('file-size');
        let saveDirDiv = document.getElementById('save-location');
        let fileExtension = document.getElementById('file-extension');

        fileInput.addEventListener('change', function() {
            saveDirDiv.classList.remove('d-none');
            let file = this.files[0];
            fileName.textContent = file.name;
            fileSize.textContent = formatBytes(file.size);
            fileExtension.textContent = file.type.split('/').pop();
        });

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            let k = 1024;
            let dm = decimals < 0 ? 0 : decimals;
            let sizes = ['Bytes', 'KB', 'MB'];
            let i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        function encryptFile() {
            cryptForm.action = '/encrypt';
        }

        function decryptFile() {
            cryptForm.action = '/decrypt';
        }
    </script>
@endpush
