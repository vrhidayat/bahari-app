<script setup lang="ts">
import { computed } from 'vue';

const props = withDefaults(
    defineProps<{
        title: string;
        description: string;
        icon: any;
        badge?: string;
        color?: 'emerald' | 'teal' | 'blue' | 'amber';
    }>(),
    {
        color: 'emerald',
    },
);

// Map colors to classes for custom styling
const colorClasses = computed(() => {
    switch (props.color) {
        case 'teal':
            return {
                bg: 'bg-teal-500/10 text-teal-600 dark:bg-teal-500/20 dark:text-teal-400',
                border: 'hover:border-teal-500/30',
                accentText: 'text-teal-600 dark:text-teal-400',
            };
        case 'blue':
            return {
                bg: 'bg-blue-500/10 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400',
                border: 'hover:border-blue-500/30',
                accentText: 'text-blue-600 dark:text-blue-400',
            };
        case 'amber':
            return {
                bg: 'bg-amber-500/10 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400',
                border: 'hover:border-amber-500/30',
                accentText: 'text-amber-600 dark:text-amber-400',
            };
        case 'emerald':
        default:
            return {
                bg: 'bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400',
                border: 'hover:border-emerald-500/30',
                accentText: 'text-emerald-600 dark:text-emerald-400',
            };
    }
});
</script>

<template>
    <div
        :class="[
            'relative flex flex-col items-start gap-4 rounded-2xl border border-border/60 bg-card p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg sm:p-8 dark:hover:shadow-black/20',
            colorClasses.border,
        ]"
    >
        <!-- Floating badge if present -->
        <span
            v-if="badge"
            class="absolute top-4 right-4 rounded-full border border-emerald-500/15 bg-emerald-500/10 px-2 py-0.5 text-[10px] font-bold tracking-wider text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400"
        >
            {{ badge }}
        </span>

        <!-- Icon Container -->
        <div
            :class="[
                'flex items-center justify-center rounded-2xl p-3 transition-transform duration-300 group-hover:scale-110',
                colorClasses.bg,
            ]"
        >
            <component :is="icon" class="h-6 w-6 shrink-0" />
        </div>

        <!-- Info -->
        <div class="mt-2 flex flex-col gap-2">
            <h3 class="text-lg font-bold tracking-tight text-foreground">
                {{ title }}
            </h3>
            <p class="text-sm leading-relaxed text-muted-foreground">
                {{ description }}
            </p>
        </div>
    </div>
</template>
