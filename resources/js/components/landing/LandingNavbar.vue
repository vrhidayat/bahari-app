<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    Leaf,
    Menu,
    X,
    Sun,
    Moon,
    Monitor,
    ArrowRight,
    User,
} from '@lucide/vue';
import { ref, onMounted, onUnmounted } from 'vue';
import { Button } from '@/components/ui/button';
import { useAppearance } from '@/composables/useAppearance';
import { dashboard, login, register } from '@/routes';

const { appearance, updateAppearance } = useAppearance();
const page = usePage();

const isScrolled = ref(false);
const mobileMenuOpen = ref(false);

const navItems = [
    { name: 'Beranda', href: '#home' },
    { name: 'Layanan', href: '#services' },
    { name: 'Jenis Sampah', href: '#waste-types' },
    { name: 'Kalkulator', href: '#calculator' },
    { name: 'Alur Kerja', href: '#workflow' },
    { name: 'Testimoni', href: '#testimonials' },
    { name: 'FAQ', href: '#faq' },
];

const handleScroll = () => {
    isScrolled.value = window.scrollY > 10;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

const scrollToSection = (e: Event, href: string) => {
    e.preventDefault();
    mobileMenuOpen.value = false;
    const target = document.querySelector(href);

    if (target) {
        const offset = 80; // height of sticky navbar
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

const toggleAppearance = () => {
    if (appearance.value === 'light') {
        updateAppearance('dark');
    } else if (appearance.value === 'dark') {
        updateAppearance('system');
    } else {
        updateAppearance('light');
    }
};
</script>

<template>
    <header
        :class="[
            'fixed top-0 right-0 left-0 z-50 border-b transition-all duration-300',
            isScrolled
                ? 'border-border/40 bg-background/85 py-3 shadow-xs backdrop-blur-md'
                : 'border-transparent bg-transparent py-5',
        ]"
    >
        <div
            class="container mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8"
        >
            <!-- Brand Logo -->
            <a
                href="#home"
                @click="scrollToSection($event, '#home')"
                class="group flex items-center gap-2.5"
            >
                <div
                    class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600 transition-transform duration-300 group-hover:scale-105 dark:bg-emerald-500/20 dark:text-emerald-400"
                >
                    <Leaf
                        class="h-5 w-5 rotate-12 transition-transform duration-300 group-hover:rotate-0"
                    />
                    <span class="absolute -top-0.5 -right-0.5 flex h-2 w-2">
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"
                        ></span>
                        <span
                            class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"
                        ></span>
                    </span>
                </div>
                <div class="flex flex-col">
                    <span
                        class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-lg font-bold tracking-tight text-transparent dark:from-emerald-400 dark:to-teal-300"
                    >
                        Bahari Eco
                    </span>
                    <span
                        class="-mt-1 text-[10px] font-medium tracking-wider text-muted-foreground uppercase"
                        >Lestari Bumi</span
                    >
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav
                class="hidden items-center gap-1.5 rounded-full border border-border/30 bg-muted/30 px-3 py-1.5 lg:flex dark:bg-zinc-900/30"
            >
                <a
                    v-for="item in navItems"
                    :key="item.name"
                    :href="item.href"
                    @click="scrollToSection($event, item.href)"
                    class="rounded-full px-4 py-1.5 text-xs font-semibold text-muted-foreground transition-all duration-200 hover:bg-background/80 hover:text-foreground dark:hover:bg-zinc-800/80"
                >
                    {{ item.name }}
                </a>
            </nav>

            <!-- Actions -->
            <div class="hidden items-center gap-4 lg:flex">
                <!-- Dark Mode Toggle Button -->
                <button
                    @click="toggleAppearance"
                    class="rounded-xl border border-transparent p-2.5 text-muted-foreground transition-colors duration-200 hover:border-border/30 hover:bg-muted hover:text-foreground"
                    title="Toggle Theme"
                >
                    <Sun v-if="appearance === 'light'" class="h-4.5 w-4.5" />
                    <Moon
                        v-else-if="appearance === 'dark'"
                        class="h-4.5 w-4.5"
                    />
                    <Monitor v-else class="h-4.5 w-4.5" />
                </button>

                <!-- Authentication CTAs -->
                <div class="flex items-center gap-2">
                    <template v-if="page.props.auth?.user">
                        <Link :href="dashboard()">
                            <Button
                                variant="outline"
                                size="sm"
                                class="gap-1.5 rounded-xl border-emerald-500/20 text-emerald-600 hover:text-emerald-700 dark:border-emerald-500/30 dark:text-emerald-400"
                            >
                                <User class="h-4 w-4" />
                                Dashboard
                            </Button>
                        </Link>
                    </template>
                    <template v-else>
                        <Link :href="login()">
                            <Button
                                variant="ghost"
                                size="sm"
                                class="rounded-xl text-muted-foreground hover:text-foreground"
                            >
                                Masuk
                            </Button>
                        </Link>
                        <Link :href="register()">
                            <Button
                                size="sm"
                                class="gap-1 rounded-xl bg-emerald-600 px-4 font-semibold text-white shadow-xs hover:bg-emerald-700"
                            >
                                Mulai Jual
                                <ArrowRight class="h-3.5 w-3.5" />
                            </Button>
                        </Link>
                    </template>
                </div>
            </div>

            <!-- Mobile menu button & theme button -->
            <div class="flex items-center gap-2 lg:hidden">
                <button
                    @click="toggleAppearance"
                    class="rounded-xl p-2 text-muted-foreground transition-colors hover:bg-muted/50 hover:text-foreground"
                >
                    <Sun v-if="appearance === 'light'" class="h-4 w-4" />
                    <Moon
                        v-else-if="appearance === 'dark'"
                        class="h-4.5 w-4.5"
                    />
                    <Monitor v-else class="h-4.5 w-4.5" />
                </button>
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="rounded-xl border border-border/20 p-2 text-muted-foreground transition-colors hover:bg-muted/50 hover:text-foreground"
                >
                    <Menu v-if="!mobileMenuOpen" class="h-5 w-5" />
                    <X v-else class="h-5 w-5" />
                </button>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 translate-y-[-10px]"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-[-10px]"
        >
            <div
                v-if="mobileMenuOpen"
                class="absolute top-full right-0 left-0 border-b border-border bg-background/95 px-4 py-6 shadow-lg backdrop-blur-lg lg:hidden"
            >
                <nav class="flex flex-col gap-2.5">
                    <a
                        v-for="item in navItems"
                        :key="item.name"
                        :href="item.href"
                        @click="scrollToSection($event, item.href)"
                        class="rounded-xl px-4 py-2.5 text-sm font-medium text-muted-foreground transition-all hover:bg-emerald-500/5 hover:text-emerald-500"
                    >
                        {{ item.name }}
                    </a>

                    <hr class="my-2 border-border/60" />

                    <!-- Auth actions in mobile menu -->
                    <div class="flex flex-col gap-2 px-2">
                        <template v-if="page.props.auth?.user">
                            <Link
                                :href="dashboard()"
                                @click="mobileMenuOpen = false"
                                class="w-full"
                            >
                                <Button
                                    class="w-full justify-center rounded-xl bg-emerald-600 font-semibold text-white hover:bg-emerald-700"
                                >
                                    Ke Dashboard
                                </Button>
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                :href="login()"
                                @click="mobileMenuOpen = false"
                                class="w-full"
                            >
                                <Button
                                    variant="outline"
                                    class="w-full justify-center rounded-xl border-border"
                                >
                                    Masuk
                                </Button>
                            </Link>
                            <Link
                                :href="register()"
                                @click="mobileMenuOpen = false"
                                class="w-full"
                            >
                                <Button
                                    class="w-full justify-center rounded-xl bg-emerald-600 font-semibold text-white hover:bg-emerald-700"
                                >
                                    Mulai Jual Sekarang
                                </Button>
                            </Link>
                        </template>
                    </div>
                </nav>
            </div>
        </transition>
    </header>
</template>
