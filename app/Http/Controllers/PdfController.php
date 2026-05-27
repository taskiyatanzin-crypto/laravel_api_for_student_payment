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

        $dir = storage_path('app/temp');

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $filePath = $dir . '/receipt_' . $payment->id . '.pdf';

        file_put_contents($filePath, $pdf->output());

        // ⚠️ Cloudinary temporarily disable test
        // comment this first
        // $uploadedFile = Cloudinary::upload($filePath, [
        //     'folder' => 'receipts',
        //     'resource_type' => 'raw',
        // ]);

        // $url = $uploadedFile->getSecurePath();

        $url = url('/storage/' . basename($filePath));

        if (file_exists($filePath)) {
            unlink($filePath);
        }

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
