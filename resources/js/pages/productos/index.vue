<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Shirt, ShoppingCart } from '@lucide/vue';
import { Button } from '@/components/ui/button';

type Producto = {
    id: number;
    nombre: string;
    descripcion: string | null;
    precio: number | string;
    oferta: number | string | null;
    stock: number | null;
    imagen: string | null;
    categoria?: {
        nombre: string;
    } | null;
};

defineProps<{
    productos: Producto[];
}>();

const page = usePage();

const agregarAlCarrito = (producto: Producto) => {
    if (producto.stock !== null && producto.stock > 0) {
        router.post('/carrito/agregar', { producto_id: producto.id });
    }
};

const tieneOferta = (producto: Producto) => Number(producto.oferta ?? 0) > 0;
</script>

<template>
    <Head title="Productos" />

    <main class="mx-auto w-full max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-start">
            <Button
                as-child
                variant="outline"
                size="icon"
                :aria-label="`Ver carrito: ${page.props.carritoCount} artículos`"
            >
                <Link href="/carrito" class="relative">
                    <ShoppingCart class="size-4" />
                    <span
                        v-if="page.props.carritoCount > 0"
                        class="absolute -top-2 -right-2 flex min-w-5 items-center justify-center rounded-full bg-destructive px-1 text-xs font-bold text-white"
                    >
                        {{ page.props.carritoCount }}
                    </span>
                </Link>
            </Button>
        </div>

        <header class="mb-8 text-center sm:mb-12">
            <p
                class="text-sm font-semibold tracking-[0.2em] text-primary uppercase"
            >
                Tienda de ropa
            </p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">
                Nuestra colección
            </h1>
            <p class="mx-auto mt-3 max-w-2xl text-muted-foreground">
                Explora nuestros productos y encuentra tu próximo favorito.
            </p>
        </header>

        <div
            v-if="productos.length > 0"
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
        >
            <article
                v-for="producto in productos"
                :key="producto.id"
                class="group overflow-hidden rounded-2xl border border-sidebar-border/70 bg-card shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
            >
                <Link
                    :href="`/productos/showUser/${producto.id}`"
                    :aria-label="`Ver detalles de ${producto.nombre}`"
                    class="block focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
                >
                    <div class="relative aspect-[4/5] overflow-hidden bg-muted">
                        <img
                            v-if="producto.imagen"
                            :src="`/imagenes/${producto.imagen}`"
                            :alt="producto.nombre"
                            class="size-full object-cover transition duration-300 group-hover:scale-105"
                        />
                        <div
                            v-else
                            class="flex size-full items-center justify-center text-muted-foreground"
                        >
                            <Shirt
                                class="size-16 opacity-40"
                                aria-hidden="true"
                            />
                        </div>

                        <span
                            v-if="tieneOferta(producto)"
                            class="absolute top-3 left-3 rounded-full bg-primary px-3 py-1 text-xs font-semibold text-primary-foreground"
                        >
                            Oferta
                        </span>
                    </div>

                    <div class="space-y-3 p-4">
                        <p
                            v-if="producto.categoria"
                            class="text-xs font-medium tracking-wide text-muted-foreground uppercase"
                        >
                            {{ producto.categoria.nombre }}
                        </p>
                        <h2 class="text-lg font-semibold">
                            {{ producto.nombre }}
                        </h2>
                        <p
                            v-if="producto.descripcion"
                            class="line-clamp-2 min-h-10 text-sm text-muted-foreground"
                        >
                            {{ producto.descripcion }}
                        </p>

                        <div class="flex items-center gap-2 pt-1">
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
                    </div>
                </Link>

                <div class="px-4 pb-4">
                    <Button
                        v-if="producto.stock !== null && producto.stock > 0"
                        type="button"
                        class="w-full"
                        @click="agregarAlCarrito(producto)"
                    >
                        <ShoppingCart class="size-4" aria-hidden="true" />
                        Agregar al carrito
                    </Button>
                    <p v-else class="text-sm font-medium text-destructive">
                        No disponible
                    </p>
                </div>
            </article>
        </div>

        <div
            v-else
            class="rounded-2xl border border-dashed border-sidebar-border/70 px-6 py-16 text-center"
        >
            <Shirt
                class="mx-auto size-12 text-muted-foreground"
                aria-hidden="true"
            />
            <h2 class="mt-4 text-lg font-semibold">Aún no hay productos</h2>
            <p class="mt-2 text-sm text-muted-foreground">
                Vuelve pronto para descubrir nuestra colección.
            </p>
        </div>
    </main>
</template>
