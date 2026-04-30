<script setup lang="ts">
import { defineComponent, h } from 'vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

type Props = {
    season: number;
};

defineProps<Props>();

const BracketTeamSlot = defineComponent({
    props: {
        seed: { type: String, default: '' },
    },
    setup(props) {
        return () =>
            h(
                'div',
                {
                    class: 'flex items-center gap-2 rounded-md border bg-card px-2 py-1.5 text-xs',
                },
                [
                    props.seed
                        ? h(
                              'span',
                              {
                                  class: 'flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-muted text-[10px] font-semibold text-muted-foreground',
                              },
                              props.seed,
                          )
                        : h('div', {
                              class: 'h-4 w-4 shrink-0 rounded-full bg-muted',
                          }),
                    h('span', { class: 'flex-1 text-muted-foreground' }, 'TBD'),
                    h('span', { class: 'text-muted-foreground' }, '—'),
                ],
            );
    },
});

const eastR1 = [
    { top: '1', bottom: '8' },
    { top: '4', bottom: '5' },
    { top: '2', bottom: '7' },
    { top: '3', bottom: '6' },
];

const westR1 = [
    { top: '1', bottom: '8' },
    { top: '4', bottom: '5' },
    { top: '2', bottom: '7' },
    { top: '3', bottom: '6' },
];
</script>

<template>
    <Card class="rounded-xl">
        <CardHeader>
            <div class="flex items-center justify-between">
                <CardTitle>Bracket Playoffs</CardTitle>
                <Badge variant="outline">
                    {{ season }}–{{ String(season + 1).slice(-2) }}
                </Badge>
            </div>
        </CardHeader>
        <CardContent class="overflow-x-auto">
            <div class="flex min-w-[720px] gap-1.5 py-2">
                <!-- EAST R1 -->
                <div class="flex flex-1 flex-col gap-2">
                    <p class="mb-1 text-center text-[10px] font-semibold uppercase tracking-wider text-muted-foreground">
                        1er tour
                    </p>
                    <div
                        v-for="(m, i) in eastR1"
                        :key="i"
                        class="flex flex-col gap-0.5"
                    >
                        <BracketTeamSlot :seed="m.top" />
                        <BracketTeamSlot :seed="m.bottom" />
                        <div v-if="i < eastR1.length - 1" class="h-2" />
                    </div>
                </div>

                <!-- EAST SF -->
                <div class="flex flex-1 flex-col justify-around">
                    <p class="mb-1 text-center text-[10px] font-semibold uppercase tracking-wider text-muted-foreground">
                        Demi-finales
                    </p>
                    <div class="flex flex-col gap-0.5">
                        <BracketTeamSlot />
                        <BracketTeamSlot />
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <BracketTeamSlot />
                        <BracketTeamSlot />
                    </div>
                </div>

                <!-- EAST CF -->
                <div class="flex flex-1 flex-col justify-center">
                    <p class="mb-1 text-center text-[10px] font-semibold uppercase tracking-wider text-muted-foreground">
                        Finale Est
                    </p>
                    <div class="flex flex-col gap-0.5">
                        <BracketTeamSlot />
                        <BracketTeamSlot />
                    </div>
                </div>

                <!-- NBA FINALS -->
                <div class="flex flex-1 flex-col justify-center">
                    <p class="mb-1 text-center text-[10px] font-semibold uppercase tracking-wider text-muted-foreground">
                        Finales NBA
                    </p>
                    <div class="flex flex-col gap-0.5">
                        <BracketTeamSlot />
                        <BracketTeamSlot />
                    </div>
                </div>

                <!-- WEST CF -->
                <div class="flex flex-1 flex-col justify-center">
                    <p class="mb-1 text-center text-[10px] font-semibold uppercase tracking-wider text-muted-foreground">
                        Finale Ouest
                    </p>
                    <div class="flex flex-col gap-0.5">
                        <BracketTeamSlot />
                        <BracketTeamSlot />
                    </div>
                </div>

                <!-- WEST SF -->
                <div class="flex flex-1 flex-col justify-around">
                    <p class="mb-1 text-center text-[10px] font-semibold uppercase tracking-wider text-muted-foreground">
                        Demi-finales
                    </p>
                    <div class="flex flex-col gap-0.5">
                        <BracketTeamSlot />
                        <BracketTeamSlot />
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <BracketTeamSlot />
                        <BracketTeamSlot />
                    </div>
                </div>

                <!-- WEST R1 -->
                <div class="flex flex-1 flex-col gap-2">
                    <p class="mb-1 text-center text-[10px] font-semibold uppercase tracking-wider text-muted-foreground">
                        1er tour
                    </p>
                    <div
                        v-for="(m, i) in westR1"
                        :key="i"
                        class="flex flex-col gap-0.5"
                    >
                        <BracketTeamSlot :seed="m.top" />
                        <BracketTeamSlot :seed="m.bottom" />
                        <div v-if="i < westR1.length - 1" class="h-2" />
                    </div>
                </div>
            </div>

            <!-- Conference labels -->
            <div class="mt-3 flex justify-between border-t pt-3 text-[10px] font-semibold uppercase tracking-wider text-muted-foreground">
                <span>◀ Conférence Est</span>
                <span>Conférence Ouest ▶</span>
            </div>
        </CardContent>
    </Card>
</template>
