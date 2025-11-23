<?php

namespace App\Modules\Usuarios\Controllers;

use App\Http\Controllers\Controller;
use App\Soporte\RespuestaApi;
use App\Modules\Usuarios\Models\Usuario;
use App\Modules\Companies\Models\Company;
use App\Modules\Companies\Models\AdminCompany;
use App\Modules\Documentos\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUaqController extends Controller
{
    use RespuestaApi;

    /**
     * 1) Admin UAQ crea empresa con credenciales temporales para el reclutador.
     * Campos esperados en el body:
     *  - compName (string)
     *  - rfc (string)
     *  - recruiterName (string)
     *  - recruiterLastName (string|nullable)
     *  - recruiterEmail (email)
     *  - industria (string)
     *  - ubicacion, telefono, descripcion (opcionales)
     */
    public function createCompany(Request $request)
    {
        $data = $request->validate([
            'compName'          => ['required', 'string', 'max:150'],
            'rfc'               => ['required', 'string', 'max:13'],
            'recruiterName'     => ['required', 'string', 'max:100'],
            'recruiterLastName' => ['nullable', 'string', 'max:100'],
            'recruiterEmail'    => ['required', 'email', 'max:100', 'unique:admins,adEmail'],
            'industria'         => ['required', 'string', 'max:100'],
            'ubicacion'         => ['nullable', 'string', 'max:255'],
            'telefono'          => ['nullable', 'string', 'max:20'],
            'descripcion'       => ['nullable', 'string'],
        ]);

        return DB::transaction(function () use ($data) {
            // Crear empresa
            $company = Company::create([
                'compName'   => $data['compName'],
                'ubicacion'  => $data['ubicacion'] ?? null,
                'telefono'   => $data['telefono'] ?? null,
                'email'      => $data['recruiterEmail'],
                'descripcion'=> $data['descripcion'] ?? null,
                'industria'  => $data['industria'],
                'rfc'        => $data['rfc'],
            ]);

            // Generar contraseña temporal
            $plainPassword = Str::random(10);

            // Crear admin de empresa (reclutador)
            $admin = AdminCompany::create([
                'idCompany'        => $company->idCompany,
                'adName'           => $data['recruiterName'],
                'adLastName'       => $data['recruiterLastName'] ?? '',
                'adEmail'          => $data['recruiterEmail'],
                'adPassword'       => Hash::make($plainPassword),
                'adPhoneNumber'    => $data['telefono'] ?? null,
                'adProfilePicture' => null,
            ]);

            return $this->created([
                'company' => [
                    'idCompany' => $company->idCompany,
                    'compName'  => $company->compName,
                    'industria' => $company->industria,
                    'rfc'       => $company->rfc,
                ],
                'recruiter' => [
                    'idAdmin'   => $admin->idAdmin,
                    'name'      => $admin->adName,
                    'lastName'  => $admin->adLastName,
                    'email'     => $admin->adEmail,
                ],
                'tempCredentials' => [
                    'email'    => $admin->adEmail,
                    'password' => $plainPassword,
                ],
            ], 'Empresa creada con credenciales temporales');
        });
    }

    /**
     * 2) Dar de baja alumno (Admin UAQ).
     * Elimina el usuario; postulations y demás se eliminan por FK cascade.
     */
    public function deactivateStudent(int $idUser)
    {
        $user = Usuario::find($idUser);

        if (!$user) {
            return $this->notFound('Alumno no encontrado');
        }

        $user->delete();

        return $this->ok(null, 'Alumno dado de baja correctamente');
    }

    /**
     * 3) Dar de baja empresa (Admin UAQ).
     * Elimina la empresa; vacants, admins, postulations se borran por cascade.
     */
    public function deactivateCompany(int $idCompany)
    {
        $company = Company::find($idCompany);

        if (!$company) {
            return $this->notFound('Empresa no encontrada');
        }

        $company->delete();

        return $this->ok(null, 'Empresa dada de baja correctamente');
    }

    /**
     * 4) Regresar lista de alumnos con expediente y carrera.
     * Carrera = programa asociado por sus postulaciones (si existe).
     */
    public function listStudents()
    {
        $students = DB::table('users as u')
            ->leftJoin('postulations as p', 'p.idUser', '=', 'u.idUser')
            ->leftJoin('programs as pr', 'pr.idPrograms', '=', 'p.idPrograms')
            ->select(
                'u.idUser',
                'u.usName',
                'u.usLastName',
                'u.expedient',
                DB::raw('MAX(pr.prName) as career')
            )
            ->groupBy('u.idUser', 'u.usName', 'u.usLastName', 'u.expedient')
            ->orderBy('u.usName')
            ->get();

        return $this->ok([
            'students' => $students,
        ]);
    }

    /**
     * 5) Regresar lista de empresas con nombre de encargado (reclutador).
     */
    public function listCompanies()
    {
        $companies = DB::table('companies as c')
            ->leftJoin('admins as a', 'a.idCompany', '=', 'c.idCompany')
            ->select(
                'c.idCompany',
                'c.compName',
                'c.industria',
                'c.rfc',
                'c.email',
                'a.idAdmin',
                'a.adName',
                'a.adLastName',
                'a.adEmail'
            )
            ->orderBy('c.compName')
            ->get();

        return $this->ok([
            'companies' => $companies,
        ]);
    }

    /**
     * 6) Regresar CV de un alumno (último documento cargado).
     */
    public function getStudentCv(int $idUser)
    {
        $document = Documento::where('idUser', $idUser)
            ->orderByDesc('modDate')
            ->first();

        if (!$document) {
            return $this->notFound('El alumno no tiene CV registrado');
        }

        return $this->ok([
            'cv' => [
                'idDocument' => $document->idDocument,
                'docRoute'   => $document->docRoute,
                'modDate'    => $document->modDate,
            ],
        ]);
    }
}

