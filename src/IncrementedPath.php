<?php

namespace Druc\Flysystem\IncrementalNaming;

use League\Flysystem\Plugin\AbstractPlugin;

class IncrementedPath extends AbstractPlugin
{
    use IncrementsPath;

    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        return 'getIncrementedPath';
    }

    /**
     * @param $path
     * @return string
     */
    public function handle($path)
    {
        return $this->getIncrementedPath($path);
    }
}
