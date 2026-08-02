<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Calculator, ArrowRight, Coins, Leaf } from '@lucide/vue';
import { ref, computed } from 'vue';
import { Button } from '@/components/ui/button';
import { register, dashboard } from '@/routes';

const page = usePage();

// Waste categories list
const categories = [
    {
        id: 'plastic',
        name: 'Sampah Plastik',
        price: 3500,
        unit: 'Kg',
        co2Multiplier: 1.5,
        desc: 'Botol mineral, jerigen, gelas plastik',
    },
    {
        id: 'paper',
        name: 'Kertas & Kardus',
        price: 2500,
        unit: 'Kg',
        co2Multiplier: 1.2,
        desc: 'Koran bekas, kardus, HVS, majalah',
    },
    {
        id: 'metal',
        name: 'Logam & Besi',
        price: 9500,
        unit: 'Kg',
        co2Multiplier: 2.4,
        desc: 'Kaleng aluminium, besi tua, seng',
    },
    {
        id: 'oil',
        name: 'Minyak Jelantah',
        price: 7500,
        unit: 'Liter',
        co2Multiplier: 2.0,
        desc: 'Minyak goreng bekas rumah tangga/resto',
    },
    {
        id: 'electronic',
        name: 'Sampah Elektronik',
        price: 15000,
        unit: 'Kg',
        co2Multiplier: 3.1,
        desc: 'Kabel, charger, HP rusak, baterai',
    },
];

const selectedCategoryId = ref('plastic');
const quantity = ref(10);

const selectedCategory = computed(() => {
    return (
        categories.find((c) => c.id === selectedCategoryId.value) ||
        categories[0]
    );
});

// Calculations
const estimatedEarnings = computed(() => {
    return selectedCategory.value.price * (quantity.value || 0);
});

const estimatedCo2Offset = computed(() => {
    return (
        selectedCategory.value.co2Multiplier * (quantity.value || 0)
    ).toFixed(1);
});

// Format money
const formatRupiah = (value: number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(value);
};

// Quick quantity adjustments
const adjustQuantity = (amount: number) => {
    const nextVal = (quantity.value || 0) + amount;
    quantity.value = nextVal < 1 ? 1 : nextVal;
};

const setQuantity = (amount: number) => {
    quantity.value = amount;
};
</script>

