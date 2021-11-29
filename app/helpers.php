<?php

if (!function_exists('photo_url'))
{
    /**
     * @param string|null $path
     * @param string|null $name
     * @return string
     */
    function photo_url(?string $path, $name = null)
    {
        if ($path) {
            return url()->route('image', $path);
        }

        return 'https://ui-avatars.com/api/?background=random&name=' . $name;
    }
}

if (!function_exists('file_responses'))
{
    /**
     * Get default response for file uploaded in [vue-formulate]
     *
     * @param string|null $path
     * @return array
     */
    function file_responses(?string $path): array
    {
        if (!$path) {
            return [];
        }

        $responses = [
            'path' => $path,
            'url' => url()->route('file', $path),
        ];

        return [$responses];
    }
}
