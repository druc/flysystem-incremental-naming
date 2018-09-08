<?php

namespace Druc\Flysystem\IncrementalNaming;

use League\Flysystem\FileExistsException;
use League\Flysystem\Plugin\AbstractPlugin;

class IncrementedRename extends AbstractPlugin
{
    use IncrementsPath;

    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        return 'incrementedRename';
    }

    /**
     * @param $path
     * @param $newpath
     * @return bool
     * @throws FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function handle($path, $newpath)
    {
        return $this->filesystem->rename($path, $this->getIncrementedPath($newpath));
    }
}
