<script setup lang="ts">
import { Truck, Scale, Zap, Leaf } from '@lucide/vue';
import FeatureCard from './FeatureCard.vue';

const features = [
    {
        title: 'Penjemputan Langsung',
        description:
            'Tidak perlu keluar rumah. Jadwalkan penjemputan sampah Anda via aplikasi, dan kurir kami akan mengambilnya langsung di lokasi Anda.',
        icon: Truck,
        badge: 'Praktis',
        color: 'emerald' as const,
    },
    {
        title: 'Timbangan & Harga Transparan',
        description:
            'Sampah Anda ditimbang menggunakan timbangan digital presisi tinggi. Nominal harga dihitung transparan sesuai harga pasar ter-update.',
        icon: Scale,
        color: 'teal' as const,
    },
    {
        title: 'Pencairan Instan',
        description:
            'Dapatkan saldo digital langsung ke akun GoPay, OVO, DANA, ShopeePay, atau rekening bank Anda. Proses aman, instan, dan tanpa potongan.',
        icon: Zap,
        badge: 'Unggulan',
        color: 'amber' as const,
    },
    {
        title: 'Laporan Dampak Hijau',
        description:
            'Pantau kontribusi ekologis Anda secara real-time. Ketahui total emisi karbon (CO₂) yang berhasil Anda kurangi dari setiap transaksi.',
        icon: Leaf,
        color: 'blue' as const,
    },
];
</script>

<template>
    <section
        id="services"
        class="relative border-y border-border/40 bg-muted/20 py-20 dark:bg-zinc-950/20"
    >
        <div
            class="relative z-10 container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <!-- Header Section -->
            <div
                class="mx-auto mb-16 flex max-w-3xl flex-col items-center text-center"
            >
                <span
                    class="mb-3 rounded-full border border-emerald-500/10 bg-emerald-500/5 px-3.5 py-1.5 text-xs font-extrabold tracking-widest text-emerald-600 uppercase dark:bg-emerald-500/10 dark:text-emerald-400"
                >
                    Layanan Terbaik
                </span>
                <h2
                    class="mb-4 text-3xl font-extrabold tracking-tight text-foreground sm:text-4xl"
                >
                    Mengapa Harus Menyetor di Bahari Eco?
                </h2>
                <p
                    class="text-sm leading-relaxed text-muted-foreground sm:text-base"
                >
                    Kami menghadirkan solusi pengolahan sampah modern yang
                    praktis, menguntungkan secara ekonomi, dan berdampak nyata
                    bagi kelestarian lingkungan Indonesia.
                </p>
            </div>

            <!-- Features Grid -->
            <div
                class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 lg:gap-8"
            >
                <FeatureCard
                    v-for="(feature, index) in features"
                    :key="index"
                    :title="feature.title"
                    :description="feature.description"
                    :icon="feature.icon"
                    :badge="feature.badge"
                    :color="feature.color"
                />
            </div>
        </div>
    </section>
</template>
