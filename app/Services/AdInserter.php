<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class AdInserter
{
    /**
     * Insert ads into article HTML.
     * Strategy: insert ad partial after Nth paragraph (configurable).
     *
     * @param string $htmlContent
     * @param \App\Models\Article|null $article
     * @param int $afterParagraph insert after this paragraph (1-based). Default: 2
     * @return string
     */
    public function insertIntoContent(string $htmlContent, $article = null, int $afterParagraph = 2): string
    {
        // Only attempt insertion when article provided and placement-targeting is available
        $adHtml = '';

        if ($article) {
            $ad = Ad::query()->active()
                ->where('placement', 'article')
                ->where(function ($q) use ($article) {
                    $q->where('placement_target', $article->slug)
                      ->orWhere('placement_target', (string)$article->id);
                })
                ->orderBy('priority')
                ->first();

            if ($ad && $ad->image_path) {
                // Render the same partial to keep markup consistent
                $adHtml = View::make('layouts.partials.ad', [
                    'position' => $ad->position,
                    'placement' => 'article',
                    'placement_target' => $ad->placement_target,
                    // do not show fallback here
                ])->render();
            }
        }

        if (!$adHtml) {
            // nothing to insert
            return $htmlContent;
        }

        // Split content by paragraph tags and inject after $afterParagraph paragraphs
        $parts = preg_split('/(<\/p>)/i', $htmlContent, -1, PREG_SPLIT_DELIM_CAPTURE);
        if (!$parts || count($parts) < 3) {
            // Can't detect paragraphs reliably — append at end
            return $htmlContent . $adHtml;
        }

        $out = '';
        $paragraphCount = 0;
        for ($i = 0; $i < count($parts); $i++) {
            $out .= $parts[$i];
            // every time we see a closing </p> (which is a separate element because of PREG_SPLIT_DELIM_CAPTURE)
            if (stripos($parts[$i], '</p>') !== false) {
                $paragraphCount++;
                if ($paragraphCount === $afterParagraph) {
                    $out .= $adHtml;
                }
            }
        }

        return $out;
    }
}