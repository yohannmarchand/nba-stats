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

class PlayersSpider extends BasicSpider
{
    public array $startUrls = [
        'https://www.basketball-reference.com/players/a/',
        'https://www.basketball-reference.com/players/b/',
        'https://www.basketball-reference.com/players/c/',
        'https://www.basketball-reference.com/players/d/',
        'https://www.basketball-reference.com/players/e/',
        'https://www.basketball-reference.com/players/f/',
        'https://www.basketball-reference.com/players/g/',
        'https://www.basketball-reference.com/players/h/',
        'https://www.basketball-reference.com/players/i/',
        'https://www.basketball-reference.com/players/j/',
        'https://www.basketball-reference.com/players/k/',
        'https://www.basketball-reference.com/players/l/',
        'https://www.basketball-reference.com/players/m/',
        'https://www.basketball-reference.com/players/n/',
        'https://www.basketball-reference.com/players/o/',
        'https://www.basketball-reference.com/players/p/',
        'https://www.basketball-reference.com/players/q/',
        'https://www.basketball-reference.com/players/r/',
        'https://www.basketball-reference.com/players/s/',
        'https://www.basketball-reference.com/players/t/',
        'https://www.basketball-reference.com/players/u/',
        'https://www.basketball-reference.com/players/v/',
        'https://www.basketball-reference.com/players/w/',
        'https://www.basketball-reference.com/players/x/',
        'https://www.basketball-reference.com/players/y/',
        'https://www.basketball-reference.com/players/z/',
    ];

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        [CsvItemProcessor::class, ['path' => 'storage/app/players_urls.csv']],
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

        $urls = $response->filter('th[data-stat="player"] > a')->each(fn ($node) => 'https://www.basketball-reference.com'.$node->attr('href'));

        yield $this->item([
            'href' => $urls,
        ]);
    }
}
