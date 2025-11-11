<?php
namespace App\Soporte;

trait RespuestaApi {
    protected function ok($data = null, string $message = 'OK', array $meta = []) {
        return response()->json(['success'=>true,'message'=>$message,'data'=>$data,'meta'=>$meta], 200);
    }
    protected function created($data = null, string $message = 'Created') {
        return response()->json(['success'=>true,'message'=>$message,'data'=>$data], 201);
    }
    protected function noContent() { return response()->json(null, 204); }
}
