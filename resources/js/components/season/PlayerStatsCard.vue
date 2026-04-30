<script setup lang="ts">
import { computed } from 'vue';
import { Card, CardContent } from '@/components/ui/card';
import type { Player } from '@/types';

type Props = {
    player: Player;
    label: string;
    value?: string;
};

const props = withDefaults(defineProps<Props>(), {
    value: '—',
});

const initials = computed(
    () =>
        `${props.player.first_name[0]}${props.player.last_name[0]}`.toUpperCase(),
);

const fullName = computed(
    () => `${props.player.first_name} ${props.player.last_name}`,
);
</script>

<template>
    <Card class="rounded-xl">
        <CardContent class="pt-6">
            <div class="flex items-center gap-4">
                <div
                    class="h-10 w-10 shrink-0 overflow-hidden rounded-full bg-muted"
                >
                    <img
                        v-if="player.image_url"
                        :src="player.image_url"
                        :alt="fullName"
                        class="h-full w-full object-cover object-top"
                    />
                    <div
                        v-else
                        class="flex h-full w-full items-center justify-center text-xs font-bold text-muted-foreground"
                    >
                        {{ initials }}
                    </div>
                </div>
                <div>
                    <p class="text-xs font-medium">{{ fullName }}</p>
                    <p class="text-sm text-muted-foreground">{{ label }}</p>
                    <p class="text-2xl font-bold">{{ value }}</p>
                </div>
            </div>
        </CardContent>
    </Card>
</template>
