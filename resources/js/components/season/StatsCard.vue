<script setup lang="ts">
import { type Component } from 'vue';
import { Card, CardContent } from '@/components/ui/card';

type Props = {
    icon: Component;
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
                    <component
                        :is="icon"
                        class="h-5 w-5 text-muted-foreground"
                    />
                </div>
                <div>
                    <p class="text-sm text-muted-foreground">{{ label }}</p>
                    <p class="text-2xl font-bold">{{ value }}</p>
                </div>
            </div>
        </CardContent>
    </Card>
</template>
