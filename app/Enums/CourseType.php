<?php

namespace App\Enums;

enum CourseType: string
{
    case LIVE = 'live';
    case ON_DEMAND = 'on_demand';
    case ETRANSCRIPT = 'etranscript';

    public function label(): string
    {
        return match($this) {
            self::LIVE => 'Live Webinar',
            self::ON_DEMAND => 'On Demand',
            self::ETRANSCRIPT => 'eTranscript',
        };
    }
}
