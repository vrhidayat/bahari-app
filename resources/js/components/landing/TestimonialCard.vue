<script setup lang="ts">
import { Star, Quote } from '@lucide/vue';

const props = withDefaults(
    defineProps<{
        name: string;
        role: string;
        text: string;
        stars?: number;
        impactSummary?: string;
    }>(),
    {
        stars: 5,
    },
);

// Get initials for avatar fallback
const initials = props.name
    .split(' ')
    .map((w) => w[0])
    .join('')
    .toUpperCase()
    .substring(0, 2);
</script>

<template>
    <div
        class="relative flex flex-col justify-between gap-6 rounded-2xl border border-border/60 bg-card p-6 shadow-xs transition-all duration-300 hover:border-emerald-500/20 hover:shadow-md sm:p-8"
    >
        <!-- Quote Icon in BG -->
        <Quote
            class="pointer-events-none absolute top-6 right-6 h-8 w-8 rotate-180 text-muted/30"
        />

        <div class="flex flex-col gap-4">
            <!-- Stars -->
            <div class="flex items-center gap-0.5">
                <Star
                    v-for="i in 5"
                    :key="i"
                    :class="[
                        'h-4 w-4 shrink-0',
                        i <= stars
                            ? 'fill-amber-500 text-amber-500'
                            : 'text-muted',
                    ]"
                />
            </div>

            <!-- Review Text -->
            <p
                class="relative z-10 text-sm leading-relaxed text-foreground/90 italic"
            >
                "{{ text }}"
            </p>
        </div>

        <!-- User Info Footer -->
        <div
            class="flex items-center justify-between gap-4 border-t border-border/40 pt-4"
        >
            <div class="flex items-center gap-3">
                <!-- Initials Avatar -->
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-500/10 text-xs font-bold text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400"
                >
                    {{ initials }}
                </div>
                <div class="flex flex-col">
                    <span
                        class="text-sm leading-tight font-bold text-foreground"
                        >{{ name }}</span
                    >
                    <span
                        class="mt-0.5 text-[11px] leading-none text-muted-foreground"
                        >{{ role }}</span
                    >
                </div>
            </div>

            <!-- Eco Badge -->
            <span
                v-if="impactSummary"
                class="shrink-0 rounded-md border border-emerald-500/10 bg-emerald-500/5 px-2 py-1 text-[10px] font-bold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400"
            >
                {{ impactSummary }}
            </span>
        </div>
    </div>
</template>
