<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Pencil } from '@lucide/vue';
import { Button } from '@/components/ui/button';

type Usuario = {
    id: number;
    name: string;
    email: string;
    rol: number;
    created_at: string | null;
    updated_at: string | null;
};

defineProps<{
    usuario: Usuario;
}>();
</script>

<template>
    <Head :title="`Usuario: ${usuario.name}`" />

    <div class="mx-auto flex h-full w-full max-w-3xl flex-1 flex-col gap-6 p-4">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <Button
                    as-child
                    variant="outline"
                    size="icon"
                    aria-label="Volver"
                >
                    <Link href="/usuarios">
                        <ArrowLeft class="size-4" />
                    </Link>
                </Button>
                <div>
                    <h1 class="text-2xl font-semibold">{{ usuario.name }}</h1>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Detalles del usuario
                    </p>
                </div>
            </div>

            <Button as-child>
                <Link :href="`/usuarios/${usuario.id}/editar`">
                    <Pencil class="size-4" />
                    Editar
                </Link>
            </Button>
        </div>

        <dl
            class="grid gap-6 rounded-xl border border-sidebar-border/70 p-6 sm:grid-cols-2"
        >
            <div>
                <dt class="text-sm text-muted-foreground">ID</dt>
                <dd class="font-medium">{{ usuario.id }}</dd>
            </div>
            <div>
                <dt class="text-sm text-muted-foreground">Nombre</dt>
                <dd class="font-medium">{{ usuario.name }}</dd>
            </div>
            <div>
                <dt class="text-sm text-muted-foreground">
                    Correo electrónico
                </dt>
                <dd class="font-medium">{{ usuario.email }}</dd>
            </div>
            <div>
                <dt class="text-sm text-muted-foreground">Rol</dt>
                <dd class="font-medium">
                    {{ usuario.rol === 2 ? 'Administrador' : 'Cliente' }}
                </dd>
            </div>
            <div>
                <dt class="text-sm text-muted-foreground">Creado</dt>
                <dd class="font-medium">{{ usuario.created_at ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-muted-foreground">Actualizado</dt>
                <dd class="font-medium">{{ usuario.updated_at ?? '—' }}</dd>
            </div>
        </dl>
    </div>
</template>
