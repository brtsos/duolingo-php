<?php

namespace ArnaudLier\DuolingoPHP;

class Vocabulary
{
    public ?string $language_string;
    public ?string $language_language;
    public ?string $from_language;
    public ?array $language_information;
    public ?array $vocab_overview;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists(__CLASS__, $key)) {
                $this->$key = $value;
            }
        }
    }
}
