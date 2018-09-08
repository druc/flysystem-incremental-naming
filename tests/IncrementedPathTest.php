<?php

namespace Druc\Flysystem\IncrementalNaming\Tests;

use Druc\Flysystem\IncrementalNaming\IncrementedPath;
use PHPUnit\Framework\TestCase;

class IncrementedPathTest extends TestCase
{
    protected $filesystem;
    protected $plugin;

    public function setUp()
    {
        $this->filesystem = $this->prophesize('League\Flysystem\FilesystemInterface');
        $this->plugin = new IncrementedPath;
        $this->plugin->setFilesystem($this->filesystem->reveal());
    }

    public function testIncrementedPathFileWithoutExtension()
    {
        $this->assertSame('getIncrementedPath', $this->plugin->getMethod());

        $this->filesystem->listContents('.')->willReturn([['path' => 'newpath']])->shouldBeCalled();

        $this->assertEquals('newpath_1', $this->plugin->handle('newpath'));
    }

    public function testIncrementedPathFileWithoutExtensionTwice()
    {
        $this->filesystem->listContents('.')->willReturn([['path' => 'newpath'], ['path' => 'newpath_1']])
            ->shouldBeCalled();
        $this->assertEquals('newpath_2', $this->plugin->handle('newpath'));
    }

    public function testIncrementedPathFileWithExtension()
    {
        $this->filesystem->listContents('.')->willReturn([['path' => 'newpath.txt']])->shouldBeCalled();
        $this->assertEquals('newpath_1.txt', $this->plugin->handle('newpath.txt'));
    }

    public function testIncrementedPathFileWithExtensionTwice()
    {
        $this->filesystem->listContents('.')->willReturn([['path' => 'newpath.txt'], ['path' => 'newpath_1.txt']])
            ->shouldBeCalled();
        $this->assertEquals('newpath_2.txt', $this->plugin->handle('newpath.txt'));
    }
}
