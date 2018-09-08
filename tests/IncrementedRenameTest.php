<?php

namespace Druc\Flysystem\IncrementalNaming\Tests;

use Druc\Flysystem\IncrementalNaming\IncrementedRename;
use PHPUnit\Framework\TestCase;

class IncrementedRenameTest extends TestCase
{
    protected $filesystem;
    protected $plugin;

    public function setUp()
    {
        $this->filesystem = $this->prophesize('League\Flysystem\FilesystemInterface');
        $this->plugin = new IncrementedRename;
        $this->plugin->setFilesystem($this->filesystem->reveal());
    }

    public function testIncrementedRenameFileWithoutExtension()
    {
        $this->assertSame('incrementedRename', $this->plugin->getMethod());

        $this->filesystem->listContents('.')->willReturn([['path' => 'newpath']])->shouldBeCalled();
        $this->filesystem->rename('path', 'newpath_1')->willReturn(true)->shouldBeCalled();

        $this->assertTrue($this->plugin->handle('path', 'newpath'));
    }

    public function testIncrementedRenameFileWithExtension()
    {
        $this->filesystem->listContents('.')->willReturn([['path' => 'newpath.txt']])->shouldBeCalled();
        $this->filesystem->rename('path.txt', 'newpath_1.txt')->willReturn(true)->shouldBeCalled();

        $this->assertTrue($this->plugin->handle('path.txt', 'newpath.txt'));
    }

    public function testReturnsFalseWhenRenameFails()
    {
        $this->filesystem->listContents('.')->willReturn([['path' => 'newpath']])->shouldBeCalled();
        $this->filesystem->rename('path', 'newpath_1')->willReturn(false)->shouldBeCalled();

        $this->assertFalse($this->plugin->handle('path', 'newpath'));
    }
}
