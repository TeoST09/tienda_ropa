<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ArrowLeft, Minus, Plus, ShoppingBag } from '@lucide/vue';
import { Button } from '@/components/ui/button';

type ProductoCarrito = {
    id: number;
    nombre: string;
    precio: number | string;
    oferta: number | string | null;
    imagen: string | null;
    cantidad: number;
    stock: number;
};

defineProps<{
    productos: ProductoCarrito[];
}>();

const tieneOferta = (producto: ProductoCarrito) =>
    Number(producto.oferta ?? 0) > 0;

const aumentarCantidad = (productoId: number) => {
    router.post('/carrito/agregar', { producto_id: productoId });
};

const disminuirCantidad = (productoId: number) => {
    router.post('/carrito/disminuir', { producto_id: productoId });
};
</script>

<template>
    <Head title="Mi carrito" />

    <main class="mx-auto w-full max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <header
            class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Mi carrito</h1>
                <p class="mt-1 text-sm text-muted-foreground">
                    Revisa los productos que agregaste.
                </p>
            </div>

            <Button as-child variant="outline">
                <Link href="/productos">
                    <ArrowLeft class="size-4" />
                    Seguir comprando
                </Link>
            </Button>
        </header>

        <div v-if="productos.length > 0" class="space-y-4">
            <article
                v-for="producto in productos"
                :key="producto.id"
                class="flex flex-col gap-4 rounded-xl border border-sidebar-border/70 bg-card p-4 sm:flex-row sm:items-center"
            >
                <img
                    v-if="producto.imagen"
                    :src="`/imagenes/${producto.imagen}`"
                    :alt="producto.nombre"
                    class="size-24 rounded-lg object-cover"
                />
                <div
                    v-else
                    class="flex size-24 shrink-0 items-center justify-center rounded-lg bg-muted text-muted-foreground"
                >
                    <ShoppingBag class="size-8" aria-hidden="true" />
                </div>

                <div class="min-w-0 flex-1">
                    <h2 class="truncate text-lg font-semibold">
                        {{ producto.nombre }}
                    </h2>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Cantidad
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <Button
                        type="button"
                        variant="outline"
                        size="icon"
                        :aria-label="`Disminuir ${producto.nombre}`"
                        @click="disminuirCantidad(producto.id)"
                    >
                        <Minus class="size-4" />
                    </Button>
                    <span class="min-w-8 text-center font-medium">
                        {{ producto.cantidad }}
                    </span>
                    <Button
                        type="button"
                        variant="outline"
                        size="icon"
                        :disabled="producto.cantidad >= producto.stock"
                        :aria-label="`Aumentar ${producto.nombre}`"
                        @click="aumentarCantidad(producto.id)"
                    >
                        <Plus class="size-4" />
                    </Button>
                </div>

                <div class="flex items-center gap-2">
                    <template v-if="tieneOferta(producto)">
                        <span
                            class="text-sm text-muted-foreground line-through"
                        >
                            ${{ producto.precio }}
                        </span>
                        <span class="text-lg font-bold text-primary">
                            ${{ producto.oferta }}
                        </span>
                    </template>
                    <span v-else class="text-lg font-bold">
                        ${{ producto.precio }}
                    </span>
                </div>
            </article>
        </div>

        <section
            v-else
            class="rounded-2xl border border-dashed border-sidebar-border/70 px-6 py-16 text-center"
        >
            <ShoppingBag
                class="mx-auto size-12 text-muted-foreground"
                aria-hidden="true"
            />
            <h2 class="mt-4 text-lg font-semibold">Tu carrito está vacío</h2>
            <p class="mt-2 text-sm text-muted-foreground">
                Agrega productos para verlos aquí.
            </p>
            <Button as-child class="mt-6">
                <Link href="/productos">Ver productos</Link>
            </Button>
        </section>
    </main>
</template>
