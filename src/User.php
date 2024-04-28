<?php

namespace ArnaudLier\DuolingoPHP;

class User
{
    public ?int $id;
    public ?int $totalXp;
    public ?int $xpGoal;
    public ?int $streak;

    public ?string $name;
    public ?string $username;
    public ?string $picture;
    public ?bool $xpGoalMetToday;
    public ?bool $hasPlus;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists(__CLASS__, $key)) {
                $this->$key = $value;
            }
        }
    }
}
