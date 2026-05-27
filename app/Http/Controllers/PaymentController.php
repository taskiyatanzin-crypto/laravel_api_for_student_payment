<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PdfController extends Controller
{
    public function downloadReceipt($id)
    {
        $payment = Payment::with('student')->findOrFail($id);

        // 1️⃣ PDF generate (same logic)
        $pdf = Pdf::loadView('receipt', compact('payment'));

        // 2️⃣ temp file create
        $fileName = 'receipt_' . $payment->id . '.pdf';
        $filePath = storage_path("app/temp_" . $fileName);

        // ensure storage folder exists
        if (!file_exists(storage_path("app"))) {
            mkdir(storage_path("app"), 0777, true);
        }

        // save PDF temporarily
        file_put_contents($filePath, $pdf->output());

        // 3️⃣ upload to Cloudinary
        $uploadedFile = Cloudinary::upload($filePath, [
            'folder' => 'receipts'
        ]);

        // get URL
        $url = $uploadedFile->getSecurePath();

        // 4️⃣ cleanup
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // 5️⃣ return ONLY URL (frontend unchanged)
        return response()->json([
            'url' => $url
        ]);
    }
}
