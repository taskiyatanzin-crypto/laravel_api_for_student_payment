<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PdfController extends Controller
{
    public function downloadReceipt($id)
    {
        try {

            // 1. Get payment with student
            $payment = Payment::with('student')->findOrFail($id);

            // 2. Generate PDF
            $pdf = Pdf::loadView('receipt', compact('payment'));

            // 3. Create temp file
            $tempFile = tempnam(sys_get_temp_dir(), 'receipt_');
            file_put_contents($tempFile, $pdf->output());

            // 4. Upload to Cloudinary (RAW file)
            $uploadedFile = Cloudinary::uploadFile(
                $tempFile,
                [
                    'resource_type' => 'raw',
                    'folder' => 'receipts',
                    'public_id' => 'receipt_' . $payment->id,
                    'overwrite' => true,
                ]
            );

            // 5. Remove temp file
            unlink($tempFile);

            // 6. Get Cloudinary URL
            $url = $uploadedFile->getSecurePath();

            return response()->json([
                'success' => true,
                'url' => $url
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Receipt generation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
