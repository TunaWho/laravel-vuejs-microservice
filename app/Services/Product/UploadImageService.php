<?php

namespace App\Services\Product;

use App\Services\AbstractBaseService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;

class UploadImageService extends AbstractBaseService
{
    /**
     * Upload the photo.
     *
     * @param array $data
     *
     * @return array|null
     */
    public static function importFile($data): ?array
    {
        $filename = Str::random(40);

        try {
            $image = Image::make($data['image']);
        } catch (NotReadableException $e) {
            return null;
        }

        $tempfile = self::storeImage('local', $image, 'temp/' . $filename);

        try {
            $storagePath = Storage::disk('local')->path($tempfile);

            // This sets the basePath to get the filesize later.
            $image     = $image->setFileInfoFromPath($storagePath);
            $extension = (new \Mimey\MimeTypes())->getExtension($image->mime());

            if (empty($extension)) {
                $extension = str_replace(' ', '', Arr::get($data, 'extension'));
            }

            if (!empty($extension)) {
                $filename .= '.' . $extension;
            }

            $array = [
                'original_filename' => $filename,
                'filesize'          => $image->filesize(),
                'mime_type'         => $image->mime(),
            ];

            $array['new_filename_full'] = self::storeImage(
                config('filesystems.default'),
                $image,
                'photos/' . $filename
            );
        } finally {
            $storage = Storage::disk('local');

            if ($storage->exists($tempfile)) {
                $storage->delete($tempfile);
            }
        }//end try

        return $array;
    }

    /**
     * Store the decoded image in the temp file.
     *
     * @param string  $disk
     * @param \Intervention\Image\Image  $image
     * @param string  $filename
     *
     * @return string|null
     */
    private static function storeImage(string $disk, $image, string $filename): ?string
    {
        $path = $filename;

        $result = Storage::disk($disk)
            ->put($path, (string) $image->stream(), 'public');

        return $result ? $path : null;
    }
}
