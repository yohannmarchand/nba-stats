<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import type { AcceptableValue } from 'reka-ui';
import { TabsList, TabsTrigger } from '@/components/ui/tabs';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { show as showSeason } from '@/routes/season';
import type { League } from '@/types';

type Props = {
    league: League;
    season: number;
    seasons: number[];
};

const props = defineProps<Props>();

const tabTriggerClass =
    'flex-none h-auto rounded-none border-0 border-b-2 border-transparent bg-transparent px-4 pb-3 pt-2 text-sm font-medium text-muted-foreground shadow-none transition-[color,border-color] hover:text-foreground data-[state=active]:border-foreground data-[state=active]:bg-transparent data-[state=active]:font-semibold data-[state=active]:text-foreground data-[state=active]:shadow-none';

const changeSeason = (value: AcceptableValue) => {
    if (!value) return;
    router.visit(
        showSeason({ league: props.league.slug, season: Number(value) }).url,
    );
};
</script>

<template>
    <div class="mb-6">
        <div class="flex items-center justify-between pb-5 text-amber-50">
            <div class="flex items-center gap-3">
                <img
                    v-if="league.logo"
                    :src="league.logo"
                    :alt="league.name"
                    class="h-10 w-10 object-contain"
                />
                <div
                    v-else
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-muted text-xs font-bold text-muted-foreground"
                >
                    {{ league.name.slice(0, 2).toUpperCase() }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold">{{ league.name }}</h1>
                    <p class="text-sm text-muted-foreground">
                        Saison {{ season }}
                    </p>
                </div>
            </div>

            <Select
                :model-value="String(season)"
                @update:model-value="changeSeason"
            >
                <SelectTrigger class="w-28">
                    <SelectValue />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem
                        v-for="s in seasons"
                        :key="s"
                        :value="String(s)"
                    >
                        {{ s }}
                    </SelectItem>
                </SelectContent>
            </Select>
        </div>

        <TabsList
            class="h-auto w-full justify-start gap-0 rounded-none border-b bg-transparent p-0"
        >
            <TabsTrigger value="overview" :class="tabTriggerClass">
                Aperçu
            </TabsTrigger>
        </TabsList>
    </div>
</template>
