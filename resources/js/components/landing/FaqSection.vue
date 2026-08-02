<script setup lang="ts">
import { ChevronDown, HelpCircle } from '@lucide/vue';
import { ref } from 'vue';

const faqs = [
    {
        question: 'Apakah ada syarat berat minimum untuk layanan penjemputan?',
        answer: 'Ya, untuk layanan penjemputan gratis langsung ke rumah (Home Pickup), berat total minimum semua jenis sampah yang disyaratkan adalah 10 Kg. Jika berat sampah Anda di bawah 10 Kg, Anda dapat menyetorkannya secara mandiri ke Drop Point terdekat tanpa syarat minimum berat.',
    },
    {
        question: 'Bagaimana cara mencairkan uang hasil penjualan sampah?',
        answer: 'Setelah sampah Anda ditimbang secara presisi oleh kurir atau petugas, nominal saldo rupiah akan langsung dikreditkan ke dompet digital Bahari Eco Anda saat itu juga. Anda dapat mencairkannya kapan saja ke rekening bank atau e-wallet (GoPay, OVO, DANA, ShopeePay) secara instan dalam waktu kurang dari 5 menit.',
    },
    {
        question: 'Jenis sampah plastik apa saja yang diterima?',
        answer: 'Kami menerima plastik jenis PET (seperti botol plastik air mineral bening), HDPE (seperti botol bekas shampoo, botol detergen cair, jerigen tebal), dan PP (gelas plastik kemasan, cup minuman). Demi kelancaran daur ulang, harap buang cairan di dalamnya dan bilas secara singkat terlebih dahulu.',
    },
    {
        question: 'Apakah harga sampah bisa berubah sewaktu-waktu?',
        answer: 'Ya, harga sampah daur ulang dapat berubah mengikuti pergerakan harga komoditas daur ulang di pasar industri global dan lokal. Namun jangan khawatir, kami selalu memperbarui harga secara transparan dan real-time di website serta aplikasi kami.',
    },
    {
        question: 'Mengapa saya harus memilah sampah terlebih dahulu?',
        answer: 'Memilah sampah kering berdasarkan jenisnya (plastik, kertas, logam) dari rumah sangat mempermudah proses verifikasi timbangan petugas kami, menghindari penolakan karena sampah basah/terkontaminasi, dan meningkatkan efisiensi proses daur ulang industri agar nilai jual Anda tetap maksimal.',
    },
];

const openIdx = ref<number | null>(null);

const toggleFaq = (idx: number) => {
    if (openIdx.value === idx) {
        openIdx.value = null;
    } else {
        openIdx.value = idx;
    }
};
</script>

<template>
    <section id="faq" class="relative overflow-hidden bg-background py-20">
        <!-- Accent light source in background -->
        <div
            class="pointer-events-none absolute top-1/2 left-0 h-64 w-64 -translate-y-1/2 rounded-full bg-emerald-500/5 blur-3xl"
        ></div>

        <div
            class="relative z-10 container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8"
        >
            <!-- Section Header -->
            <div
                class="mx-auto mb-16 flex max-w-3xl flex-col items-center text-center"
            >
                <span
                    class="mb-3 rounded-full border border-emerald-500/10 bg-emerald-500/5 px-3.5 py-1.5 text-xs font-extrabold tracking-widest text-emerald-600 uppercase dark:bg-emerald-500/10 dark:text-emerald-400"
                >
                    Tanya Jawab
                </span>
                <h2
                    class="mb-4 text-3xl font-extrabold tracking-tight text-foreground sm:text-4xl"
                >
                    Pertanyaan yang Sering Diajukan (FAQ)
                </h2>
                <p
                    class="text-sm leading-relaxed text-muted-foreground sm:text-base"
                >
                    Masih ragu atau butuh informasi lebih lanjut? Temukan
                    jawaban atas beberapa pertanyaan umum yang sering ditanyakan
                    oleh calon mitra kami.
                </p>
            </div>

            <!-- Accordion List -->
            <div class="flex flex-col gap-4">
                <div
                    v-for="(faq, idx) in faqs"
                    :key="idx"
                    class="overflow-hidden rounded-2xl border border-border/70 bg-card transition-all duration-300 hover:border-emerald-500/20"
                >
                    <!-- Trigger Header -->
                    <button
                        @click="toggleFaq(idx)"
                        class="flex w-full items-center justify-between gap-4 p-5 text-left text-sm font-bold text-foreground transition-colors hover:bg-muted/30 sm:text-base"
                    >
                        <span class="flex items-center gap-3">
                            <HelpCircle
                                class="h-4.5 w-4.5 shrink-0 text-emerald-500"
                            />
                            {{ faq.question }}
                        </span>
                        <ChevronDown
                            :class="[
                                'h-4 w-4 shrink-0 text-muted-foreground transition-transform duration-300',
                                openIdx === idx
                                    ? 'rotate-180 text-emerald-500'
                                    : '',
                            ]"
                        />
                    </button>

                    <!-- Answer panel -->
                    <div
                        v-show="openIdx === idx"
                        class="border-t border-border/30 bg-muted/10 px-5 pt-1 pb-5 text-xs leading-relaxed text-muted-foreground sm:text-sm"
                    >
                        <p class="animate-fade-in">
                            {{ faq.answer }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
