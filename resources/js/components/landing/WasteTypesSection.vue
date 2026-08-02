<script setup lang="ts">
import { Layers, FileText, Hammer, Droplets, Cpu } from '@lucide/vue';
import WasteTypeCard from './WasteTypeCard.vue';

const wasteTypes = [
    {
        name: 'Sampah Plastik',
        priceRange: 'Rp 2.000 - Rp 5.500 / Kg',
        description:
            'Plastik PET (botol mineral), HDPE (botol shampoo/detergen), PP (gelas plastik), dan jerigen bersih.',
        examples: ['Botol PET', 'Gelas Plastik', 'Jerigen', 'Wadah Kosmetik'],
        icon: Layers,
        impactInfo: 'Mereduksi 1.5 Kg CO₂ per Kg',
        badge: 'Tergacor',
    },
    {
        name: 'Kertas & Kardus',
        priceRange: 'Rp 1.500 - Rp 3.500 / Kg',
        description:
            'Kardus packing cokelat tebal, kertas koran, majalah, buku sekolah bekas, brosur, serta kertas HVS.',
        examples: ['Kardus Box', 'Koran Bekas', 'Buku & Majalah', 'Kertas HVS'],
        icon: FileText,
        impactInfo: 'Menyelamatkan 17 pohon per Ton',
    },
    {
        name: 'Logam & Besi',
        priceRange: 'Rp 4.000 - Rp 15.000 / Kg',
        description:
            'Kaleng minuman ringan aluminium, besi tua kontruksi, seng, tembaga, kuningan, dan peralatan besi dapur.',
        examples: [
            'Kaleng Soda',
            'Besi Tua',
            'Kabel Tembaga',
            'Wajan Aluminium',
        ],
        icon: Hammer,
        impactInfo: 'Mereduksi 2.4 Kg CO₂ per Kg',
        badge: 'Harga Tinggi',
    },
    {
        name: 'Minyak Jelantah',
        priceRange: 'Rp 6.000 - Rp 9.500 / Liter',
        description:
            'Minyak bekas penggorengan rumah tangga atau usaha kuliner. Disaring dari sisa makanan kasar.',
        examples: ['Minyak Goreng Bekas'],
        icon: Droplets,
        impactInfo: 'Cegah pencemaran 1 Juta Liter Air',
    },
    {
        name: 'Sampah Elektronik',
        priceRange: 'Rp 5.000 - Rp 50.000 / Pcs',
        description:
            'Peralatan elektronik rumah tangga yang rusak, kabel tembaga, charger, baterai HP, keyboard, dan CPU.',
        examples: [
            'Kabel & Charger',
            'Baterai Bekas',
            'Keyboard/Mouse',
            'Mainboard HP',
        ],
        icon: Cpu,
        impactInfo: 'Kurangi limbah logam berat B3',
    },
];
</script>

<template>
    <section id="waste-types" class="relative bg-background py-20">
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
                    Kategori Sampah
                </span>
                <h2
                    class="mb-4 text-3xl font-extrabold tracking-tight text-foreground sm:text-4xl"
                >
                    Jenis Sampah yang Kami Terima & Beli
                </h2>
                <p
                    class="text-sm leading-relaxed text-muted-foreground sm:text-base"
                >
                    Kami menerima berbagai kategori sampah kering dan daur ulang
                    dengan kompensasi yang transparan. Pilah sampah Anda sesuai
                    kategorinya untuk mendapatkan nilai jual terbaik.
                </p>
            </div>

            <!-- Cards Grid -->
            <div
                class="grid grid-cols-1 justify-center gap-6 md:grid-cols-2 lg:grid-cols-3 lg:gap-8"
            >
                <WasteTypeCard
                    v-for="(type, idx) in wasteTypes"
                    :key="idx"
                    :name="type.name"
                    :priceRange="type.priceRange"
                    :description="type.description"
                    :examples="type.examples"
                    :icon="type.icon"
                    :impactInfo="type.impactInfo"
                    :badge="type.badge"
                />
            </div>
        </div>
    </section>
</template>
