<?php

namespace App\Spiders\ItemProcessors;

use App\Models\Team;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\ItemProcessorInterface;
use RoachPHP\Support\Configurable;

class TeamItemProcessor implements ItemProcessorInterface
{
    use Configurable;

    public function processItem(ItemInterface $item): ItemInterface
    {
        Team::updateOrCreate(
            ['nba_reference_id' => $item->get('nba_reference_id')],
            $item->all()
        );

        return $item;
    }
}
