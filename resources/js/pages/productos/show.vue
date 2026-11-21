<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Shirt, ShoppingCart } from '@lucide/vue';
import { Button } from '@/components/ui/button';

type Opcion = {
    nombre: string;
};

type Producto = {
    id: number;
    nombre: string;
    descripcion: string | null;
    precio: number | string;
    oferta: number | string | null;
    stock: number | null;
    imagen: string | null;
    categoria: Opcion | null;
    color: Opcion | null;
    talla: Opcion | null;
};

defineProps<{
    producto: Producto;
}>();

const tieneOferta = (producto: Producto) => Number(producto.oferta ?? 0) > 0;
</script>

<template>
    <Head :title="producto.nombre" />

    <main class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <Button as-child variant="ghost" class="mb-6">
            <Link href="/productos">
                <ArrowLeft class="size-4" />
                Volver a productos
            </Link>
        </Button>

        <article
            class="grid overflow-hidden rounded-2xl border border-sidebar-border/70 bg-card shadow-sm md:grid-cols-2"
        >
            <div class="relative min-h-80 bg-muted md:min-h-[36rem]">
                <img
                    v-if="producto.imagen"
                    :src="`/imagenes/${producto.imagen}`"
                    :alt="producto.nombre"
                    class="absolute inset-0 size-full object-cover"
                />
                <div
                    v-else
                    class="flex size-full min-h-80 items-center justify-center text-muted-foreground md:min-h-[36rem]"
                >
                    <Shirt class="size-20 opacity-40" aria-hidden="true" />
                </div>
                <span
                    v-if="tieneOferta(producto)"
                    class="absolute top-4 left-4 rounded-full bg-primary px-3 py-1 text-sm font-semibold text-primary-foreground"
                >
                    Oferta
                </span>
            </div>

            <div class="flex flex-col gap-6 p-6 sm:p-8 lg:p-10">
                <div>
                    <p
                        v-if="producto.categoria"
                        class="text-sm font-medium tracking-wide text-muted-foreground uppercase"
                    >
                        {{ producto.categoria.nombre }}
                    </p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight">
                        {{ producto.nombre }}
                    </h1>
                </div>

                <div class="flex items-center gap-3">
                    <template v-if="tieneOferta(producto)">
                        <span
                            class="text-lg text-muted-foreground line-through"
                        >
                            ${{ producto.precio }}
                        </span>
                        <span class="text-2xl font-bold text-primary">
                            ${{ producto.oferta }}
                        </span>
                    </template>
                    <span v-else class="text-2xl font-bold">
                        ${{ producto.precio }}
                    </span>
                </div>

                <p class="whitespace-pre-line text-muted-foreground">
                    {{ producto.descripcion || 'Sin descripción disponible.' }}
                </p>

                <dl class="grid grid-cols-2 gap-4 rounded-xl bg-muted/50 p-4">
                    <div>
                        <dt class="text-sm text-muted-foreground">Talla</dt>
                        <dd class="font-medium">
                            {{ producto.talla?.nombre ?? 'No especificada' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-muted-foreground">Color</dt>
                        <dd class="font-medium">
                            {{ producto.color?.nombre ?? 'No especificado' }}
                        </dd>
                    </div>
                </dl>

                <div class="mt-auto">
                    <Button
                        v-if="producto.stock !== null && producto.stock > 0"
                        type="button"
                        class="w-full"
                    >
                        <ShoppingCart class="size-4" aria-hidden="true" />
                        Agregar al carrito
                    </Button>
                    <p
                        v-else
                        class="text-center text-sm font-medium text-destructive"
                    >
                        No disponible
                    </p>
                </div>
            </div>
        </article>
    </main>
</template>
