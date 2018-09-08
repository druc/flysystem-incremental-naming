<?php

namespace Druc\Flysystem\IncrementalNaming;

trait IncrementsPath
{
    /**
     * @param $filePath
     * @return string
     */
    private function getIncrementedPath($filePath)
    {
        $originalFilePath = $filePath;
        $increment = 1;

        while ($this->fileExists($filePath)) {
            $filePath = $this->incrementPath($originalFilePath, $increment);
            $increment++;
        }

        return $filePath;
    }

    /**
     * @param $filePath
     * @return bool
     */
    private function fileExists($filePath)
    {
        $directory = pathinfo($filePath, PATHINFO_DIRNAME);
        $existingPaths = array_column($this->filesystem->listContents($directory), 'path');
        
        return in_array($filePath, $existingPaths);
    }

    /**
     * @param $originalFilePath
     * @param $increment
     * @return null|string|string[]
     */
    private function incrementPath($originalFilePath, $increment)
    {
        if ($this->pathHasExtension($originalFilePath)) {
            return preg_replace('#^(.+)\.([\w]+)$#i', '$1_' . $increment . '.$2', $originalFilePath);
        }

        return $originalFilePath . '_' . $increment;
    }

    /**
     * @param $filePath
     * @return bool|int
     */
    private function pathHasExtension($filePath)
    {
        return (bool)strpos($filePath, '.');
    }
}
