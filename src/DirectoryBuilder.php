<?php

namespace Street;

use Street\Resources\CsvResource;

class DirectoryBuilder
{
    /**
     * @var CsvResource
     */
    private $contacts;

    /**
     * @var Array
     */
    private $directory;

    /**
     * DirectoryBuilder constructor.
     * @param CsvResource $contacts
     */
    public function __construct(CsvResource $contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     *
     * @return DirectoryBuilder $this
     */
    public function buildDirectory() : DirectoryBuilder
    {
        $this->directory = [];

        $contacts = $this->contacts->toArray();
        foreach ($contacts as $contact) {
            array_push($this->directory, $this->getContactsFromArray($contact));
        }

        return $this;
    }

    /**
     *
     * @return Array $person(s)
     */
    public function getContactsFromArray($entry) : array
    {
        $separatedEntries = preg_split('/ (&|and) /', $entry);
        $hasMultiple = count($separatedEntries) > 1;

        if (!$hasMultiple) {
            return $this->getNamesFromArray(explode(' ', $entry));
        }

        $lastPerson = $this->getNamesFromArray(explode(' ', array_pop($separatedEntries)));

        $persons[] = $lastPerson;

        foreach ($separatedEntries as $separatedEntry) {
            array_unshift($persons, $this->getNamesFromArray(explode(' ', $separatedEntry), $lastPerson));
        }

        return $persons;
    }

    /**
     *
     * @return Array $person
     */
    public function getNamesFromArray($fullname, $default = [
        'title' => null,
        'first_name' => null,
        'initial' => null,
        'last_name' => null,
    ]) : array
    {
        $person['title'] = array_shift($fullname);
        $person['first_name'] = null;
        $person['initial'] = null;
        $person['last_name'] = array_pop($fullname);

        foreach ($fullname as $name) {
            if ($this->isInitial($name)) {
                $person['initial'] = $name;
                continue;
            }
            $person['first_name'] = $name;
        }

        $person['first_name'] = $person['first_name'] ?? $default['first_name'];
        $person['initial'] = $person['initial'] ?? $default['initial'];
        $person['last_name'] = $person['last_name'] ?? $default['last_name'];

        return $person;
    }

    /**
     *
     * @return Bool $isShortened
     */
    public function isInitial($name) : bool
    {
        return strlen($name) == 1;
    }

    /**
     * @return string $json
     */
    public function toJson(): string
    {
        return json_encode($this->directory);
    }
}
