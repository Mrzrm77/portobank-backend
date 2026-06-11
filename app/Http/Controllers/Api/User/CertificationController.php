<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\Certification\StoreCertificationRequest;
use App\Http\Requests\User\Certification\UpdateCertificationRequest;
use App\Services\User\CertificationService;

class CertificationController extends Controller
{
    public function index(CertificationService $service)
    {

        $certifications = $service->get(auth()->user());

        // Gunakan transform untuk mengubah setiap data di dalam collection
        $certifications->transform(function ($cert) {
            // Cek apakah URL ada dan belum berbentuk link utuh (http)
            if ($cert->certificate_url && !str_starts_with($cert->certificate_url, 'http')) {
                $cert->certificate_url = asset('storage/' . $cert->certificate_url);
            }
            return $cert;
        });

        return response()->json([
            'success' => true,
            'data' => $certifications
        ]);
    }

    public function store(StoreCertificationRequest $request, CertificationService $service)
    {
        // Ambil file dari request jika ada
        if ($request->hasFile('certificate_file')) {
            $data['certificate_file'] = $request->file('certificate_file');
        }
        $certificate = $service->store(auth()->user(), $request->validated());

        return response()->json([
            'success' => true,
            'data' => $certificate
        ]);
    }

    public function update($id, UpdateCertificationRequest $request, CertificationService $service)
    {
        if ($request->hasFile('certificate_file')) {
            $data['certificate_file'] = $request->file('certificate_file');
        }

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
