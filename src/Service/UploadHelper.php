<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadHelper
{
    private string $logosDirectory;
    private SluggerInterface $slugger;

    public function __construct(string $logosDirectory, SluggerInterface $slugger)
    {
        $this->logosDirectory = $logosDirectory;
        $this->slugger = $slugger;
    }

    public function handleLogoUpload(?UploadedFile $logoFile, ?string $oldLogo): ?string
    {
        if (!$logoFile) return $oldLogo;

        $originalFilename = pathinfo($logoFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $logoFile->guessExtension();

        try {
            $logoFile->move($this->logosDirectory, $newFilename);
        } catch (FileException $e) {
            // log or rethrow if needed
            return $oldLogo;
        }

        // delete old logo
        if ($oldLogo) {
            $oldPath = $this->logosDirectory . '/' . $oldLogo;
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        return $newFilename;
    }
}
