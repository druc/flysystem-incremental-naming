<?php

namespace Druc\Flysystem\IncrementalNaming\Tests;

use Druc\Flysystem\IncrementalNaming\IncrementedCopy;
use PHPUnit\Framework\TestCase;

class IncrementedCopyTest extends TestCase
{
    protected $filesystem;
    protected $plugin;

    public function setUp()
    {
        $this->filesystem = $this->prophesize('League\Flysystem\FilesystemInterface');
        $this->plugin = new IncrementedCopy;
        $this->plugin->setFilesystem($this->filesystem->reveal());
    }

    public function testIncrementedCopyFileWithoutExtension()
    {
        $this->assertSame('incrementedCopy', $this->plugin->getMethod());

        $this->filesystem->listContents('.')->willReturn([['path' => 'newpath']])->shouldBeCalled();
        $this->filesystem->copy('path', 'newpath_1')->willReturn(true)->shouldBeCalled();

        $this->assertTrue($this->plugin->handle('path', 'newpath'));
    }

    public function testIncrementedCopyFileWithExtension()
    {
        $this->filesystem->listContents('.')->willReturn([['path' => 'newpath.txt']])->shouldBeCalled();
        $this->filesystem->copy('path.txt', 'newpath_1.txt')->willReturn(true)->shouldBeCalled();

        $this->assertTrue($this->plugin->handle('path.txt', 'newpath.txt'));
    }

    public function testReturnsFalseWhenCopyFails()
    {
        $this->filesystem->listContents('.')->willReturn([['path' => 'newpath']])->shouldBeCalled();
        $this->filesystem->copy('path', 'newpath_1')->willReturn(false)->shouldBeCalled();

        $this->assertFalse($this->plugin->handle('path', 'newpath'));
    }
}
