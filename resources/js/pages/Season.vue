<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Calendar, Trophy, Target, Activity } from 'lucide-vue-next';
import MainLayout from '@/layouts/MainLayout.vue';
import AppContainer from '@/components/AppContainer.vue';
import SeasonHeader from '@/components/season/SeasonHeader.vue';
import StatsCard from '@/components/season/StatsCard.vue';
import TeamStatsCard from '@/components/season/TeamStatsCard.vue';
import PlayerStatsCard from '@/components/season/PlayerStatsCard.vue';
import StandingsCard from '@/components/season/StandingsCard.vue';
import PlayoffBracket from '@/components/season/PlayoffBracket.vue';
import { Tabs, TabsContent } from '@/components/ui/tabs';
import type { League, Team, Player } from '@/types';

type TeamStat = { team: Team; label: string; value: string };
type PlayerStat = { player: Player; label: string; value: string };

type Props = {
    league: League;
    season: number;
    seasons: number[];
    teamStats?: TeamStat[];
    playerStats?: PlayerStat[];
};

const {
    league,
    season,
    seasons,
} = defineProps<Props>();

defineOptions({ layout: MainLayout });
</script>

<template>
    <Head :title="`${league.name} ${season}`" />

    <Tabs default-value="overview">
        <AppContainer class="py-8">
            <SeasonHeader :league :season :seasons />

            <TabsContent value="overview" class="mt-0 space-y-8">
                <!-- KPI -->
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

                </div>

                <!-- Standings + Bracket -->
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                    <StandingsCard class="lg:col-span-1" />
                    <PlayoffBracket :season class="lg:col-span-2" />
                </div>
            </TabsContent>
        </AppContainer>
    </Tabs>
</template>
