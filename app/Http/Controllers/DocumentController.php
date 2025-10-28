<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentUploadRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    // Listado de documentos del usuario (admin ve todos)
    public function index(Request $request)
    {
        $user = $request->user();

        $docs = ($user->role === 'admin')
            ? Document::latest()->paginate(10)
            : Document::where('owner_user_id', $user->id)->latest()->paginate(10);

        return view('documents.index', compact('docs'));
    }

    public function form()
    {
        $this->authorize('upload', Document::class);
        return view('documents.upload');
    }

    public function upload(DocumentUploadRequest $request)
    {
        $this->authorize('upload', Document::class);

        $user = $request->user();
        $file = $request->file('file');

        // Seguridad: MIME real y hash
        $mime   = $file->getMimeType();
        $size   = $file->getSize();
        $orig   = $file->getClientOriginalName();
        $binary = file_get_contents($file->getRealPath());
        $sha256 = hash('sha256', $binary);

        // Nombre y ruta
        $uuid      = (string) Str::uuid();
        $fileName  = $uuid . '.pdf';
        $dir       = 'docs/' . now()->format('Y/m');
        $path      = $dir . '/' . $fileName;

        // Guardar en storage local (protegido)
        Storage::disk('local')->put($path, $binary);

        // Crear registro
        $doc = Document::create([
            'owner_user_id' => $user->id,
            'doc_type'      => $request->doc_type,
            'original_name' => $orig,
            'file_name'     => $fileName,
            'file_path'     => $path,
            'mime_type'     => $mime,
            'file_size'     => $size,
            'sha256'        => $sha256,
            'application_id'=> $request->application_id,
        ]);

        return redirect()->route('documents.index')->with('success','Documento subido correctamente.');
    }

    public function download(Document $document)
    {
        $this->authorize('download', $document);

        if (!Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'Archivo no encontrado.');
        }

        // Descarga segura
        return response()->streamDownload(function () use ($document) {
            echo Storage::disk('local')->get($document->file_path);
        }, $document->original_name, [
            'Content-Type'        => $document->mime_type,
            'Content-Disposition' => 'attachment; filename="'.$document->original_name.'"',
            'Content-Length'      => $document->file_size,
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);

        Storage::disk('local')->delete($document->file_path);
        $document->delete();

        return back()->with('success','Documento eliminado.');
    }
}
