<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import {
    ExternalLink,
    ImagePlus,
    LoaderCircle,
    MapPin,
    ScanLine,
    Trash2,
} from '@lucide/vue';
import { onBeforeUnmount, ref } from 'vue';
import { dashboard } from '@/routes';
import { predict } from '@/routes/waste-scan';

type NearbyPlace = {
    id: number;
    name: string;
    latitude: number;
    longitude: number;
    distance: number;
};

type OverpassElement = {
    id: number;
    lat?: number;
    lon?: number;
    center?: {
        lat: number;
        lon: number;
    };
    tags?: Record<string, string>;
};

type ScanResult = {
    prediction: {
        class: string;
        confidence: number;
        status: 'accepted' | 'uncertain';
    };
    recommendation: {
        summary: string;
        steps: string[];
        warnings: string[];
    } | null;
    message?: string;
    candidates?: {
        class: string;
        confidence: number;
    }[];
};

const selectedImage = ref<File | null>(null);
const previewUrl = ref<string | null>(null);
const errorMessage = ref('');
const scanError = ref('');
const scanResult = ref<ScanResult | null>(null);
const isScanning = ref(false);
const nearbyPlaces = ref<NearbyPlace[]>([]);
const locationError = ref('');
const isSearching = ref(false);
const hasSearched = ref(false);
let scanRequestId = 0;

const materialLabels: Record<string, string> = {
    cardboard: 'Kardus',
    glass: 'Kaca',
    metal: 'Logam',
    paper: 'Kertas',
    plastic: 'Plastik',
    trash: 'Sampah campuran',
};

const formatMaterial = (material: string): string =>
    materialLabels[material] ?? material;

const formatConfidence = (confidence: number): string =>
    new Intl.NumberFormat('id-ID', {
        style: 'percent',
        maximumFractionDigits: 2,
    }).format(confidence);

const calculateDistance = (
    originLatitude: number,
    originLongitude: number,
    destinationLatitude: number,
    destinationLongitude: number,
): number => {
    const earthRadius = 6371e3;
    const latitudeDifference =
        ((destinationLatitude - originLatitude) * Math.PI) / 180;
    const longitudeDifference =
        ((destinationLongitude - originLongitude) * Math.PI) / 180;
    const haversine =
        Math.sin(latitudeDifference / 2) ** 2 +
        Math.cos((originLatitude * Math.PI) / 180) *
            Math.cos((destinationLatitude * Math.PI) / 180) *
            Math.sin(longitudeDifference / 2) ** 2;

    return (
        earthRadius *
        2 *
        Math.atan2(Math.sqrt(haversine), Math.sqrt(1 - haversine))
    );
};

const formatDistance = (distance: number): string => {
    if (distance < 1000) {
        return `${Math.round(distance)} m`;
    }

    return `${(distance / 1000).toLocaleString('id-ID', { maximumFractionDigits: 1 })} km`;
};

const scanImage = async (): Promise<void> => {
    const image = selectedImage.value;

    if (!image) {
        return;
    }

    const requestId = ++scanRequestId;
    const formData = new FormData();
    formData.append('file', image);
    scanError.value = '';
    scanResult.value = null;
    nearbyPlaces.value = [];
    locationError.value = '';
    hasSearched.value = false;
    isScanning.value = true;

    try {
        const xsrfCookie = document.cookie
            .split('; ')
            .find((cookie) => cookie.startsWith('XSRF-TOKEN='));
        const headers = new Headers({ Accept: 'application/json' });

        if (xsrfCookie) {
            headers.set(
                'X-XSRF-TOKEN',
                decodeURIComponent(xsrfCookie.slice('XSRF-TOKEN='.length)),
            );
        }

        const response = await fetch(predict().url, {
            method: 'POST',
            headers,
            body: formData,
        });
        const data = (await response.json()) as ScanResult & {
            detail?: string;
        };

        if (!response.ok) {
            throw new Error(
                data.detail ?? 'Gambar tidak dapat diproses oleh layanan scan.',
            );
        }

        if (requestId === scanRequestId) {
            scanResult.value = data;
        }
    } catch (error) {
        if (requestId === scanRequestId) {
            scanError.value =
                error instanceof TypeError
                    ? 'Layanan scan tidak dapat dihubungi. Periksa koneksi dan pengaturan CORS API.'
                    : error instanceof Error
                      ? error.message
                      : 'Terjadi kesalahan saat memproses gambar.';
        }
    } finally {
        if (requestId === scanRequestId) {
            isScanning.value = false;
        }
    }
};

