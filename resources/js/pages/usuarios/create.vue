<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import { Label } from '@/components/ui/label';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    rol: 1,
});

const submit = () => {
    form.post('/usuarios');
};
</script>

<template>
    <Head title="Crear usuario" />

    <div class="mx-auto flex h-full w-full max-w-xl flex-1 flex-col gap-6 p-4">
        <div class="flex items-center gap-3">
            <Button as-child variant="outline" size="icon" aria-label="Volver">
                <Link href="/usuarios">
                    <ArrowLeft class="size-4" />
                </Link>
            </Button>
            <div>
                <h1 class="text-2xl font-semibold">Crear usuario</h1>
                <p class="mt-1 text-sm text-muted-foreground">
                    Agrega un nuevo usuario
                </p>
            </div>
        </div>

        <form
            class="space-y-6 rounded-xl border border-sidebar-border/70 p-6"
            @submit.prevent="submit"
        >
            <div class="space-y-2">
                <Label for="name">Nombre</Label>
                <Input
                    id="name"
                    v-model="form.name"
                    name="name"
                    autocomplete="name"
                />
                <InputError :message="form.errors.name" />
            </div>

            <div class="space-y-2">
                <Label for="email">Correo electrónico</Label>
                <Input
                    id="email"
                    v-model="form.email"
                    type="email"
                    name="email"
                    autocomplete="email"
                />
                <InputError :message="form.errors.email" />
            </div>

            <div class="space-y-2">
                <Label for="rol">Rol</Label>
                <select
                    id="rol"
                    v-model.number="form.rol"
                    name="rol"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none"
                >
                    <option :value="1">Cliente</option>
                    <option :value="2">Administrador</option>
                </select>
                <InputError :message="form.errors.rol" />
            </div>

            <div class="space-y-2">
                <Label for="password">Contraseña</Label>
                <Input
                    id="password"
                    v-model="form.password"
                    type="password"
                    name="password"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password" />
            </div>

            <div class="space-y-2">
                <Label for="password_confirmation">Confirmar contraseña</Label>
                <Input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    name="password_confirmation"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center gap-3">
                <Button type="submit" :disabled="form.processing">
                    Crear usuario
                </Button>
                <Button as-child variant="outline">
                    <Link href="/usuarios">Cancelar</Link>
                </Button>
            </div>
        </form>
    </div>
</template>
