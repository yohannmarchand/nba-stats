<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { login, logout, register } from '@/routes';

const page = usePage();
const user = computed(() => page.props.auth.user);
const canRegister = computed(() => (page.props as { canRegister?: boolean }).canRegister ?? true);
</script>

<template>
    <div class="flex min-h-screen flex-col bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a]">
        <header class="w-full border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
            <div class="mx-auto flex h-14 max-w-7xl items-center justify-between px-6">
                <Link href="/" class="text-sm font-semibold tracking-tight dark:text-[#EDEDEC]">
                    NBA Stats
                </Link>
                <nav class="flex items-center gap-4 text-sm">
                    <template v-if="user">
                        <span class="text-[#1b1b18] dark:text-[#EDEDEC]">{{ user.name }}</span>
                        <Link
                            :href="logout()"
                            method="post"
                            class="rounded-sm border border-[#19140035] px-4 py-1.5 leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                        >
                            Log out
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            :href="login()"
                            class="rounded-sm border border-transparent px-4 py-1.5 leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                        >
                            Log in
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="register()"
                            class="rounded-sm border border-[#19140035] px-4 py-1.5 leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                        >
                            Register
                        </Link>
                    </template>
                </nav>
            </div>
        </header>
        <main class="flex flex-1 flex-col">
            <slot />
        </main>
    </div>
</template>
