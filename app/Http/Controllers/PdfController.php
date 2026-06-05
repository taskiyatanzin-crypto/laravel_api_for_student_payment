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

        $payment = Payment::with('student')->findOrFail($id);

        $pdf = Pdf::loadView('receipt', compact('payment'));

        $tempFile = tempnam(sys_get_temp_dir(), 'receipt_');
        file_put_contents($tempFile, $pdf->output());

        $uploadedFile = Cloudinary::uploadFile(
            $tempFile,
            [
                'resource_type' => 'raw',
                'folder' => 'receipts',
                'public_id' => 'receipt_' . $payment->id,
                'overwrite' => true,
            ]
        );

        unlink($tempFile);

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