const searchNearbyBanks = async (): Promise<void> => {
    locationError.value = '';
    nearbyPlaces.value = [];
    hasSearched.value = false;
    isSearching.value = true;

    try {
        if (!navigator.geolocation) {
            throw new Error('Browser ini tidak mendukung akses lokasi.');
        }

        const position = await new Promise<GeolocationPosition>(
            (resolve, reject) => {
                navigator.geolocation.getCurrentPosition(resolve, reject, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 300000,
                });
            },
        );
        const { latitude, longitude } = position.coords;
        const query = `[out:json][timeout:25];(node["amenity"="recycling"](around:10000,${latitude},${longitude});way["amenity"="recycling"](around:10000,${latitude},${longitude});relation["amenity"="recycling"](around:10000,${latitude},${longitude}););out center tags;`;
        const response = await fetch(
            'https://overpass-api.de/api/interpreter',
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ data: query }),
            },
        );

        if (!response.ok) {
            throw new Error('Data lokasi tidak dapat dimuat.');
        }

        const data = (await response.json()) as {
            elements: OverpassElement[];
        };

        nearbyPlaces.value = data.elements
            .flatMap((element): NearbyPlace[] => {
                const placeLatitude = element.center?.lat ?? element.lat;
                const placeLongitude = element.center?.lon ?? element.lon;

                if (
                    placeLatitude === undefined ||
                    placeLongitude === undefined
                ) {
                    return [];
                }

                return [
                    {
                        id: element.id,
                        name:
                            element.tags?.name ??
                            element.tags?.operator ??
                            'Titik daur ulang',
                        latitude: placeLatitude,
                        longitude: placeLongitude,
                        distance: calculateDistance(
                            latitude,
                            longitude,
                            placeLatitude,
                            placeLongitude,
                        ),
                    },
                ];
            })
            .sort((first, second) => first.distance - second.distance)
            .slice(0, 10);
        hasSearched.value = true;
    } catch {
        locationError.value =
            'Lokasi atau data tempat tidak dapat diakses. Izinkan akses lokasi dan periksa koneksi internet, lalu coba lagi.';
    } finally {
        isSearching.value = false;
    }
};

const selectImage = (file?: File): void => {
    errorMessage.value = '';

    if (!file) {
        return;
    }

    if (
        !['image/jpeg', 'image/png', 'image/webp', 'image/bmp'].includes(
            file.type,
        )
    ) {
        errorMessage.value = 'Format gambar harus JPG, PNG, WebP, atau BMP.';

        return;
    }

    if (file.size > 10 * 1024 * 1024) {
        errorMessage.value = 'Ukuran gambar maksimal 10 MB.';

        return;
    }

    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value);
    }

    selectedImage.value = file;
    previewUrl.value = URL.createObjectURL(file);
    scanRequestId += 1;
    isScanning.value = false;
    scanError.value = '';
    scanResult.value = null;
    nearbyPlaces.value = [];
    hasSearched.value = false;
    locationError.value = '';
};

const handleFileChange = (event: Event): void => {
    const input = event.target as HTMLInputElement;
    selectImage(input.files?.[0]);
    input.value = '';
};

const handleDrop = (event: DragEvent): void => {
    selectImage(event.dataTransfer?.files[0]);
};

const removeImage = (): void => {
    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value);
    }

    selectedImage.value = null;
    previewUrl.value = null;
    errorMessage.value = '';
    scanRequestId += 1;
    isScanning.value = false;
    scanError.value = '';
    scanResult.value = null;
    nearbyPlaces.value = [];
    hasSearched.value = false;
    locationError.value = '';
};

