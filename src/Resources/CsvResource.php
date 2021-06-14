<?php

namespace Street\Resources;

class CsvResource extends Resource
{
    private $data;

    private $hasHeaders;

    public function __construct(string $data = '', bool $hasHeaders = false)
    {
        $this->data = $data;
        $this->hasHeaders = $hasHeaders;
    }

    public function __toString()
    {
        return $this->data;
    }

    public function toArray()
    {
        $csv = explode(',', $this->data);

        // remove csv header
        if ($this->hasHeaders) {
            array_shift($csv);
        }

        return $this->cleanCsv($csv);
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    private function cleanCsv($csv): array
    {
        return array_map(fn ($data) => trim(str_replace('.', '', $data)), $csv);
    }
}
