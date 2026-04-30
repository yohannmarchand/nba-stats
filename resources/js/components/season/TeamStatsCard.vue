<script setup lang="ts">
import { Card, CardContent } from '@/components/ui/card';
import type { Team } from '@/types';

type Props = {
    team: Team;
    label: string;
    value?: string;
};

withDefaults(defineProps<Props>(), {
    value: '—',
});
</script>

<template>
    <Card class="rounded-xl">
        <CardContent class="pt-6">
            <div class="flex items-center gap-4">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-muted"
                >
                    <img
                        v-if="team.logo"
                        :src="team.logo"
                        :alt="team.name"
                        class="h-6 w-6 object-contain"
                    />
                    <span
                        v-else
                        class="text-xs font-bold text-muted-foreground"
                    >
                        {{ team.name.slice(0, 2).toUpperCase() }}
                    </span>
                </div>
                <div>
                    <p class="text-xs font-medium">{{ team.name }}</p>
                    <p class="text-sm text-muted-foreground">{{ label }}</p>
                    <p class="text-2xl font-bold">{{ value }}</p>
                </div>
            </div>
        </CardContent>
    </Card>
</template>
