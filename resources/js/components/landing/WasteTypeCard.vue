<script setup lang="ts">
defineProps<{
    name: string;
    priceRange: string;
    description: string;
    examples: string[];
    icon: any;
    impactInfo: string;
    badge?: string;
}>();
</script>

<template>
    <div
        class="group relative flex flex-col justify-between gap-6 rounded-2xl border border-border/60 bg-card p-6 transition-all duration-300 hover:border-emerald-500/30 hover:shadow-lg dark:hover:shadow-black/20"
    >
        <!-- Badge -->
        <span
            v-if="badge"
            class="absolute top-4 right-4 rounded-full bg-emerald-500 px-2.5 py-0.5 text-[10px] font-extrabold tracking-wider text-white uppercase shadow-xs"
        >
            {{ badge }}
        </span>

        <div class="flex flex-col gap-4">
            <!-- Icon & Category Title -->
            <div class="flex items-center gap-3.5">
                <div
                    class="shrink-0 rounded-xl bg-emerald-500/10 p-3 text-emerald-600 transition-transform duration-300 group-hover:scale-105 dark:bg-emerald-500/20 dark:text-emerald-400"
                >
                    <component :is="icon" class="h-6 w-6" />
                </div>
                <div class="flex flex-col">
                    <h3
                        class="text-lg leading-tight font-bold tracking-tight text-foreground"
                    >
                        {{ name }}
                    </h3>
                    <span
                        class="mt-0.5 text-[11px] font-semibold text-muted-foreground"
                        >Diterima</span
                    >
                </div>
            </div>

            <!-- Description -->
            <p class="text-sm leading-relaxed text-muted-foreground">
                {{ description }}
            </p>

            <!-- Examples -->
            <div class="flex flex-wrap gap-1.5 pt-1">
                <span
                    v-for="(item, idx) in examples"
                    :key="idx"
                    class="rounded-md bg-muted px-2 py-0.5 text-[11px] font-semibold text-muted-foreground dark:bg-zinc-800"
                >
                    {{ item }}
                </span>
            </div>
        </div>

        <!-- Footer Card (Price & Eco info) -->
        <div class="flex flex-col gap-2.5 border-t border-border/40 pt-4">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-muted-foreground"
                    >Estimasi Harga</span
                >
                <span
                    class="text-sm font-extrabold text-emerald-600 dark:text-emerald-400"
                >
                    {{ priceRange }}
                </span>
            </div>

            <!-- Eco Impact -->
            <div
                class="flex items-center gap-1.5 rounded-lg bg-emerald-500/5 p-2 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300"
            >
                <span
                    class="flex h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-500"
                ></span>
                <span>Dampak: {{ impactInfo }}</span>
            </div>
        </div>
    </div>
</template>
