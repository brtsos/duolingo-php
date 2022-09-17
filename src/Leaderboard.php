<?php

namespace ArnaudLier\DuolingoPHP;

class Leaderboard
{
    public ?int $num_wins;
    public ?array $stats;
    public ?int $streak_in_tier;
    public ?int $tier;
    public ?int $top_three_finishes;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists(__CLASS__, $key)) {
                $this->$key = $value;
            }
        }
    }
}
