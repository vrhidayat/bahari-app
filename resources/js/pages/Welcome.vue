<script setup lang="ts">
import FaqSection from '@/components/landing/FaqSection.vue';
import FeatureSection from '@/components/landing/FeatureSection.vue';
import HeroSection from '@/components/landing/HeroSection.vue';
import PriceCalculator from '@/components/landing/PriceCalculator.vue';
import TestimonialsSection from '@/components/landing/TestimonialsSection.vue';
import WasteTypesSection from '@/components/landing/WasteTypesSection.vue';
import WorkflowSection from '@/components/landing/WorkflowSection.vue';
import LandingLayout from '@/layouts/LandingLayout.vue';
</script>

<template>
    <LandingLayout title="Jual Beli Sampah & Daur Ulang Online Terpercaya">
        <!-- Hero Section -->
        <HeroSection />

        <!-- Feature Section -->
        <FeatureSection />

        <!-- Waste Types Section -->
        <WasteTypesSection />

        <!-- Price Calculator Section -->
        <PriceCalculator />

        <!-- Workflow Section -->
        <WorkflowSection />

        <!-- Testimonials Section -->
        <TestimonialsSection />

        <!-- FAQ Section -->
        <FaqSection />
    </LandingLayout>
</template>
