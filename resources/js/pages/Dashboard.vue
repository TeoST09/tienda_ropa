<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowUpRight,
    Package,
    Palette,
    Plus,
    Ruler,
    ShoppingCart,
    Tags,
} from '@lucide/vue';
import { dashboard } from '@/routes';

type DashboardStats = {
    products: number;
    sizes: number;
    colors: number;
    categories: number;
};

const props = defineProps<{
    isAdmin: boolean;
    stats: DashboardStats | null;
}>();

const quickLinks = [
    { title: 'Agregar producto', href: '/productos/admin/crear' },
    { title: 'Crear talla', href: '/tallas/crear' },
    { title: 'Crear color', href: '/colores/crear' },
    { title: 'Crear categoría', href: '/categorias/crear' },
];

const demoOrders = [
    { id: 'DEMO-001', customer: 'Cliente de prueba 1', status: 'Pendiente' },
    { id: 'DEMO-002', customer: 'Cliente de prueba 2', status: 'En preparación' },
    { id: 'DEMO-003', customer: 'Cliente de prueba 3', status: 'Enviado' },
];

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});
</script>

<template>
    <Head :title="props.isAdmin ? 'Panel de administración' : 'Dashboard'" />

    <main class="flex flex-1 flex-col gap-6 p-4">
        <header
            class="flex flex-col gap-4 rounded-xl border border-border bg-card p-6 text-card-foreground sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <p class="text-sm font-medium text-muted-foreground">
                    Hola, {{ $page.props.auth.user.name }}
                </p>
                <h1 class="mt-1 text-2xl font-semibold tracking-tight">
                    {{ props.isAdmin ? 'Panel de administración' : 'Mi panel' }}
                </h1>
                <p class="mt-2 text-sm text-muted-foreground">
                    {{
                        props.isAdmin
                            ? 'Un resumen rápido de tu tienda y su catálogo.'
                            : 'Bienvenido a tu espacio de la tienda.'
                    }}
                </p>
            </div>
            <span
                v-if="props.isAdmin"
                class="inline-flex w-fit items-center rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary"
            >
                Administrador
            </span>
        </header>

        <template v-if="props.isAdmin">
            <section
                v-if="props.stats"
                aria-label="Resumen del catálogo"
                class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4"
            >
                <Link
                    href="/productos/admin"
                    class="group rounded-xl border border-border bg-card p-5 text-card-foreground transition-colors hover:bg-accent/50"
                >
                    <div class="flex items-start justify-between">
                        <div
                            class="flex size-11 items-center justify-center rounded-lg bg-sky-500/10 text-sky-600 dark:text-sky-400"
                        >
                            <Package class="size-5" />
                        </div>
                        <ArrowUpRight
                            class="size-4 text-muted-foreground transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5"
                        />
                    </div>
                    <p class="mt-5 text-sm font-medium text-muted-foreground">
                        Productos
                    </p>
                    <div class="mt-1 flex items-baseline gap-2">
                        <span class="text-3xl font-semibold tracking-tight">
                            {{ props.stats.products }}
                        </span>
                        <span class="text-sm text-muted-foreground">
                            En el catálogo
                        </span>
                    </div>
                </Link>

                <Link
                    href="/tallas"
                    class="group rounded-xl border border-border bg-card p-5 text-card-foreground transition-colors hover:bg-accent/50"
                >
                    <div class="flex items-start justify-between">
                        <div
                            class="flex size-11 items-center justify-center rounded-lg bg-violet-500/10 text-violet-600 dark:text-violet-400"
                        >
                            <Ruler class="size-5" />
                        </div>
                        <ArrowUpRight
                            class="size-4 text-muted-foreground transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5"
                        />
                    </div>
                    <p class="mt-5 text-sm font-medium text-muted-foreground">
                        Tallas
                    </p>
                    <div class="mt-1 flex items-baseline gap-2">
                        <span class="text-3xl font-semibold tracking-tight">
                            {{ props.stats.sizes }}
                        </span>
                        <span class="text-sm text-muted-foreground">
                            Registradas
                        </span>
                    </div>
                </Link>

                <Link
                    href="/colores"
                    class="group rounded-xl border border-border bg-card p-5 text-card-foreground transition-colors hover:bg-accent/50"
                >
                    <div class="flex items-start justify-between">
                        <div
                            class="flex size-11 items-center justify-center rounded-lg bg-rose-500/10 text-rose-600 dark:text-rose-400"
                        >
                            <Palette class="size-5" />
                        </div>
                        <ArrowUpRight
                            class="size-4 text-muted-foreground transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5"
                        />
                    </div>
                    <p class="mt-5 text-sm font-medium text-muted-foreground">
                        Colores
                    </p>
                    <div class="mt-1 flex items-baseline gap-2">
                        <span class="text-3xl font-semibold tracking-tight">
                            {{ props.stats.colors }}
                        </span>
                        <span class="text-sm text-muted-foreground">
                            Registrados
                        </span>
                    </div>
                </Link>

                <Link
                    href="/categorias"
                    class="group rounded-xl border border-border bg-card p-5 text-card-foreground transition-colors hover:bg-accent/50"
                >
                    <div class="flex items-start justify-between">
                        <div
                            class="flex size-11 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400"
                        >
                            <Tags class="size-5" />
                        </div>
                        <ArrowUpRight
                            class="size-4 text-muted-foreground transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5"
                        />
                    </div>
                    <p class="mt-5 text-sm font-medium text-muted-foreground">
                        Categorías
                    </p>
                    <div class="mt-1 flex items-baseline gap-2">
                        <span class="text-3xl font-semibold tracking-tight">
                            {{ props.stats.categories }}
                        </span>
                        <span class="text-sm text-muted-foreground">
                            Disponibles
                        </span>
                    </div>
                </Link>
            </section>

            <section class="grid gap-6 xl:grid-cols-2">
                <div
                    class="rounded-xl border border-border bg-card p-6 text-card-foreground"
                >
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold">
                                Accesos rápidos
                            </h2>
                            <p class="mt-1 text-sm text-muted-foreground">
                                Crea y administra el catálogo.
                            </p>
                        </div>
                        <Plus class="size-5 text-muted-foreground" />
                    </div>
                    <div class="mt-5 grid gap-2 sm:grid-cols-2">
                        <Link
                            v-for="link in quickLinks"
                            :key="link.href"
                            :href="link.href"
                            class="flex items-center justify-between rounded-lg border border-border px-4 py-3 text-sm font-medium transition-colors hover:bg-accent"
                        >
                            {{ link.title }}
                            <ArrowUpRight
                                class="size-4 text-muted-foreground"
                            />
                        </Link>
                    </div>
                </div>

                <div
                    class="rounded-xl border border-border bg-card p-6 text-card-foreground"
                >
                    <div
                        class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex size-10 items-center justify-center rounded-lg bg-primary/10 text-primary"
                            >
                                <ShoppingCart class="size-5" />
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold">
                                    Pedidos recientes
                                </h2>
                                <p class="text-sm text-muted-foreground">
                                    Vista de ejemplo
                                </p>
                            </div>
                        </div>
                        <span
                            class="w-fit rounded-full bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-700 dark:text-amber-300"
                        >
                            DEMO
                        </span>
                    </div>

                    <div class="mt-5 divide-y divide-border">
                        <div
                            v-for="order in demoOrders"
                            :key="order.id"
                            class="flex items-center justify-between gap-4 py-3 first:pt-0 last:pb-0"
                        >
                            <div>
                                <p class="text-sm font-medium">
                                    {{ order.id }}
                                </p>
                                <p class="mt-1 text-sm text-muted-foreground">
                                    {{ order.customer }}
                                </p>
                            </div>
                            <span
                                class="rounded-full bg-muted px-3 py-1 text-xs font-medium text-muted-foreground"
                            >
                                {{ order.status }}
                            </span>
                        </div>
                    </div>
                    <p
                        class="mt-5 rounded-lg bg-muted/60 p-3 text-xs text-muted-foreground"
                    >
                        Estos datos son ficticios para mostrar el diseño; no
                        representan pedidos reales.
                    </p>
                </div>
            </section>
        </template>

        <section
            v-else
            class="rounded-xl border border-border bg-card p-6 text-card-foreground"
        >
            <h2 class="text-lg font-semibold">Bienvenido a la tienda</h2>
            <p class="mt-2 text-sm text-muted-foreground">
                Este espacio está listo para mostrar la información de tu
                cuenta. Las herramientas de administración solo están
                disponibles para administradores.
            </p>
            <Link
                href="/"
                class="mt-5 inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-opacity hover:opacity-90"
            >
                Ir a la tienda
                <ArrowUpRight class="size-4" />
            </Link>
        </section>
    </main>
</template>
