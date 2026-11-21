<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { Eye, Pencil, Search, Trash2 } from '@lucide/vue';
import { toast } from 'vue-sonner';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import type { FlashToast } from '@/types/ui';

type Opcion = {
    id: number;
    nombre: string;
};

type Producto = {
    id: number;
    nombre: string;
    precio: number | string;
    stock: number;
    imagen: string | null;
    color: Opcion | null;
    talla: Opcion | null;
};

defineProps<{
    productos: Producto[];
    search: string;
    stock: string | number;
    talla_id: string | number;
    color_id: string | number;
    tallas: Opcion[];
    colores: Opcion[];
}>();

const page = usePage<{
    flash: {
        alert?: FlashToast;
    };
}>();

watch(
    () => page.flash.alert as FlashToast | undefined,
    (alert) => {
        if (alert) {
            if (alert.type === 'success') {
                toast.success(alert.message);
            } else if (alert.type === 'error') {
                toast.error(alert.message);
            } else if (alert.type === 'warning') {
                toast.warning(alert.message);
            } else {
                toast.info(alert.message);
            }
        }
    },
    { immediate: true },
);

const eliminarProducto = (producto: Producto) => {
    if (confirm(`¿Eliminar el producto ${producto.nombre}?`)) {
        router.delete(`/productos/admin/${producto.id}`);
    } else {
        toast.info('No se eliminó el producto.');
    }
};
</script>

<template>
    <Head title="Productos" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold">Productos</h1>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Gestiona los productos de la tienda
                    </p>
                </div>

                <Button as-child>
                    <Link href="/productos/admin/crear">Crear producto</Link>
                </Button>
            </div>

            <form
                method="get"
                action="/productos/admin"
                class="grid w-full gap-3 sm:grid-cols-2 lg:grid-cols-6"
            >
                <div class="relative sm:col-span-2">
                    <Search
                        class="absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
                        aria-hidden="true"
                    />
                    <Input
                        type="search"
                        name="search"
                        :default-value="search"
                        placeholder="Buscar por nombre..."
                        aria-label="Buscar por nombre"
                        class="pl-9"
                    />
                </div>

                <Input
                    type="number"
                    name="stock"
                    :default-value="stock"
                    placeholder="Stock exacto"
                    aria-label="Filtrar por cantidad exacta de stock"
                    min="0"
                    step="1"
                />

                <select
                    name="talla_id"
                    :value="talla_id"
                    aria-label="Filtrar por talla"
                    class="border-input bg-background text-foreground dark:bg-input/30 focus-visible:border-ring focus-visible:ring-ring/50 [color-scheme:light] dark:[color-scheme:dark] h-9 w-full rounded-md border px-3 py-1 text-sm shadow-xs outline-none focus-visible:ring-[3px]"
                >
                    <option value="" class="bg-popover text-popover-foreground">
                        Todas las tallas
                    </option>
                    <option
                        v-for="talla in tallas"
                        :key="talla.id"
                        :value="talla.id"
                        class="bg-popover text-popover-foreground"
                    >
                        {{ talla.nombre }}
                    </option>
                </select>

                <select
                    name="color_id"
                    :value="color_id"
                    aria-label="Filtrar por color"
                    class="border-input bg-background text-foreground dark:bg-input/30 focus-visible:border-ring focus-visible:ring-ring/50 [color-scheme:light] dark:[color-scheme:dark] h-9 w-full rounded-md border px-3 py-1 text-sm shadow-xs outline-none focus-visible:ring-[3px]"
                >
                    <option value="" class="bg-popover text-popover-foreground">
                        Todos los colores
                    </option>
                    <option
                        v-for="color in colores"
                        :key="color.id"
                        :value="color.id"
                        class="bg-popover text-popover-foreground"
                    >
                        {{ color.nombre }}
                    </option>
                </select>

                <div class="flex gap-2">
                    <Button type="submit" variant="outline">Filtrar</Button>
                    <Button as-child variant="ghost">
                        <Link href="/productos/admin">Limpiar</Link>
                    </Button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto rounded-xl border border-sidebar-border/70">
            <table class="w-full text-left">
                <thead class="border-b border-sidebar-border/70 bg-muted/40">
                    <tr>
                        <th class="px-4 py-3 text-sm font-medium">Imagen</th>
                        <th class="px-4 py-3 text-sm font-medium">Nombre</th>
                        <th class="px-4 py-3 text-sm font-medium">Color</th>
                        <th class="px-4 py-3 text-sm font-medium">Talla</th>
                        <th class="px-4 py-3 text-sm font-medium">Precio</th>
                        <th class="px-4 py-3 text-sm font-medium">Stock</th>
                        <th class="w-24 px-4 py-3 text-right text-sm font-medium">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="producto in productos"
                        :key="producto.id"
                        class="border-b border-sidebar-border/70 last:border-b-0"
                    >
                        <td class="px-4 py-3">
                            <img
                                v-if="producto.imagen"
                                :src="`/imagenes/${producto.imagen}`"
                                :alt="`Imagen de ${producto.nombre}`"
                                class="size-12 rounded-md object-cover"
                            />
                            <span
                                v-else
                                class="flex size-12 items-center justify-center rounded-md bg-muted text-xs text-muted-foreground"
                            >
                                Sin imagen
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm font-medium">
                            {{ producto.nombre }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ producto.color?.nombre ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ producto.talla?.nombre ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ producto.precio }}
                        </td>
                        <td class="px-4 py-3 text-sm">{{ producto.stock }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <Button
                                    as-child
                                    variant="outline"
                                    size="icon"
                                    :aria-label="`Ver producto ${producto.nombre}`"
                                >
                                    <Link :href="`/productos/admin/${producto.id}`">
                                        <Eye class="size-4" />
                                    </Link>
                                </Button>
                                <Button
                                    as-child
                                    variant="outline"
                                    size="icon"
                                    :aria-label="`Editar producto ${producto.nombre}`"
                                >
                                    <Link
                                        :href="`/productos/admin/${producto.id}/editar`"
                                    >
                                        <Pencil class="size-4" />
                                    </Link>
                                </Button>
                                <Button
                                    type="button"
                                    variant="destructive"
                                    size="icon"
                                    :aria-label="`Eliminar producto ${producto.nombre}`"
                                    @click="eliminarProducto(producto)"
                                >
                                    <Trash2 class="size-4" />
                                </Button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="productos.length === 0">
                        <td
                            colspan="7"
                            class="px-4 py-8 text-center text-sm text-muted-foreground"
                        >
                            No hay productos registrados.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
