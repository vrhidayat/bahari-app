<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import {
    Leaf,
} from '@lucide/vue';
import { home } from '@/routes';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="flex min-h-svh flex-col items-center justify-center gap-6 bg-gradient-to-br from-emerald-500/10 to-teal-500/5 p-6 md:p-10">
        <div class="w-full max-w-md rounded-xl bg-background/80 p-6 shadow-md backdrop-blur-md">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <Link :href="home()" class="flex flex-col items-center gap-2 font-medium">
                        <div
                            class="mb-1 flex h-9 w-9 items-center justify-center rounded-md bg-emerald-500/10 text-emerald-600">
                            <a href="#home" class="group flex items-center gap-2.5">
                                <div
                                    class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600 transition-transform duration-300 group-hover:scale-105 dark:bg-emerald-500/20 dark:text-emerald-400">
                                    <Leaf
                                        class="h-5 w-5 rotate-12 transition-transform duration-300 group-hover:rotate-0" />
                                    <span class="absolute -top-0.5 -right-0.5 flex h-2 w-2">
                                        <span
                                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                                    </span>
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-lg font-bold tracking-tight text-transparent dark:from-emerald-400 dark:to-teal-300">
                                        Bahari Eco
                                    </span>
                                </div>
                            </a>
                        </div>
                    </Link>
                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">{{ title }}</h1>
                        <p class="text-center text-sm text-muted-foreground">{{ description }}</p>
                    </div>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
