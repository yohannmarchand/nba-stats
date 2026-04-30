<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import type { League, StandingEntry } from '@/types';
import { index as standingIndex } from '@/routes/standing';

type Conference = 'east' | 'west';

type Props = {
    league: League;
    season: number;
};

const { league, season } = defineProps<Props>();

const conference = ref<Conference>('east');
const entries = ref<StandingEntry[]>([]);
const loading = ref(false);

async function fetchStandings() {
    loading.value = true;
    try {
        const route = standingIndex(
            { league: league.slug, season },
            { query: { conference: conference.value } },
        );
        const res = await fetch(route.url);
        entries.value = await res.json();
    } finally {
        loading.value = false;
    }
}

onMounted(fetchStandings);
watch(conference, fetchStandings);
</script>

<template>
    <Card class="flex h-full flex-col rounded-xl">
        <CardHeader>
            <div class="flex items-center justify-between">
                <CardTitle>Classement</CardTitle>
                <div class="flex gap-1">
                    <Button
                        size="sm"
                        :variant="conference === 'east' ? 'default' : 'ghost'"
                        @click="conference = 'east'"
                    >
                        Est
                    </Button>
                    <Button
                        size="sm"
                        :variant="conference === 'west' ? 'default' : 'ghost'"
                        @click="conference = 'west'"
                    >
                        Ouest
                    </Button>
                </div>
            </div>
        </CardHeader>
        <CardContent class="flex-1">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-left text-muted-foreground">
                        <th class="pb-2 font-medium">#</th>
                        <th class="pb-2 font-medium">Équipe</th>
                        <th class="pb-2 text-center font-medium">V</th>
                        <th class="pb-2 text-center font-medium">D</th>
                        <th class="pb-2 text-center font-medium">%</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="!loading && entries.length">
                        <tr
                            v-for="entry in entries"
                            :key="entry.rank"
                            class="border-b border-border/50 last:border-0"
                        >
                            <td class="py-2 text-muted-foreground">{{ entry.rank }}</td>
                            <td class="py-2">
                                <div class="flex items-center gap-2">
                                    <img
                                        v-if="entry.team.logo"
                                        :src="entry.team.logo"
                                        :alt="entry.team.name"
                                        class="h-4 w-4 object-contain"
                                    />
                                    <span>{{ entry.team.name }}</span>
                                </div>
                            </td>
                            <td class="py-2 text-center">{{ entry.wins }}</td>
                            <td class="py-2 text-center">{{ entry.losses }}</td>
                            <td class="py-2 text-center text-muted-foreground">
                                {{ entry.pct.toFixed(3).replace('0.', '.') }}
                            </td>
                        </tr>
                    </template>
                    <tr v-else>
                        <td colspan="5" class="py-8 text-center text-muted-foreground">
                            {{ loading ? 'Chargement…' : 'Données à venir' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </CardContent>
    </Card>
</template>