onBeforeUnmount(() => {
    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value);
    }
});

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Scan Sampah',
                href: dashboard(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Scan Sampah" />

    <main
        class="mx-auto flex w-full max-w-5xl flex-1 flex-col gap-8 p-6 md:p-10"
    >
        <header class="max-w-2xl space-y-3">
            <div
                class="flex items-center gap-2 text-sm font-medium text-emerald-700 dark:text-emerald-400"
            >
                <ScanLine class="size-4" />
                <span>Kenali dan pilah sampahmu</span>
            </div>
            <h1 class="text-3xl font-semibold tracking-tight md:text-4xl">
                Scan Sampah
            </h1>
            <p class="text-base text-muted-foreground">
                Unggah foto sampah yang ingin kamu pilah. Pastikan objek
                terlihat jelas dan pencahayaan cukup.
            </p>
        </header>

        <section class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_18rem]">
            <div class="space-y-3">
                <input
                    id="waste-image"
                    class="sr-only"
                    type="file"
                    accept="image/jpeg,image/png,image/webp,image/bmp"
                    @change="handleFileChange"
                />
                <label
                    for="waste-image"
                    class="group relative flex min-h-80 cursor-pointer flex-col items-center justify-center overflow-hidden border-2 border-dashed border-border bg-muted/30 text-center transition-colors hover:border-emerald-600/70 hover:bg-emerald-50/50 dark:hover:bg-emerald-950/20"
                    @dragover.prevent
                    @drop.prevent="handleDrop"
                >
                    <img
                        v-if="previewUrl"
                        :src="previewUrl"
                        :alt="selectedImage?.name ?? 'Pratinjau gambar sampah'"
                        class="absolute inset-0 size-full object-contain p-4"
                    />
                    <div
                        v-else
                        class="flex flex-col items-center gap-4 px-6 py-12"
                    >
                        <span
                            class="grid size-14 place-items-center rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300"
                        >
                            <ImagePlus class="size-7" />
                        </span>
                        <span class="space-y-1">
                            <span class="block font-medium"
                                >Pilih gambar sampah</span
                            >
                            <span class="block text-sm text-muted-foreground">
                                atau seret dan lepaskan gambar di sini
                            </span>
                        </span>
                        <span class="text-xs text-muted-foreground"
                            >JPG, PNG, WebP, BMP · Maks. 10 MB</span
                        >
                    </div>
                </label>

                <p
                    v-if="errorMessage"
                    class="text-sm text-destructive"
                    role="alert"
                >
                    {{ errorMessage }}
                </p>

                <div
                    v-if="selectedImage"
                    class="flex items-center justify-between gap-4"
                >
                    <p class="min-w-0 truncate text-sm text-muted-foreground">
                        {{ selectedImage.name }}
                    </p>
                    <button
                        type="button"
                        class="inline-flex shrink-0 items-center gap-2 text-sm font-medium text-destructive hover:underline"
                        aria-label="Hapus gambar"
                        @click="removeImage"
                    >
                        <Trash2 class="size-4" />
                        Hapus gambar
                    </button>
                </div>
            </div>

            <aside class="h-fit border-l-2 border-emerald-600 pl-5">
                <h2 class="font-semibold">Agar hasil foto lebih baik</h2>
                <ul
                    class="mt-4 space-y-3 text-sm leading-6 text-muted-foreground"
                >
                    <li>Foto satu jenis sampah dalam satu gambar.</li>
                    <li>Gunakan latar yang sederhana dan tidak ramai.</li>
                    <li>Hindari gambar yang gelap atau buram.</li>
                </ul>
            </aside>
        </section>

        <section
            v-if="selectedImage"
            class="space-y-4 border-t border-border pt-6"
            aria-label="Proses scan gambar"
        >
            <button
                type="button"
                class="inline-flex min-h-11 items-center justify-center gap-2 bg-emerald-700 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-800 disabled:cursor-not-allowed disabled:opacity-60"
                :disabled="isScanning"
                @click="scanImage"
            >
                <LoaderCircle v-if="isScanning" class="size-4 animate-spin" />
                <ScanLine v-else class="size-4" />
                {{ isScanning ? 'Memindai gambar...' : 'Scan gambar' }}
            </button>

            <p v-if="scanError" class="text-sm text-destructive" role="alert">
                {{ scanError }}
            </p>
        </section>

        <section
            v-if="scanResult"
            class="space-y-5 border-t border-border pt-6"
            aria-labelledby="scan-result-title"
            aria-live="polite"
        >
            <div>
                <p
                    class="text-sm font-medium text-emerald-700 dark:text-emerald-400"
                >
                    Hasil pemindaian
                </p>
                <h2 id="scan-result-title" class="mt-1 text-2xl font-semibold">
                    {{ formatMaterial(scanResult.prediction.class) }}
                </h2>
                <p class="mt-1 text-sm text-muted-foreground">
                    Keyakinan model
                    {{ formatConfidence(scanResult.prediction.confidence) }}
                </p>
            </div>

            <div
                v-if="scanResult.prediction.status === 'uncertain'"
                class="space-y-4 border-l-2 border-amber-500 pl-5"
            >
                <p class="text-sm leading-6 text-muted-foreground">
                    {{ scanResult.message }}
                </p>
                <div v-if="scanResult.candidates?.length">
                    <h3 class="text-sm font-semibold">Kemungkinan material</h3>
                    <ul class="mt-2 space-y-2">
                        <li
                            v-for="candidate in scanResult.candidates"
                            :key="candidate.class"
                            class="flex max-w-md items-center justify-between gap-4 text-sm"
                        >
                            <span>{{ formatMaterial(candidate.class) }}</span>
                            <span class="text-muted-foreground">
                                {{ formatConfidence(candidate.confidence) }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div
                v-else-if="scanResult.recommendation"
                class="max-w-3xl space-y-5"
            >
                <p class="leading-7">{{ scanResult.recommendation.summary }}</p>
                <div v-if="scanResult.recommendation.steps.length">
                    <h3 class="font-semibold">Langkah penanganan</h3>
                    <ol
                        class="mt-2 list-decimal space-y-2 pl-5 text-sm leading-6"
                    >
                        <li
                            v-for="(step, index) in scanResult.recommendation
                                .steps"
                            :key="`${index}-${step}`"
                        >
                            {{ step }}
                        </li>
                    </ol>
                </div>
                <div v-if="scanResult.recommendation.warnings.length">
                    <h3 class="font-semibold">Perhatian</h3>
                    <ul
                        class="mt-2 list-disc space-y-2 pl-5 text-sm leading-6 text-muted-foreground"
                    >
                        <li
                            v-for="(warning, index) in scanResult.recommendation
                                .warnings"
                            :key="`${index}-${warning}`"
                        >
                            {{ warning }}
                        </li>
                    </ul>
                </div>
            </div>
            <p v-else class="text-sm text-muted-foreground">
                {{ scanResult.message ?? 'Rekomendasi belum tersedia.' }}
            </p>
        </section>

        <section
            v-if="scanResult"
            class="space-y-5 border-t border-border pt-6"
            aria-labelledby="nearby-places-title"
        >
            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <div>
                    <h2 id="nearby-places-title" class="text-xl font-semibold">
                        Bank sampah terdekat
                    </h2>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Titik daur ulang berdasarkan lokasi GPS, dalam radius 10
                        km.
                    </p>
                </div>
                <button
                    type="button"
                    class="inline-flex min-h-11 items-center justify-center gap-2 bg-emerald-700 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-800 disabled:cursor-not-allowed disabled:opacity-60"
                    :disabled="isSearching"
                    @click="searchNearbyBanks"
                >
                    <LoaderCircle
                        v-if="isSearching"
                        class="size-4 animate-spin"
                    />
                    <MapPin v-else class="size-4" />
                    {{
                        isSearching
                            ? 'Mencari lokasi...'
                            : 'Cari bank sampah terdekat'
                    }}
                </button>
            </div>

            <p
                v-if="locationError"
                class="text-sm text-destructive"
                role="alert"
            >
                {{ locationError }}
            </p>

            <p
                v-else-if="hasSearched && nearbyPlaces.length === 0"
                class="border border-border p-5 text-sm text-muted-foreground"
            >
                Tidak ditemukan titik daur ulang dalam radius 10 km.
            </p>

            <ul v-else-if="nearbyPlaces.length" class="divide-y divide-border">
                <li
                    v-for="place in nearbyPlaces"
                    :key="place.id"
                    class="flex items-center justify-between gap-4 py-4"
                >
                    <div class="flex min-w-0 items-start gap-3">
                        <MapPin
                            class="mt-0.5 size-4 shrink-0 text-emerald-700"
                        />
                        <div class="min-w-0">
                            <p class="truncate font-medium">{{ place.name }}</p>
                            <p class="mt-1 text-sm text-muted-foreground">
                                {{ formatDistance(place.distance) }}
                            </p>
                        </div>
                    </div>
                    <a
                        :href="`https://www.openstreetmap.org/?mlat=${place.latitude}&mlon=${place.longitude}#map=18/${place.latitude}/${place.longitude}`"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex shrink-0 items-center gap-1 text-sm font-medium text-emerald-800 hover:underline dark:text-emerald-400"
                    >
                        Peta
                        <ExternalLink class="size-3.5" />
                    </a>
                </li>
            </ul>

            <p v-else class="text-sm text-muted-foreground">
                Pilih tombol di atas untuk menemukan titik daur ulang di
                sekitarmu.
            </p>

            <p class="text-xs text-muted-foreground">
                Data peta dari OpenStreetMap; cakupan bank sampah dapat berbeda
                di tiap wilayah.
            </p>
        </section>
    </main>
</template>
