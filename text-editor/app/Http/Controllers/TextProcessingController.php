<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TextProcessingController extends Controller
{
    public function processText(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string',
            'operations' => 'required|array',
            'operations.*' => 'in:reverse,uppercase,lowercase,remove_spaces'
        ]);

        $originalText = $request->input('text');
        $processedText = $originalText;
        
        foreach ($request->input('operations') as $operation) {
            switch ($operation) {
                case 'reverse':
                    $processedText = strrev($processedText);
                    break;
                case 'uppercase':
                    $processedText = strtoupper($processedText);
                    break;
                case 'lowercase':
                    $processedText = strtolower($processedText);
                    break;
                case 'remove_spaces':
                    $processedText = str_replace(' ', '', $processedText);
                    break;
            }
        }

        return response()->json([
            'original_text' => $originalText,
            'processed_text' => $processedText
        ]);
    }
}
