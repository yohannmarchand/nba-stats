<?php

namespace App\Spiders\ItemProcessors;

use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\ItemProcessorInterface;
use RoachPHP\Support\Configurable;

class CsvItemProcessor implements ItemProcessorInterface
{
    use Configurable;

    protected function defaultOptions(): array
    {
        return [
            'path' => storage_path('app/teams_urls.csv'),
        ];
    }

    public function processItem(ItemInterface $item): ItemInterface
    {
        $handle = fopen($this->option('path'), 'a');

        if ($handle) {
            $data = $item->all();

            // Si on a plusieurs href dans un item (car extract retourne un tableau)
            if (isset($data['href']) && is_array($data['href'])) {
                foreach ($data['href'] as $url) {
                    fputcsv($handle, [$url]);
                }
            } elseif (isset($data['href'])) {
                fputcsv($handle, [$data['href']]);
            } else {
                fputcsv($handle, $data);
            }

            fclose($handle);
        }

        return $item;
    }
}
