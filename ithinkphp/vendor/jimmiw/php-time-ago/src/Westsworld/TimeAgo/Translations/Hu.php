<?php

namespace Westsworld\TimeAgo\Translations;

use \Westsworld\TimeAgo\Language;

/**
 * Hungarian translations
 */
class Hu extends Language
{
    public function __construct()
    {
        $this->setTranslations([
            'aboutOneDay' => "1 napja",
            'aboutOneHour' => "körülbelül 1 órája",
            'aboutOneMonth' => "körülbelül 1 hónapja",
            'aboutOneYear' => "körülbelül 1 éve",
            'days' => "%s napja",
            'hours' => "%s órája",
            'lessThanAMinute' => "kevesebb, mint egy perce",
            'lessThanOneHour' => "%s perce",
            'months' => "%s hónapja",
            'oneMinute' => "1 perce",
            'years' => "több, mint %s éve"
        ]);
    }
}
