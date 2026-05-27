<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    public function downloadReceipt($id)
    {
        $payment = Payment::with('student')->findOrFail($id);

        // 1. PDF generate
        $pdf = Pdf::loadView('receipt', compact('payment'));

        // 2. temp file path বানানো
        $fileName = 'receipt_' . $payment->id . '.pdf';
        $filePath = storage_path("app/public/receipts/" . $fileName);

        // 3. folder ensure করা
        if (!file_exists(storage_path("app/public/receipts"))) {
            mkdir(storage_path("app/public/receipts"), 0777, true);
        }

        // 4. PDF save locally (temp)
        file_put_contents($filePath, $pdf->output());

        // 5. Cloudinary upload
        $uploadedFile = Cloudinary::upload($filePath, [
            'folder' => 'receipts'
        ]);

        $url = $uploadedFile->getSecurePath();

        // 6. optional DB save (if needed)
        $payment->receipt_url = $url;
        $payment->save();

        // 7. file delete (cleanup)
        unlink($filePath);

        // 8. return PDF OR URL
        return response()->json([
            'success' => true,
            'url' => $url
        ]);
    }
}
