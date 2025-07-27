<?php

namespace App\Services\Api;

use App\Models\Certificate;
use App\Models\CertificateRenewRequest;
use App\Traits\StoreImageTrait;

class APIService
{
    use StoreImageTrait;

    public function certificateRenew($request)
    {
        try {
            $query = Certificate::with(['user.info']) // Eager load user and their info
                ->whereHas('user.info', function ($qry) {
                    $qry->whereNotNull('first_name')
                        ->whereNotNull('last_name');
                });

            if (!empty($request['q'])) {
                $q = $request['q'];
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->where(function ($subQry) use ($q) {
                        $subQry->where('name', 'LIKE', '%' . $q . '%')
                            ->orWhere('email', 'LIKE', '%' . $q . '%')
                            ->orWhere('phone', 'LIKE', '%' . $q . '%');
                    });
                });
            }

            if (!empty($request['cert_number'])) {
                $query->where('cert_registration_number', $request['cert_number']);
            }

            $certificates = $query->orderBy('id', 'desc')->paginate(10)
                ->appends([
                    'q' => $request['q'] ?? null,
                    'cert_number' => $request['cert_number'] ?? null,
                ]);

            return response()->json([
                'data' => $certificates,
                'message' => null,
                'error' => null,
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error retrieving certificates: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function certificateRenewStore($validated)
    {
        try {
            // Check for duplicate certificate renewal requests
            $certCheck = CertificateRenewRequest::where('user_id', $validated['user_id'])
                ->where('cert_registration_number', $validated['cert_registration_number'])
                ->exists();

            if ($certCheck) {
                return response()->json([
                    'message' => 'You have already requested a certificate renewal.',
                    'error' => null,
                    'status' => 400,
                ], 400);
            }

            // Process the voucher image and get the filename
            $voucherImageName = $this->processVoucherImage($validated['voucher_image']);

            // Create a new certificate renewal request
            $certRenewRequest = CertificateRenewRequest::create([
                'user_id' => $validated['user_id'],
                'level_id' => $validated['level_id'],
                'program_id' => $validated['program_id'],
                'cert_registration_number' => $validated['cert_registration_number'],
                'voucher_image' => $voucherImageName, // Store only the filename
                'status' => $validated['status'] ?? 'pending',
            ]);

            return response()->json([
                'data' => $certRenewRequest,
                'message' => 'Successfully applied for certificate renewal.',
                'error' => null,
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error processing renewal request: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function processVoucherImage($image)
    {
        // Define the folder where images should be stored
        $folderPath = 'certificateRenewReq'; // This is the folder in the public directory

        // Get the file extension of the image
        $extension = $image->getClientOriginalExtension();

        // Generate a unique filename for the image
        $imageName = uniqid() . '.' . $extension;

        // Store the image in the specified folder and return the image name
        $image->move(public_path($folderPath), $imageName);

        return $imageName;
    }

}
