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
            ['external_id' => $item->get('external_id')],
            $item->all()
        );

        return $item;
    }
}
