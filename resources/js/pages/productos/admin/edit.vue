<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

type Opcion = {
    id: number;
    nombre: string;
};

type Producto = {
    id: number;
    categoria_id: number;
    talla_id: number;
    color_id: number;
    nombre: string;
    descripcion: string | null;
    precio: number | string;
    oferta: number | string | null;
    stock: number;
    imagen: string | null;
};

const props = defineProps<{
    producto: Producto;
    categorias: Opcion[];
    tallas: Opcion[];
    colores: Opcion[];
}>();

const form = useForm({
    categoria_id: props.producto.categoria_id,
    talla_id: props.producto.talla_id,
    color_id: props.producto.color_id,
    nombre: props.producto.nombre,
    descripcion: props.producto.descripcion ?? '',
    precio: String(props.producto.precio),
    oferta: String(props.producto.oferta ?? ''),
    stock: props.producto.stock,
    imagen: null as File | null,
});

const seleccionarImagen = (event: Event) => {
    form.imagen =
        (event.target as HTMLInputElement).files?.[0] ?? null;
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        _method: 'put',
    })).post(`/productos/admin/${props.producto.id}`);
};
</script>

<template>
    <Head title="Editar producto" />

    <div class="flex h-full flex-1 flex-col items-center gap-6 rounded-xl p-4">
        <div class="flex w-full max-w-3xl items-center gap-3">
            <Button as-child variant="outline" size="icon" aria-label="Volver">
                <Link href="/productos/admin">
                    <ArrowLeft class="size-4" />
                </Link>
            </Button>
            <div>
                <h1 class="text-2xl font-semibold">Editar producto</h1>
                <p class="mt-1 text-sm text-muted-foreground">
                    Modifica la información del producto
                </p>
            </div>
        </div>

        <form
            class="w-full max-w-3xl space-y-6 rounded-xl border border-sidebar-border/70 p-6"
            @submit.prevent="submit"
        >
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-2">
                    <Label for="nombre">Nombre</Label>
                    <Input
                        id="nombre"
                        v-model="form.nombre"
                        name="nombre"
                        autocomplete="off"
                    />
                    <InputError :message="form.errors.nombre" />
                </div>

                <div class="space-y-2">
                    <Label for="categoria_id">Categoría</Label>
                    <select
                        id="categoria_id"
                        v-model="form.categoria_id"
                        name="categoria_id"
                        class="border-input bg-background text-foreground dark:bg-input/30 focus-visible:border-ring focus-visible:ring-ring/50 [color-scheme:light] dark:[color-scheme:dark] h-9 w-full rounded-md border px-3 py-1 text-sm shadow-xs outline-none focus-visible:ring-[3px]"
                    >
                        <option
                            v-for="categoria in categorias"
                            :key="categoria.id"
                            :value="categoria.id"
                            class="bg-popover text-popover-foreground"
                        >
                            {{ categoria.nombre }}
                        </option>
                    </select>
                    <InputError :message="form.errors.categoria_id" />
                </div>

                <div class="space-y-2">
                    <Label for="talla_id">Talla</Label>
                    <select
                        id="talla_id"
                        v-model="form.talla_id"
                        name="talla_id"
                        class="border-input bg-background text-foreground dark:bg-input/30 focus-visible:border-ring focus-visible:ring-ring/50 [color-scheme:light] dark:[color-scheme:dark] h-9 w-full rounded-md border px-3 py-1 text-sm shadow-xs outline-none focus-visible:ring-[3px]"
                    >
                        <option
                            v-for="talla in tallas"
                            :key="talla.id"
                            :value="talla.id"
                            class="bg-popover text-popover-foreground"
                        >
                            {{ talla.nombre }}
                        </option>
                    </select>
                    <InputError :message="form.errors.talla_id" />
                </div>

                <div class="space-y-2">
                    <Label for="color_id">Color</Label>
                    <select
                        id="color_id"
                        v-model="form.color_id"
                        name="color_id"
                        class="border-input bg-background text-foreground dark:bg-input/30 focus-visible:border-ring focus-visible:ring-ring/50 [color-scheme:light] dark:[color-scheme:dark] h-9 w-full rounded-md border px-3 py-1 text-sm shadow-xs outline-none focus-visible:ring-[3px]"
                    >
                        <option
                            v-for="color in colores"
                            :key="color.id"
                            :value="color.id"
                            class="bg-popover text-popover-foreground"
                        >
                            {{ color.nombre }}
                        </option>
                    </select>
                    <InputError :message="form.errors.color_id" />
                </div>

                <div class="space-y-2">
                    <Label for="precio">Precio</Label>
                    <Input
                        id="precio"
                        v-model="form.precio"
                        name="precio"
                        type="number"
                        min="0"
                        step="0.01"
                    />
                    <InputError :message="form.errors.precio" />
                </div>

                <div class="space-y-2">
                    <Label for="oferta">Precio de oferta</Label>
                    <Input
                        id="oferta"
                        v-model="form.oferta"
                        name="oferta"
                        type="number"
                        min="0"
                        step="0.01"
                    />
                    <InputError :message="form.errors.oferta" />
                </div>

                <div class="space-y-2">
                    <Label for="stock">Stock</Label>
                    <Input
                        id="stock"
                        v-model.number="form.stock"
                        name="stock"
                        type="number"
                        min="0"
                        step="1"
                    />
                    <InputError :message="form.errors.stock" />
                </div>

                <div class="space-y-2 sm:col-span-2">
                    <Label for="descripcion">Descripción</Label>
                    <textarea
                        id="descripcion"
                        v-model="form.descripcion"
                        name="descripcion"
                        rows="4"
                        class="border-input bg-background dark:bg-input/30 focus-visible:border-ring focus-visible:ring-ring/50 w-full rounded-md border px-3 py-2 text-sm shadow-xs outline-none focus-visible:ring-[3px]"
                    />
                    <InputError :message="form.errors.descripcion" />
                </div>

                <div class="space-y-2 sm:col-span-2">
                    <Label for="imagen">Imagen del producto</Label>
                    <div v-if="producto.imagen" class="mb-3">
                        <img
                            :src="`/imagenes/${producto.imagen}`"
                            :alt="`Imagen de ${producto.nombre}`"
                            class="size-32 rounded-md object-cover"
                        />
                    </div>
                    <Input
                        id="imagen"
                        name="imagen"
                        type="file"
                        accept="image/*"
                        @change="seleccionarImagen"
                    />
                    <p v-if="form.imagen" class="text-sm text-muted-foreground">
                        {{ form.imagen.name }}
                    </p>
                    <InputError :message="form.errors.imagen" />
                    <progress
                        v-if="form.progress"
                        :value="form.progress.percentage"
                        max="100"
                        class="w-full"
                    >
                        {{ form.progress.percentage }}%
                    </progress>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <Button type="submit" :disabled="form.processing">
                    Guardar cambios
                </Button>
                <Button as-child variant="outline">
                    <Link href="/productos/admin">Cancelar</Link>
                </Button>
            </div>
        </form>
    </div>
</template>
