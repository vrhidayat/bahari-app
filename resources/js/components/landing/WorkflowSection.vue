<script setup lang="ts">
import { Sparkles, Calendar, Scale, Coins } from '@lucide/vue';

const steps = [
    {
        num: '01',
        title: 'Pilah Sampah',
        description:
            'Pisahkan sampah kering daur ulang Anda (plastik, kertas, logam, dll.) di rumah agar memiliki nilai jual tertinggi.',
        icon: Sparkles,
        color: 'from-emerald-500 to-teal-500',
    },
    {
        num: '02',
        title: 'Jadwalkan Setor',
        description:
            'Gunakan aplikasi untuk memesan layanan jemput sampah gratis ke rumah, atau bawa sendiri ke Drop Point terdekat.',
        icon: Calendar,
        color: 'from-teal-500 to-emerald-600',
    },
    {
        num: '03',
        title: 'Timbang Presisi',
        description:
            'Kurir atau petugas akan menimbang sampah Anda secara transparan menggunakan timbangan digital presisi tinggi.',
        icon: Scale,
        color: 'from-emerald-600 to-teal-600',
    },
    {
        num: '04',
        title: 'Terima Hasil',
        description:
            'Dapatkan saldo rupiah yang langsung dikirimkan ke akun e-wallet Anda. Cepat, aman, dan tanpa biaya tambahan.',
        icon: Coins,
        color: 'from-teal-600 to-emerald-700',
    },
];
</script>

<template>
    <section id="workflow" class="relative bg-background py-20">
        <div
            class="relative z-10 container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <!-- Section Header -->
            <div
                class="mx-auto mb-16 flex max-w-3xl flex-col items-center text-center"
            >
                <span
                    class="mb-3 rounded-full border border-emerald-500/10 bg-emerald-500/5 px-3.5 py-1.5 text-xs font-extrabold tracking-widest text-emerald-600 uppercase dark:bg-emerald-500/10 dark:text-emerald-400"
                >
                    Alur Kerja
                </span>
                <h2
                    class="mb-4 text-3xl font-extrabold tracking-tight text-foreground sm:text-4xl"
                >
                    Bagaimana Cara Kerjanya?
                </h2>
                <p
                    class="text-sm leading-relaxed text-muted-foreground sm:text-base"
                >
                    Hanya butuh 4 langkah mudah untuk mengonversi sampah kering
                    Anda menjadi saldo uang digital dan ikut serta menjaga bumi.
                </p>
            </div>

            <!-- Steps Grid -->
            <div
                class="relative grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-4 lg:gap-8"
            >
                <div
                    v-for="(step, idx) in steps"
                    :key="idx"
                    class="group relative flex flex-col items-center text-center"
                >
                    <!-- Connection Line (Desktop only) -->
                    <div
                        v-if="idx < steps.length - 1"
                        class="absolute top-12 right-[-calc(50%-2.5rem)] left-[calc(50%+2.5rem)] z-0 hidden h-[2px] bg-gradient-to-r from-emerald-500/40 to-teal-500/20 lg:block"
                    ></div>

                    <!-- Step Number & Icon Stack -->
                    <div class="relative z-10 mb-6">
                        <div
                            class="relative flex h-20 w-20 items-center justify-center rounded-2xl border border-border/80 bg-card shadow-md transition-all duration-300 group-hover:border-emerald-500/30 group-hover:shadow-lg"
                        >
                            <component
                                :is="step.icon"
                                class="h-8 w-8 text-emerald-600 dark:text-emerald-400"
                            />

                            <!-- Absolute Number Badge -->
                            <span
                                :class="[
                                    'absolute -top-3.5 -right-3.5 flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-br text-[11px] font-black text-white shadow-xs',
                                    step.color,
                                ]"
                            >
                                {{ step.num }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="relative z-10 flex flex-col gap-2 px-4">
                        <h3
                            class="text-base font-extrabold tracking-tight text-foreground"
                        >
                            {{ step.title }}
                        </h3>
                        <p
                            class="text-xs leading-relaxed text-muted-foreground sm:text-sm"
                        >
                            {{ step.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
