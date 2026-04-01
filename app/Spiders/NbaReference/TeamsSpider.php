<?php

namespace App\Spiders\NbaReference;

use App\Spiders\ItemProcessors\CsvItemProcessor;
use Generator;
use Illuminate\Support\Facades\Log;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;

class TeamsSpider extends BasicSpider
{
    public array $startUrls = [
        'https://www.basketball-reference.com/teams/',
    ];

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        [CsvItemProcessor::class, ['path' => 'storage/app/teams_urls.csv']],
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        if ($response->getStatus() === \Symfony\Component\HttpFoundation\Response::HTTP_TOO_MANY_REQUESTS) {
            Log::error('Error: '.$response->getStatus());

            return;
        }

        $urls = $response->filter('.full_table a')->each(fn ($node) => 'https://www.basketball-reference.com'.$node->attr('href'));

        yield $this->item([
            'href' => $urls,
        ]);
    }
}
