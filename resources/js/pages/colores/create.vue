<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const form = useForm({
    nombre: '',
});

const submit = () => {
    form.post('/colores');
};
</script>

<template>
    <Head title="Crear color" />

    <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-4">
        <div class="flex items-center gap-3">
            <Button as-child variant="outline" size="icon" aria-label="Volver">
                <Link href="/colores">
                    <ArrowLeft class="size-4" />
                </Link>
            </Button>
            <div>
                <h1 class="text-2xl font-semibold">Crear color</h1>
                <p class="mt-1 text-sm text-muted-foreground">
                    Agrega un nuevo color al catálogo
                </p>
            </div>
        </div>

        <form
            class="max-w-xl space-y-6 rounded-xl border border-sidebar-border/70 p-6"
            @submit.prevent="submit"
        >
            <div class="space-y-2">
                <Label for="nombre">Nombre</Label>
                <Input
                    id="nombre"
                    v-model="form.nombre"
                    name="nombre"
                    placeholder="Ejemplo: Verde"
                    autocomplete="off"
                />
                <InputError :message="form.errors.nombre" />
            </div>

            <div class="flex items-center gap-3">
                <Button type="submit" :disabled="form.processing">
                    Crear color
                </Button>
                <Button as-child variant="outline">
                    <Link href="/colores">Cancelar</Link>
                </Button>
            </div>
        </form>
    </div>
</template>
