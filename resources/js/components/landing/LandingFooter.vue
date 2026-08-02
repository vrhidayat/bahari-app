<script setup lang="ts">
import { Leaf, Mail, Phone, MapPin, Heart, ArrowRight } from '@lucide/vue';

const currentYear = new Date().getFullYear();

const quickLinks = [
    { name: 'Tentang Kami', href: '#home' },
    { name: 'Layanan Kami', href: '#services' },
    { name: 'Kalkulator Harga', href: '#calculator' },
    { name: 'Alur Kerja', href: '#workflow' },
];

const resourceLinks = [
    { name: 'Edukasi Memilah', href: '#' },
    { name: 'Panduan Mitra', href: '#' },
    { name: 'Pusat Bantuan', href: '#faq' },
    { name: 'Kebijakan Privasi', href: '#' },
];
</script>

<template>
    <footer class="border-t border-border/60 bg-muted/40 dark:bg-zinc-950">
        <!-- Top Section with Grid -->
        <div
            class="container mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16"
        >
            <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-4">
                <!-- Info Column -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2.5">
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400"
                        >
                            <Leaf class="h-4.5 w-4.5 rotate-12" />
                        </div>
                        <span
                            class="text-md bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text font-bold tracking-tight text-transparent dark:from-emerald-400 dark:to-teal-300"
                        >
                            Bahari Eco
                        </span>
                    </div>
                    <p class="text-sm leading-relaxed text-muted-foreground">
                        Mendorong ekonomi sirkular dengan mempermudah transaksi
                        daur ulang sampah. Mari lestarikan pesisir dan daratan
                        kita dari ancaman limbah plastik.
                    </p>
                    <!-- Carbon Badge -->
                    <div
                        class="mt-2 inline-flex items-center gap-2 self-start rounded-full border border-emerald-500/20 bg-emerald-500/5 px-3.5 py-1.5 text-xs font-semibold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400"
                    >
                        <span
                            class="flex h-2 w-2 animate-pulse rounded-full bg-emerald-500"
                        ></span>
                        100% Karbon Netral
                    </div>
                </div>

                <!-- Navigation Links -->
                <div>
                    <h3
                        class="mb-4 text-sm font-bold tracking-wider text-foreground uppercase"
                    >
                        Navigasi
                    </h3>
                    <ul class="flex flex-col gap-2.5">
                        <li v-for="link in quickLinks" :key="link.name">
                            <a
                                :href="link.href"
                                class="group flex items-center text-sm text-muted-foreground transition-colors hover:text-emerald-500"
                            >
                                <ArrowRight
                                    class="mr-1.5 h-3 w-3 text-muted-foreground/0 transition-all group-hover:text-emerald-500 group-hover:text-muted-foreground/100"
                                />
                                {{ link.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Resources Links -->
                <div>
                    <h3
                        class="mb-4 text-sm font-bold tracking-wider text-foreground uppercase"
                    >
                        Sumber Daya
                    </h3>
                    <ul class="flex flex-col gap-2.5">
                        <li v-for="link in resourceLinks" :key="link.name">
                            <a
                                :href="link.href"
                                class="group flex items-center text-sm text-muted-foreground transition-colors hover:text-emerald-500"
                            >
                                <ArrowRight
                                    class="mr-1.5 h-3 w-3 text-muted-foreground/0 transition-all group-hover:text-emerald-500 group-hover:text-muted-foreground/100"
                                />
                                {{ link.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact & Info Column -->
                <div class="flex flex-col gap-4">
                    <h3
                        class="text-sm font-bold tracking-wider text-foreground uppercase"
                    >
                        Kontak & Hubungi
                    </h3>
                    <div
                        class="flex flex-col gap-3 text-sm text-muted-foreground"
                    >
                        <div class="flex items-start gap-2.5">
                            <MapPin
                                class="mt-0.5 h-4.5 w-4.5 shrink-0 text-emerald-500"
                            />
                            <span
                                >Jl. Pesisir Lestari No. 42, Surabaya, Jawa
                                Timur, Indonesia</span
                            >
                        </div>
                        <div class="flex items-center gap-2.5">
                            <Phone
                                class="h-4.5 w-4.5 shrink-0 text-emerald-500"
                            />
                            <span>+62 812-3456-7890</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <Mail
                                class="h-4.5 w-4.5 shrink-0 text-emerald-500"
                            />
                            <span>info@baharieco.id</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div
            class="border-t border-border/50 bg-muted/60 py-6 dark:bg-zinc-950/80"
        >
            <div
                class="container mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 sm:px-6 md:flex-row lg:px-8"
            >
                <p
                    class="text-center text-xs text-muted-foreground md:text-left"
                >
                    &copy; {{ currentYear }}
                    <span
                        class="font-semibold text-emerald-600 dark:text-emerald-400"
                        >Bahari Eco</span
                    >. Hak Cipta Dilindungi.
                </p>
                <p
                    class="flex items-center justify-center gap-1 text-xs text-muted-foreground"
                >
                    Dibuat dengan
                    <Heart
                        class="h-3.5 w-3.5 animate-pulse fill-red-500 text-red-500"
                    />
                    untuk pelestarian maritim.
                </p>
            </div>
        </div>
    </footer>
</template>
