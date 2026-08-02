<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import LandingFooter from '@/components/landing/LandingFooter.vue';
import LandingNavbar from '@/components/landing/LandingNavbar.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <Head
        :title="
            title
                ? `${title} | Bahari Eco`
                : 'Bahari Eco - Jual Beli Sampah & Daur Ulang'
        "
    >
        <meta
            name="description"
            :content="
                description ||
                'Bahari Eco - Platform Jual Beli Sampah Online Terpercaya. Setor sampah daur ulang Anda, dapatkan insentif saldo digital, dan selamatkan bumi.'
            "
        />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin="anonymous"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet"
        />
    </Head>

    <div
        class="flex min-h-screen flex-col bg-background font-sans text-foreground transition-colors duration-300 selection:bg-emerald-500/20 selection:text-emerald-500"
    >
        <!-- Reusable Navbar -->
        <LandingNavbar />

        <!-- Page Content -->
        <main class="flex-grow pt-16">
            <slot />
        </main>

        <!-- Reusable Footer -->
        <LandingFooter />
    </div>
</template>

<style>
/* Custom typography defaults for landing pages to make it look premium and custom */
body {
    font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
}
h1,
h2,
h3,
h4,
h5,
h6 {
    font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
}
</style>
