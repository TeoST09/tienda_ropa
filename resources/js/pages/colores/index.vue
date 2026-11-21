<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { Pencil, Search, Trash2 } from '@lucide/vue';
import { toast } from 'vue-sonner';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import type { FlashToast } from '@/types/ui';

type Color = {
    id: number;
    nombre: string;
};

defineProps<{
    colores: Color[];
    search: string;
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

const eliminarColor = (color: Color) => {
    if (confirm(`¿Eliminar el color ${color.nombre}?`)) {
        router.delete(`/colores/${color.id}`);
    } else {
        toast.info('No se eliminó el color.');
    }
};
</script>

<template>
    <Head title="Colores" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Colores</h1>
                <p class="mt-1 text-sm text-muted-foreground">
                    Gestiona los colores disponibles
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <form
                    method="get"
                    action="/colores"
                    class="flex flex-1 gap-2 sm:flex-initial"
                >
                    <div class="relative w-full sm:w-64">
                        <Search
                            class="absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
                            aria-hidden="true"
                        />
                        <Input
                            type="search"
                            name="search"
                            :default-value="search"
                            placeholder="Buscar colores..."
                            aria-label="Buscar colores"
                            class="pl-9"
                        />
                    </div>

                    <Button type="submit" variant="outline">Buscar</Button>
                </form>

                <Button as-child>
                    <Link href="/colores/crear">Crear color</Link>
                </Button>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-sidebar-border/70">
            <table class="w-full text-left">
                <thead class="border-b border-sidebar-border/70 bg-muted/40">
                    <tr>
                        <th class="px-4 py-3 text-sm font-medium">ID</th>
                        <th class="px-4 py-3 text-sm font-medium">Nombre</th>
                        <th class="w-24 px-4 py-3 text-right text-sm font-medium">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="color in colores"
                        :key="color.id"
                        class="border-b border-sidebar-border/70 last:border-b-0"
                    >
                        <td class="px-4 py-3 text-sm">{{ color.id }}</td>
                        <td class="px-4 py-3 text-sm font-medium">
                            {{ color.nombre }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <Button
                                    as-child
                                    variant="outline"
                                    size="icon"
                                    :aria-label="`Editar color ${color.nombre}`"
                                >
                                    <Link :href="`/colores/${color.id}/editar`">
                                        <Pencil class="size-4" />
                                    </Link>
                                </Button>
                                <Button
                                    type="button"
                                    variant="destructive"
                                    size="icon"
                                    :aria-label="`Eliminar color ${color.nombre}`"
                                    @click="eliminarColor(color)"
                                >
                                    <Trash2 class="size-4" />
                                </Button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="colores.length === 0">
                        <td
                            colspan="3"
                            class="px-4 py-8 text-center text-sm text-muted-foreground"
                        >
                            No hay colores registrados.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
