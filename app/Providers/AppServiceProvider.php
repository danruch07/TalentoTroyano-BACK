<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Modules\Documentos\Models\Documento;
use App\Modules\Documentos\Policies\DocumentoPolicy;

class AuthServiceProvider extends ServiceProvider {
    protected $policies = [ Documento::class => DocumentoPolicy::class ];
    public function boot(): void { $this->registerPolicies(); }
}
