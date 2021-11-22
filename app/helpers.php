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
