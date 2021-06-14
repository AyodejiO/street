<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Street\Resources\CsvResource;

abstract class TestBase extends TestCase
{
    public function loadBrief($path): CsvResource
    {
        return new CsvResource(
            $this->loadData($path, 'csv'),
            true,
        );
    }

    public function loadData($path, $type): string
    {
        return file_get_contents($this->resolvePath($path, $type));
    }

    private function resolvePath($path, $type)
    {
        return sprintf(
            '%s/data/%s.' . $type,
            dirname(__FILE__),
            str_replace('.', '/', $path)
        );
    }
}
