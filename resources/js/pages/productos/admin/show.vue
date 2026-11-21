<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Pencil } from '@lucide/vue';
import { Button } from '@/components/ui/button';

type Opcion = {
    id: number;
    nombre: string;
};

type Producto = {
    id: number;
    nombre: string;
    descripcion: string | null;
    precio: number | string;
    oferta: number | string | null;
    stock: number;
    created_at: string | null;
    updated_at: string | null;
    imagen: string | null;
    categoria: Opcion | null;
    color: Opcion | null;
    talla: Opcion | null;
};

defineProps<{
    producto: Producto;
}>();
</script>

<template>
    <Head :title="producto.nombre" />

    <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-4">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <Button as-child variant="outline" size="icon" aria-label="Volver">
                    <Link href="/productos/admin">
                        <ArrowLeft class="size-4" />
                    </Link>
                </Button>
                <div>
                    <h1 class="text-2xl font-semibold">{{ producto.nombre }}</h1>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Detalles del producto
                    </p>
                </div>
            </div>

            <Button as-child>
                <Link :href="`/productos/admin/${producto.id}/editar`">
                    <Pencil class="size-4" />
                    Editar
                </Link>
            </Button>
        </div>

        <div class="grid gap-6 rounded-xl border border-sidebar-border/70 p-6 md:grid-cols-2">
            <div>
                <img
                    v-if="producto.imagen"
                    :src="`/imagenes/${producto.imagen}`"
                    :alt="`Imagen de ${producto.nombre}`"
                    class="w-full max-w-md rounded-lg object-cover"
                />
                <div
                    v-else
                    class="flex aspect-square w-full max-w-md items-center justify-center rounded-lg bg-muted text-sm text-muted-foreground"
                >
                    Sin imagen
                </div>
            </div>

            <dl class="grid content-start gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-sm text-muted-foreground">Categoría</dt>
                    <dd class="font-medium">
                        {{ producto.categoria?.nombre ?? 'Sin categoría' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm text-muted-foreground">Talla</dt>
                    <dd class="font-medium">
                        {{ producto.talla?.nombre ?? 'Sin talla' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm text-muted-foreground">Color</dt>
                    <dd class="font-medium">
                        {{ producto.color?.nombre ?? 'Sin color' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm text-muted-foreground">Precio</dt>
                    <dd class="font-medium">{{ producto.precio }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-muted-foreground">Precio de oferta</dt>
                    <dd class="font-medium">
                        {{ producto.oferta ?? 'Sin oferta' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm text-muted-foreground">Stock</dt>
                    <dd class="font-medium">{{ producto.stock }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-muted-foreground">Creado</dt>
                    <dd class="font-medium">
                        {{ producto.created_at ?? '—' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm text-muted-foreground">Actualizado</dt>
                    <dd class="font-medium">
                        {{ producto.updated_at ?? '—' }}
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm text-muted-foreground">Descripción</dt>
                    <dd class="whitespace-pre-wrap font-medium">
                        {{ producto.descripcion || 'Sin descripción' }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</template>
