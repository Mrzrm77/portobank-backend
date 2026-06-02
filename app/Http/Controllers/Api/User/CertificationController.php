<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\Certification\StoreCertificationRequest;
use App\Http\Requests\User\Certification\UpdateCertificationRequest;
use App\Http\Requests\User\Certification\UploadCertificationImageRequest;
use App\Services\User\CertificationService;

class CertificationController extends Controller
{
    public function index(CertificationService $service)
    {
        return response()->json([
            'success' => true,
            'data' => $service->get(auth()->user())
        ]);
    }

    public function store(StoreCertificationRequest $request, CertificationService $service)
    {
        $certificate = $service->store(auth()->user(), $request->validated());

        return response()->json([
            'success' => true,
            'data' => $certificate
        ]);
    }

    public function update($id, UpdateCertificationRequest $request, CertificationService $service)
    {

        $certificate = $service->update(auth()->user(), $id, $request->validated());

        return response()->json([
            'success' => true,
            'data' => $certificate
        ]);
    }

    public function destroy($id, CertificationService $service)
    {
        $service->delete(auth()->user(), $id);

        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ]);
    }

    public function uploadImage(
        UploadCertificationImageRequest $request,
        CertificationService $certificationService,
        int $id
    ) {
        $certification = $certificationService
            ->uploadImage(
                auth()->user(),
                $id,
                $request->file('certificate')
            );
    
        return response()->json([
            'success' => true,
            'message' => 'Certificate uploaded successfully',
            'data' => $certification,
        ]);
    }
}
