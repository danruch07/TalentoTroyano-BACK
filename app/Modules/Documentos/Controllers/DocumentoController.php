<?php
namespace App\Modules\Documentos\Controllers;

use App\Http\Controllers\Controller;
use App\Soporte\RespuestaApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Modules\Documentos\Requests\UploadDocumentRequest;
use App\Modules\Documentos\Models\Documento;
use App\Modules\Documentos\Resources\DocumentoResource;

class DocumentoController extends Controller {
    use RespuestaApi;

    public function store(UploadDocumentRequest $req) {
        $file = $req->file('file');
        $path = $file->store('', 'documentos'); // guarda en storage/app/documentos

        $doc = Documento::create([
            'docRoute' => $path,
            'idUser'   => $req->user()->idUser,
            'modDate'  => now(),
        ]);

        return $this->created(new DocumentoResource($doc), 'Document uploaded');
    }

    public function show(Documento $documento) {
        $this->authorize('view', $documento);
        return $this->ok(new DocumentoResource($documento));
    }

    // URL firmada temporal para descarga segura
    public function downloadUrl(Documento $documento) {
        $this->authorize('view', $documento);
        $url = \URL::temporarySignedRoute(
            'documents.download.signed',
            now()->addMinutes(5),
            ['documento'=>$documento->idDocument]
        );
        return $this->ok(['url'=>$url], 'Signed URL');
    }

    // Entrega el archivo con firma válida
    public function downloadSigned(Documento $documento, Request $r) {
        if (!$r->hasValidSignature()) abort(401, 'Invalid or expired URL');
        $this->authorize('view', $documento);
        return Storage::disk('documentos')->download($documento->docRoute);
    }
}
