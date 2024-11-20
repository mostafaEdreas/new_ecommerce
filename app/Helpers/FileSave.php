<?php
namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class FileSave
{
    private UploadedFile $file;
    private string $path;
    private string $fileName;
    private ?int $realHeight = null;
    private ?int $realWidth = null;

    /**
     * Constructor
     */
    public function __construct(UploadedFile $file, string $folderOrFullPath, bool $isFolder = true)
    {
        $this->file = $file;
        $this->path = $isFolder ? $this->buildPath($folderOrFullPath) : $folderOrFullPath;
        $this->fileName = $this->generateFileName();

        $this->ensureDirectoryExists();

        if ($this->isImage()) {
            $this->setImageDimensions();
        }
    }

    /**
     * Save the file to the specified folder
     */
    public function save(string $subFolder = ''): string
    {
        $destination = $this->path . ($subFolder ? "/$subFolder" : '');
        $this->ensureDirectoryExists($destination);

        $filePath = "$destination/{$this->fileName}.{$this->getExtension()}";
        $this->file->move($destination, "{$this->fileName}.{$this->getExtension()}");

        return $filePath;
    }

    /**
     * Delete a file
     */
    public static function delete(string $fileName, string $folderOrFullPath, bool $isFolder = true): void
    {
        $path = $isFolder ? base_path("uploads/$folderOrFullPath/source") : $folderOrFullPath;
        $filePath = "$path/$fileName";

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    /**
     * Build the path for saving files
     */
    private function buildPath(string $folder): string
    {
        return base_path("uploads/$folder/source");
    }

    /**
     * Generate a unique file name
     */
    private function generateFileName(): string
    {
        return now()->format('YmdHisu');
    }

    /**
     * Ensure a directory exists
     */
    private function ensureDirectoryExists(string $directory = null): void
    {
        $directory = $directory ?? $this->path;
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    }

    /**
     * Determine if the file is an image
     */
    private function isImage(): bool
    {
        return str_starts_with($this->file->getMimeType(), 'image/');
    }

    /**
     * Set image dimensions
     */
    private function setImageDimensions(): void
    {
        [$width, $height] = getimagesize($this->file->getRealPath());
        $this->realWidth = $width;
        $this->realHeight = $height;
    }

    /**
     * Get the file extension
     */
    public function getExtension(): string
    {
        return $this->file->getClientOriginalExtension();
    }

    /**
     * Get the file MIME type
     */
    public function getMimeType(): string
    {
        return $this->file->getMimeType();
    }

    /**
     * Get the file name
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * Get the file path
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the real width of the image
     */
    public function getWidth(): ?int
    {
        return $this->realWidth;
    }

    /**
     * Get the real height of the image
     */
    public function getHeight(): ?int
    {
        return $this->realHeight;
    }
}
