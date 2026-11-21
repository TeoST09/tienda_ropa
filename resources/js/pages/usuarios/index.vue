<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Eye, Pencil, Search, Trash2 } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

type Usuario = {
    id: number;
    name: string;
    email: string;
    rol: number;
};

defineProps<{
    usuarios: Usuario[];
    search: string;
}>();

const eliminarUsuario = (usuario: Usuario) => {
    if (confirm(`¿Eliminar al usuario ${usuario.name}?`)) {
        router.delete(`/usuarios/${usuario.id}`);
    }
};
</script>

<template>
    <Head title="Usuarios" />

    <div class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 p-4">
        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="text-2xl font-semibold">Usuarios</h1>
                <p class="mt-1 text-sm text-muted-foreground">
                    Gestiona los usuarios registrados
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <form method="get" action="/usuarios" class="flex gap-2">
                    <div class="relative w-full sm:w-64">
                        <Search
                            class="absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted-foreground"
                            aria-hidden="true"
                        />
                        <Input
                            type="search"
                            name="search"
                            :default-value="search"
                            placeholder="Buscar por nombre o correo..."
                            aria-label="Buscar usuarios por nombre o correo"
                            class="pl-9"
                        />
                    </div>
                    <Button type="submit" variant="outline">Buscar</Button>
                </form>

                <Button as-child>
                    <Link href="/usuarios/crear">Crear usuario</Link>
                </Button>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-sidebar-border/70">
            <table class="w-full text-left">
                <thead class="border-b border-sidebar-border/70 bg-muted/40">
                    <tr>
                        <th class="px-4 py-3 text-sm font-medium">ID</th>
                        <th class="px-4 py-3 text-sm font-medium">Nombre</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Correo electrónico
                        </th>
                        <th class="px-4 py-3 text-sm font-medium">Rol</th>
                        <th
                            class="w-32 px-4 py-3 text-right text-sm font-medium"
                        >
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="usuario in usuarios"
                        :key="usuario.id"
                        class="border-b border-sidebar-border/70 last:border-b-0"
                    >
                        <td class="px-4 py-3 text-sm">{{ usuario.id }}</td>
                        <td class="px-4 py-3 text-sm font-medium">
                            {{ usuario.name }}
                        </td>
                        <td class="px-4 py-3 text-sm">{{ usuario.email }}</td>
                        <td class="px-4 py-3 text-sm">
                            {{
                                usuario.rol === 2 ? 'Administrador' : 'Cliente'
                            }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <Button
                                    as-child
                                    variant="outline"
                                    size="icon"
                                    :aria-label="`Ver usuario ${usuario.name}`"
                                >
                                    <Link :href="`/usuarios/${usuario.id}`">
                                        <Eye class="size-4" />
                                    </Link>
                                </Button>
                                <Button
                                    as-child
                                    variant="outline"
                                    size="icon"
                                    :aria-label="`Editar usuario ${usuario.name}`"
                                >
                                    <Link
                                        :href="`/usuarios/${usuario.id}/editar`"
                                    >
                                        <Pencil class="size-4" />
                                    </Link>
                                </Button>
                                <Button
                                    type="button"
                                    variant="destructive"
                                    size="icon"
                                    :aria-label="`Eliminar usuario ${usuario.name}`"
                                    @click="eliminarUsuario(usuario)"
                                >
                                    <Trash2 class="size-4" />
                                </Button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="usuarios.length === 0">
                        <td
                            colspan="5"
                            class="px-4 py-8 text-center text-sm text-muted-foreground"
                        >
                            No se encontraron usuarios.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