<template>
    <section
        id="calculator"
        class="relative overflow-hidden border-y border-border/40 bg-muted/30 py-20 dark:bg-zinc-950/20"
    >
        <!-- Background accents -->
        <div
            class="pointer-events-none absolute right-0 bottom-0 h-80 w-80 translate-y-1/3 rounded-full bg-emerald-500/5 blur-3xl"
        ></div>

        <div
            class="relative z-10 container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
        >
            <div
                class="grid grid-cols-1 items-center gap-12 lg:grid-cols-12 lg:gap-16"
            >
                <!-- Left text -->
                <div class="flex flex-col items-start text-left lg:col-span-5">
                    <span
                        class="mb-3 rounded-full border border-emerald-500/10 bg-emerald-500/5 px-3.5 py-1.5 text-xs font-extrabold tracking-widest text-emerald-600 uppercase dark:bg-emerald-500/10 dark:text-emerald-400"
                    >
                        Kalkulator Rupiah
                    </span>
                    <h2
                        class="mb-4 text-3xl font-extrabold tracking-tight text-foreground sm:text-4xl"
                    >
                        Estimasi Uang Dari Sampah Anda
                    </h2>
                    <p
                        class="mb-6 text-sm leading-relaxed text-muted-foreground sm:text-base"
                    >
                        Gunakan kalkulator interaktif ini untuk memprediksi
                        berapa rupiah insentif yang bisa Anda dapatkan beserta
                        kontribusi penyelamatan iklim dari setiap kilogram
                        sampah daur ulang Anda.
                    </p>

                    <!-- Features bullets -->
                    <div class="mt-2 flex flex-col gap-4">
                        <div class="flex items-start gap-3">
                            <div
                                class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400"
                            >
                                <Coins class="h-3.5 w-3.5" />
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-foreground">
                                    Harga Ter-update
                                </h4>
                                <p class="text-xs text-muted-foreground">
                                    Fluktuasi harga transparan mengikuti
                                    pergerakan pasar daur ulang terkini.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div
                                class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400"
                            >
                                <Leaf class="h-3.5 w-3.5" />
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-foreground">
                                    Konversi Karbon CO₂
                                </h4>
                                <p class="text-xs text-muted-foreground">
                                    Ketahui nilai reduksi jejak karbon yang Anda
                                    sumbangkan untuk mitigasi perubahan iklim.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right widget (Calculator Card) -->
                <div class="lg:col-span-7">
                    <div
                        class="relative overflow-hidden rounded-3xl border border-border/80 bg-card p-6 shadow-xl sm:p-8"
                    >
                        <div
                            class="pointer-events-none absolute -top-10 -right-10 h-24 w-24 rounded-full bg-emerald-500/5"
                        ></div>

                        <!-- Card Header -->
                        <div
                            class="mb-6 flex items-center gap-3 border-b border-border/40 pb-4"
                        >
                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400"
                            >
                                <Calculator class="h-4.5 w-4.5" />
                            </div>
                            <div>
                                <h3
                                    class="text-base leading-none font-bold text-foreground"
                                >
                                    Simulasi Pendapatan
                                </h3>
                                <span
                                    class="mt-1 block text-[11px] font-semibold text-muted-foreground"
                                    >Silakan masukkan kategori dan estimasi
                                    berat sampah</span
                                >
                            </div>
                        </div>

                        <!-- Form -->
                        <div class="flex flex-col gap-6">
                            <!-- Select Kategori -->
                            <div class="flex flex-col gap-2.5">
                                <label
                                    class="text-xs font-extrabold tracking-wider text-muted-foreground uppercase"
                                    >1. Pilih Kategori Sampah</label
                                >
                                <div
                                    class="grid grid-cols-2 gap-2 sm:grid-cols-5"
                                >
                                    <button
                                        v-for="cat in categories"
                                        :key="cat.id"
                                        @click="selectedCategoryId = cat.id"
                                        :class="[
                                            'flex flex-col items-center justify-center gap-1.5 rounded-xl border px-3.5 py-3 text-center transition-all duration-200',
                                            selectedCategoryId === cat.id
                                                ? 'border-emerald-500 bg-emerald-500/5 font-bold text-emerald-600 shadow-xs dark:text-emerald-400'
                                                : 'border-border/60 text-muted-foreground hover:border-border hover:bg-muted/40',
                                        ]"
                                    >
                                        <span
                                            class="text-xs leading-none font-bold"
                                            >{{
                                                cat.name.split(' ')[1] ||
                                                cat.name
                                            }}</span
                                        >
                                        <span
                                            class="text-[10px] leading-none opacity-85"
                                            >{{ formatRupiah(cat.price) }}/{{
                                                cat.unit
                                            }}</span
                                        >
                                    </button>
                                </div>
                                <span
                                    class="mt-1 text-[11px] font-medium text-muted-foreground italic"
                                    >{{ selectedCategory.desc }}</span
                                >
                            </div>

                            <!-- Input Weight -->
                            <div class="flex flex-col gap-2.5">
                                <label
                                    class="text-xs font-extrabold tracking-wider text-muted-foreground uppercase"
                                    >2. Tentukan Jumlah (Berat/Volume)</label
                                >
                                <div class="flex items-center gap-3">
                                    <!-- Quick adjustments -->
                                    <button
                                        @click="adjustQuantity(-5)"
                                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-border font-bold text-foreground transition-colors hover:bg-muted/40"
                                    >
                                        -5
                                    </button>

                                    <!-- Main Input -->
                                    <div
                                        class="relative flex flex-grow items-center"
                                    >
                                        <input
                                            type="number"
                                            v-model.number="quantity"
                                            min="1"
                                            max="9999"
                                            class="h-11 w-full [appearance:textfield] rounded-xl border border-border bg-background px-4 text-center text-lg font-extrabold text-foreground transition-all outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                        />
                                        <span
                                            class="pointer-events-none absolute right-4 text-sm font-bold text-muted-foreground uppercase"
                                        >
                                            {{ selectedCategory.unit }}
                                        </span>
                                    </div>

                                    <!-- Quick adjustments -->
                                    <button
                                        @click="adjustQuantity(5)"
                                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-border font-bold text-foreground transition-colors hover:bg-muted/40"
                                    >
                                        +5
                                    </button>
                                </div>

                                <!-- Preset shortcuts -->
                                <div
                                    class="mt-1 flex flex-wrap items-center gap-1.5"
                                >
                                    <button
                                        v-for="preset in [5, 10, 20, 50, 100]"
                                        :key="preset"
                                        @click="setQuantity(preset)"
                                        :class="[
                                            'rounded-lg border px-3 py-1 text-xs font-bold transition-all',
                                            quantity === preset
                                                ? 'border-emerald-600 bg-emerald-600 text-white shadow-xs'
                                                : 'border-border text-muted-foreground hover:bg-muted/40',
                                        ]"
                                    >
                                        {{ preset }} {{ selectedCategory.unit }}
                                    </button>
                                </div>
                            </div>

                            <!-- Calculations Display -->
                            <div
                                class="grid grid-cols-1 gap-4 border-t border-border/40 pt-6 sm:grid-cols-2"
                            >
                                <!-- Cash reward -->
                                <div
                                    class="rounded-2xl border border-emerald-500/20 bg-emerald-500/5 p-4 dark:bg-emerald-500/10"
                                >
                                    <span
                                        class="mb-1 block text-[11px] font-extrabold tracking-wider text-emerald-800 uppercase dark:text-emerald-300"
                                        >Total Insentif Uang</span
                                    >
                                    <div
                                        class="text-2xl font-black text-emerald-600 dark:text-emerald-400"
                                    >
                                        {{ formatRupiah(estimatedEarnings) }}
                                    </div>
                                </div>

                                <!-- Carbon offset -->
                                <div
                                    class="rounded-2xl border border-teal-500/20 bg-teal-500/5 p-4 dark:bg-teal-500/10"
                                >
                                    <span
                                        class="mb-1 block text-[11px] font-extrabold tracking-wider text-teal-800 uppercase dark:text-teal-300"
                                        >Mengurangi Emisi Karbon</span
                                    >
                                    <div
                                        class="flex items-baseline gap-1 text-2xl font-black text-teal-600 dark:text-teal-400"
                                    >
                                        {{ estimatedCo2Offset }}
                                        <span
                                            class="text-xs font-bold text-teal-500"
                                            >KG CO₂</span
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Action CTA -->
                            <template v-if="page.props.auth?.user">
                                <Link :href="dashboard()" class="block w-full">
                                    <Button
                                        size="lg"
                                        class="group w-full gap-2 rounded-2xl bg-emerald-600 py-6 font-bold text-white shadow-md shadow-emerald-500/10 hover:bg-emerald-700"
                                    >
                                        Setor Sekarang & Ambil Insentif
                                        <ArrowRight
                                            class="h-4.5 w-4.5 transition-transform group-hover:translate-x-1"
                                        />
                                    </Button>
                                </Link>
                            </template>
                            <template v-else>
                                <Link :href="register()" class="block w-full">
                                    <Button
                                        size="lg"
                                        class="group w-full gap-2 rounded-2xl bg-emerald-600 py-6 font-bold text-white shadow-md shadow-emerald-500/10 hover:bg-emerald-700"
                                    >
                                        Daftar Sekarang untuk Menjual
                                        <ArrowRight
                                            class="h-4.5 w-4.5 transition-transform group-hover:translate-x-1"
                                        />
                                    </Button>
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
