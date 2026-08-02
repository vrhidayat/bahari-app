<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    ArrowRight,
    Coins,
    Calculator,
    TrendingUp,
    ShieldCheck,
    Leaf,
} from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { register, dashboard } from '@/routes';

const page = usePage();

const scrollToCalculator = (e: Event) => {
    e.preventDefault();
    const target = document.querySelector('#calculator');

    if (target) {
        const offset = 80;
        const bodyRect = document.body.getBoundingClientRect().top;
        const elementRect = target.getBoundingClientRect().top;
        const elementPosition = elementRect - bodyRect;
        const offsetPosition = elementPosition - offset;

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth',
        });
    }
};
</script>

<template>
    <section
        id="home"
        class="relative overflow-hidden bg-gradient-to-b from-emerald-50/30 via-background to-background py-20 lg:py-28 dark:from-emerald-950/10 dark:via-background dark:to-background"
    >
        <!-- Floating Eco Circles/Glows for design aesthetics -->
        <div
            class="pointer-events-none absolute top-1/4 left-0 h-72 w-72 -translate-x-1/2 rounded-full bg-emerald-500/10 blur-3xl dark:bg-emerald-500/5"
        ></div>
        <div
            class="pointer-events-none absolute top-1/3 right-0 h-96 w-96 translate-x-1/3 rounded-full bg-teal-500/10 blur-3xl dark:bg-teal-500/5"
        ></div>

        <div
            class="relative z-10 container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <div
                class="grid grid-cols-1 items-center gap-12 lg:grid-cols-12 lg:gap-8"
            >
                <!-- Left Content -->
                <div class="flex flex-col items-start text-left lg:col-span-7">
                    <!-- Badge -->
                    <div
                        class="animate-fade-in mb-6 inline-flex items-center gap-2 rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3.5 py-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400"
                    >
                        <span
                            class="flex h-2 w-2 animate-pulse rounded-full bg-emerald-500"
                        ></span>
                        🏆 Pelopor Ekonomi Sirkular Digital
                    </div>

                    <!-- Heading -->
                    <h1
                        class="mb-6 text-4xl leading-[1.1] font-extrabold tracking-tight text-foreground sm:text-5xl lg:text-6xl"
                    >
                        Ubah Sampah Jadi
                        <span
                            class="bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500 bg-clip-text text-transparent dark:from-emerald-400 dark:via-emerald-300 dark:to-teal-300"
                            >Rupiah</span
                        >, Selamatkan Bumi
                    </h1>

                    <!-- Paragraph -->
                    <p
                        class="mb-8 max-w-2xl text-base leading-relaxed text-muted-foreground sm:text-lg"
                    >
                        Bahari Eco mendigitalisasi proses jual beli sampah daur
                        ulang. Pilah sampah plastik, kertas, logam, hingga
                        minyak jelantah dari rumah Anda. Kami jemput, timbang
                        transparan, dan bayar instan ke saldo e-wallet pilihan
                        Anda.
                    </p>

                    <!-- CTAs -->
                    <div
                        class="mb-12 flex w-full flex-col items-stretch gap-3.5 sm:w-auto sm:flex-row sm:items-center"
                    >
                        <template v-if="page.props.auth?.user">
                            <Link :href="dashboard()" class="w-full sm:w-auto">
                                <Button
                                    size="lg"
                                    class="group w-full gap-2 rounded-xl bg-emerald-600 font-bold text-white shadow-md shadow-emerald-500/15 hover:bg-emerald-700 sm:w-auto"
                                >
                                    Setor Sampah Sekarang
                                    <ArrowRight
                                        class="h-4 w-4 transition-transform group-hover:translate-x-1"
                                    />
                                </Button>
                            </Link>
                        </template>
                        <template v-else>
                            <Link :href="register()" class="w-full sm:w-auto">
                                <Button
                                    size="lg"
                                    class="group w-full gap-2 rounded-xl bg-emerald-600 font-bold text-white shadow-md shadow-emerald-500/15 hover:bg-emerald-700 sm:w-auto"
                                >
                                    Mulai Jual Sampah
                                    <ArrowRight
                                        class="h-4 w-4 transition-transform group-hover:translate-x-1"
                                    />
                                </Button>
                            </Link>
                        </template>
                        <a
                            href="#calculator"
                            @click="scrollToCalculator"
                            class="w-full sm:w-auto"
                        >
                            <Button
                                size="lg"
                                variant="outline"
                                class="w-full gap-2 rounded-xl border-emerald-500/20 font-semibold text-emerald-600 hover:border-emerald-500/30 hover:bg-emerald-500/5 sm:w-auto dark:text-emerald-400"
                            >
                                <Calculator class="h-4.5 w-4.5" />
                                Kalkulator Pendapatan
                            </Button>
                        </a>
                    </div>

                    <!-- Quick Stats Grid -->
                    <div
                        class="grid w-full max-w-lg grid-cols-3 gap-6 border-t border-border/60 pt-8 sm:gap-10"
                    >
                        <div>
                            <div
                                class="text-2xl font-extrabold tracking-tight text-foreground sm:text-3xl"
                            >
                                50+ Ton
                            </div>
                            <div
                                class="mt-1 text-xs font-semibold text-muted-foreground"
                            >
                                Sampah Terolah
                            </div>
                        </div>
                        <div>
                            <div
                                class="text-2xl font-extrabold tracking-tight text-foreground sm:text-3xl"
                            >
                                1.2K+
                            </div>
                            <div
                                class="mt-1 text-xs font-semibold text-muted-foreground"
                            >
                                Mitra Aktif
                            </div>
                        </div>
                        <div>
                            <div
                                class="text-2xl font-extrabold tracking-tight text-foreground sm:text-3xl"
                            >
                                Rp150Jt+
                            </div>
                            <div
                                class="mt-1 text-xs font-semibold text-muted-foreground"
                            >
                                Insentif Cair
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Visual Stack -->
                <div
                    class="relative mt-8 flex items-center justify-center lg:col-span-5 lg:mt-0"
                >
                    <!-- Main Card -->
                    <div
                        class="group relative aspect-square w-full max-w-[390px] overflow-hidden rounded-3xl bg-gradient-to-tr from-emerald-500 to-teal-600 p-8 text-white shadow-2xl shadow-emerald-500/20"
                    >
                        <!-- BG pattern overlay -->
                        <div
                            class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white/20 via-transparent to-transparent opacity-60"
                        ></div>
                        <div
                            class="pointer-events-none absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-white/5 blur-xl"
                        ></div>

                        <!-- Card Header -->
                        <div
                            class="relative z-10 mb-8 flex items-center justify-between"
                        >
                            <div class="flex items-center gap-2">
                                <div
                                    class="rounded-2xl bg-white/10 p-2.5 backdrop-blur-md"
                                >
                                    <Leaf
                                        class="h-5 w-5 rotate-12 text-emerald-200"
                                    />
                                </div>
                                <span
                                    class="text-sm font-bold tracking-wide text-emerald-100 uppercase"
                                    >Dampak Ekologis Anda</span
                                >
                            </div>
                            <span
                                class="rounded-full border border-white/20 bg-white/10 px-2 py-1 text-[10px] font-bold tracking-wider uppercase"
                                >LIVE</span
                            >
                        </div>

                        <!-- Total Weight -->
                        <div class="relative z-10 mb-8">
                            <span class="text-sm font-semibold text-emerald-100"
                                >Total Penyelamatan Karbon</span
                            >
                            <div
                                class="mt-1.5 flex items-baseline gap-1 text-5xl font-black"
                            >
                                4,820
                                <span class="text-lg font-bold text-emerald-200"
                                    >KG CO₂</span
                                >
                            </div>
                        </div>

                        <!-- Mini stats grid inside card -->
                        <div
                            class="relative z-10 grid grid-cols-2 gap-4 border-t border-white/10 pt-6"
                        >
                            <div>
                                <span class="block text-xs text-emerald-100/80"
                                    >Plastik Didaur Ulang</span
                                >
                                <span
                                    class="mt-0.5 block text-lg font-bold text-white"
                                    >3,240 Kg</span
                                >
                            </div>
                            <div>
                                <span class="block text-xs text-emerald-100/80"
                                    >Kertas Terselamatkan</span
                                >
                                <span
                                    class="mt-0.5 block text-lg font-bold text-white"
                                    >1,580 Kg</span
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Floating Card 1: Last Transaction -->
                    <div
                        class="animate-fade-in absolute -top-6 -right-4 flex max-w-[260px] items-center gap-3.5 rounded-2xl border border-border/80 bg-background/90 p-4 shadow-xl backdrop-blur-md transition-all duration-300 hover:scale-103 sm:-right-8 dark:bg-zinc-900/90"
                    >
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-500/10 text-sm font-bold text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400"
                        >
                            <Coins class="h-5 w-5 text-emerald-500" />
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-foreground"
                                >Sari W. (Mitra)</span
                            >
                            <span class="text-[10px] text-muted-foreground"
                                >Baru saja mencairkan</span
                            >
                            <span
                                class="mt-0.5 text-xs font-bold text-emerald-600 dark:text-emerald-400"
                                >Rp115.000 (23 Kg Plastik)</span
                            >
                        </div>
                    </div>

                    <!-- Floating Card 2: Security & Transparency -->
                    <div
                        class="absolute -bottom-6 -left-4 flex max-w-[240px] items-center gap-3.5 rounded-2xl border border-border/80 bg-background/90 p-4 shadow-xl backdrop-blur-md transition-all duration-300 hover:scale-103 sm:-left-8 dark:bg-zinc-900/90"
                    >
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-teal-500/10 text-teal-600 dark:bg-teal-500/20 dark:text-teal-400"
                        >
                            <ShieldCheck class="h-5 w-5 text-teal-500" />
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-foreground"
                                >100% Transparan</span
                            >
                            <span class="text-[10px] text-muted-foreground"
                                >Timbangan digital terkalibrasi</span
                            >
                            <span
                                class="mt-0.5 flex items-center gap-0.5 text-[10px] font-semibold text-teal-600 dark:text-teal-400"
                            >
                                <TrendingUp class="h-3 w-3" /> Harga ter-update
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
