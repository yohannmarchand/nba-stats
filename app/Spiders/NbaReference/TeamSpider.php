<?php

namespace App\Spiders\NbaReference;

use App\Data\TeamData;
use App\Enums\Conference;
use App\Enums\Division;
use App\Models\Team;
use App\Spiders\ItemProcessors\TeamItemProcessor;
use Generator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Request;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;

class TeamSpider extends BasicSpider
{
    public array $startUrls = [
        //
    ];

    /**
     * @return Request[]
     */
    protected function initialRequests(): array
    {
        $urls = [];
        $file = storage_path('app/teams_urls.csv');
        if (file_exists($file)) {
            $handle = fopen($file, 'r');
            while (($data = fgetcsv($handle)) !== false) {
                if (! empty($data[0])) {
                    $urls[] = $data[0];
                }
            }
            fclose($handle);
        }

        $existingExternalIds = Team::pluck('external_id')->toArray();

        return collect($urls)
            ->unique()
            ->filter(function (string $url) use ($existingExternalIds) {
                $externalId = Str::of($url)->afterLast('/')->value();

                return ! in_array($externalId, $existingExternalIds);
            })
            ->map(fn (string $url) => new Request('GET', $url, [$this, 'parse']))
            ->toArray();
    }

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        TeamItemProcessor::class,
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

        $h1Node = $response->filter('h1 > span');
        $name = $h1Node->count() > 0 ? trim($h1Node->first()->text()) : '';

        $logoNode = $response->filter('.media-item.logo img.teamlogo');
        $logo = $logoNode->count() > 0 ? $logoNode->attr('src') : '';

        $externalId = Str::of($response->getUri())->afterLast('/')->value();

        $divisionNode = $response->filter('.division')->reduce(function ($node) use ($externalId) {
            return $node->filter('a[href*="/teams/'.$externalId.'/"]')->count() > 0;
        });

        $divisionName = $divisionNode->count() > 0 ? trim($divisionNode->filter('strong')->first()->text(), ': ') : '';

        $division = match ($divisionName) {
            'Atlantic' => Division::ATLANTIC_DIVISION,
            'Central' => Division::CENTRAL_DIVISION,
            'Northwest' => Division::NORTHWEST_DIVISION,
            'Pacific' => Division::PACIFIC_DIVISION,
            'Southeast' => Division::SOUTHEAST_DIVISION,
            'Southwest' => Division::SOUTHWEST_DIVISION,
            default => Division::EASTERN_DIVISION,
        };

        yield $this->item(TeamData::forNba(
            $name,
            $logo,
            $externalId,
            Conference::fromDivision($division),
            $division,
        )->toArray());
    }
}
