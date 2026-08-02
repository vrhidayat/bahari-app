<script setup lang="ts">
import TestimonialCard from './TestimonialCard.vue';

const testimonials = [
    {
        name: 'Ibu Endang Lestari',
        role: 'Ibu Rumah Tangga',
        text: 'Sangat terbantu! Dulu minyak jelantah bekas gorengan & botol bekas menumpuk di dapur. Sekarang tinggal jadwalkan jemput lewat HP, kurir datang, langsung cair jadi saldo Dana.',
        impactSummary: 'Setor 52 Ltr Minyak',
        stars: 5,
    },
    {
        name: 'Budi Susanto',
        role: 'Pemilik Kedai Kopi',
        text: 'Timbangan kurirnya transparan karena digital dan bisa kita saksikan langsung. Sangat profesional, harganya bersaing, dan pencairan insentif ke rekening bank instan tanpa potongan.',
        impactSummary: 'Setor 145 Kg Plastik',
        stars: 5,
    },
    {
        name: 'Rian Anggara',
        role: 'Mahasiswa Kelautan',
        text: 'Selain dapet uang saku tambahan dari kardus & kertas tugas bekas, saya bangga bisa melihat statistik jumlah karbon CO₂ yang saya selamatkan secara berkala di aplikasi ini.',
        impactSummary: 'Setor 34 Kg Kertas',
        stars: 5,
    },
];
</script>

<template>
    <section
        id="testimonials"
        class="relative border-y border-border/40 bg-muted/20 py-20 dark:bg-zinc-950/20"
    >
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
                    Testimoni Mitra
                </span>
                <h2
                    class="mb-4 text-3xl font-extrabold tracking-tight text-foreground sm:text-4xl"
                >
                    Apa Kata Mereka Tentang Kami?
                </h2>
                <p
                    class="text-sm leading-relaxed text-muted-foreground sm:text-base"
                >
                    Lebih dari ribuan mitra rumah tangga dan UMKM telah
                    bergabung untuk mendaur ulang sampah mereka secara praktis
                    dan transparan bersama Bahari Eco.
                </p>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <TestimonialCard
                    v-for="(t, idx) in testimonials"
                    :key="idx"
                    :name="t.name"
                    :role="t.role"
                    :text="t.text"
                    :impactSummary="t.impactSummary"
                    :stars="t.stars"
                />
            </div>
        </div>
    </section>
</template>
