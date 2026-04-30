<script setup lang="ts">
import { ref, computed, watch, onMounted } from 'vue';
import { Card, CardContent } from '@/components/ui/card';
import type { League, PlayerStat } from '@/types';
import { index as playerStatIndex } from '@/routes/player-stat';

type Props = {
    league: League;
    season: number;
    stat?: string;
    label?: string;
};

const { league, season, stat = 'pts', label = 'Points' } = defineProps<Props>();

const entry = ref<PlayerStat | null>(null);
const loading = ref(false);

const initials = computed(() => {
    if (!entry.value) return '?';
    return `${entry.value.player.first_name[0]}${entry.value.player.last_name[0]}`.toUpperCase();
});

const fullName = computed(() => {
    if (!entry.value) return '—';
    return `${entry.value.player.first_name} ${entry.value.player.last_name}`;
});

async function fetchLeader() {
    loading.value = true;

    try {
        const route = playerStatIndex(
            { league: league.slug, season },
            { query: { stat, limit: 1 } },
        );
        const res = await fetch(route.url);
        const data: PlayerStat[] = await res.json();
        entry.value = data[0] ?? null;
    } finally {
        loading.value = false;
    }
}

onMounted(fetchLeader);
watch(() => stat, fetchLeader);
</script>

<template>
    <Card class="rounded-xl py-0">
        <CardContent class="p-0">
            <div class="flex gap-4">
                <div class="aspect-square w-1/2 shrink-0">
                    <img
                        v-if="entry?.player.image_url"
                        :src="entry.player.image_url"
                        :alt="fullName"
                        class="h-full w-full object-cover rounded-bl-lg"
                    />
                    <div
                        v-else
                        class="flex h-full w-full items-center justify-center text-xs font-bold text-muted-foreground"
                    >
                        {{ loading ? '…' : initials }}
                    </div>
                </div>
                <div class="py-6 flex flex-col">
                    <p class="text-xs font-medium">{{ fullName }}</p>
                    <p class="text-sm text-muted-foreground grow">{{ label }}</p>
                    <p class="text-2xl font-bold">{{ entry?.value ?? '—' }}</p>
                </div>
            </div>
        </CardContent>
    </Card>
</template>
