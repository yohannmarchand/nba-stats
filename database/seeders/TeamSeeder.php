<?php

namespace Database\Seeders;

use App\Models\League;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $league = League::where('slug', 'nba')->firstOrFail();

        $teams = [
            ['name' => 'Atlanta Hawks', 'slug' => 'atlanta-hawks', 'external_id' => '1', 'division' => 'southeast_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/ATL.png'],
            ['name' => 'Boston Celtics', 'slug' => 'boston-celtics', 'external_id' => '2', 'division' => 'atlantic_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/BOS.png'],
            ['name' => 'Brooklyn Nets', 'slug' => 'brooklyn-nets', 'external_id' => '3', 'division' => 'eastern_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/NJN.png'],
            ['name' => 'Charlotte Hornets', 'slug' => 'charlotte-hornets', 'external_id' => '4', 'division' => 'eastern_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/CHA.png'],
            ['name' => 'Chicago Bulls', 'slug' => 'chicago-bulls', 'external_id' => '5', 'division' => 'central_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/CHI.png'],
            ['name' => 'Cleveland Cavaliers', 'slug' => 'cleveland-cavaliers', 'external_id' => '6', 'division' => 'central_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/CLE.png'],
            ['name' => 'Dallas Mavericks', 'slug' => 'dallas-mavericks', 'external_id' => '7', 'division' => 'southwest_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/DAL.png'],
            ['name' => 'Denver Nuggets', 'slug' => 'denver-nuggets', 'external_id' => '8', 'division' => 'northwest_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/DEN.png'],
            ['name' => 'Detroit Pistons', 'slug' => 'detroit-pistons', 'external_id' => '9', 'division' => 'central_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/DET.png'],
            ['name' => 'Golden State Warriors', 'slug' => 'golden-state-warriors', 'external_id' => '10', 'division' => 'pacific_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/GSW.png'],
            ['name' => 'Houston Rockets', 'slug' => 'houston-rockets', 'external_id' => '11', 'division' => 'southwest_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/HOU.png'],
            ['name' => 'Indiana Pacers', 'slug' => 'indiana-pacers', 'external_id' => '12', 'division' => 'central_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/IND.png'],
            ['name' => 'Los Angeles Clippers', 'slug' => 'los-angeles-clippers', 'external_id' => '13', 'division' => 'pacific_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/LAC.png'],
            ['name' => 'Los Angeles Lakers', 'slug' => 'los-angeles-lakers', 'external_id' => '14', 'division' => 'pacific_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/LAL.png'],
            ['name' => 'Memphis Grizzlies', 'slug' => 'memphis-grizzlies', 'external_id' => '15', 'division' => 'southwest_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/MEM.png'],
            ['name' => 'Miami Heat', 'slug' => 'miami-heat', 'external_id' => '16', 'division' => 'southeast_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/MIA.png'],
            ['name' => 'Milwaukee Bucks', 'slug' => 'milwaukee-bucks', 'external_id' => '17', 'division' => 'central_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/MIL.png'],
            ['name' => 'Minnesota Timberwolves', 'slug' => 'minnesota-timberwolves', 'external_id' => '18', 'division' => 'northwest_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/MIN.png'],
            ['name' => 'New Orleans Pelicans', 'slug' => 'new-orleans-pelicans', 'external_id' => '19', 'division' => 'eastern_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/NOH.png'],
            ['name' => 'New York Knicks', 'slug' => 'new-york-knicks', 'external_id' => '20', 'division' => 'atlantic_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/NYK.png'],
            ['name' => 'Oklahoma City Thunder', 'slug' => 'oklahoma-city-thunder', 'external_id' => '21', 'division' => 'northwest_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/OKC.png'],
            ['name' => 'Orlando Magic', 'slug' => 'orlando-magic', 'external_id' => '22', 'division' => 'southeast_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/ORL.png'],
            ['name' => 'Philadelphia 76ers', 'slug' => 'philadelphia-76ers', 'external_id' => '23', 'division' => 'atlantic_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/PHI.png'],
            ['name' => 'Phoenix Suns', 'slug' => 'phoenix-suns', 'external_id' => '24', 'division' => 'pacific_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/PHO.png'],
            ['name' => 'Portland Trail Blazers', 'slug' => 'portland-trail-blazers', 'external_id' => '25', 'division' => 'northwest_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/POR.png'],
            ['name' => 'Sacramento Kings', 'slug' => 'sacramento-kings', 'external_id' => '26', 'division' => 'pacific_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/SAC.png'],
            ['name' => 'San Antonio Spurs', 'slug' => 'san-antonio-spurs', 'external_id' => '27', 'division' => 'southwest_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/SAS.png'],
            ['name' => 'Toronto Raptors', 'slug' => 'toronto-raptors', 'external_id' => '28', 'division' => 'atlantic_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/TOR.png'],
            ['name' => 'Utah Jazz', 'slug' => 'utah-jazz', 'external_id' => '29', 'division' => 'northwest_division', 'conference' => 'west', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/UTA.png'],
            ['name' => 'Washington Wizards', 'slug' => 'washington-wizards', 'external_id' => '30', 'division' => 'eastern_division', 'conference' => 'east', 'logo' => 'https://cdn.ssref.net/req/202603120/tlogo/bbr/WAS.png'],
        ];

        foreach ($teams as $team) {
            Team::updateOrCreate(
                ['external_id' => $team['external_id']],
                array_merge($team, ['league_id' => $league->id])
            );
        }
    }
}
