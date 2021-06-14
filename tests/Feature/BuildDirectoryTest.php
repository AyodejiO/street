<?php

namespace Tests\Feature;

use Tests\TestBase;
use Street\DirectoryBuilder;

class DirectoryBuilderTest extends TestBase
{
    /**
     * @test
     *
     * @throws \Street\Exceptions\JsonFormatException
     */
    public function briefDataIsConvertedToDirectory()
    {
        // load brief
        $data = $this->loadBrief('examples');
        $expectedData = $this->loadData('result', 'json');

        // run end to end
        $directoryBuilder = new DirectoryBuilder($data);

        // make assertions
        $this->assertEquals($expectedData, $directoryBuilder->buildDirectory()->toJson());
    }
}
