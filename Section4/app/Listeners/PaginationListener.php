<?php

namespace App\Listeners;

use Dingo\Api\Event\ResponseWasMorphed;

class PaginationListener
{
    public function handle(ResponseWasMorphed $event)
    {
        if (isset($event->content['meta']['pagination'])) {
            // from
            if (!array_key_exists('from', $event->content['meta']['pagination'])) {
                $event->content['meta']['pagination']['from'] = (
                    ($event->content['meta']['pagination']['current_page'] - 1)
                    * $event->content['meta']['pagination']['per_page']
                    ) + 1;
            }
            //  to
            if (!array_key_exists('to', $event->content['meta']['pagination'])) {
                $event->content['meta']['pagination']['to'] =
                    $event->content['meta']['pagination']['from'] + $event->content['meta']['pagination']['per_page'] - 1;

                if ($event->content['meta']['pagination']['to'] > $event->content['meta']['pagination']['total']) {
                    $event->content['meta']['pagination']['to'] = $event->content['meta']['pagination']['total'];
                }
            }
        }
    }
}